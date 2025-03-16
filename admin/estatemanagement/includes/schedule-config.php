<?php
/**********************************************************************************************************************************
*
* Schedule Configurations 
* 
* Author: Webbu Design & Occasion Franchise
* Please do not modify below functions.
***********************************************************************************************************************************/

$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

if ($setup4_membersettings_paymentsystem == 2) {
	//**
	//*Start: Membership System Schedule
	//**
  
    //**
		//*Start: Check Expired Items & Expire
		//**
			add_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_check_expires_child' );
			function pointfinder_check_expires_child() {
        $post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
        // WP_Query arguments
        $args = array(
          'post_type'              => array( $post_type_annonce ),
          'post_parent'            => 0,
          'post_status'            => array( 'publish' ),
          'meta_query'             => array(
            array(
              'key'     => 'of_webbupointfinder_item_expire',
              'value'   => time(),
              'compare' => '<=',
            ),
          ),
        );

        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {
          while ( $the_query->have_posts() ) {
            $the_query->the_post();
            PFExpireItemManual(
              array( 
                'post_id' => $the_query->post->ID,
                'post_author' => $the_query->post->post_author,
                'payment_type' => 'direct'
              )
            );
            
            $setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');
            if ($setup33_emaillimits_listingexpired == 1) {
              $user_info = get_userdata( $the_query->post->post_author);
              $expiredate = get_post_meta($the_query->post->ID, 'of_webbupointfinder_item_expire',true);
              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $user_info->user_email,
                  'predefined' => 'directafterexpire',
                  'data' => array('ID' => $the_query->post->ID, 'expiredate' => $expiredate)
                )
              );
            }
            
            
            
          }
        }

        // Restore original Post Data
        wp_reset_postdata();
			}
		//**
		//*End: Check Expired Items & Expire
		//**
    
    //**
		//*Start: Check expiring items and send email 30 days before.
		//**
			add_action( 'pointfinder_schedule_hooks_daily', 'pointfinder_check_expiring_child' );
			function pointfinder_check_expiring_child() {
				// Only for Direct payments. And this schedule will check item 1 day before expire.
				$setup33_emaillimits_listingautowarning = PFMSIssetControl('setup33_emaillimits_listingautowarning','','1');
				if ($setup33_emaillimits_listingautowarning == 1) {
          $post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
          $args = array(
            'post_type'              => array( $post_type_annonce ),
            'post_parent'            => 0,
            'post_status'            => array( 'publish' ),
            'meta_query'             => array(
              array(
                'key'     => 'of_webbupointfinder_item_expire',
                'value'   => strtotime('+30 day'),
                'compare' => '<=',
              ),
              array(
                'key'     => 'webbupointfinder_item_exemail',
                'compare' => 'NOT EXISTS', // envoie le courriel seulement si pas encore envoyé
              ),
            ),
          );
          
          $the_query = new WP_Query( $args );

          if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
              $the_query->the_post();
              
              $item_id = $the_query->post->ID;
              $user_info = get_userdata( $the_query->post->post_author);
              $expiredate = get_post_meta($the_query->post->ID, 'of_webbupointfinder_item_expire',true);
              $mailHasBeenSent = pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $user_info->user_email,
                  'predefined' => 'directbeforeexpire',
                  'data' => array(
                    'ID' => $item_id,
                    'expiredate' => $expiredate
                  )
                )
              );
              
              if($mailHasBeenSent){
                $mail_info = array(
                              'date' => time(),
                              'sentTo' => $user_info->user_email
                            );
                add_post_meta($item_id, 'webbupointfinder_item_exemail', json_encode($mail_info));
              }else{
                error_log("Impossible d'envoyer le courriel de notification d'expiration de l'annonce à l'annonceur", 0);
                error_log("Impossible d'envoyer le courriel de notification d'expiration de l'annonce à l'annonceur", 1, get_option( 'admin_email' ));
              }
            }
          }

          // Restore original Post Data
          wp_reset_postdata();
          
          /*
          global $wpdb;
          $post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
          $results = $wpdb->get_results( $wpdb->prepare( 
            "SELECT p.ID, p.post_author, p.post_date, p.post_status FROM $wpdb->posts as p 
            WHERE p.post_type = %s 
            and p.post_status = %s 
            and p.post_parent = %d
            and TIMESTAMPDIFF(DAY,NOW(),DATE_ADD(p.post_date, INTERVAL 1 YEAR)) < 31", 
            $post_type_annonce,
            'publish',
            0
          ),'OBJECT_K' );
          
					if (PFControlEmptyArr($results)) {
						foreach ($results as $result) {
							if ($result->post_status) {
                $item_id = $result->ID;
                $mail_ok = TRUE;
								if(PFcheck_postmeta_exist('webbupointfinder_item_exemail', $item_id)){
                  $mail_info = get_post_meta( $item_id, 'webbupointfinder_item_exemail',true); 
									if(!empty($mail_info)){
										$mail_info = json_decode($mail_info,true);
                    if(is_array($mail_info)){
                      $mail_ok = FALSE; // tout est ok donc on envoie pas
                    }else{
                      delete_post_meta($item_id, 'webbupointfinder_item_exemail'); // reset l'information
                    }
									}else{
                    delete_post_meta($item_id, 'webbupointfinder_item_exemail'); // reset l'information
                  }
                }
                
                if($mail_ok){
                  $user_info = get_userdata( $result->post_author);
                  $expiredate = date('Y-m-d H:i:s', strtotime($result->post_date . ' +1 year'));
									$mailHasBeenSent = pointfinder_mailsystem_mailsender(
										array(
                      'toemail' => $user_info->user_email,
                      'predefined' => 'directbeforeexpire',
                      'data' => array(
                        'ID' => $item_id,
                        'expiredate' => $expiredate
                      )
										)
									);
                  
                  if($mailHasBeenSent){
                    $mail_info = array(array('date'=>date("Y-m-d")));
                    add_post_meta($item_id, 'webbupointfinder_item_exemail', json_encode($mail_info));
                  }
                }
							}
						} // end Foreach
					}
          */
				}
			}
    //**
		//*End: Check expiring items and send email 30 days before.
		//**

	//**
	//*End: Membership System Schedule
	//**
}


?>