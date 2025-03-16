<?php

add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

add_filter("gform_field_content", "bootstrap_styles_for_gravityforms_fields", 10, 5);
function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id){
  if(
    $field->type == 'text'
    ||
    $field->type == 'phone'
    ||
    $field->type == 'email'
  ){
    $classNames = array("medium", "large");
    foreach($classNames as $className){
      if (strpos($content, $className) !== false) {
        $content = str_replace('class=\''.$className, 'class=\''.$className.' input', $content);
      }
    }
  }else if($field->type == 'address'){
    $content = str_replace('ginput_complex', 'ginput_complex row', $content);
    $content = str_replace('ginput_left', 'ginput_left col6 first', $content);
    $content = str_replace('ginput_right', 'ginput_right col6 last', $content);
    $content = str_replace("id='input_1_5_4'", "id='input_1_5_4' class='select'", $content);
    $content = str_replace("id='input_3_3_4'", "id='input_3_3_4' class='select'", $content);
    $content = str_replace("placeholder='Ville'", "class='input' placeholder='Ville'", $content);
    $content = str_replace("placeholder='Ville *'", "class='input' placeholder='Ville *'", $content);
  }else if($field->type == 'select'){
    $content = str_replace("gfield_select", "gfield_select select", $content);
  }
	
	return $content;
}

add_action( 'gform_after_submission_3', 'after_lead_nouvelle_franchise', 10, 2 );
function after_lead_nouvelle_franchise( $entry, $form ) {
  $subscribe_status = rgar( $entry, '12.1' );
  if($subscribe_status == 'sinscrire'){
    $new_entry['form_id'] = 4;
    $new_entry['1'] = rgar( $entry, '2' );
    $new_entry['2'] = rgar( $entry, '4' );
    $entry_id = GFAPI::add_entry( $new_entry );
    //GFCommon::log_debug( 'gform_after_submission: nouvelle entrée => ' . print_r( $entry_id, 1 ) );
  }
}

add_action( 'gform_after_submission_4', 'after_inscription_alertes', 10, 2 );
function after_inscription_alertes( $entry, $form ) {
  $abonnements_utilisateur = array();
  if(!empty($entry['7.1'])){
    $abonnements_utilisateur[] = (int)$entry['7.1'];
  }
  if(!empty($entry['7.2'])){
    $abonnements_utilisateur[] = (int)$entry['7.2'];
  }
  if(!empty($entry['7.3'])){
    $abonnements_utilisateur[] = (int)$entry['7.3'];
  }
  if(!empty($entry['7.4'])){
    $abonnements_utilisateur[] = (int)$entry['7.4'];
  }
  
  if(!empty($abonnements_utilisateur)){
    $email = rgar( $entry, '2' );
    $prenom = rgar( $entry, '10.3' );
    $nom = rgar( $entry, '10.6' );
    $name_attributes["FIRSTNAME"] = $prenom;
    $name_attributes["LASTNAME"] = $nom;
    $region_dinteret = rgar( $entry, '11' );
    if($region_dinteret){
      $term = get_term( $region_dinteret, 'pointfinderlocations' );
      $name_attributes["REGION_D-INTERET"] = $term->name;
    }
    $name_attributes = (object)$name_attributes;
    $fields = array(
      "listIds" => $abonnements_utilisateur,
      "email" => $email,
      "attributes" => $name_attributes
    );
    $json_fields = json_encode($fields);
    
    //Vérifie si le courriel est déjà utilisé
    $user_updated_on_sendinblue = FALSE;
    $response = wp_remote_get(
      "https://api.brevo.com/v3/contacts/".urlencode($email),
      array(
        'headers' => array(
          'Api-Key' => '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',
          'Content-Type' => 'application/json'
        )
      )
    );
    if (!is_wp_error( $response ) ) {
      if($response['response']['code'] == 200){
        // l'utilisateur existe donc on l'update
        $fields_tmp = $fields;
        unset($fields_tmp['email']);
        $json_fields_tmp = json_encode($fields_tmp);
        
        $response = wp_remote_request(
          "https://api.brevo.com/v3/contacts/".urlencode($email),
          array(
            'headers' => array(
              'Api-Key' => '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',
              'Content-Type' => 'application/json'
            ),
            'method' => 'PUT',
            'body' => $json_fields_tmp
          )
        );
        if (!is_wp_error( $response ) ) {
          if($response['response']['code'] == 204){
            $user_updated_on_sendinblue = TRUE;
          }else{
            GLOBAL $errors;
            $errors = new WP_Error;
            $errors -> add( 'sendinblue_error', $response['body'] );
          }
        }
      }else{
        if($response['response']['code'] != 404){
          GLOBAL $errors;
          $errors = new WP_Error;
          $errors -> add( 'sendinblue_error', $response['body'] );
        }
      }
    }
    
    if(!$user_updated_on_sendinblue){
      $response = wp_remote_post(
        "https://api.brevo.com/v3/contacts",
        array(
          'headers' => array(
            'Api-Key' => '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',
            'Content-Type' => 'application/json'
          ),
          'body' => $json_fields
        )
      );

      if (!is_wp_error( $response ) ) {
        if($response['response']['code'] != 201){
          GLOBAL $errors;
          $errors = new WP_Error;
          $errors -> add( 'sendinblue_error', $response['body'] );
        }
      }
    }
  }
}

// Formulaire de désabonnement aux alertes
add_action( 'gform_pre_submission_8', 'after_desabonnement_alertes', 10, 2 );
function after_desabonnement_alertes( $form ) {
  $desabonnements_utilisateur = array();
  if(!empty(rgpost('input_4_1'))){
    $desabonnements_utilisateur[] = (int)rgpost('input_4_1');
  }
  if(!empty(rgpost('input_4_2'))){
    $desabonnements_utilisateur[] = (int)rgpost('input_4_2');
  }
  if(!empty(rgpost('input_4_3'))){
    $desabonnements_utilisateur[] = (int)rgpost('input_4_3');
  }
  if(!empty(rgpost('input_4_4'))){
    $desabonnements_utilisateur[] = (int)rgpost('input_4_4');
  }
  
  $fields = array(
    "unlinkListIds" => $desabonnements_utilisateur
  );
  $json_fields = json_encode($fields);
  $email = rgpost( 'input_1' );
  
  $response = wp_remote_request(
    "https://api.brevo.com/v3/contacts/".urlencode($email),
    array(
      'headers' => array(
        'Api-Key' => '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',
        'Content-Type' => 'application/json'
      ),
      'method' => 'PUT',
      'body' => $json_fields
    )
  );
  
  if (!is_wp_error( $response ) ) {
    if($response['response']['code'] == 204){
      $_POST['input_5_1'] = 1;
    }elseif($response['response']['code'] == 400){
      $_POST['input_5_3'] = 3;
    }elseif($response['response']['code'] == 404){
      $_POST['input_5_2'] = 2;
    }
  }
}
// FIN Formulaire de désabonnement

add_filter( 'gform_field_value_heure_formulaire_rempli', 'populate_heure_formulaire_rempli', 10, 3 );
function populate_heure_formulaire_rempli( $value, $field, $name ) {
  $local_timestamp = GFCommon::get_local_timestamp( time() );
 
  return date_i18n( 'H:i', $local_timestamp, true );
}

add_filter( 'gform_notification_3', 'change_receiver_email', 10, 3 );
function change_receiver_email( $notification, $form, $entry ) {
  // There is no concept of user notifications anymore, so
  // we will need to target notifications based on other
  // criteria, such as name
  if ( $notification['name'] == 'Notification administrateur et franchiseurs' ) {
    // toType can be routing or email
    $notification['toType'] = 'email';
    // change the "to" email address
    //$courriels_franchiseur = get_post_meta( get_the_ID(), 'courriels_franchiseur', true );
    $notification['to'] = get_post_meta( get_the_ID(), 'courriels_franchiseur', true );
    //$notification['to'] = 'remibarbalat.occasionfranchise@outlook.com';

  }

  return $notification;
}

add_filter( 'gform_field_value', 'populate_gravity_forms', 10, 3 );
function populate_gravity_forms( $value, $field, $name ) {
  $author_email = get_the_author_meta('user_email');
  
  // Vérifie si l'annonce a été créée par nous à l'interne
  $author_id = get_the_author_meta('ID');
  $liste_id_admin_users = array(5,1);
  if(in_array($author_id, $liste_id_admin_users, true)){
    // Vérifie si un agent est associé à l'annonce
    $itemCourtier = esc_attr(get_post_meta(get_the_ID(), 'webbupointfinder_item_agents', true ));
    //$itemCourtier = redux_post_meta("pointfinderthemefmb_options", $pfgetdata['relatedcpi'], "webbupointfinder_item_agents");
    if($itemCourtier != false){
      $courtierCourriel = sanitize_email(get_post_meta( $itemCourtier, 'webbupointfinder_agent_email', true ));
      if(!empty($courtierCourriel)){
        $author_email = $courtierCourriel;
      }
      
    }
  }
  
  $saved_annonce_types = get_the_terms(get_the_ID(),'pointfinderltypes');
  $types_annonce = array();
  if($saved_annonce_types){
    foreach($saved_annonce_types as $saved_annonce_type){
      if (isset($saved_annonce_type->term_id)) {
        $all_annonce_types = get_term_parents_list( $saved_annonce_type->term_id, 'pointfinderltypes', array('format'=>'slug','separator'=>'±','link'=>FALSE) );
        $tmp_all_annonce_types = explode("±",trim($all_annonce_types, "±"));
        $types_annonce = array_merge ($types_annonce, $tmp_all_annonce_types);
      }
    }
  }
  $types_annonce = array_unique ($types_annonce);
  
  $values = array(
    'courriel_annonceur'=> $author_email,
    'type_annonce'      => $types_annonce
  );
  
  return isset( $values[ $name ] ) ? $values[ $name ] : '';
}

// Synchronisation avec SendinBlue
add_action( 'gform_user_registered', 'sync_SendinBlue_registration', 10, 4 );
function sync_SendinBlue_registration($user_id, $feed, $entry, $user_pass){
  if($feed['form_id'] == 7){
    $abonnements_utilisateur = array();
    if(!empty($entry['9.1'])){
      $abonnements_utilisateur[] = (int)$entry['9.1'];
    }
    if(!empty($entry['9.2'])){
      $abonnements_utilisateur[] = (int)$entry['9.2'];
    }
    if(!empty($entry['9.3'])){
      $abonnements_utilisateur[] = (int)$entry['9.3'];
    }
    if(!empty($entry['9.4'])){
      $abonnements_utilisateur[] = (int)$entry['9.4'];
    }
    
    if(!empty($abonnements_utilisateur)){
      $prenom = rgar( $entry, '4.3' );
      $nom = rgar( $entry, '4.6' );
      $email = rgar( $entry, '1' );
      $name_attributes["FIRSTNAME"] = $prenom;
      $name_attributes["LASTNAME"] = $nom;
      $region_dinteret = rgar( $entry, '16' );
      if($region_dinteret){
        $term = get_term( $region_dinteret, 'pointfinderlocations' );
        $name_attributes["REGION_D-INTERET"] = $term->name;
      }
      $name_attributes = (object)$name_attributes;
      $fields = array(
        "listIds" => $abonnements_utilisateur,
        "email" => $email,
        "attributes" => $name_attributes
      );
      $json_fields = json_encode($fields);
      
      //Vérifie si le courriel est déjà utilisé
      $user_updated_on_sendinblue = FALSE;
      $response = wp_remote_get(
        "https://api.brevo.com/v3/contacts/".urlencode($email),
        array(
          'headers' => array(
            'Api-Key' => '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',
            'Content-Type' => 'application/json'
          )
        )
      );
      if (!is_wp_error( $response ) ) {
        if($response['response']['code'] == 200){
          // l'utilisateur existe donc on l'update
          $fields_tmp = $fields;
          unset($fields_tmp['email']);
          $json_fields_tmp = json_encode($fields_tmp);
          
          $response = wp_remote_request(
            "https://api.brevo.com/v3/contacts/".urlencode($email),
            array(
              'headers' => array(
                'Api-Key' => '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',
                'Content-Type' => 'application/json'
              ),
              'method' => 'PUT',
              'body' => $json_fields_tmp
            )
          );
          if (!is_wp_error( $response ) ) {
            if($response['response']['code'] == 204){
              $user_updated_on_sendinblue = TRUE;
            }else{
              GLOBAL $errors;
              $errors = new WP_Error;
              $errors -> add( 'sendinblue_error', $response['body'] );
            }
          }
        }else{
          if($response['response']['code'] != 404){
            GLOBAL $errors;
            $errors = new WP_Error;
            $errors -> add( 'sendinblue_error', $response['body'] );
          }
        }
      }
      
      if(!$user_updated_on_sendinblue){
        $response = wp_remote_post(
          "https://api.brevo.com/v3/contacts",
          array(
            'headers' => array(
              'Api-Key' => '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',
              'Content-Type' => 'application/json'
            ),
            'body' => $json_fields
          )
        );

        if (!is_wp_error( $response ) ) {
          if($response['response']['code'] != 201){
            GLOBAL $errors;
            $errors = new WP_Error;
            $errors -> add( 'sendinblue_error', $response['body'] );
          }
        }
      }
    }
  }
}

add_filter( 'gform_confirmation_7', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
  GLOBAL $errors;
  if( is_wp_error( $errors ) ) {
    $error_codes = $errors->get_error_codes();
    foreach($error_codes as $error_code){
      if($error_code == 'sendinblue_error'){
        $confirmation = '<div class="gform_confirmation_message">'.__('You have been registered but following error occurred way subscribing to newsletters :').'</div><pre>'.$errors->get_error_message('sendinblue_error').'</pre>';
      }
    }
  }
  return $confirmation;
}
// fin Synchronisation avec SendinBlue

// Rempli le menu déroulant "Région" du formulaire de création de compte
add_filter( 'gform_pre_render_7', 'populate_regions' );
add_filter( 'gform_pre_render_4', 'populate_regions' );
add_filter( 'gform_pre_validation_7', 'populate_regions' );
add_filter( 'gform_pre_validation_4', 'populate_regions' );
add_filter( 'gform_pre_submission_filter_7', 'populate_regions' );
add_filter( 'gform_pre_submission_filter_4', 'populate_regions' );
add_filter( 'gform_admin_pre_render_7', 'populate_regions' );
add_filter( 'gform_admin_pre_render_4', 'populate_regions' );
function populate_regions( $form ) {
  foreach ( $form['fields'] as &$field ) {
    if ( $field->inputName === 'region_pointfinderlocations' ){
      $choices = array();

      $locations = get_terms( array( 
        'taxonomy'    => 'pointfinderlocations',
        'parent'      => 0,
        'hide_empty'  => false
      ) );
      
      foreach($locations as $location){
        $choices[] = array( 'text' => $location->name, 'value' => $location->term_id );
      }
      
      $field->placeholder = __('Select a region','pointfindert2d');
      $field->choices = $choices;
    }
  }

  return $form;
}
// FIN Rempli le menu déroulant "Région" du formulaire de création de compte

// Rempli le champ caché "Type d'annonce" dans le formulaire d'annonce classée
add_filter( 'gform_pre_render_1', 'populate_types_annonces' );
add_filter( 'gform_pre_validation_1', 'populate_types_annonces' );
add_filter( 'gform_pre_submission_filter_1', 'populate_types_annonces' );
add_filter( 'gform_admin_pre_render_1', 'populate_types_annonces' );
function populate_types_annonces( $form ) {
  foreach ( $form['fields'] as &$field ) {
    if ( $field->inputName === 'type_annonce' ){
      $choices = array();

      $types_annonce = get_terms( array( 
        'taxonomy'    => 'pointfinderltypes',
        'hide_empty'  => false
      ) );
      
      foreach($types_annonce as $type_annonce){
        $choices[] = array( 'text' => $type_annonce->name, 'value' => $type_annonce->slug );
      }
      
      $field->choices = $choices;
    }
  }

  return $form;
}
// FIN Rempli le champ caché "Type d'annonce" dans le formulaire d'annonce classée
?>