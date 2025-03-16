<?php
/*
Original
//Your Code Here

add_action( 'wp_enqueue_scripts', 'pfch_theme_enqueue_styles' );
function pfch_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array()
    );
}
*/
/*
function pfch_theme_enqueue_styles() {

  $parent_style = 'theme-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style(
      'child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
  );
}
add_action( 'wp_enqueue_scripts', 'pfch_theme_enqueue_styles' );
*/
function pfch_theme_enqueue_script() {
  $parent_js = 'theme-scriptspf';
  $parent_js_m = 'theme-scriptspfm';

  wp_dequeue_script($parent_js);
  wp_dequeue_script($parent_js_m);
  // basé sur /admin/core/scripts.php ligne 118
  // Nécessite peut-être de dé-enregistrer et de réenregistrer?...
  //wp_deregister_script($parent_js);
  //wp_register_script
  //wp_localize_script
  wp_enqueue_script(
    $parent_js,
    get_stylesheet_directory_uri() . '/js/theme-scripts.min.js',
    array(
      'jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog','pftheme-minified-package'
    ),
    '1.8.7',
    true
  );
  wp_enqueue_script(
    $parent_js_m,
    get_stylesheet_directory_uri() . '/js/theme-scripts-dash.min.js',
    array(
      'jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog','theme-scriptspf'
    ),
    '1.8.7',
    true
  );
}
add_action( 'wp_enqueue_scripts', 'pfch_theme_enqueue_script');

function child_remove_parent_function() {
  remove_action( 'PF_AJAX_HANDLER_pfget_itemsystem', 'pf_ajax_itemsystem' );
  remove_action( 'PF_AJAX_HANDLER_nopriv_pfget_itemsystem', 'pf_ajax_itemsystem' );

  remove_action( 'PF_AJAX_HANDLER_pfget_membershipsystem', 'pf_ajax_membershipsystem' );
  remove_action( 'PF_AJAX_HANDLER_nopriv_pfget_membershipsystem', 'pf_ajax_membershipsystem' );
  
  remove_action( 'PF_AJAX_HANDLER_pfget_usersystem', 'pf_ajax_usersystem' );
  remove_action( 'PF_AJAX_HANDLER_nopriv_pfget_usersystem', 'pf_ajax_usersystem' );
  require_once(get_stylesheet_directory() . '/admin/estatemanagement/includes/ajax/ajax-usersystem.php');
  
  remove_action( 'PF_AJAX_HANDLER_pfget_membershippaymentsystem', 'pf_ajax_membershippaymentsystem' );
  remove_action( 'PF_AJAX_HANDLER_nopriv_pfget_membershippaymentsystem', 'pf_ajax_membershippaymentsystem' );
  
  remove_action( 'PF_AJAX_HANDLER_pfget_imagesystem', 'pf_ajax_imagesystem' );
  remove_action( 'PF_AJAX_HANDLER_nopriv_pfget_imagesystem', 'pf_ajax_imagesystem' );
  
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
  remove_action( 'manage_edit-'.$setup3_pointposttype_pt1.'_columns', 'pointfinder_items_edit_columns', 10, 2 );
  remove_action( 'manage_'.$setup3_pointposttype_pt1.'_posts_custom_column', 'pointfinder_items_manage_columns', 10, 2 );
  //pas accès à PFSAIssetControl() en bas
  add_action( 'manage_edit-'.$setup3_pointposttype_pt1.'_columns', 'pointfinder_items_edit_columns_child', 10, 2 );
  add_action( 'manage_'.$setup3_pointposttype_pt1.'_posts_custom_column', 'pointfinder_items_manage_columns_child', 10, 2 );
  
  remove_action( 'add_meta_boxes', 'pointfinder_minvoices_add_meta_box', 10,1);
  
  remove_action( 'admin_head-edit.php', 'pointfinder_admin_head_custompost_listing' );
  
  remove_action('transition_post_status', 'pointfinder_all_item_status_changes', 10, 3 );
  
  remove_filter('user_contactmethods', 'pf_modify_contact_methods');
  
  remove_filter( 'widget_title' , 'pfedit_my_widget_title', 10, 3);
  
  remove_action( 'widgets_init','pointfinder_extrafunction_03' ); // pas l'air de faire grand chose... peut-être parce qu'une fois lancé, c'est fini?
  
  remove_action('wp_enqueue_scripts', 'pf_styleandscripts');
  require_once(get_stylesheet_directory() . '/admin/core/scripts.php'); // semble fonctionner
  
  // Met à jour les crons
  remove_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_check_expires_member' );
  remove_action( 'pointfinder_schedule_hooks_daily', 'pointfinder_check_expiring_member' );
  require_once(get_stylesheet_directory() . '/admin/estatemanagement/includes/schedule-config.php');
  
  remove_shortcode( 'pf_searchw' );
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf-search_child.php'); // re-crée le shortcode
  
  remove_shortcode( 'pf_itemgrid2' );
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf-grid-shortcodes-static_child.php'); // re-crée le shortcode
  
  remove_shortcode( 'pf_agentlist' );
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf-list-agents_child.php'); // re-crée le shortcode
  
  remove_shortcode( 'pf_pfitemcarousel' );
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf_pfitem_carousel_child.php'); // re-crée le shortcode
  
  remove_shortcode( 'pf_llist_widget' );
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf-locationlist_child.php'); // re-crée le shortcode
  
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/pf-secteuractivitelist_child.php');
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/customshortcodes/fp-agenttypelist.php');
  
  // Ajoute un VC elemvent
  require_once(get_stylesheet_directory() . '/admin/includes/vcextend/vc_extend_child.php');
  
  // Rétablie la barre d'admin par role d'utilisateur
  $current_user = wp_get_current_user();
  if ( in_array( 'editor', (array) $current_user->roles ) ) {
    show_admin_bar( true );
    remove_filter( 'show_admin_bar', '__return_false' );
    remove_filter( 'wp_admin_bar_class', '__return_false' );
    remove_action('wp_head','pointfinder_disable_admin_hook2');
  }
  
  require_once(get_stylesheet_directory() . '/admin/core/aq_resizer.php');
  
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  remove_action( 'wp_head', 'feed_links', 2 );
  
  remove_action('show_user_profile', 'pf_custom_user_profile_fields');
  remove_action('edit_user_profile', 'pf_custom_user_profile_fields');
  require_once(get_stylesheet_directory() . '/admin/estatemanagement/includes/user-profilemods.php');
}
add_action( 'wp_loaded', 'child_remove_parent_function' );

add_filter('user_contactmethods', 'pf_modify_contact_methods_child');

add_filter ( 'widget_title' , 'pfedit_my_widget_title_child', 10, 3);

add_action( 'PF_AJAX_HANDLER_pfget_itemsystem', 'pf_ajax_itemsystem_child' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_itemsystem', 'pf_ajax_itemsystem_child' );

add_action( 'PF_AJAX_HANDLER_pfget_membershipsystem', 'OF_pf_ajax_membershipsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_membershipsystem', 'OF_pf_ajax_membershipsystem' );

add_action( 'PF_AJAX_HANDLER_pfget_usersystem', 'pf_ajax_usersystem_child' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_usersystem', 'pf_ajax_usersystem_child' );

add_action( 'PF_AJAX_HANDLER_pfget_membershippaymentsystem', 'OF_pf_ajax_membershippaymentsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_membershippaymentsystem', 'OF_pf_ajax_membershippaymentsystem' );

add_action( 'PF_AJAX_HANDLER_pfget_imagesystem', 'pf_ajax_imagesystem_child' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_imagesystem', 'pf_ajax_imagesystem_child' );

function of_disable_feed() {
 wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'of_disable_feed', 1);
add_action('do_feed_rdf', 'of_disable_feed', 1);
add_action('do_feed_rss', 'of_disable_feed', 1);
add_action('do_feed_rss2', 'of_disable_feed', 1);
add_action('do_feed_atom', 'of_disable_feed', 1);
add_action('do_feed_rss2_comments', 'of_disable_feed', 1);
add_action('do_feed_atom_comments', 'of_disable_feed', 1);

add_action('wp_enqueue_scripts', 'pf_styleandscripts_child');
// Occasion Franchise ADMIN styles et scripts
add_action('admin_enqueue_scripts','of_admin_styleandscripts',10);
function of_admin_styleandscripts(){
	wp_register_style('of_admin_style', get_stylesheet_directory_uri() . '/admin/core/css/ofadmin.css', array('itempage-custom.'), '1.0', 'all');
  wp_enqueue_style('of_admin_style');
}

//pas accès à PFSAIssetControl()
//$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
//add_action( 'manage_'.$setup3_pointposttype_pt1.'_posts_custom_column', 'pointfinder_items_manage_columns_child', 10, 2 );

add_action( 'add_meta_boxes', 'OF_pointfinder_minvoices_add_meta_box', 10,1);

add_action( 'admin_head-edit.php', 'pointfinder_admin_head_custompost_listing_child' );

add_action('transition_post_status', 'pointfinder_all_item_status_changes_child', 10, 3 );

//** DÉBUT Modifs formulaires **//
require_once(get_stylesheet_directory() . '/FranchisePerformance/fp-gravityforms.php');
//** FIN Modifs formulaires **//

//** Ajoute les crons maison **//
require_once(get_stylesheet_directory() . '/FranchisePerformance/crons.php');

//** DÉBUT Modifs WIDGETS **//
add_action( 'widgets_init','unregister_a_widget', 99);
function unregister_a_widget(){
    //unregister_widget( 'pf_recent_items_w' );
    unregister_widget( 'pf_featured_items_w' );
    unregister_widget( 'pf_search_items_w' );
    //unregister_widget( 'pf_twitter_w' );
    //unregister_widget( 'pf_featured_agents_w' );
};
require_once(get_stylesheet_directory() . '/admin/includes/pfcustomwidgets.php');
require_once(get_stylesheet_directory() . '/admin/includes/pfgetsearchfields.php');
//** Ajoute de nouveaux widgets **//
require_once(get_stylesheet_directory() . '/FranchisePerformance/fp-customwidgets.php');

add_action( 'widgets_init','pointfinder_extrafunction_03_child' );
function pointfinder_extrafunction_03_child(){
    register_widget( 'pf_featured_items_w_child' );
    register_widget( 'pf_search_items_w_child' );
    register_widget( 'fp_advanced_search_w_child' );
    register_widget( 'pf_recent_items_w_child' );
    //register_widget( 'pf_search_items_w_child' ); !! N'existes pas !
    //register_widget( 'pf_twitter_w_child' ); !! N'existes pas !
    //register_widget( 'pf_featured_agents_w_child' ); !! N'existes pas !
};
//** FIN Modifs WIDGETS **//

function PFU_AddorUpdateRecord($params = array()){

  $defaults = array(
    'post_id' => '',
    'order_post_id' => '',
    'order_title' => '',
    'vars' => array(),
    'user_id' => ''
  );

  $params = array_merge($defaults, $params);


  $setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
  switch ($setup4_membersettings_dateformat) {
    case '1':$datetype = "d/m/Y";break;
    case '2':$datetype = "m/d/Y";break;
    case '3':$datetype = "Y/m/d";break;
    case '4':$datetype = "Y/d/m";break;
  }



  $vars = $params['vars'];


  $user_id = $params['user_id'];
  $returnval = array();
  $returnval['sccval'] = $returnval['errorval'] = $returnval['post_id'] = $returnval['ppps'] = $selectedpayment = $returnval['pppso'] ='';

  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
  $setup31_userlimits_userpublish = PFSAIssetControl('setup31_userlimits_userpublish','','0');
  $setup31_userpayments_priceperitem = PFSAIssetControl('setup31_userpayments_priceperitem','','0');
  $setup31_userlimits_userpublishonedit = PFSAIssetControl('setup31_userlimits_userpublishonedit','','0');
  $setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','0');
  $setup31_userpayments_featuredoffer = PFSAIssetControl('setup31_userpayments_featuredoffer','','0');
  $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
  $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
  $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
  $pfmenu_perout = PFPermalinkCheck();
  $setup4_ppp_catprice = PFSAIssetControl('setup4_ppp_catprice','','0');
  $membership_user_activeorder;
  $original_status_of_post = get_post_status($params['post_id']);
  $original_status_of_order;
  
  

  $autoexpire_create = $is_item_recurring = 0;

  /* Selected Payment Method for PPP */
  if (isset($vars['pf_lpacks_payment_selection']) && $setup4_membersettings_paymentsystem == 1) {
    if ($vars['pf_lpacks_payment_selection'] == 'paypal' || $vars['pf_lpacks_payment_selection'] == 'paypal2') {
      $selectedpayment = 'paypal';
    }else{
      $selectedpayment = $vars['pf_lpacks_payment_selection'];
    }
    if ($vars['pf_lpacks_payment_selection'] == 'paypal2') {
      $is_item_recurring = 1;
    }
    if ($vars['pf_lpacks_payment_selection'] == 'iyzico') {
      if(isset($vars['pfusr_firstname'])){update_user_meta($user_id, 'first_name', $vars['pfusr_firstname']);}
      if(isset($vars['pfusr_lastname'])){update_user_meta($user_id, 'last_name', $vars['pfusr_lastname']);}
      if(isset($vars['pfusr_mobile'])){update_user_meta($user_id, 'user_mobile', $vars['pfusr_mobile']);}
      if(isset($vars['pfusr_vatnumber'])){update_user_meta($user_id, 'user_vatnumber', $vars['pfusr_vatnumber']);}
      if(isset($vars['pfusr_country'])){update_user_meta($user_id, 'user_country', $vars['pfusr_country']);}
      if(isset($vars['pfusr_address'])){update_user_meta($user_id, 'user_address', $vars['pfusr_address']);}
      if(isset($vars['pfusr_city'])){update_user_meta($user_id, 'user_city', $vars['pfusr_city']);}
    }
    $returnval['ppps'] = $selectedpayment;
  }


  if($params['post_id'] == ''){
    $userpublish = ($setup31_userlimits_userpublish == 0) ? 'pendingapproval' : 'publish' ;

    if ($setup4_membersettings_paymentsystem == 2) {
      $membership_user_activeorder = get_user_meta( $params['user_id'], 'membership_user_activeorder', true );
      $original_status_of_order = get_post_status($membership_user_activeorder);
      $post_status = $userpublish;
      $checkemail_poststatus = $post_status;
    }else{
      if ($vars['pf_lpacks_payment_selection'] == 'free') {
        $pricestatus = 'publish';
        $autoexpire_create = 1;
      }else{
        $pricestatus = 'pendingpayment';
      }

      if($userpublish == 'publish' && $pricestatus == 'publish'){
        $post_status = 'publish';
      }elseif($userpublish == 'publish' && $pricestatus == 'pendingpayment'){
        $post_status = 'pendingpayment';
      }elseif($userpublish == 'pendingapproval' && $pricestatus == 'publish'){
        $post_status = 'pendingapproval';
      }elseif($userpublish == 'pendingapproval' && $pricestatus == 'pendingpayment'){
        $post_status = 'pendingpayment';
      }
      
    }

  }else{
    if ($setup4_membersettings_paymentsystem == 2) {
      $membership_user_activeorder = get_user_meta( $params['user_id'], 'membership_user_activeorder', true );
      $original_status_of_order = get_post_status($membership_user_activeorder);
      $post_status = ($setup31_userlimits_userpublishonedit == 0) ? 'pendingapproval' : 'publish' ;
      $checkemail_poststatus = get_post_status( $params['post_id']);
      if($post_status == 'publish'){
        PFCreateProcessRecord(
          array( 
                'user_id' => $user_id,
                'item_post_id' => $membership_user_activeorder,
            'processname' => esc_html__('Published post edited by USER.','pointfindert2d'),
            'membership' => 1
            )
        );
      }else{
        PFCreateProcessRecord(
          array( 
                'user_id' => $user_id,
                'item_post_id' => $membership_user_activeorder,
            'processname' => esc_html__('Pending Approval post edited by USER.','pointfindert2d'),
            'membership' => 1
            )
        );
      }
    }else{
      /**
      *Rules;
      *	- If post editing
      *	- If post status not pending payment create a post meta item edited.
      *		- If post status pending approval and not approved before. don't create edit record for order meta.
      *	- If post status pending payment don't change status and not create record for edit.
      **/
      $checkemail_poststatus = get_post_status( $params['post_id']);
      if($checkemail_poststatus != 'pendingpayment'){
        if($checkemail_poststatus != 'pendingapproval'){
          $post_status = ($setup31_userlimits_userpublishonedit == 0) ? 'pendingapproval' : 'publish' ;
        }else{
          $post_status = 'pendingapproval';
          PFCreateProcessRecord(
            array( 
                  'user_id' => $user_id,
                  'item_post_id' => $params['post_id'],
              'processname' => esc_html__('Pending Approval post edited by USER.','pointfindert2d')
              )
          );
        }

        update_post_meta($params['order_post_id'], 'pointfinder_order_itemedit', 1 );
        
      }else{
        $post_status = 'pendingpayment';

        /* - Creating record for process system. */
        PFCreateProcessRecord(
          array( 
                'user_id' => $user_id,
                'item_post_id' => $params['post_id'],
            'processname' => esc_html__('Pending Payment post edited by USER.','pointfindert2d')
            )
        );
      }

      if($checkemail_poststatus == 'publish'){
        /* - Creating record for process system. */
        PFCreateProcessRecord(
          array( 
                'user_id' => $user_id,
                'item_post_id' => $params['post_id'],
            'processname' => esc_html__('Published post edited by USER.','pointfindert2d')
            )
        );
      }


      /* New Payment system  with v1.6.4 */
      if ($checkemail_poststatus == 'publish') {

        $pf_changed_value = array();
        $current_category_change = $pf_plan_changed_val = '';
        $pf_category_change = $pf_featured_change = $pf_plan_change = 0;

        /* Detect Featured Change */ 
        $pf_changed_featured = get_post_meta( $params['post_id'], "webbupointfinder_item_featuredmarker", true );
        if (empty($pf_changed_featured) && !empty($vars['featureditembox'])) {
          $pf_featured_change = 1;
          $pf_changed_value['featured'] = 1;
        }else{
          $pf_featured_change = 0;
          $pf_changed_value['featured'] = 0;
        }


        /* Detect Category Change if paid category selected */
        if (isset($vars['radio'])) {
          $item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
          if (isset($item_defaultvalue[0])) {
            $current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
            $current_category = $current_category['parent'];
          }
          if ($vars['radio'] == $current_category) {
            $pf_category_change = 0;
            $pf_changed_value['category'] = 0;
          }else{
            $pf_category_change = 1;
            $pf_changed_value['category'] = 1;
            $current_category_change = $vars['radio'];
          }
        }else{
          $pf_changed_value['category'] = 0;
          $pf_category_change = 0;
        }

        

        if (isset($vars['radio'])) {
          $current_category = $vars['radio'];
        }else{
          $item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
          if (isset($item_defaultvalue[0])) {
            $current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
            $current_category = $current_category['parent'];
          }
        }

        /* Detect Package Change */
        if (isset($vars['pfpackselector'])) {
          $current_selected_plan = get_post_meta( $params['order_post_id'], 'pointfinder_order_listingpid', true );

          if ($current_selected_plan == $vars['pfpackselector']) {
            $pf_plan_change = 0;
            $pf_changed_value['plan'] = 0;
          }else{
            $pf_plan_change = 1;
            $pf_changed_value['plan'] = 1;
            $pf_plan_changed_val = $vars['pfpackselector'];
          }
        }
        
        $pack_results = pointfinder_calculate_listingtypeprice($current_category_change,$pf_featured_change,$pf_plan_changed_val);

          $total_pr = $pack_results['total_pr'];
          $cat_price = $pack_results['cat_price'];
          $pack_price = $pack_results['pack_price'];
          $featured_price = $pack_results['featured_price'];
          $total_pr_output = $pack_results['total_pr_output'];
          $featured_pr_output = $pack_results['featured_pr_output'];
          $pack_pr_output = $pack_results['pack_pr_output'];
          $cat_pr_output = $pack_results['cat_pr_output'];
          $pack_title = $pack_results['pack_title'];


          if ($vars['pfpackselector'] == 1) {
            $duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
          }else{
            $duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
          if (empty($duration_package)) {
            $duration_package = 0;
          }
          };

        /* Create Order Sub Fields */
        update_post_meta($params['order_post_id'], 'pointfinder_sub_order_change', 1);
        update_post_meta($params['order_post_id'], 'pointfinder_sub_order_changedvals', $pf_changed_value);

        update_post_meta($params['order_post_id'], 'pointfinder_sub_order_price', $total_pr);
          update_post_meta($params['order_post_id'], 'pointfinder_sub_order_detailedprice', json_encode(array($pack_title => $total_pr)));
          update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingtime', $duration_package);
          update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingpname', $pack_title);	
        update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingpid', $vars['pfpackselector']);
        update_post_meta($params['order_post_id'], 'pointfinder_sub_order_category_price', $cat_price);

        
        if ($pf_featured_change == 1) {
          update_post_meta($params['order_post_id'], 'pointfinder_sub_order_featured', 1);
        }

        $returnval['pppso'] = 1;

      }elseif ($checkemail_poststatus == 'pendingpayment') {
        
        if ($vars['pf_lpacks_payment_selection'] == 'free') {
          $pricestatus = 'publish';
          $autoexpire_create = 1;
        }else{
          $pricestatus = 'pendingpayment';
        }

        if ($setup4_ppp_catprice == 1) {
          if (isset($vars['radio'])) {
            $current_category = $vars['radio'];
          }else{
            $item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
            if (isset($item_defaultvalue[0])) {
              $current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
              $current_category = $current_category['parent'];
            }
          }
        }else{
          $current_category = '';
        }
        
        if(empty($vars['featureditembox'])){
          $featured_item_box = 0;
          update_post_meta($params['order_post_id'], 'pointfinder_order_featured', 0);
          delete_post_meta($params['order_post_id'], 'pointfinder_order_expiredate_featured');
          update_post_meta($params['post_id'], 'webbupointfinder_item_featuredmarker', 0);
        }else{
          $featured_item_box = 1;
        }

        if (isset($vars['pfpackselector']) && isset($vars['radio'])) {
          if ($featured_item_box == 1 && (pointfinder_get_package_price_ppp($vars['pfpackselector']) != 0 || pointfinder_get_category_price_ppp($vars['radio']) != 0)) {
            update_post_meta($params['order_post_id'], 'pointfinder_order_fremoveback2', 1);
          }
        }

        $pack_results = pointfinder_calculate_listingtypeprice($current_category,$featured_item_box,$vars['pfpackselector']);

        $total_pr = $pack_results['total_pr'];
        $cat_price = $pack_results['cat_price'];
        $pack_price = $pack_results['pack_price'];
        $featured_price = $pack_results['featured_price'];
        $total_pr_output = $pack_results['total_pr_output'];
        $featured_pr_output = $pack_results['featured_pr_output'];
        $pack_pr_output = $pack_results['pack_pr_output'];
        $cat_pr_output = $pack_results['cat_pr_output'];
        $pack_title = $pack_results['pack_title'];

        if ($vars['pfpackselector'] == 1) {
          $duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
        }else{
          $duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
          if (empty($duration_package)) {
            $duration_package = 0;
          }
        };

        $setup31_userpayments_orderprefix = PFSAIssetControl('setup31_userpayments_orderprefix','','PF');
        
        $order_post_status = ($total_pr == 0)? 'completed' : 'pendingpayment';
      
        $arg_order = array(
          'ID' => $params['order_post_id'],
          'post_type'    => 'pointfinderorders',
          'post_status'   => $order_post_status
        );

        $order_post_id = wp_update_post($arg_order);

        $order_recurring = ($is_item_recurring == 1 && $total_pr != 0 ) ? '1' : '0';
        
        $setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','');
        $stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

        /* Order Meta */
        update_post_meta($params['order_post_id'], 'pointfinder_order_itemid', $params['post_id']);
        update_post_meta($params['order_post_id'], 'pointfinder_order_userid', $user_id);
        update_post_meta($params['order_post_id'], 'pointfinder_order_recurring', $order_recurring);
        update_post_meta($params['order_post_id'], 'pointfinder_order_price', $total_pr);
        update_post_meta($params['order_post_id'], 'pointfinder_order_detailedprice', json_encode(array($pack_title => $total_pr)));
        update_post_meta($params['order_post_id'], 'pointfinder_order_listingtime', $duration_package);
        update_post_meta($params['order_post_id'], 'pointfinder_order_listingpname', $pack_title);	
        update_post_meta($params['order_post_id'], 'pointfinder_order_listingpid', $vars['pfpackselector']);
        update_post_meta($params['order_post_id'], 'pointfinder_order_pricesign', $setup20_paypalsettings_paypal_price_short);
        update_post_meta($params['order_post_id'], 'pointfinder_order_category_price', $cat_price);

        if ($featured_item_box == 1) {
          update_post_meta($params['order_post_id'], 'pointfinder_order_featured', 1);
          update_post_meta($params['order_post_id'], 'pointfinder_order_frecurring', $order_recurring);
        }

        if ($selectedpayment == 'bank') {
          $returnval['pppsru'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2&i='.$params['post_id'];
          update_post_meta($params['order_post_id'], 'pointfinder_order_bankcheck', '1');
        }else{
          update_post_meta($params['order_post_id'], 'pointfinder_order_bankcheck', '0');
        }

        /* Start: Add expire date if this item is ready to publish (free listing) */
        if($autoexpire_create == 1){

          $userpublish = ($setup31_userlimits_userpublish == 0) ? 'pendingapproval' : 'publish' ;

          if($userpublish == 'publish' && $pricestatus == 'publish'){
            $post_status = 'publish';
          }elseif($userpublish == 'publish' && $pricestatus == 'pendingpayment'){
            $post_status = 'pendingpayment';
          }elseif($userpublish == 'pendingapproval' && $pricestatus == 'publish'){
            $post_status = 'pendingapproval';
          }elseif($userpublish == 'pendingapproval' && $pricestatus == 'pendingpayment'){
            $post_status = 'pendingpayment';
          }

          wp_update_post(array('ID' => $params['post_id'],'post_status' => $post_status) );
          
          $exp_date = date("Y-m-d H:i:s", strtotime("+".$duration_package." days"));
          $app_date = date("Y-m-d H:i:s");

          if ($featured_item_box == 1) {
            $exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
            update_post_meta( $params['order_post_id'], 'pointfinder_order_expiredate_featured', $exp_date_featured);
          }
          
          update_post_meta( $params['order_post_id'], 'pointfinder_order_expiredate', 3000000000 );
          update_post_meta( $params['order_post_id'], 'pointfinder_order_datetime_approval', $app_date);
          update_post_meta( $params['order_post_id'], 'pointfinder_order_bankcheck', '0');

          global $wpdb;
          $wpdb->UPDATE($wpdb->posts,array('post_status' => 'completed'),array('ID' => $params['order_post_id']));
          
          /* - Creating record for process system. */
          PFCreateProcessRecord(
            array( 
                  'user_id' => $user_id,
                  'item_post_id' => $params['post_id'],
              'processname' => esc_html__('Item status changed to Publish by Autosystem (Free Plan)','pointfindert2d')
              )
          );
        }
        /* End: Add expire date if this item is ready to publish (free listing) */

        /* - Creating record for process system. */
        PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $params['post_id'],'processname' => esc_html__('An item edited by USER.','pointfindert2d')));	
      }
    }

  }

  $arg = array(
    'ID'=> $params['post_id'],
    'post_type'    => $setup3_pointposttype_pt1,
    'post_title'    => sanitize_text_field($vars['item_title']),
    'post_content'  => (!empty($vars['item_desc']))?wp_kses_post($vars['item_desc']):'',
    'post_status'   => $post_status,
    'post_author'   => $user_id,
  );

  if ($params['post_id']!='') {
    $update_work = "ok";
    wp_update_post($arg);
    $post_id = $params['post_id'];
    $old_status_featured = get_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', true );
  }else{
    $update_work = "not";
    $post_id = wp_insert_post($arg);
    $old_status_featured = false;
    update_post_meta( $post_id, "webbupointfinder_item_reviewcount", 0);
  }



  if ($setup4_membersettings_paymentsystem == 2) {
    PFCreateProcessRecord(
      array( 
            'user_id' => $user_id,
            'item_post_id' => $membership_user_activeorder,
        'processname' => esc_html__('New item uploaded by USER.','pointfindert2d'),
        'membership' => 1
        )
    );
  }
  
  /** 
  *Send email to the user;
  *	- Check $post_id for edit
  *	- Don't send email if direct publish enabled on edit.
  *	- Don't send email if edited post status pendingpayment & pendingapproval
  **/
    if ($params['post_id'] != '') {
      
      if($checkemail_poststatus != 'pendingpayment' && $checkemail_poststatus != 'pendingapproval'){
        if ($setup31_userlimits_userpublishonedit == 0) {
          $user_email_action = 'send';
        }else{
          $user_email_action = 'cancel';
        }
      }else{
        $user_email_action = 'cancel';
      }
      
    }elseif ($params['post_id'] == '') {
      $user_email_action = 'send';
    }

    if($user_email_action == 'send'){

      if ($post_status == 'publish') {
        $email_subject = 'itemapproved';
      }elseif ($post_status == 'pendingpayment') {
        $email_subject = 'waitingpayment';
      }elseif ($post_status == 'pendingapproval') {
        $email_subject = 'waitingapproval';
      }
      $user_info = get_userdata( $user_id );

      pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $user_info->user_email,
              'predefined' => $email_subject,
              'data' => array('ID' => $post_id,'title'=>esc_html($vars['item_title'])),
          )
        );
    }
  

  /**
  *Send email to the admin;
  *	- System will not send email if disabled by PF Mail System
  *	- Don't send email if edited post status pendingpayment & pendingapproval
  **/

     $admin_email = get_option( 'admin_email' );
     $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
     

     if ($setup33_emailsettings_mainemail != '') {
      
      if ($params['post_id']!='') {
        $adminemail_subject = 'updateditemsubmission';
        $setup33_emaillimits_adminemailsafteredit = PFMSIssetControl('setup33_emaillimits_adminemailsafteredit','','1');
        if($checkemail_poststatus != 'pendingpayment' && $checkemail_poststatus != 'pendingapproval'){
          if ($setup33_emaillimits_adminemailsafteredit == 1) {
            $admin_email_action = 'send';
          }else{
            $admin_email_action = 'cancel';
          }
        }else{
          $admin_email_action = 'cancel';
        }
      }else{
        $adminemail_subject = 'newitemsubmission';
        $setup33_emaillimits_adminemailsafterupload = PFMSIssetControl('setup33_emaillimits_adminemailsafterupload','','1');
        if ($setup33_emaillimits_adminemailsafterupload == 1) {
          $admin_email_action = 'send';
        }else{
          $admin_email_action = 'cancel';
        }
      }

      if ($admin_email_action == 'send') {
        
        pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $setup33_emailsettings_mainemail,
              'predefined' => $adminemail_subject,
              'data' => array('ID' => $post_id,'title'=>esc_html($vars['item_title'])),
          )
        );
      }
     }
  
  $returnval['post_id'] = $post_id;

  if (isset($vars['issuer'])) {
    $returnval['issuer'] = $vars['issuer'];
  }
  

  /** Start: Taxonomies **/

    /*Listing Types*/

      $pftax_terms = '';

      if(isset($vars['pfupload_listingtypes'])){
        if(PFControlEmptyArr($vars['pfupload_listingtypes'])){
          $pftax_terms = $vars['pfupload_listingtypes'];
        }else if(!PFControlEmptyArr($vars['pfupload_listingtypes']) && isset($vars['pfupload_listingtypes'])){
          $pftax_terms = $vars['pfupload_listingtypes'];
          if (strpos($pftax_terms, ",") != false) {
            $pftax_terms = pfstring2BasicArray($pftax_terms);
          }else{
            $pftax_terms = array($vars['pfupload_listingtypes']);
          }
        }
      }

      if(!empty($pftax_terms)){
        if ($setup4_membersettings_paymentsystem == 2) {

          wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

        }else{

          if ($setup4_ppp_catprice == 1) {

            if ($update_work == "not") {

              wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

            }else{

              $item_defaultvalue = wp_get_post_terms($post_id, 'pointfinderltypes', array("fields" => "ids"));
              
              if (isset($item_defaultvalue[0])) {
                $current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
                $current_category = $current_category['parent'];
              }

              if (isset($vars['radio'])) {

                if ($post_status != "pendingpayment") {
                  $category_price_status = pointfinder_get_category_price_ppp($vars['radio']);

                  if (empty($category_price_status)) {
                    wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
                  }else{
                    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_termsmc', $current_category);
                    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_termsms', $vars['radio']);
                    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_terms', $pftax_terms);
                  }

                }else{

                  wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

                }
                
              }else{
                wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
              }
            }

          }else{
            wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
          }

        }
      }


    /*Item Types*/
    if(isset($vars['pfupload_itemtypes'])){
      if(PFControlEmptyArr($vars['pfupload_itemtypes'])){
        $pftax_terms = $vars['pfupload_itemtypes'];
      }else if(!PFControlEmptyArr($vars['pfupload_itemtypes']) && isset($vars['pfupload_itemtypes'])){
        $pftax_terms = array($vars['pfupload_itemtypes']);
      }
      wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderitypes');
    }

    /*Conditions*/
    if(isset($vars['pfupload_conditions'])){
      if(PFControlEmptyArr($vars['pfupload_conditions'])){
        $pftax_terms = $vars['pfupload_conditions'];
      }else if(!PFControlEmptyArr($vars['pfupload_conditions']) && isset($vars['pfupload_conditions'])){
        $pftax_terms = array($vars['pfupload_conditions']);
      }
      wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderconditions');
    }


    /*Locations Types*/
    if(isset($vars['pfupload_locations'])){

      $stp4_loc_new = PFSAIssetControl('stp4_loc_new','','0');
      $stp4_loc_add = PFSAIssetControl('stp4_loc_add','','0');
      
      if ($stp4_loc_new == 1 && $stp4_loc_add == 1 && !empty($vars['customlocation'])) {
        $stp4_loc_level = PFSAIssetControl('stp4_loc_level','',3);
        if ($stp4_loc_level == 2) {
          $retunlocation = wp_insert_term( $vars['customlocation'], 'pointfinderlocations', array('parent'=>$vars['pfupload_locations']) );
        }else{
          $retunlocation = wp_insert_term( $vars['customlocation'], 'pointfinderlocations', array('parent'=>$vars['pfupload_sublocations']) );
        }
        
        $pftax_terms = $retunlocation['term_id'];
      }else{
        if(PFControlEmptyArr($vars['pfupload_locations'])){
          $pftax_terms = $vars['pfupload_locations'];
        }else if(!PFControlEmptyArr($vars['pfupload_locations']) && isset($vars['pfupload_locations'])){
          $pftax_terms = array($vars['pfupload_locations']);
        }
      }

      wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderlocations');
    }


    /*Features Types*/
    if(isset($vars['pffeature'])){				
      if(PFControlEmptyArr($vars['pffeature'])){
        $pftax_terms = $vars['pffeature'];
      }else if(!PFControlEmptyArr($vars['pffeature']) && isset($vars['pffeature'])){
        $pftax_terms = array($vars['pffeature']);
      }
      wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderfeatures');
    }else{
      wp_set_post_terms( $post_id, '', 'pointfinderfeatures');
    }


    /* Post Tags */
    if (isset($vars['posttags'])) {wp_set_post_tags( $post_id, $vars['posttags'], true );}

  /** End: Taxonomies **/



  /** Start: Events **/

    if (isset($vars['field_startdate'])) {
      if (!empty($vars['field_startdate'])) {

        $start_time_hour = 0;
        $start_time_min = 0;

        if (isset($vars['field_starttime'])) {
          if (!empty($vars['field_starttime'])) {
            $start_time = explode(':', $vars['field_starttime']);
            if (isset($start_time[0])) {
              $start_time_hour = $start_time[0];
            }
            if (isset($start_time[1])) {
              $start_time_min = $start_time[1];
            }
          }
        }

        $field_startdate = date_parse_from_format($datetype, $vars['field_startdate']);
        $vars['field_startdate'] = strtotime(date("Y-m-d", mktime($start_time_hour, $start_time_min, 0, $field_startdate['month'], $field_startdate['day'], $field_startdate['year'])));

        update_post_meta($post_id, 'webbupointfinder_item_field_startdate', $vars['field_startdate']);
      }else{
        update_post_meta($post_id, 'webbupointfinder_item_field_startdate', '');
      }
    }

    if (isset($vars['field_enddate'])) {
      if (!empty($vars['field_enddate'])) {

        $end_time_hour = 0;
        $end_time_min = 0;
        
        if (isset($vars['field_endtime'])) {
          if (!empty($vars['field_endtime'])) {
            $end_time = explode(':', $vars['field_endtime']);
            if (isset($end_time[0])) {
              $end_time_hour = $end_time[0];
            }
            if (isset($end_time[1])) {
              $end_time_min = $end_time[1];
            }
          }
        }

        $field_enddate = date_parse_from_format($datetype, $vars['field_enddate']);
        $vars['field_enddate'] = strtotime(date("Y-m-d", mktime($end_time_hour, $end_time_min, 0, $field_enddate['month'], $field_enddate['day'], $field_enddate['year'])));

        update_post_meta($post_id, 'webbupointfinder_item_field_enddate', $vars['field_enddate']);
      }else{
        update_post_meta($post_id, 'webbupointfinder_item_field_enddate', '');
      }
    }

    if (isset($vars['field_starttime'])) {
      if (!empty($vars['field_starttime'])) {
        update_post_meta($post_id, 'webbupointfinder_item_field_starttime', $vars['field_starttime']);
      }else{
        update_post_meta($post_id, 'webbupointfinder_item_field_starttime', '');
      }
    }

    if (isset($vars['field_endtime'])) {
      if (!empty($vars['field_endtime'])) {
        update_post_meta($post_id, 'webbupointfinder_item_field_endtime', $vars['field_endtime']);
      }else{
        update_post_meta($post_id, 'webbupointfinder_item_field_endtime', '');
      }
    }

  /** End: Events **/




  /** Start: Opening Hours **/
    $setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
    $setup3_modulessetup_openinghours_ex = PFSAIssetControl('setup3_modulessetup_openinghours_ex','','1');

    if($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 0){

      $i = 1;
      while ( $i <= 7) {
        if(isset($vars['o'.$i])){
          update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i]);	
        }
        $i++;
      }

    }elseif($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 1){

      $i = 1;
      while ( $i <= 1) {
        if(isset($vars['o'.$i])){
          update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i]);	
        }
        $i++;
      }

    }elseif($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 2){

      $i = 1;
      while ( $i <= 7) {
        if(isset($vars['o'.$i.'_1']) && isset($vars['o'.$i.'_2'])){
          update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i.'_1'].'-'.$vars['o'.$i.'_2']);	
        }
        $i++;
      }

    }
  /** End: Opening Hours **/

  
  /** Start: Post Meta **/

    /*Featured*/

      if(!empty($vars['featureditembox']) && $params['post_id'] == ''){
        if($vars['featureditembox'] == 'on'){
          update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 1);	
        }else{
          update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);	
        }
      }elseif(empty($vars['featureditembox']) && $params['post_id'] == ''){
        update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);
      }
      

    /*Location*/
      if(isset($vars['pfupload_lat']) && isset($vars['pfupload_lng'])){
        $check_latlng = true;

        if ($check_latlng) {
          update_post_meta($post_id, 'webbupointfinder_items_location', ''.$vars['pfupload_lat'].','.$vars['pfupload_lng'].'');
        }else{
          update_post_meta($post_id, 'webbupointfinder_items_location', '');
        }
      }

    /*Addrress*/
      if(isset($vars['pfupload_address'])){
        update_post_meta($post_id, 'webbupointfinder_items_address', $vars['pfupload_address']);	
      }

    /*Message to Reviewer*/
      if (isset($vars['item_mesrev'])) {
        if (PFcheck_postmeta_exist('webbupointfinder_items_mesrev',$post_id)) { 
          $old_mesrev = get_post_meta($post_id, 'webbupointfinder_items_mesrev', true);
          $old_mesrev = json_decode($old_mesrev,true);

          if (is_array($old_mesrev)) {
            $old_mesrev = PFCleanArrayAttr('PFCleanFilters',$old_mesrev);
          } 

          $old_mesrev[] = array('message' => $vars['item_mesrev'], 'date' => date("Y-m-d H:i:s"));
          $old_mesrev = json_encode($old_mesrev);

          update_post_meta($post_id, 'webbupointfinder_items_mesrev', $old_mesrev);	
        }else{

          $old_mesrev = array();
          $old_mesrev[] = array('message' => $vars['item_mesrev'], 'date' => date("Y-m-d H:i:s"));
          $old_mesrev = json_encode($old_mesrev);

          add_post_meta ($post_id, 'webbupointfinder_items_mesrev', $old_mesrev);
        }; 
      }

    /** Start: Featured Video **/
      if(isset($vars['pfuploadfeaturedvideo'])){
        update_post_meta($post_id, 'webbupointfinder_item_video', esc_url($vars['pfuploadfeaturedvideo']));	
      }
    /** End: Featured Video **/

    /*Custom fields loop*/
      $pfstart = PFCheckStatusofVar('setup1_slides');
      $setup1_slides = PFSAIssetControl('setup1_slides','','');

      if($pfstart == true){

        foreach ($setup1_slides as &$value) {

              $customfield_statuscheck = PFCFIssetControl('setupcustomfields_'.$value['url'].'_frontupload','','0');
              $available_fields = array(1,2,3,4,5,7,8,9,14,15);
              
              if(in_array($value['select'], $available_fields) && $customfield_statuscheck != 0){
                 
          if(isset($vars[''.$value['url'].''])){

            if ($value['select'] == 15 && !empty($vars[''.$value['url'].''])) {
              $pfvalue = date_parse_from_format($datetype, $vars[''.$value['url'].'']);
              $vars[''.$value['url'].''] = strtotime(date("Y-m-d", mktime(0, 0, 0, $pfvalue['month'], $pfvalue['day'], $pfvalue['year'])));
            }

            if(!is_array($vars[''.$value['url'].''])){ 
              update_post_meta($post_id, 'webbupointfinder_item_'.$value['url'], $vars[''.$value['url'].'']);
            }else{
              if(PFcheck_postmeta_exist('webbupointfinder_item_'.$value['url'],$post_id)){
                delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
              };

              foreach ($vars[''.$value['url'].''] as $val) {
                add_post_meta ($post_id, 'webbupointfinder_item_'.$value['url'], $val);
              };

            };
          }else{
            if (PFcheck_postmeta_exist('webbupointfinder_item_'.$value['url'],$post_id)) { 
              delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
            }; 
          };

              };
              
            };
      };		

  /** End: Post Meta **/

  /*Old Image upload for Backup*/
    $setup4_submitpage_status_old = PFSAIssetControl('setup4_submitpage_status_old','','0');

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9') !== false || $setup4_submitpage_status_old == 1) {

      if (!empty($vars['pfuploadimagesrc'])) {
      
        $uploadimages = pfstring2BasicArray($vars['pfuploadimagesrc']);
        $i = 0;
        foreach ($uploadimages as $uploadimage) {
          delete_post_meta( $uploadimage, 'pointfinder_delete_unused');
          $postthumbid = get_post_thumbnail_id($post_id);
          if ($update_work == "ok" && $postthumbid != false) {
            add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);
          }else{
            if($i != 0){
               add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);
            }else{
               set_post_thumbnail( $post_id, $uploadimage );
            }
          }
          $i++;
        }
        
      }
    }elseif ($setup4_submitpage_status_old == 0){
      if (!empty($vars['pfuploadimagesrc'])) {
        if ($params['order_post_id'] == '') {
          $uploadimages = pfstring2BasicArray($vars['pfuploadimagesrc']);
          $i = 0;
          foreach ($uploadimages as $uploadimage) {
            delete_post_meta( $uploadimage, 'pointfinder_delete_unused');
            if($i != 0){
               add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);	
            }else{
               set_post_thumbnail( $post_id, $uploadimage );
            }
            $i++;
          }
        }
      }
    }

  /*File Upload System*/
    $stp4_fupl = PFSAIssetControl('stp4_fupl','','0');

    if($stp4_fupl == 1) {

      if (!empty($vars['pfuploadfilesrc'])) {
      
        $uploadfiles = pfstring2BasicArray($vars['pfuploadfilesrc']);
        $i = 0;
        foreach ($uploadfiles as $uploadfile) {
          delete_post_meta( $uploadfile, 'pointfinder_delete_unused');
          add_post_meta($post_id, 'webbupointfinder_item_files', $uploadfile);
          $i++;
        }
        
      }
    }

  /*Custom Tabs System*/
  
    if (!empty($vars['webbupointfinder_item_custombox1'])) {
      $vars['webbupointfinder_item_custombox1'] = (!empty($vars['webbupointfinder_item_custombox1']))?wp_kses_post($vars['webbupointfinder_item_custombox1']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox1', $vars['webbupointfinder_item_custombox1']);	
    }
  
  
    if (!empty($vars['webbupointfinder_item_custombox2'])) {
      $vars['webbupointfinder_item_custombox2'] = (!empty($vars['webbupointfinder_item_custombox2']))?wp_kses_post($vars['webbupointfinder_item_custombox2']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox2', $vars['webbupointfinder_item_custombox2']);	
    }
  
  
    if (!empty($vars['webbupointfinder_item_custombox3'])) {
      $vars['webbupointfinder_item_custombox3'] = (!empty($vars['webbupointfinder_item_custombox3']))?wp_kses_post($vars['webbupointfinder_item_custombox3']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox3', $vars['webbupointfinder_item_custombox3']);	
    }

    if (!empty($vars['webbupointfinder_item_custombox4'])) {
      $vars['webbupointfinder_item_custombox4'] = (!empty($vars['webbupointfinder_item_custombox4']))?wp_kses_post($vars['webbupointfinder_item_custombox4']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox4', $vars['webbupointfinder_item_custombox4']);	
    }

    if (!empty($vars['webbupointfinder_item_custombox5'])) {
      $vars['webbupointfinder_item_custombox5'] = (!empty($vars['webbupointfinder_item_custombox5']))?wp_kses_post($vars['webbupointfinder_item_custombox5']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox5', $vars['webbupointfinder_item_custombox5']);	
    }

    if (!empty($vars['webbupointfinder_item_custombox6'])) {
      $vars['webbupointfinder_item_custombox6'] = (!empty($vars['webbupointfinder_item_custombox6']))?wp_kses_post($vars['webbupointfinder_item_custombox6']):'';
      update_post_meta($post_id, 'webbupointfinder_item_custombox6', $vars['webbupointfinder_item_custombox6']);	
    }
    
  
  
  if ($setup4_membersettings_paymentsystem == 2) {
    /* - Creating record for process system. */
    PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $membership_user_activeorder,'processname' => esc_html__('A new item uploaded by USER.','pointfindert2d'),'membership' => 1));	
  }else{
    /** Orders: Post Info **/
    if ($params['order_post_id'] == '' && $params['post_id'] == '') {

      /* New order system
      $vars['pfpackselector'];//2461 paket
      $vars['featureditembox'];//on
      $vars['radio'];// pf listing type
      $vars['pf_lpacks_payment_selection'];//payment selector
      */
      if(empty($vars['featureditembox'])){
        $featured_item_box = 0;
      }else{
        $featured_item_box = 1;
      }


      $pack_results = pointfinder_calculate_listingtypeprice($vars['radio'],$featured_item_box,$vars['pfpackselector']);

        $total_pr = $pack_results['total_pr'];
        $cat_price = $pack_results['cat_price'];
        $pack_price = $pack_results['pack_price'];
        $featured_price = $pack_results['featured_price'];
        $total_pr_output = $pack_results['total_pr_output'];
        $featured_pr_output = $pack_results['featured_pr_output'];
        $pack_pr_output = $pack_results['pack_pr_output'];
        $cat_pr_output = $pack_results['cat_pr_output'];
        $pack_title = $pack_results['pack_title'];

        if ($vars['pfpackselector'] == 1) {
          $duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
        }else{
          $duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
        if (empty($duration_package)) {
          $duration_package = 0;
        }
        };

      srand(pfmake_seed());

      $setup31_userpayments_orderprefix = PFSAIssetControl('setup31_userpayments_orderprefix','','PF');
      
      $order_post_title = ($params['order_title'] != '') ? $params['order_title'] : $setup31_userpayments_orderprefix.rand();
      $order_post_status = ($total_pr == 0)? 'completed' : 'pendingpayment';
    
      $arg_order = array(
        'post_type'    => 'pointfinderorders',
        'post_title'	=> $order_post_title,
        'post_status'   => $order_post_status,
        'post_author'   => $user_id,
      );

      $order_post_id = wp_insert_post($arg_order);

      $order_recurring = ($is_item_recurring == 1 && $total_pr != 0 ) ? '1' : '0';
      
      $setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','');
      $stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

      /* Order Meta */
      add_post_meta($order_post_id, 'pointfinder_order_itemid', $post_id, true );
      add_post_meta($order_post_id, 'pointfinder_order_userid', $user_id, true );
      add_post_meta($order_post_id, 'pointfinder_order_recurring', $order_recurring, true );
      add_post_meta($order_post_id, 'pointfinder_order_price', $total_pr, true );
      add_post_meta($order_post_id, 'pointfinder_order_detailedprice', json_encode(array($pack_title => $total_pr)), true );
      add_post_meta($order_post_id, 'pointfinder_order_listingtime', $duration_package, true );
      add_post_meta($order_post_id, 'pointfinder_order_listingpname', $pack_title, true );	
      add_post_meta($order_post_id, 'pointfinder_order_listingpid', $vars['pfpackselector'], true );
      add_post_meta($order_post_id, 'pointfinder_order_pricesign', $setup20_paypalsettings_paypal_price_short, true );
      add_post_meta($order_post_id, 'pointfinder_order_category_price', $cat_price);

      if ($featured_item_box == 1) {
        add_post_meta($order_post_id, 'pointfinder_order_featured', 1);
        add_post_meta($order_post_id, 'pointfinder_order_frecurring', $order_recurring, true );
      }

      if ($selectedpayment == 'bank') {
        $returnval['pppsru'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2&i='.$post_id;
        add_post_meta($order_post_id, 'pointfinder_order_bankcheck', '1');
      }else{
        add_post_meta($order_post_id, 'pointfinder_order_bankcheck', '0');
      }
      
      if (isset($vars['pfpackselector'])) {
        if ($featured_item_box == 1 && pointfinder_get_package_price_ppp($vars['pfpackselector']) == 0) {
          update_post_meta($order_post_id, 'pointfinder_order_fremoveback', 1);
        }
      }

      if (isset($vars['pfpackselector']) && isset($vars['radio'])) {
        if ($featured_item_box == 1 && (pointfinder_get_package_price_ppp($vars['pfpackselector']) != 0 || pointfinder_get_category_price_ppp($vars['radio']) != 0)) {
          update_post_meta($order_post_id, 'pointfinder_order_fremoveback2', 1);
        }
      }
      


      /* Start: Add expire date if this item is ready to publish (free listing) */
      if($autoexpire_create == 1){
        
        $exp_date = date("Y-m-d H:i:s", strtotime("+".$duration_package." days"));
        $app_date = date("Y-m-d H:i:s");

        if ($featured_item_box == 1) {
          $exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
          update_post_meta( $order_post_id, 'pointfinder_order_expiredate_featured', $exp_date_featured);
        }
        
        update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
        update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);

        if (PFcheck_postmeta_exist('pointfinder_order_bankcheck',$order_post_id)) { 
          update_post_meta($order_post_id, 'pointfinder_order_bankcheck', '0');	
        };

        global $wpdb;
        $wpdb->UPDATE($wpdb->posts,array('post_status' => 'completed'),array('ID' => $order_post_id));
        
        /* - Creating record for process system. */
        PFCreateProcessRecord(
          array( 
                'user_id' => $user_id,
                'item_post_id' => $post_id,
            'processname' => esc_html__('Item status changed to Publish by Autosystem','pointfindert2d')
            )
        );
      }
      /* End: Add expire date if this item is ready to publish (free listing) */

      /* - Creating record for process system. */
      PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $post_id,'processname' => esc_html__('A new item uploaded by USER.','pointfindert2d')));	
    }
    /** Orders: Post Info **/
  }
    
  
  if ($params['post_id'] == '') {
    $returnval['sccval'] = sprintf(esc_html__('New item successfully added. %s You are redirecting to my items page...','pointfindert2d'),'<br/>');
  }else{
    $returnval['sccval'] = sprintf(esc_html__('Your item successfully updated. %s You are redirecting to my items page...','pointfindert2d'),'<br/>');
  }
  
  /*Membership limits for item /featured limit*/
  if ($setup4_membersettings_paymentsystem == 2) {
    
      $membership_user_item_limit = get_user_meta( $user_id, 'membership_user_item_limit', true );
      $membership_user_featureditem_limit = get_user_meta( $user_id, 'membership_user_featureditem_limit', true );
      
      if (!empty($membership_user_item_limit)){
        // occasionfranchise
        // si l'annonce a déjà été complétée (déjà créée et achetée)
        // si l'annonce est en attente de paiement
        // si l'utilisateur a suffisemment de crédit
        if(
            (
              $update_work == "ok"
              &&
              $original_status_of_order == "completed"
              &&
              $original_status_of_post == "pendingpayment"
              &&
              $membership_user_item_limit >= 1
            )
            ||
            $update_work == "not"
          ){
          $membership_user_item_limit = $membership_user_item_limit - 1;
          update_user_meta($user_id, 'membership_user_item_limit', $membership_user_item_limit);
          update_post_meta($post_id, 'of_webbupointfinder_item_expire', strtotime('+1 year')); // Crée ou modifie la date d'expiration
          delete_post_meta($post_id, 'webbupointfinder_item_exemail'); // On s'assure que ce champ soit abscent (utilisé pour vérifier si le courriel de notification d'expiration de l'annonce a été envoyé)
        }
      }


      if(!empty($vars['featureditembox'])){
        
        if($vars['featureditembox'] == 'on' && $update_work == "not"){
          
          $membership_user_featureditem_limit = $membership_user_featureditem_limit - 1;
          update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
        
        }elseif ($vars['featureditembox'] == 'on' && $update_work == "ok") {
          
          if (empty($old_status_featured) && $membership_user_featureditem_limit > 0) {
            $membership_user_featureditem_limit = $membership_user_featureditem_limit - 1;
            update_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', 1);
            update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
          }elseif (empty($old_status_featured) && $membership_user_featureditem_limit <= 0) {
            update_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', 0);
          }

        }
      }else{
        if ($old_status_featured != false && $old_status_featured != 0) {
          update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);
          $membership_user_featureditem_limit = $membership_user_featureditem_limit + 1;
          update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
        }
      }
  }

  return $returnval;
}

function OF_pointfinder_minvoices_add_meta_box($post_type) {
  if ($post_type == 'pointfinderinvoices') {
    
    add_meta_box(
      'pointfinder_invoices_info',
      esc_html__( 'INVOICE INFO', 'pointfindert2d' ),
      'pointfinder_minvoices_meta_box_orderinfo',
      'pointfinderinvoices',
      'side',
      'high'
    );

    add_meta_box(
      'pointfinder_invoices_process',
      esc_html__( 'INVOICE DETAIL', 'pointfindert2d' ),
      'OF_pointfinder_minvoices_meta_box_orderprocess',
      'pointfinderinvoices',
      'normal',
      'core'
    );
  }
}

function pointfinder_admin_head_custompost_listing_child() {
  global $post_type;
  
  /* Main post type filters */
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
  if($post_type == $setup3_pointposttype_pt1){
    $setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
    $setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
    $pftaxarray = array('pointfinderltypes');
    if($setup3_pointposttype_pt4_check == 1){$pftaxarray[] = 'pointfinderitypes';}  
    if($setup3_pointposttype_pt5_check == 1){$pftaxarray[] = 'pointfinderlocations';}
    
    
    if (PFASSIssetControl('st8_ncptsys','',0) != 1) {
      require_once( get_template_directory().'/admin/estatemanagement/taxonomy-filter-class.php');
      new Tax_CTP_Filter(array($setup3_pointposttype_pt1 => $pftaxarray));
    }

    /* One click item approval */
    if (isset($_GET['publishitemid']) && current_user_can( 'publish_posts' )) {
      if (!empty($_GET['publishitemid'])) {
        $itemid = sanitize_text_field($_GET['publishitemid']);
        if (get_post_status($itemid) != 'publish') {
          wp_update_post(array('ID' => $itemid, 'post_status' => 'publish'));
        }
      }
    }
  }

  /* One click review approval */
  if ($post_type == 'pointfinderreviews') {
    if (isset($_GET['publishrevid']) && current_user_can( 'publish_posts' )) {
      if (!empty($_GET['publishrevid'])) {
        $revid = sanitize_text_field($_GET['publishrevid']);
        if (get_post_status($revid) != 'publish') {
          wp_update_post(array('ID' => $revid, 'post_status' => 'publish'));
        }
      }
    }
  }
}

/* Additional Filters
add_action( 'admin_head-post.php', 'pointfinder_admin_head_post_editing' );
add_action( 'admin_head-post-new.php',  'pointfinder_admin_head_post_new' );

function pointfinder_admin_head_post_editing() {
  //edit
}

function pointfinder_admin_head_post_new() {
//edit
}
*/

function OF_pointfinder_minvoices_meta_box_orderprocess( $post ) {
  echo '<ul class="pforders-orderdetails-ul">';

    global $wpdb;
    $post_author = $wpdb->get_var($wpdb->prepare("SELECT post_author FROM $wpdb->posts WHERE post_type = %s and ID = %d",'pointfinderinvoices',$post->ID));

    $user = get_user_by( 'id', $post_author );

    echo '<li>';
    esc_html_e( 'USER : ', 'pointfindert2d' );
    echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_user_link($post_author).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$user->nickname.'('.$post_author.')</a></div>';
    echo '</li> ';
    
    echo '<li>';
    esc_html_e( 'AMOUNT : ', 'pointfindert2d' );
    $unformated_amount = get_post_meta( $post->ID, 'pointfinder_invoice_amount', true );
    $formated_amount = pointfinder_reformat_pricevalue_for_frontend($unformated_amount);
    echo '<div class="pforders-orderdetails-lbltext">'.$formated_amount.'</div>';
    echo '</li> ';

    echo '<li>';
    esc_html_e( 'GST : ', 'pointfindert2d' );
    $unformated_gst_amount = get_post_meta( $post->ID, 'pointfinder_invoice_gst', true );
    $formated_gst_amount = pointfinder_reformat_pricevalue_for_frontend($unformated_gst_amount);
    echo '<div class="pforders-orderdetails-lbltext">'.$formated_gst_amount.'</div>';
    echo '</li> ';
    
    echo '<li>';
    esc_html_e( 'QST : ', 'pointfindert2d' );
    $unformated_qst_amount = get_post_meta( $post->ID, 'pointfinder_invoice_qst', true );
    $formated_qst_amount = pointfinder_reformat_pricevalue_for_frontend($unformated_qst_amount);
    echo '<div class="pforders-orderdetails-lbltext">'.$formated_qst_amount.'</div>';
    echo '</li> ';
    
    $orderid = get_post_meta( $post->ID, 'pointfinder_invoice_orderid', true );

    if (!empty($orderid)) {
      echo '<li>';
      esc_html_e( 'ORDER ID : ', 'pointfindert2d' );
      echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($orderid).'">'.get_the_title($orderid).'</a></div>';
      echo '</li> ';
    }
    
    echo '<li>';
    esc_html_e( 'TYPE : ', 'pointfindert2d' );
    echo '<div class="pforders-orderdetails-lbltext">'.get_post_meta( $post->ID, 'pointfinder_invoice_invoicetype', true ).'</div>';
    echo '</li> ';

    $invoice_itemid = get_post_meta( $post->ID, 'pointfinder_invoice_itemid', true );
    $invoice_packid = get_post_meta( $post->ID, 'pointfinder_invoice_packageid', true );

    if (!empty($invoice_itemid)) {
      echo '<li>';
      esc_html_e( 'INVOICE ITEM : ', 'pointfindert2d' );
      echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($invoice_itemid).'">'.$invoice_itemid.'-'.get_the_title($invoice_itemid).'</a></div>';
      echo '</li> ';
    }

    if (!empty($invoice_packid)) {
      echo '<li>';
      esc_html_e( 'INVOICE PLAN : ', 'pointfindert2d' );
      echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($invoice_packid).'">'.get_the_title($invoice_packid).'</a></div>';
      echo '</li> ';
    }

    echo '<li>';
    esc_html_e( 'DATE : ', 'pointfindert2d' );
    echo '<div class="pforders-orderdetails-lbltext">'.PFU_DateformatS(get_post_meta( $post->ID, 'pointfinder_invoice_date', true ),1).'</div>';
    echo '</li> ';

  echo '</ul>';
}

function pf_ajax_itemsystem_child(){
  check_ajax_referer( 'pfget_itemsystem', 'security');
	header('Content-Type: application/json; charset=UTF-8;');

	// Get form variables
  if(isset($_POST['formtype']) && $_POST['formtype']!=''){
    $formtype = $processname = esc_attr($_POST['formtype']);
  }

  // Get data
  $vars = array();
  if(isset($_POST['dt']) && $_POST['dt']!=''){
    if ($formtype == 'delete') {
      $pid = sanitize_text_field($_POST['dt']);
    }else{
      $vars = array();
      parse_str($_POST['dt'], $vars);

      if (is_array($vars)) {
          $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
      } else {
          $vars = esc_attr($vars);
      }
    }
    
  }

  // WPML Fix
  $lang_c = '';
  if(isset($_POST['lang']) && $_POST['lang']!=''){
    $lang_c = sanitize_text_field($_POST['lang']);
  }
  if(function_exists('icl_t')) {
    if (!empty($lang_c)) {
      do_action( 'wpml_switch_language', $lang_c );
    }
  }


  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;

  $returnval = $errorval = $pfreturn_url = $msg_output = $overlay_add = $sccval = '';
  $icon_processout = 62;
	
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

  if ($formtype == 'delete') {
    //**
    //*Start: Delete Item for PPP/Membership
    //**
      if($user_id != 0){

        $delete_postid = (is_numeric($pid))? $pid:'';

        if ($delete_postid != '') {
          $old_status_featured = false;
          $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
      
          if ($setup4_membersettings_paymentsystem == 2) {

            // Check if item user s item
            global $wpdb;

            $result = $wpdb->get_results( $wpdb->prepare( 
              "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
              $delete_postid,
              $user_id,
              $setup3_pointposttype_pt1
            ) );
            
            if (is_array($result) && count($result)>0) {
              if ($result[0]->ID == $delete_postid) {
                $delete_item_images = get_post_meta($delete_postid, 'webbupointfinder_item_images');
                if (!empty($delete_item_images)) {
                  foreach ($delete_item_images as $item_image) {
                    wp_delete_attachment(esc_attr($item_image),true);
                  }
                }
                wp_delete_attachment(get_post_thumbnail_id( $delete_postid ),true);
                //$old_status_featured = get_post_meta( $delete_postid, 'webbupointfinder_item_featuredmarker', true );
                wp_delete_post($delete_postid);


                $membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );
                // Creating record for process system
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $membership_user_activeorder,
                    'processname' => esc_html__('Item deleted by USER.','pointfindert2d'),
                    'membership' => 1
                    )
                );

                // Create a record for payment system
              
                $sccval .= esc_html__('Item successfully deleted. Refreshing...','pointfindert2d');
              }

            }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Wrong item ID or already deleted. Item can not delete.','pointfindert2d');
            }

            /*
            // Membership limits for item /featured limit
            
            $membership_user_featureditem_limit = get_user_meta( $user_id, 'membership_user_featureditem_limit', true );
            $membership_user_item_limit = get_user_meta( $user_id, 'membership_user_item_limit', true );
            
            $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
            $packageinfox = pointfinder_membership_package_details_get($membership_user_package_id);

            if ($membership_user_item_limit == -1) {
              // Do nothing...
            }else{

              if ($membership_user_item_limit >= 0) {
                $membership_user_item_limit = $membership_user_item_limit + 1;
                if ($membership_user_item_limit <= $packageinfox['webbupointfinder_mp_itemnumber']) {
                  update_user_meta( $user_id, 'membership_user_item_limit', $membership_user_item_limit);
                }
              }
            }

            if($old_status_featured != false && $old_status_featured != 0){

              $membership_user_featureditem_limit = $membership_user_featureditem_limit + 1;
              if ($membership_user_featureditem_limit <= $packageinfox['webbupointfinder_mp_fitemnumber']) {
                update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
              } 
            }
            */
            
          } else {
            /*Check if item user s item*/
            global $wpdb;

            $result = $wpdb->get_results( $wpdb->prepare( 
              "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
              $delete_postid,
              $user_id,
              $setup3_pointposttype_pt1
            ) );


            $result_id = $wpdb->get_var( $wpdb->prepare(
              "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 
              'pointfinder_order_itemid',
              $delete_postid
            ) );

            $pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));

            if($pointfinder_order_recurring == 1){

              $pointfinder_order_recurringid = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurringid', true ));
              PF_Cancel_recurring_payment(
               array( 
                      'user_id' => $user_id,
                      'profile_id' => $pointfinder_order_recurringid,
                      'item_post_id' => $delete_postid,
                      'order_post_id' => $result_id,
                  )
               );
            }

            
            if (is_array($result) && count($result)>0) {  
              if ($result[0]->ID == $delete_postid) {
                $delete_item_images = get_post_meta($delete_postid, 'webbupointfinder_item_images');
                if (!empty($delete_item_images)) {
                  foreach ($delete_item_images as $item_image) {
                    wp_delete_attachment(esc_attr($item_image),true);
                  }
                }
                wp_delete_attachment(get_post_thumbnail_id( $delete_postid ),true);
                wp_delete_post($delete_postid);

                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $delete_postid,
                    'processname' => esc_html__('Item deleted by USER.','pointfindert2d')
                    )
                );

                /* - Create a record for payment system. */
              
                $sccval .= esc_html__('Item successfully deleted. Refreshing...','pointfindert2d');
              }

            }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Wrong item ID (Not your item!). Item can not delete.','pointfindert2d');
            }
          }
      
        }else{
          $icon_processout = 485;
          $errorval .= esc_html__('Wrong item ID.','pointfindert2d');
        }
      }else{
        $icon_processout = 485;
        $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
      }

        if (!empty($sccval)) {
          $msg_output .= $sccval;
          $overlay_add = ' pfoverlayapprove';
        }elseif (!empty($errorval)) {
          $msg_output .= $errorval;
        }
    /**
    *End: Delete Item for PPP/Membership
    **/
  } else {
    /**
    *Start: New/Edit Item Form Request
    **/ 

      if(isset($_POST) && $_POST!='' && count($_POST)>0){
          if($user_id != 0){
            if($vars['action'] == 'pfget_edititem'){
              
              
              if (isset($vars['edit_pid']) && !empty($vars['edit_pid'])) {
                $edit_postid = $vars['edit_pid'];
                global $wpdb;

                $result = $wpdb->get_results( $wpdb->prepare( 
                  "
                    SELECT ID, post_author
                    FROM $wpdb->posts 
                    WHERE ID = %s and post_author = %s and post_type = %s
                  ", 
                  $edit_postid,
                  $user_id,
                  $setup3_pointposttype_pt1
                ) );

                if (is_array($result) && count($result)>0) {
                  if ($result[0]->ID == $edit_postid) {
                    $returnval = PFU_AddorUpdateRecord(
                      array(
                        'post_id' => $edit_postid,
                            'order_post_id' => PFU_GetOrderID($edit_postid,1),
                            'order_title' => PFU_GetOrderID($edit_postid,0),
                        'vars' => $vars,
                        'user_id' => $user_id
                      )
                    );
                  }else{
                    $icon_processout = 485;
                    $errorval .= esc_html__('This is not your item.','pointfindert2d');
                  }
                }else{
                  $icon_processout = 485;
                  $errorval .= esc_html__('Wrong Item ID','pointfindert2d');
                }
              }else{
                $icon_processout = 485;
                $errorval .= esc_html__('There is no item ID to edit.','pointfindert2d');
              }
            }elseif ($vars['action'] == 'pfget_uploaditem') {           
              $returnval = PFU_AddorUpdateRecord(
                array(
                  'post_id' => '',
                      'order_post_id' => '',
                      'order_title' => '',
                  'vars' => $vars,
                  'user_id' => $user_id
                )
              );   
            }
          }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
          }   
      }

      if (is_array($returnval) && !empty($returnval)) {
        if (isset($returnval['sccval'])) {
          $msg_output .= $returnval['sccval'];
          $overlay_add = ' pfoverlayapprove';
        }elseif (isset($returnval['errorval'])) {
          $msg_output .= $returnval['errorval'];
        }
      }else{
        $msg_output .= $errorval;
      }
    /**
    *End: New/Edit Item Form Request
    **/
  }
  
  

  
  $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
  $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
  $pfmenu_perout = PFPermalinkCheck();

  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';

  $output_html = '';
  $output_html .= '<div class="golden-forms wrapper mini" style="height:200px">';
  $output_html .= '<div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay">';
  $output_html .= "<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div>";
  $output_html .= "<div class='pfrevoverlaytext".$overlay_add."'><i class='pfadmicon-glyph-".$icon_processout."'></i><span>".$msg_output."</span></div>";
  $output_html .= '</div>';
  $output_html .= '</div>';    

  if (!empty($errorval)) {  
    echo json_encode( 
      array( 
        'process'=>false, 
        'processname'=>$processname, 
        'mes'=>$output_html, 
        'returnurl' => $pfreturn_url
        )
      );
  }else{
      echo json_encode( 
        array( 
          'process'=>true, 
          'processname'=>$processname, 
          'returnval'=>$returnval, 
          'mes'=>$output_html, 
          'returnurl' => $pfreturn_url
          )
        );
  }


  die();
}

function OF_pf_ajax_membershippaymentsystem(){
	//Security
  check_ajax_referer( 'pfget_membershipsystem', 'security');
  
	header('Content-Type: text/html; charset=UTF-8;');

	//Get form type
  if(isset($_POST['pid']) && $_POST['pid']!=''){
    $pid = esc_attr($_POST['pid']);
  }

  if(isset($_POST['ptype']) && $_POST['ptype']!=''){
    $ptype = esc_attr($_POST['ptype']);
  }

  if(isset($_POST['lang']) && $_POST['lang']!=''){
    $lang_c = sanitize_text_field($_POST['lang']);
  }

  if(function_exists('icl_t')) {
    if (!empty($lang_c)) {
      do_action( 'wpml_switch_language', $lang_c );
    }
  }

  $output = '';

  if (!empty($pid) && !empty($ptype)) {
    $bank_status = PFSAIssetControl('setup20_paypalsettings_bankdeposit_status','','0');
    $paypal_status = PFSAIssetControl('setup20_paypalsettings_paypal_status','','1');
    $stripe_status = PFSAIssetControl('setup20_stripesettings_status','','0');
    $pags_status = PFPGIssetControl('pags_status','','0');
    $payu_status = PFPGIssetControl('payu_status','','0');
    $ideal_status = PFPGIssetControl('ideal_status','','0');
    $robo_status = PFPGIssetControl('robo_status','','0');
    $iyzico_status = PFPGIssetControl('iyzico_status','','0');

    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    $active_order_ex = get_user_meta($user_id, 'membership_user_activeorder_ex',true );
    if ($active_order_ex != false && !empty($active_order_ex)) {
      $bank_current = get_post_meta( $active_order_ex, 'pointfinder_order_bankcheck', 1);
    } else {
      $bank_current = false;
    }
    
    

    $packageinfo = pointfinder_membership_package_details_get($pid);

    /*Package payment total*/
    $output .= '<div class="pf-membership-price-header">'.esc_html__('Selected Package','pointfindert2d').'</div>';
    $output .= '
    <div class="pf-membership-package-box">
      <div class="pf-membership-package-title">' . get_the_title($pid) . '</div>
      <div class="pf-membership-package-info">
        <ul>
          <li><span class="pf-membership-package-info-title">'.esc_html__('Number of ads included in the package:','pointfindert2d').'</span> <strong>'.$packageinfo['packageinfo_itemnumber_output_text'].'</strong></li>
          <li><span class="pf-membership-package-info-title">'.esc_html__('Display duration of an ad:','pointfindert2d').'</span> <strong>'.$packageinfo['webbupointfinder_mp_billing_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text'].'</strong></li>
          ';
        if ($packageinfo['webbupointfinder_mp_trial'] == 1 && $packageinfo['packageinfo_priceoutput'] != 0) {
          $output .= '<li><span class="pf-membership-package-info-title">'.esc_html__('Trial Period:','pointfindert2d').'</span> '.$packageinfo['webbupointfinder_mp_trial_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text'].' <br/><small>'.esc_html__('Note: Your listing will expire end of trial period.','pointfindert2d').'</small></li>';
        }
        /*
        if (!empty($packageinfo['webbupointfinder_mp_description'])) {
          $output.= '<li><span class="pf-membership-package-info-title">'.esc_html__('Description:','pointfindert2d').'</span> '.$packageinfo['webbupointfinder_mp_description'].'</li>';
        }
        */

        $setup4_pricevat = PFSAIssetControl('setup4_pricevat','','0');
        if ($setup4_pricevat == 1) {
          $setup4_pv_pr = PFSAIssetControl('setup4_pv_pr','','0');
          $output .= '<li style="margin-top:10px;font-weight:600;"><span class="pf-membership-package-info-title">'.esc_html__("Sub Total:",'pointfindert2d').' </span> '.$packageinfo['packageinfo_priceoutput_bfvat_text'].'</li>';
          $output .= '<li style="font-weight:600;"><span class="pf-membership-package-info-title">'.sprintf(esc_html__("GST (%s):",'pointfindert2d'),'5%').' </span> '.$packageinfo['packageinfo_priceoutput_gst_text'].'</li>';
          $output .= '<li style="font-weight:600;"><span class="pf-membership-package-info-title">'.sprintf(esc_html__("QST (%s):",'pointfindert2d'),'9,9975%').' </span> '.$packageinfo['packageinfo_priceoutput_qst_text'].'</li>';
        }

        $output .= '<li style="margin-top:10px;font-weight:600;"><span class="pf-membership-package-info-title">'.esc_html__('Total:','pointfindert2d').' </span>'.$packageinfo['packageinfo_priceoutput_text'].'</li>';

        
        $output .= '
        </ul>
      </div>
    </div>';

   

    /*Payment Options*/
    if ($packageinfo['packageinfo_priceoutput'] != 0) {
      $output .= '<div class="pf-membership-price-header">'.esc_html__('Payment Options','pointfindert2d').'</div>';
      if ($packageinfo['webbupointfinder_mp_trial'] == 1  && ($ptype != 'renewplan' && $ptype != 'upgradeplan')) {        
        $output .= '
          <div class="pf-membership-upload-option">
            <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-trial" value="trial">
            <label for="pfm-payment-trial">'.esc_html__('Trial Period (Free)','pointfindert2d').'</label>
            <div class="pfm-active">
            <p>'.sprintf(__('You can use this package trial for %d %s','pointfindert2d'),$packageinfo['webbupointfinder_mp_trial_period'], $packageinfo['webbupointfinder_mp_billing_time_unit_text']).'</p>
            </div>
          </div>';
      }

      if ($bank_status == 1) {
       
        if ($bank_current != false && !empty($bank_current)) {
          $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-bank" value="bank" disabled="disabled">
          <label for="pfm-payment-bank">'.esc_html__('Bank Transfer','pointfindert2d').' <font style="font-weight:normal;"> '.esc_html__('(Disabled - Please complete or cancel existing transfer.)','pointfindert2d').'</font></label>
          <div class="pfm-active">
          <p>'.__("Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be approved until the funds have cleared in our account.",'pointfindert2d').'</p>
          </div>
        </div>';
        } else {
          $output .= '
          <div class="pf-membership-upload-option">
            <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-bank" value="bank">
            <label for="pfm-payment-bank">'.esc_html__('Bank Transfer','pointfindert2d').'</label>
            <div class="pfm-active">
            <p>'.__("Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be approved until the funds have cleared in our account.",'pointfindert2d').'</p>
            </div>
          </div>';
        }
      }

      if ($paypal_status == 1) {  
        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-paypal" value="paypal">
          <label for="pfm-payment-paypal">'.esc_html__('Paypal','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.",'pointfindert2d').'</p>
          </div>
        </div>';
        $setup31_userpayments_recurringoption = PFSAIssetControl('setup31_userpayments_recurringoption','','1');
        if($setup31_userpayments_recurringoption == 1){
          $output .= '
          <div class="pf-membership-upload-option">
            <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-paypal2" value="paypal2">
            <label for="pfm-payment-paypal2">'.esc_html__('Paypal Recurring Payment','pointfindert2d').'</label>
            <div class="pfm-active">
            <p>'.__("Pay via PayPal Recurring Payment; you can create automated payments for this order.",'pointfindert2d').'</p>
            </div>
          </div>';
        }
      }

      if ($stripe_status == 1) {
        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-stripe" value="stripe">
          <label for="pfm-payment-stripe">'.esc_html__('Credit Card (Stripe)','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via Credit Card; you can pay with your credit card. (This service is using Stripe Payment Gateway)",'pointfindert2d').'</p>
          </div>
        </div>';
      }

      if ($pags_status == 1) {
        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-pags" value="pags">
          <label for="pfm-payment-pags">'.esc_html__('PagSeguro Payment System','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via PagSeguro; you can pay with your PagSeguro account.",'pointfindert2d').'</p>
          </div>
        </div>';
      }

      if ($payu_status == 1) {
        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-payu" value="payu">
          <label for="pfm-payment-payu">'.esc_html__('PayU Money Payment System','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via Payu Money; you can pay with your Payu Money account.",'pointfindert2d').'</p>
          </div>
        </div>';
      }

      if ($ideal_status == 1) {

        require_once( get_template_directory(). '/admin/core/Mollie/API/Autoloader.php' );
        $ideal_id = PFPGIssetControl('ideal_id','','');
        $mollie = new Mollie_API_Client;
        $mollie->setApiKey($ideal_id);

        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-ideal" value="ideal">
          <label for="pfm-payment-ideal">'.esc_html__('iDeal Payment System','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via iDeal; you can pay with your iDeal account.",'pointfindert2d').'</p>
          ';
          $issuers = $mollie->issuers->all();
          $output .= esc_html__("Select your bank:","pointfindert2d");
          $output .= '<select name="issuer" style="margin-top:5px;margin-left: 5px;">';

          foreach ($issuers as $issuer)
          {
            if ($issuer->method == Mollie_API_Object_Method::IDEAL)
            {
              $output .= '<option value=' . htmlspecialchars($issuer->id) . '>' . htmlspecialchars($issuer->name) . '</option>';
            }
          }

          $output .= '<option value="">or select later</option>';
          $output .= '</select>';
          $output .= '
          </div>
        </div>';
      }

      if ($robo_status == 1) {
        $output .= '
        <div class="pf-membership-upload-option">
          <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-robo" value="robo">
          <label for="pfm-payment-robo">'.esc_html__('Robokassa Payment System','pointfindert2d').'</label>
          <div class="pfm-active">
          <p>'.__("Pay via Robokassa; you can pay with your Robokassa account.",'pointfindert2d').'</p>
          </div>
        </div>';
      }

      if ($iyzico_status == 1) {
          $output .= '
          <div class="pf-membership-upload-option">
            <input name="pf_membership_payment_selection" type="radio" id="pfm-payment-iyzico" value="iyzico">
            <label for="pfm-payment-iyzico">'.esc_html__('Iyzico Payment System','pointfindert2d').'</label>
            <div class="pfm-active">
              <p>'.esc_html__("Pay via iyzico; you can pay with your iyzico account.",'pointfindert2d').'</p>
              ';
              $usermetaarr = get_user_meta($user_id);

              $output .= '<div class="iyzico-fields golden-forms">';
            
              if(empty($usermetaarr['first_name'][0])){
                $output .= '<section>
                  <label for="pfusr_firstname" class="lbl-text">'.esc_html__('First Name','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_firstname" id="pfusr_firstname" class="input">
                  </label>                            
                </section>';
              }
              if(empty($usermetaarr['last_name'][0])){
                $output .= '<section>
                  <label for="pfusr_lastname" class="lbl-text">'.esc_html__('Last Name','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_lastname" id="pfusr_lastname" class="input">
                  </label>                            
                </section>';
              }
              if(empty($usermetaarr['user_mobile'][0])){
                $output .= '<section>
                  <label for="pfusr_mobile" class="lbl-text">'.esc_html__('GSM Number','pointfindert2d').'</label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_mobile" id="pfusr_mobile" class="input">
                  </label>                            
                </section>';
              }
              if(empty($usermetaarr['user_vatnumber'][0])){
                $output .= '<section>
                  <label for="pfusr_vatnumber" class="lbl-text">'.esc_html__('VAT Number','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_vatnumber" id="pfusr_vatnumber" class="input">
                  </label>                            
                </section>';
              }
              if(empty($usermetaarr['user_country'][0])){
                $output .= '<section>
                  <label for="pfusr_country" class="lbl-text">'.esc_html__('Country','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_country" id="pfusr_country" class="input">
                  </label>                            
                </section>';
              }
              if(empty($usermetaarr['user_city'][0])){
                $output .= '<section>
                  <label for="pfusr_city" class="lbl-text">'.esc_html__('City','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_city" id="pfusr_city" class="input">
                  </label>                            
                </section>';
              }
              
              if(empty($usermetaarr['user_address'][0])){
                $output .= '<section>
                  <label for="pfusr_address" class="lbl-text">'.esc_html__('Address','pointfindert2d').'<span style="color:red!important">*</span></label>
                  <label class="lbl-ui">
                    <input type="text" name="pfusr_address" id="pfusr_address" class="input">
                  </label>                            
                </section>';
              }

              if (
                empty($usermetaarr['user_address'][0]) 
                || empty($usermetaarr['user_city'][0])
                || empty($usermetaarr['user_country'][0])
                || empty($usermetaarr['user_vatnumber'][0])
                || empty($usermetaarr['user_mobile'][0])
                || empty($usermetaarr['first_name'][0])
                || empty($usermetaarr['last_name'][0])
                ) {
                $output .= '<small>'.esc_html__('Please fill above informations before use iyzico payment system.','pointfindert2d').'</small>';
              }
              

              $output .= '</div>';
            $output .= '</div>';

          $output .= '</div>';
      }

      if (
        $stripe_status != 1 
        && $paypal_status != 1 
        && $bank_status != 1 
        && $ideal_status != 1 
        && $payu_status != 1 
        && $pags_status != 1
        && $robo_status != 1
        && $iyzico_status != 1
        ) {
        $output .= '<div class="pf-membership-upload-option">'.esc_html__('Please enable a payment system by using Options Panel','pointfindert2d').'</div>';
      }else{
        $output .= '
        <script>
        (function($) {
        "use strict";
          $(function(){
            var membership_radio = $(".pf-membership-upload-option input[type=\'radio\']");
            membership_radio.on("change", function () {
            membership_radio.parents().removeClass("active");
            $(this).parent().addClass("active");
            if ($(this).val() == "iyzico") {
              ';
                 if(empty($usermetaarr['first_name'][0])){
                 $output .= '$("#pfusr_firstname").rules( "add", {
                  required: true,
                  messages: {
                    required: "'.esc_html__('Please add your Name (Iyzico requirement)','pointfindert2d').'"
                  }
                  });';
                 }
                 if(empty($usermetaarr['last_name'][0])){
                 $output .= '$("#pfusr_lastname").rules( "add", {required: true,messages: {required: "'.esc_html__('Please add your Last Name (Iyzico requirement)','pointfindert2d').'"}});';
                 }
                 if(empty($usermetaarr['user_vatnumber'][0])){
                 $output .= '$("#pfusr_vatnumber").rules( "add", {required: true,messages: {required: "'.esc_html__('Please add your VAT Number (Iyzico requirement)','pointfindert2d').'"}});';
                 }
                 if(empty($usermetaarr['user_country'][0])){
                 $output .= '$("#pfusr_country").rules( "add", {required: true,messages: {required: "'.esc_html__('Please add your Country (Iyzico requirement)','pointfindert2d').'"}});';
                 }
                 if(empty($usermetaarr['user_city'][0])){
                 $output .= '$("#pfusr_city").rules( "add", {required: true,messages: {required: "'.esc_html__('Please add your City (Iyzico requirement)','pointfindert2d').'"}});';
                 }
                 if(empty($usermetaarr['user_address'][0])){
                 $output .= '$("#pfusr_address").rules( "add", {required: true,messages: {required: "'.esc_html__('Please add your Address (Iyzico requirement)','pointfindert2d').'"}});';
                 }
              $output .= '
              }else{
               
                ';
                 if(empty($usermetaarr['first_name'][0])){
                 $output .= '$("#pfusr_firstname").rules( "remove" );';
                 }
                 if(empty($usermetaarr['last_name'][0])){
                 $output .= '$("#pfusr_lastname").rules( "remove" );';
                 }
                 if(empty($usermetaarr['user_vatnumber'][0])){
                 $output .= '$("#pfusr_vatnumber").rules( "remove" );';
                 }
                 if(empty($usermetaarr['user_country'][0])){
                 $output .= '$("#pfusr_country").rules( "remove" );';
                 }
                 if(empty($usermetaarr['user_city'][0])){
                 $output .= '$("#pfusr_city").rules( "remove" );';
                 }
                 if(empty($usermetaarr['user_address'][0])){
                 $output .= '$("#pfusr_address").rules( "remove" );';
                 }
              $output .= '

              }
            });
          });
        })(jQuery);
        </script>
        ';
      }
    }else{
      $output .= '<input name="pf_membership_payment_selection" type="hidden" id="pfm-payment-free" value="free">';
    }

  }
  echo $output;

  die();
}

function OF_pf_ajax_membershipsystem(){
  check_ajax_referer( 'pfget_membershipsystem', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

  if(isset($_POST['formtype']) && $_POST['formtype']!=''){
    $formtype = esc_attr($_POST['formtype']);
  }

  $vars = array();
  if(isset($_POST['dt']) && $_POST['dt']!=''){
    
    if ($formtype != 'stripepay') {
      $vars = array();
      parse_str($_POST['dt'], $vars);
      if (is_array($vars)) {
          $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
      } else {
          $vars = esc_attr($vars);
      }
    }
    
  }

  
  if (empty($vars['subaction'])) {
    $vars['subaction'] = "n";
  }

  $msg_output = $pfreturn_url = '';
  $current_user = wp_get_current_user();
  $user_id = isset($current_user->ID)?$current_user->ID:0;
  $icon_processout = 62;

  if (!isset($vars['pf_membership_payment_selection'])) {
    $vars['pf_membership_payment_selection'] = '';
  }

  if(!empty($user_id)){

    $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','',site_url());
    $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
    $pfmenu_perout = PFPermalinkCheck();

    if(isset($vars['pfusr_firstname'])){update_user_meta($user_id, 'first_name', $vars['pfusr_firstname']);}
    if(isset($vars['pfusr_lastname'])){update_user_meta($user_id, 'last_name', $vars['pfusr_lastname']);}
    if(isset($vars['pfusr_mobile'])){update_user_meta($user_id, 'user_mobile', $vars['pfusr_mobile']);}
    if(isset($vars['pfusr_vatnumber'])){update_user_meta($user_id, 'user_vatnumber', $vars['pfusr_vatnumber']);}
    if(isset($vars['pfusr_country'])){update_user_meta($user_id, 'user_country', $vars['pfusr_country']);}
    if(isset($vars['pfusr_address'])){update_user_meta($user_id, 'user_address', $vars['pfusr_address']);}
    if(isset($vars['pfusr_city'])){update_user_meta($user_id, 'user_city', $vars['pfusr_city']);}


    switch ($formtype) {
      case 'purchasepackage':
       
        if (isset($vars['selectedpackageid'])) {
          
          switch ($vars['pf_membership_payment_selection']){
            case 'paypal':
            case 'paypal2':
                $processname = 'paypal';
                
                $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

                $setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
                $setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);

                $total_package_price =  number_format($packageinfo['webbupointfinder_mp_price'], $setup20_paypalsettings_decimals, '.', ',');
                
                if ($vars['pf_membership_payment_selection'] == 'paypal2') {
                  $vars['recurringlistingitemval'] = 1;
                }else{
                  $vars['recurringlistingitemval'] = 0;
                }

                $billing_description = '';

                if ($vars['recurringlistingitemval'] == 1) {
                  $billing_description = sprintf(
                    esc_html__('%s / %s / Recurring: %s per %s','pointfindert2d'),
                    $packageinfo['webbupointfinder_mp_title'],
                    $packageinfo['packageinfo_itemnumber_output_text'].' '.esc_html__('Item','pointfindert2d'),
                    $packageinfo['packageinfo_priceoutput_text'],
                    $packageinfo['webbupointfinder_mp_billing_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text']                 
                    );
                }

                $response = pointfinder_paypal_request(
                  array(
                    'returnurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_recm',
                    'cancelurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_cancel',
                    'total_package_price' => $total_package_price,
                    'payment_custom_field' => $user_id,
                    'payment_custom_field1' => $vars['subaction'],
                    'payment_custom_field3' => $packageinfo['webbupointfinder_mp_title'],
                    'payment_custom_field2' => $vars['selectedpackageid'],
                    'recurring' => $vars['recurringlistingitemval'],
                    'billing_description' => $billing_description,
                    'paymentName' => $packageinfo['webbupointfinder_mp_title'],
                    'apipackage_name' => $packageinfo['webbupointfinder_mp_title']
                  )
                );

               
                
                if(!$response){ $msg_output .= esc_html__( 'Error: No Response', 'pointfindert2d' ).'<br>';}

                if(is_array($response) && ($response['ACK'] == 'Success')) { 
                  $token = $response['TOKEN'];

                  if ($vars['subaction'] == 'r') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    update_post_meta($order_post_id,'pointfinder_order_token',$token );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }elseif ($vars['subaction'] == 'u') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    update_post_meta($order_post_id,'pointfinder_order_token',$token );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }else{
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'recurring' => $vars['recurringlistingitemval'],
                        'token' =>$token
                      )
                    );
                  }
                  

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                      array(
                      'user_id' => $user_id,
                      'item_post_id'  =>  $vars['selectedpackageid'],
                      'order_post_id' =>  $order_post_id,
                      'response'  =>  $response,
                      'token' =>  $response['TOKEN'],
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $response['ACK'],
                      )
                  );
                
                  $paypal_sandbox = PFSAIssetControl('setup20_paypalsettings_paypal_sandbox','','0');
                  
                  if($paypal_sandbox == 0){
                    $pfreturn_url = 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token).'';
                  }else{
                    $pfreturn_url = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token).'';
                  }
                  
                  $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                }else{

                  if ($vars['subaction'] == 'r') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }elseif ($vars['subaction'] == 'u') {
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'autoexpire_create' => 1
                      )
                    );
                  }else{
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'recurring' => $vars['recurringlistingitemval']
                      )
                    );
                  }

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $vars['selectedpackageid'],
                      'order_post_id' =>  $order_post_id,
                      'response'  =>  $response,
                      'token' =>  '',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $response['ACK'],
                      )
                    );

                  $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                  if (isset($response['L_SHORTMESSAGE0'])) {$msg_output .= '<small>'.$response['L_SHORTMESSAGE0'].'</small><br/>';}
                  if (isset($response['L_LONGMESSAGE0'])) {$msg_output .= '<small>'.$response['L_LONGMESSAGE0'].'</small><br/>';}
                  $icon_processout = 485;
                }
              break;

            case 'stripe':
                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'stripe';

                $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
                $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
                $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');
                $setup20_stripesettings_sitename = PFSAIssetControl('setup20_stripesettings_sitename','','');
                $user_email = $current_user->user_email;
                $locale_short = substr( get_locale(), 0, 2 );

                $stripe_array = array( 
                  'process'=>true,
                  'processname'=>$processname, 
                  'name'=>$setup20_stripesettings_sitename, 
                  'description'=>$packageinfo['webbupointfinder_mp_title'], 
                  'amount'=>$packageinfo['packageinfo_priceoutput']*100,
                  'key'=>$setup20_stripesettings_publishkey,
                  'email'=>$user_email,
                  'currency'=>$setup20_stripesettings_currency,
                  'locale'=>$locale_short
                );

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Package Renew Process Started with Stripe Payment','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Package Upgrade Process Started with Stripe Payment','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }
                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);

                PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckoutStripe',
                      'status'  => 'Success',
                      'membership' => 1
                      )
                    );
              break;

            case 'bank':
                $processname = 'bank';

                $active_order_ex = get_user_meta($user_id, 'membership_user_activeorder_ex',true );
                if ($active_order_ex != false || !empty($active_order_ex)) {
                  $bank_current = get_post_meta( $active_order_ex, 'pointfinder_order_bankcheck', 1);
                } else {
                  $bank_current = false;
                }

                if ($bank_current == false && empty($bank_current)) {
                  
                  if ($vars['subaction'] == 'r') {
                    $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                    $vars['selectedpackageid'] = $membership_user_package_id;
                  }

                  $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);


                  if ($vars['subaction'] == 'r') {
                    
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('Package Renew Process Started with Bank Transfer','pointfindert2d'),
                        'membership' => 1
                        )
                    );

                  }elseif ($vars['subaction'] == 'u') {

                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('Package Upgrade Process Started with Bank Transfer','pointfindert2d'),
                        'membership' => 1
                        )
                    );

                  }else{

                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                      )
                    );

                  }

                  
                  if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                  }

                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);
                  update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 1);


                  PF_CreatePaymentRecord(
                        array(
                        'user_id' =>  $user_id,
                        'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                        'order_post_id' => $order_post_id,
                        'processname' =>  'BankTransfer',
                        'membership' => 1
                        )
                      );

                  /* Create an invoice for this */
                  $invoicenum = PF_CreateInvoice(
                    array( 
                      'user_id' => $user_id,
                      'item_id' => 0,
                      'order_id' => $order_post_id,
                      'description' => $packageinfo['webbupointfinder_mp_title'],
                      'processname' => esc_html__('Bank Transfer','pointfindert2d'),
                      'amount' => $packageinfo['packageinfo_priceoutput'],
                      'gst' => $packageinfo['packageinfo_priceoutput_gst'],
                      'qst' => $packageinfo['packageinfo_priceoutput_qst'],
                      'datetime' => strtotime("now"),
                      'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                      'status' => 'pendingpayment'
                    )
                  );
                  
                  update_user_meta( $user_id, 'membership_user_invnum_ex', $invoicenum);

                  $user_info = get_userdata( $user_id );
                  pointfinder_mailsystem_mailsender(
                    array(
                    'toemail' => $user_info->user_email,
                        'predefined' => 'bankpaymentwaitingmember',
                        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $packageinfo['webbupointfinder_mp_title']),
                    )
                  );

                  $admin_email = get_option( 'admin_email' );
                  $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
                  pointfinder_mailsystem_mailsender(
                    array(
                      'toemail' => $setup33_emailsettings_mainemail,
                          'predefined' => 'newbankpreceivedmember',
                          'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $packageinfo['webbupointfinder_mp_title']),
                      )
                    );

                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2m';
                }else{
                  $msg_output .= esc_html__('You already have a bank transfer.','pointfindert2d');
                  $icon_processout = 485;
                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
                }
              break;
              
            case 'free':
                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'free';

                /*This is free item so check again*/
                if ($packageinfo['packageinfo_priceoutput'] == 0) {

                    if ($vars['subaction'] == 'r') {
                      /*Get Order Record*/
                      $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                      $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'r'));
                      $app_date = strtotime("now");
                      update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
                    }elseif ($vars['subaction'] == 'u') {
                      /*Create Order Record*/
                      $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                      update_post_meta( $order_post_id, 'pointfinder_order_packageid', $vars['selectedpackageid']);
                      $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'u'));

                      /* Start: Calculate item/featured item count and remove from new package. */
                        $total_icounts = pointfinder_membership_count_ui($user_id);

                        /*Count User's Items*/
                        $user_post_count = 0;
                        $user_post_count = $total_icounts['item_count'];

                        /*Count User's Featured Items*/
                        $users_post_featured = 0;
                        $users_post_featured = $total_icounts['fitem_count'];

                        if ($packageinfo['webbupointfinder_mp_itemnumber'] != -1) {
                          $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'] - $user_post_count;
                        }else{
                          $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'];
                        }
                        
                        $new_fitem_limit = $packageinfo['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


                        /*Create User Limits*/
                        update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                        update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                        update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
                        update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
                        update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                        update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                        update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                        update_user_meta( $user_id, 'membership_user_recurring', 0);
                      /* End: Calculate new limits */
                    }else{
                      /*Create Order Record*/
                      $order_post_id = pointfinder_membership_create_order(
                        array(
                          'user_id' => $user_id,
                          'packageinfo' => $packageinfo,
                          'autoexpire_create' => 1
                        )
                      );
                      update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
                      
                      /*Create User Limits*/
                      update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                      update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                      /***
                      debut modif occasionfranchise
                      */
                      $expired_items = get_user_meta( $user_id, 'membership_user_item_limit', true );
                      update_user_meta( $user_id, 'membership_user_item_limit', $expired_items + $packageinfo['webbupointfinder_mp_itemnumber']);
                      update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                      update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                      /*
                      fin modif occasionfranchise
                      ***/
                      update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                      update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);

                      $user_info = get_userdata( $user_id );
                      pointfinder_mailsystem_mailsender(
                        array(
                        'toemail' => $user_info->user_email,
                            'predefined' => 'freecompletedmember',
                            'data' => array('packagename' => $packageinfo['webbupointfinder_mp_title']),
                        )
                      );

                      $admin_email = get_option( 'admin_email' );
                      $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
                      pointfinder_mailsystem_mailsender(
                        array(
                          'toemail' => $setup33_emailsettings_mainemail,
                              'predefined' => 'freepaymentreceivedmember',
                              'data' => array('ID' => $order_post_id,'packagename' => $packageinfo['webbupointfinder_mp_title']),
                          )
                        );
                    }

                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

                    /* Create an invoice for this */
                    PF_CreateInvoice(
                      array( 
                        'user_id' => $user_id,
                        'item_id' => 0,
                        'order_id' => $order_post_id,
                        'description' => $packageinfo['webbupointfinder_mp_title'],
                        'processname' => esc_html__('Free Package','pointfindert2d'),
                        'amount' => 0,
                        'gst' => 0,
                        'qst' => 0,
                        'datetime' => strtotime("now"),
                        'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                        'status' => 'publish'
                      )
                    );
                    
                    

                } else {
                  $msg_output .= esc_html__('Wrong package info. Process stopped.','pointfindert2d');
                  $icon_processout = 485;
                }
              break;

            case 'trial':
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'trial';

                $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );

                /*This is free item so check again*/
                if ($packageinfo['webbupointfinder_mp_trial'] == 1 && $membership_user_package_id == false) {
                  
                  /*Create Order Record*/
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                      'autoexpire_create' => 1,
                      'trial' => 1
                    )
                  );

                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

                  /* Create an invoice for this */
                  PF_CreateInvoice(
                    array( 
                      'user_id' => $user_id,
                      'item_id' => 0,
                      'order_id' => $order_post_id,
                      'description' => $packageinfo['webbupointfinder_mp_title'],
                      'processname' => esc_html__('Trial Package','pointfindert2d'),
                      'amount' => 0,
                      'gst' => 0,
                      'qst' => 0,
                      'datetime' => strtotime("now"),
                      'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                      'status' => 'publish'
                    )
                  );

                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                  update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
                  update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                  update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                  update_user_meta( $user_id, 'membership_user_trialperiod', 1);
                  update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                  update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );

                } else {
                  $msg_output .= esc_html__("This package doesn't support trial period or user already have a package. Process stopped.",'pointfindert2d');
                  $icon_processout = 485;
                }
              break;

            case 'pags':

                require_once( get_template_directory(). '/admin/core/PagSeguroLibrary/PagSeguroLibrary.php' );

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'pags';

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
              

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Pagseguro: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Pagseguro: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }



                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);

                $paymentRequest = new PagSeguroPaymentRequest();
                $paymentRequest->setCurrency("BRL");
                $paymentRequest->setReference($order_post_id.'-'.$vars['subaction']); 
                $paymentRequest->addItem($order_post_id, $packageinfo['webbupointfinder_mp_title'] , 1, $total_package_price);
                $paymentRequest->addParameter('notificationURL', $setup4_membersettings_dashboard_link);

                try {

                    $credentials = PagSeguroConfig::getAccountCredentials();
                    $url = $paymentRequest->register($credentials);

                    /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckout',
                      'token' =>  $order_post_id.'- PagSeguro',
                      'status'  => 'Success',
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                    $pfreturn_url = $url;

                } catch (PagSeguroServiceException $e) {

                    /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckout',
                      'token' =>  $order_post_id.'- PagSeguro',
                      'status'  =>  $e->getMessage(),
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                    $msg_output .= '<small>'.$e->getMessage().'</small><br/>';
                    $icon_processout = 485;
                    $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';

                }
              break;

            case 'payu':

                $payu_key = PFPGIssetControl('payu_key','','');
                $payu_salt = PFPGIssetControl('payu_salt','','');

                if (!empty($payu_key) && !empty($payu_salt)) {

                  $membership_user_package_id = '';

                  if ($vars['subaction'] == 'r') {
                    $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                    $vars['selectedpackageid'] = $membership_user_package_id;
                  }

                  $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                  $processname = 'payu';

                  $total_package_price =  $packageinfo['webbupointfinder_mp_price'];


                  if ($vars['subaction'] == 'r') {
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('PayU Money: Package Renew Process Started','pointfindert2d'),
                        'membership' => 1
                        )
                    );
                  }elseif ($vars['subaction'] == 'u') {
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('PayU Money: Package Upgrade Process Started','pointfindert2d'),
                        'membership' => 1
                        )
                    );
                  }else{
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                      )
                    );
                  }


                  if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                  }

                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                  /* Start PayU Works */
                    $payu_mode = PFPGIssetControl('payu_mode','',0);
                    if (empty($payu_mode)) {
                      $PAYU_BASE_URL = "https://test.payu.in";
                    }else{
                      $PAYU_BASE_URL = "https://secure.payu.in";
                    }


                    $payu_provider = PFPGIssetControl('payu_provider','',1);
                    if (empty($payu_provider)) {
                      $service_provider = "";
                    }else{
                      $service_provider = "payu_paisa";
                    }
                    

                    /* Generate a transaction ID */
                    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

                    update_post_meta($order_post_id, 'pointfinder_order_txnid', $txnid );

                    /*First name */
                    $firstname = $current_user->user_firstname;
                    if (empty($firstname)) {
                      $firstname = $current_user->user_login;
                    }

                    /*Email*/
                    $user_email = $current_user->user_email;
                    if (empty($user_email)) {
                      $domain_name = $_SERVER['SERVER_NAME'];
                      $user_email = $current_user->user_login.'@'.$domain_name;
                    }

                    /*Phone*/
                    $user_phone = get_user_meta( $user_id, 'user_phone', true );
                    if(isset($_POST['user_phone']) && $_POST['user_phone']!=''){
                      $user_phone = esc_attr($_POST['user_phone']);
                    }
                    
                    if (empty($user_phone)) {
                      /*Create a payment record for this process */
                        PF_CreatePaymentRecord(
                          array(
                          'user_id' =>  $user_id,
                          'item_post_id'  =>  $membership_user_package_id,
                          'order_post_id' =>  $order_post_id,
                          'token' =>  $order_post_id.' - PAYUMONEY',
                          'processname' =>  'SetExpressCheckout',
                          'status'  =>  'Failure: Phone '.$user_phone,
                          'membership' => 1
                          )
                        );

                        $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                        $msg_output .= '<small>'.esc_html__( 'Phone Required', 'pointfindert2d' ).'</small><br/>';
                        $icon_processout = 485;
                        $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
                    }
                  /* End: PayU Works */


                  $productinfo = $packageinfo['webbupointfinder_mp_title'].' - '.$order_post_id;

                  // Hash Sequence
                  $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

                  $createOrder = array();

                  $createOrder['key'] = $payu_key;
                  $createOrder['txnid'] = $txnid;
                  $createOrder['amount'] = $total_package_price;
                  $createOrder['firstname'] = $firstname;
                  $createOrder['email'] = $user_email;
                  $createOrder['phone'] = $user_phone;
                  $createOrder['productinfo'] = $productinfo;
                  $createOrder['surl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s';
                  $createOrder['furl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f';
                  $createOrder['service_provider'] = $service_provider;
                  $createOrder['udf1'] = $order_post_id;
                  $createOrder['udf2'] = $vars['subaction'];
                  $createOrder['udf3'] = $membership_user_package_id;


                  $hashVarsSeq = explode('|', $hashSequence);
                  $hash_string = '';

                  foreach($hashVarsSeq as $hash_var) {
                      $hash_string .= isset($createOrder[$hash_var]) ? $createOrder[$hash_var] : '';
                      $hash_string .= '|';
                  }

                  $hash_string .= $payu_salt;
                  $hash = strtolower(hash('sha512', $hash_string));
                  
                  $pfreturn_url = $PAYU_BASE_URL . '/_payment';

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                    'order_post_id' =>  $order_post_id,
                    'token' =>  $order_post_id.' - PAYUMONEY',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  'Success',
                    'membership' => 1
                    )
                  );
    
                  $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');

                  $payumail = '';
                  $payumail .= '<form action="'.$pfreturn_url.'" method="post" name="payuForm">
                  <input type="hidden" name="hash" value="'.$hash.'"/>
                  <input type="hidden" name="key" value="'.$payu_key.'" />
                  <input type="hidden" name="txnid" value="'.$txnid.'" />
                  <input type="hidden" name="amount" value="'.$total_package_price.'" />
                  <input type="hidden" name="firstname" value="'.$firstname.'" />
                  <input type="hidden" name="email" value="'.$user_email.'" />
                  <input type="hidden" name="phone" value="'.$user_phone.'" />
                  <input type="hidden" name="productinfo" value="'.$productinfo.'" />
                  <input type="hidden" name="surl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s'.'" />
                  <input type="hidden" name="furl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f'.'" />
                  <input type="hidden" name="service_provider" value="'.$service_provider.'" size="64" />
                  <input type="hidden" name="udf1" value="'.$order_post_id.'" />
                  <input type="hidden" name="udf2" value="'.$vars['subaction'].'" />
                  <input type="hidden" name="udf3" value="'.$membership_user_package_id.'" />
                  </form>';

                }
              break;

            case 'ideal':
                require_once( get_template_directory(). '/admin/core/Mollie/API/Autoloader.php' );

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'pags';

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
              

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('iDeal: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('iDeal: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }



                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                $ideal_id = PFPGIssetControl('ideal_id','','');
                $mollie = new Mollie_API_Client;
                $mollie->setApiKey($ideal_id);

                $ideal_issuer = '';

                if (isset($vars['issuer'])) {
                  $ideal_issuer = $vars['issuer'];
                }


                try{
                  $payment = $mollie->payments->create(array(
                    "amount"       => $total_package_price,
                    "method"       => Mollie_API_Object_Method::IDEAL,
                    "description"  => $packageinfo['webbupointfinder_mp_title'],
                    "redirectUrl"  => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$order_post_id,
                    "metadata"     => array(
                      "order_id" => $order_post_id,
                      "item_post_id" => $packageinfo['webbupointfinder_mp_packageid'],
                      "user_id" => $user_id,
                      "otype" => $vars['subaction']
                    ),
                    "issuer"       => !empty($ideal_issuer) ? $ideal_issuer : NULL
                  ));

                  update_post_meta($order_post_id, 'pointfinder_order_ideal', $payment->id );

                  /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' =>  $order_post_id,
                      'token' =>  $order_post_id.'-'.$packageinfo['webbupointfinder_mp_packageid'].'- iDeal',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  'success',
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                    $pfreturn_url = $payment->getPaymentUrl();

                }catch (Mollie_API_Exception $e){
                  /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' =>  $order_post_id,
                      'token' =>  $order_post_id.'-'.$packageinfo['webbupointfinder_mp_packageid'].'- iDeal',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $e->getMessage(),
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                    $msg_output .= '<small>'.htmlspecialchars($e->getMessage()).'</small><br/>';
                    $icon_processout = 485;
                    $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$order_post_id;
                }
              break;

            case 'robo':

                $membership_user_package_id = '';
                $processname = 'robo';

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];


                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Robokassa: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Robokassa: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }


                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                /* Start Robo Works */
                $robo_mode = PFPGIssetControl('robo_mode','',0);
                $robo_login = PFPGIssetControl('robo_login','','');
                $robo_pass1 = PFPGIssetControl('robo_pass1','','');
                $robo_currency = PFPGIssetControl('robo_currency','','');
                $robo_lang = PFPGIssetControl('robo_lang','','ru');

                if (!empty($robo_currency)) {
                  $crc  = md5("$robo_login:$total_package_price:$order_post_id:$robo_currency:$robo_pass1:Shp_itemnum=$membership_user_package_id:Shp_otype=".$vars['subaction'].":Shp_user=$user_id");
                }else{
                  $crc  = md5("$robo_login:$total_package_price:$order_post_id:$robo_pass1:Shp_itemnum=$membership_user_package_id:Shp_otype=".$vars['subaction'].":Shp_user=$user_id");
                }


                $productinfo = $packageinfo['webbupointfinder_mp_title'].' - '.$order_post_id;
    
                $robo_html = "<form action='https://auth.robokassa.ru/Merchant/Index.aspx' method='POST' name='roboForm'>".
                "<input type=hidden name='MrchLogin' value='$robo_login'>".
                "<input type=hidden name='OutSum' value='$total_package_price'>".
                "<input type=hidden name='InvId' value='$order_post_id'>".
                "<input type=hidden name='Desc' value='$productinfo'>".
                "<input type=hidden name='SignatureValue' value='$crc'>".
                "<input type=hidden name='Shp_itemnum' value='$membership_user_package_id'>".
                "<input type=hidden name='Shp_user' value='$user_id'>".
                "<input type=hidden name='Shp_otype' value='".$vars['subaction']."'>".
                "<input type=hidden name='Culture' value='$robo_lang'>";
                
                if (!empty($robo_currency)) {
                  $robo_html .= "<input type=hidden name='OutSumCurrency' value='$robo_currency'>";
                }
                if ($robo_mode == 0) {
                  $robo_html .= "<input type=hidden name='IsTest' value='1'>";
                }
                $robo_html .= "</form>";

                update_post_meta($order_post_id, 'pointfinder_order_robo', $order_post_id );
                update_post_meta($order_post_id, 'pointfinder_order_robo2', $order_post_id );

                PF_CreatePaymentRecord(
                  array(
                  'user_id' =>  $user_id,
                  'item_post_id'  =>  $membership_user_package_id,
                  'order_post_id' =>  $order_post_id,
                  'token' =>  $order_post_id.'-'.$membership_user_package_id.'- Robokassa',
                  'processname' =>  'SetExpressCheckout',
                  'status'  =>  'success',
                  )
                );

                $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                $pfreturn_url = '';
                $icon_processout = 62;
                
              break;

            /*Iyzico*/
            case 'iyzico':

              if ($vars['subaction'] == 'r') {
                $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                $vars['selectedpackageid'] = $membership_user_package_id;
              }

              $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
              $processname = 'iyzico';

              $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
            

              if ($vars['subaction'] == 'r') {
                $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Pagseguro: Package Renew Process Started','pointfindert2d'),
                    'membership' => 1
                    )
                );
              }elseif ($vars['subaction'] == 'u') {
                $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Pagseguro: Package Upgrade Process Started','pointfindert2d'),
                    'membership' => 1
                    )
                );
              }else{
                $order_post_id = pointfinder_membership_create_order(
                  array(
                    'user_id' => $user_id,
                    'packageinfo' => $packageinfo,
                  )
                );
              }



              if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                global $wpdb;
                $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
              }

              /*Create User Limits*/
              update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
              update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
              update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


              $iyzico_installment = PFPGIssetControl('iyzico_installment','','1, 2, 3, 6, 9');
              $iyzico_installment = (!empty($iyzico_installment))?explode(",", $iyzico_installment):1;
              $iyzico_key1 = PFPGIssetControl('iyzico_key1','','');
              $iyzico_key2 = PFPGIssetControl('iyzico_key2','','');
              $iyzico_mode = PFPGIssetControl('iyzico_mode','','0');
              $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';



              if ($iyzico_mode == 1) {
                $api_url = 'https://api.iyzipay.com/';
              }else{
                $api_url = 'https://sandbox-api.iyzipay.com/';
              }
              $usermetaarr = get_user_meta($user_id);
              $user_address = (isset($usermetaarr['user_address'][0]))?$usermetaarr['user_address'][0]:'';
              $user_country = (isset($usermetaarr['user_country'][0]))?$usermetaarr['user_country'][0]:'';
              $user_name = (isset($usermetaarr['first_name'][0]))?$usermetaarr['first_name'][0]:'';
              $user_surname = (isset($usermetaarr['last_name'][0]))?$usermetaarr['last_name'][0]:'';
              $user_email = $current_user->user_email;
              $user_tck = (isset($usermetaarr['user_vatnumber'][0]))?$usermetaarr['user_vatnumber'][0]:'';
              $user_city = (isset($usermetaarr['user_city'][0]))?$usermetaarr['user_city'][0]:'';
              $user_phone = (isset($usermetaarr['user_mobile'][0]))?$usermetaarr['user_mobile'][0]:'';


              require_once( get_template_directory().'/admin/core/IyzipayBootstrap.php'); 
              IyzipayBootstrap::init();

              $options = new \Iyzipay\Options();
              $options->setApiKey($iyzico_key1);
              $options->setSecretKey($iyzico_key2);
              $options->setBaseUrl($api_url);

              $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
              $request->setLocale(\Iyzipay\Model\Locale::TR);
              $request->setPrice($total_package_price);
              $request->setPaidPrice($total_package_price);
              $request->setCurrency(\Iyzipay\Model\Currency::TL);
              $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::LISTING);
              $request->setCallbackUrl($pfreturn_url);
              $request->setEnabledInstallments($iyzico_installment);
              $request->setConversationId($order_post_id.'-'.$vars['subaction']);

              $buyer = new \Iyzipay\Model\Buyer();
              $buyer->setId('PF'.$user_id);
              $buyer->setName($user_name);
              $buyer->setSurname($user_surname);
              $buyer->setEmail($user_email);
              $buyer->setIdentityNumber($user_tck);
              $buyer->setGsmNumber($user_phone);
              $buyer->setRegistrationAddress($user_address);
              $buyer->setIp(pointfinder_getUserIP());
              $buyer->setCity($user_city);
              $buyer->setCountry($user_country);
              $request->setBuyer($buyer);

              $billingAddress = new \Iyzipay\Model\Address();
              $billingAddress->setContactName($user_name.' '.$user_surname);
              $billingAddress->setCity($user_city);
              $billingAddress->setCountry($user_country);
              $billingAddress->setAddress($user_address);
              $request->setBillingAddress($billingAddress);

              $BasketItem = new \Iyzipay\Model\BasketItem();
              $BasketItem->setId($packageinfo['webbupointfinder_mp_packageid']);
              $BasketItem->setName($packageinfo['webbupointfinder_mp_title'].'-'.$user_id.'-'.$current_user->user_login);
              $BasketItem->setCategory1("Listing");
              $BasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
              $BasketItem->setPrice($total_package_price);
              $basketItems[0] = $BasketItem;
              $request->setBasketItems($basketItems);

              $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);
              
              update_post_meta($result_id,'pointfinder_order_iyzicotoken',$checkoutFormInitialize->getToken());


              $iyzico_content = $checkoutFormInitialize->getCheckoutFormContent();
              $iyzico_status = $checkoutFormInitialize->getStatus();
              $iyzico_errorMessage = $checkoutFormInitialize->geterrorMessage();

              if($iyzico_status == 'success'){
                  
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                    'order_post_id' =>  $order_post_id,
                    'token' =>  $order_post_id.'- Iyzico',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  'success',
                    'membership' => 1
                    )
                  );

                  $msg_output .= esc_html__('Payment process started. Please wait...','pointfindert2d');
          
              }else{
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                    'order_post_id' =>  $order_post_id,
                    'token' =>  $order_post_id.'- Iyzico',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  $iyzico_errorMessage,
                    'membership' => 1
                    )
                  );

                  $msg_output .= sprintf(esc_html__( 'Error: %s', 'pointfindert2d' ),$iyzico_errorMessage).'<br>';
                  $msg_output .= '<small>'.$iyzico_errorMessage.'</small><br/>';
                  $icon_processout = 485;
                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
              }

            break;
          }

        }else{
          $msg_output .= esc_html__('Please select a package.','pointfindert2d');
          $icon_processout = 485;
        }

      break;

      case 'stripepay':
        $processname = 'stripepay';
        $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id_ex', true );
        $packageinfo = pointfinder_membership_package_details_get($membership_user_package_id);

        $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );
        $sub_action = get_user_meta( $user_id, 'membership_user_subaction_ex', true );

        $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
        $user_email = $current_user->user_email;

        if ($setup20_stripesettings_decimals == 0) {
          $total_package_price =  $packageinfo['packageinfo_priceoutput'];
        }else{
          $total_package_price =  $packageinfo['packageinfo_priceoutput'] * 100;
        }

        $apipackage_name = $packageinfo['webbupointfinder_mp_title'];
        $apipackage_description = $packageinfo['webbupointfinder_mp_description'];

        $setup20_stripesettings_secretkey = PFSAIssetControl('setup20_stripesettings_secretkey','','');
        $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
        $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');

        require_once( get_template_directory().'/admin/core/stripe/init.php');

        $stripe = array(
          "secret_key"      => $setup20_stripesettings_secretkey,
          "publishable_key" => $setup20_stripesettings_publishkey
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        

        $token  = $_POST['dt'];
        $token = PFCleanArrayAttr('PFCleanFilters',$token);
   
        $charge = '';
        if ($total_package_price != 0) {
          try {
            $order_name = get_the_title($order_post_id);
            $charge = \Stripe\Charge::create(array(
              'amount'   => $total_package_price,
              'currency' => ''.$setup20_stripesettings_currency.'',
              'source'  => $token['id'],
              'description' => sprintf(esc_html__('Charge for %1$s (Order ID: %2$s)','pointfindert2d'),$apipackage_name,$order_name),
              'metadata' => array(
                "User ID" => $user_id,
                "Username" => $current_user->user_login,
                "User email" => $current_user->user_email,
                "Package Name" => $apipackage_name,
                "Package ID" => $membership_user_package_id,
                "FAV Order ID" => $order_name,
                "Taxe - GST" => $packageinfo['packageinfo_priceoutput_gst'],
                "Taxe - QST" => $packageinfo['packageinfo_priceoutput_qst'],
              )
            ));

            if ($charge->status == 'succeeded') {
              PF_CreatePaymentRecord(
                array(
                'user_id' =>  $user_id,
                'item_post_id'  =>  $membership_user_package_id,
                'order_post_id' => $order_post_id,
                'processname' =>  'DoExpressCheckoutPaymentStripe',
                'status'  =>  $charge->status,
                'membership' => 1
                )
              );

              delete_user_meta($user_id, 'membership_user_package_id_ex');
              delete_user_meta($user_id, 'membership_user_activeorder_ex');
              delete_user_meta($user_id, 'membership_user_subaction_ex');

              if ($sub_action == 'r') {
                $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process' => 'r'));
                $app_date = strtotime("now");
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
               
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Renew Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Renew','pointfindert2d'),
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput'],
                    'gst' => $packageinfo['packageinfo_priceoutput_gst'],
                    'qst' => $packageinfo['packageinfo_priceoutput_qst'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );
              }elseif ($sub_action == 'u') {
                $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process' => 'u'));
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
                update_post_meta( $order_post_id, 'pointfinder_order_packageid', $membership_user_package_id);

                /* Start: Calculate item/featured item count and remove from new package. */
                  $total_icounts = pointfinder_membership_count_ui($user_id);

                  /*Count User's Items*/
                  $user_post_count = 0;
                  $user_post_count = $total_icounts['item_count'];

                  /*Count User's Featured Items*/
                  $users_post_featured = 0;
                  $users_post_featured = $total_icounts['fitem_count'];

                  if ($packageinfo['webbupointfinder_mp_itemnumber'] != -1) {
                    $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'] - $user_post_count;
                  }else{
                    $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'];
                  }
                  
                  $new_fitem_limit = $packageinfo['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                  update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
                  update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
                  update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                  update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                  update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_recurring', 0);
                /* End: Calculate new limits */

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Upgrade','pointfindert2d'),
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput'],
                    'gst' => $packageinfo['packageinfo_priceoutput_gst'],
                    'qst' => $packageinfo['packageinfo_priceoutput_qst'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );

                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Upgrade Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );
              }else{
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', 3000000000 );
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Purchase Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                $membership_user_item_limit = get_user_meta( $user_id, 'membership_user_item_limit', true );
                update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']+$membership_user_item_limit);
                update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                update_user_meta( $user_id, 'membership_user_recurring', 0);

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'],
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput'],
                    'gst' => $packageinfo['packageinfo_priceoutput_gst'],
                    'qst' => $packageinfo['packageinfo_priceoutput_qst'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );
              }

              global $wpdb;
              $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

              

              $admin_email = get_option( 'admin_email' );
              $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
              
              $setup4_pricevat = PFSAIssetControl('setup4_pricevat','','0');
              if ($setup4_pricevat == 1) {
                $packagepricetag_text = $packageinfo['packageinfo_priceoutput_bfvat_text'];
              }else{
                $packagepricetag_text = $packageinfo['packageinfo_priceoutput_text'];
              }
              
              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $user_email,
                  'predefined' => 'paymentcompletedmember',
                  'data' => array(
                    'packagepricetag' => $packagepricetag_text,
                    'packagedescription' => $apipackage_description,
                    'packagename' => $apipackage_name
                  ),
                )
              );

              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'newpaymentreceivedmember',
                  'data' => array(
                    'ID'=> $order_post_id,
                    'ordername'=> $order_name,
                    'packagepricetag' => $packagepricetag_text,
                    'packagedescription' => $apipackage_description,
                    'packagename' => $apipackage_name
                  ),
                )
              );


              $msg_output .= esc_html__('Payment is successful.','pointfindert2d');
            }

          } catch(\Stripe\Error\Card $e) {
            if(isset($e)){
              $error_mes = json_decode($e->httpBody,true);
              $icon_processout = 485;
              $msg_output = (isset($error_mes['error']['message']))? $error_mes['error']['message']:'';
              if (empty($msg_output)) {
                $msg_output .= esc_html__('Payment not completed.','pointfindert2d');
              }
            }
          }
        }else{
          $msg_output .= esc_html__('Price can not be 0!). Payment process is stopped.','pointfindert2d');
          $icon_processout = 485;
        }
        
        if ($icon_processout != 485) {
          $overlar_class = ' pfoverlayapprove';
        }else{
          $overlar_class = '';
        }

      break;


      case 'cancelrecurring':
        $processname = 'cancelrecurring';
        
        $membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );   
        $membership_user_recurring = get_user_meta( $user_id, 'membership_user_recurring', true );

        $order_id = $membership_user_activeorder;

        $recurring_status = esc_attr(get_post_meta( $order_id, 'pointfinder_order_recurring',true));

        if (!empty($order_id) && $recurring_status == 1 && $membership_user_recurring == 1) {
          
            $pointfinder_order_expiredate = get_post_meta( $order_id, 'pointfinder_order_expiredate', true );
            $pointfinder_order_recurringid = get_post_meta( $order_id, 'pointfinder_order_recurringid', true );
            $pointfinder_order_packageid = get_post_meta( $order_id, 'pointfinder_order_packageid', true );
            $packageinfo = pointfinder_membership_package_details_get($pointfinder_order_packageid);
            
            update_post_meta( $order_id, 'pointfinder_order_recurring', 0 );
            update_user_meta( $user_id, 'membership_user_recurring', 0);
            
            PF_Cancel_recurring_payment_member(
             array( 
                    'user_id' => $user_id,
                    'profile_id' => $pointfinder_order_recurringid,
                    'item_post_id' => $order_id,
                    'order_post_id' => $order_id,
                )
             );

            PFCreateProcessRecord(
              array( 
                'user_id' => $user_id,
                'item_post_id' => $order_id,
                'processname' => esc_html__('Recurring Payment Profile Cancelled by User (User Profile Cancel)','pointfindert2d'),
                'membership' => 1
                )
            );

            $setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');

            if ($setup33_emaillimits_listingexpired == 1) {
              $user_info = get_userdata( $user_id);
              pointfinder_mailsystem_mailsender(
                array(
                'toemail' => $user_info->user_email,
                    'predefined' => 'expiredrecpaymentmember',
                    'data' => array(
                      'packagename' => $packageinfo['webbupointfinder_mp_title'], 
                      'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'], 
                      'expiredate' => PFU_DateformatS($pointfinder_order_expiredate),
                      'orderid' => $order_id
                      ),
                )
              );
            }
          }else{
            $icon_processout = 485;
            $msg_output = esc_html__("Recurring Profile can't found.",'pointfindert2d');
          }
      break;
    }
  }else{
    $msg_output .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
    $icon_processout = 485;
  }

  if ($icon_processout == 62) {
    $overlar_class = ' pfoverlayapprove';
  }else{
    $overlar_class = '';
  }

  $output_html = '';
  $output_html .= '<div class="golden-forms wrapper mini" style="height:200px">';
  $output_html .= '<div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay">';
  
  $output_html .= "<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div>";
  $output_html .= "<div class='pfrevoverlaytext".$overlar_class."'><i class='pfadmicon-glyph-".$icon_processout."'></i><span>".$msg_output."</span></div>";
  
  $output_html .= '</div>';
  $output_html .= '</div>';

  if ($icon_processout == 485) {
    echo json_encode( array( 'process'=>false, 'processname'=>$processname, 'mes'=>$output_html, 'returnurl' => $pfreturn_url));
  }else{
    
    if ($vars['pf_membership_payment_selection'] == 'stripe' && $formtype == 'purchasepackage') {
      
      echo json_encode($stripe_array);

    }elseif ($vars['pf_membership_payment_selection'] == 'payu' && $formtype == 'purchasepackage') {

      echo json_encode( array( 'process'=>true, 'mes'=>'','processname'=>$processname, 'returnurl' => $pfreturn_url,'payumail' => $payumail));

    }elseif ($vars['pf_membership_payment_selection'] == 'robo' && $formtype == 'purchasepackage') {

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html.$robo_html,'processname'=>$processname, 'returnurl' => $pfreturn_url));

    }elseif ($vars['pf_membership_payment_selection'] == 'iyzico' && $formtype == 'purchasepackage') {

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html.$robo_html,'processname'=>$processname, 'returnurl' => $pfreturn_url,'iyzico_content' => $iyzico_content,'iyzico_status' => $iyzico_status));
  
    } else {

      echo json_encode( 
        array( 
          'process'=>true, 
          'processname'=>$processname, 
          'mes'=>'', 
          'returnurl' => $pfreturn_url)
        );

    }
     
  }
  
die();
}

function pointfinder_membership_package_details_get($post_id){
  $packageinfo = array();
  $packageinfo['webbupointfinder_mp_packageid'] = $post_id;
  $packageinfo['webbupointfinder_mp_title'] = get_the_title($post_id);

  $webbupointfinder_mp_showhide = get_post_meta($post_id, 'webbupointfinder_mp_showhide', true );
  if ($webbupointfinder_mp_showhide == false) {$packageinfo['webbupointfinder_mp_showhide'] = 2;}else{$packageinfo['webbupointfinder_mp_showhide'] = $webbupointfinder_mp_showhide;}

  $webbupointfinder_mp_billing_time_unit = get_post_meta($post_id, 'webbupointfinder_mp_billing_time_unit', true );
  $packageinfo['webbupointfinder_mp_billing_time_unit_text'] = pointfinder_billing_timeunit_text($webbupointfinder_mp_billing_time_unit);
  if($webbupointfinder_mp_billing_time_unit == false){$packageinfo['webbupointfinder_mp_billing_time_unit'] = 'daily';}else{$packageinfo['webbupointfinder_mp_billing_time_unit'] = $webbupointfinder_mp_billing_time_unit;}

  $webbupointfinder_mp_billing_period = get_post_meta($post_id, 'webbupointfinder_mp_billing_period', true );
  if ($webbupointfinder_mp_billing_period == false) {$packageinfo['webbupointfinder_mp_billing_period'] = 1;}else{$packageinfo['webbupointfinder_mp_billing_period'] = $webbupointfinder_mp_billing_period;}

  $webbupointfinder_mp_trial = get_post_meta($post_id, 'webbupointfinder_mp_trial', true );
  if ($webbupointfinder_mp_trial == false) {$packageinfo['webbupointfinder_mp_trial'] = 0;}else{$packageinfo['webbupointfinder_mp_trial'] = $webbupointfinder_mp_trial;}

  $webbupointfinder_mp_trial_period = get_post_meta($post_id, 'webbupointfinder_mp_trial_period', true );
  if ($webbupointfinder_mp_trial_period == false) {$packageinfo['webbupointfinder_mp_trial_period'] = 1;}else{$packageinfo['webbupointfinder_mp_trial_period'] = $webbupointfinder_mp_trial_period;}

  $webbupointfinder_mp_itemnumber = get_post_meta($post_id, 'webbupointfinder_mp_itemnumber', true );
  if ($webbupointfinder_mp_itemnumber == false) {$packageinfo['webbupointfinder_mp_itemnumber'] = -1;}else{$packageinfo['webbupointfinder_mp_itemnumber'] = $webbupointfinder_mp_itemnumber;}

  $webbupointfinder_mp_fitemnumber = get_post_meta($post_id, 'webbupointfinder_mp_fitemnumber', true );
  if ($webbupointfinder_mp_fitemnumber == false) {$packageinfo['webbupointfinder_mp_fitemnumber'] = 0;}else{$packageinfo['webbupointfinder_mp_fitemnumber'] = $webbupointfinder_mp_fitemnumber;}

  $webbupointfinder_mp_images = get_post_meta($post_id, 'webbupointfinder_mp_images', true );
  if ($webbupointfinder_mp_images == false) {$packageinfo['webbupointfinder_mp_images'] = 10;}else{$packageinfo['webbupointfinder_mp_images'] = $webbupointfinder_mp_images;}

  $webbupointfinder_mp_price = get_post_meta($post_id, 'webbupointfinder_mp_price', true );
  if (empty($webbupointfinder_mp_price)) {$packageinfo['webbupointfinder_mp_price'] = 0;}else{$packageinfo['webbupointfinder_mp_price'] = $webbupointfinder_mp_price;}

  $webbupointfinder_mp_description = get_post_meta($post_id, 'webbupointfinder_mp_description', true );
  if (empty($webbupointfinder_mp_description)) {$packageinfo['webbupointfinder_mp_description'] = '';}else{$packageinfo['webbupointfinder_mp_description'] = $webbupointfinder_mp_description;}

  $setup20_paypalsettings_paypal_price_pref = PFSAIssetControl('setup20_paypalsettings_paypal_price_pref','',1);
  $setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');

  $packageinfo['packageinfo_priceoutput'] = $packageinfo['webbupointfinder_mp_price'];
  $packageinfo['packageinfo_priceoutput_bfvat'] = 0;
  $packageinfo['packageinfo_priceoutput_bfvat_text'] = "N/A";
  $packageinfo['packageinfo_priceoutput_vat'] = 0;
  $packageinfo['packageinfo_priceoutput_vat_text'] = "N/A";
  $packageinfo['packageinfo_priceoutput_gst'] = 0;
  $packageinfo['packageinfo_priceoutput_gst_text'] = "N/A";
  $packageinfo['packageinfo_priceoutput_qst'] = 0;
  $packageinfo['packageinfo_priceoutput_qst_text'] = "N/A";
  
  if ($packageinfo['webbupointfinder_mp_price'] != 0) {

    $setup20_decimals_new = PFSAIssetControl('setup20_decimals_new','',2);
    $setup20_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
    $setup20_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');

    $setup4_pricevat = PFSAIssetControl('setup4_pricevat','','0');
    if ($setup4_pricevat == 1) {
      $setup4_pv_pr = PFSAIssetControl('setup4_pv_pr','','0');
      $setup4_pv_pr = str_replace ('.', '', $setup4_pv_pr);
      $setup4_pv_pr_float = '0.'.$setup4_pv_pr;
      $setup4_pv_pr_float = (float)$setup4_pv_pr_float;
      
      $packageinfo['packageinfo_priceoutput_bfvat'] = $packageinfo['webbupointfinder_mp_price'];
      $packageinfo['packageinfo_priceoutput_vat'] = round($packageinfo['webbupointfinder_mp_price']*$setup4_pv_pr_float,$setup20_decimals_new);
      $packageinfo['packageinfo_priceoutput_gst'] = round($packageinfo['webbupointfinder_mp_price']*0.05,$setup20_decimals_new);
      $packageinfo['packageinfo_priceoutput_qst'] = round($packageinfo['webbupointfinder_mp_price']*0.09975,$setup20_decimals_new);
      
      
      $packageinfo['packageinfo_priceoutput'] = $packageinfo['webbupointfinder_mp_price']+$packageinfo['packageinfo_priceoutput_gst']+$packageinfo['packageinfo_priceoutput_qst'];
      
      $packageinfo['packageinfo_priceoutput_bfvat_text'] = pointfinder_reformat_pricevalue_for_frontend($packageinfo['webbupointfinder_mp_price']);
      $packageinfo['packageinfo_priceoutput_vat_text'] = pointfinder_reformat_pricevalue_for_frontend($packageinfo['packageinfo_priceoutput_vat']);
      $packageinfo['packageinfo_priceoutput_gst_text'] = pointfinder_reformat_pricevalue_for_frontend($packageinfo['packageinfo_priceoutput_gst']);
      $packageinfo['packageinfo_priceoutput_qst_text'] = pointfinder_reformat_pricevalue_for_frontend($packageinfo['packageinfo_priceoutput_qst']);
    }

    $packageinfo['packageinfo_priceoutput_text'] = pointfinder_reformat_pricevalue_for_frontend($packageinfo['packageinfo_priceoutput']);
  }else{
    $packageinfo['packageinfo_priceoutput'] = 0;
    $packageinfo['packageinfo_priceoutput_text'] = esc_html__('Free','pointfindert2d');
  }

  /*Check unlimited item*/
  if ($packageinfo['webbupointfinder_mp_itemnumber'] == -1) {
    $packageinfo['packageinfo_itemnumber_output_text'] = esc_html__('Unlimited','pointfindert2d');
  }else{
    $packageinfo['packageinfo_itemnumber_output_text'] = $packageinfo['webbupointfinder_mp_itemnumber'];
  }

  return $packageinfo;
}

function pointfinder_reformat_pricevalue_for_frontend($value){
  if (empty($value)) {return $value;}

  $setup20_decimals_new = PFSAIssetControl('setup20_decimals_new','',2);
  $setup20_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
  $setup20_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
  $price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');
  $price_pref = PFSAIssetControl('setup20_paypalsettings_paypal_price_pref','',1);

  $value_formatted = number_format($value,$setup20_decimals_new,$setup20_decimalpoint,$setup20_thousands);
  
  if (strpos($value, $price_short) === false) {
    if ($price_pref == 1) {

    return $price_short.$value_formatted;
  
  }else{

    return $value_formatted.$price_short;

  }
  }else{
    return $value_formatted;
  }
}

class Redux_Framework_PF_Mail_Config{
  public $args = array();
  public $sections = array();
  public $theme;
  public $ReduxFramework;
  
  public function __construct(){
    if (!class_exists("ReduxFramework")) {
      return;
    }
    
    if (  true == Redux_Helpers::isTheme(__FILE__) ) {
      $this->initSettings();
    } else {
      add_action('plugins_loaded', array($this, 'initSettings'), 10);
    }
  }

  public function initSettings(){

    $this->setArguments();
    $this->setSections();
    if (!isset($this->args['opt_name'])) {
      return;
    }

    $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
  }

  public function setSections(){
    

    /**
    *EMAIL SETTINS 
    **/
      /**
      *Start: Email Limits
      **/
        $this->sections[] = array(
          'id' => 'setup33_emaillimits',
          'icon' => 'el-icon-unlock-alt',
          'title' => esc_html__('Email Permissions', 'pointfindert2d'),
          'fields' => array(
              array(
                'id' => 'setup33_emaillimits_listingautowarning',
                'type' => 'button_set',
                'title' => esc_html__('Item Expire Date Warning', 'pointfindert2d') ,
                'desc'		=> esc_html__('If this option is enabled, the owner of item will receive an email before item expires.','pointfindert2d').'<br>'.esc_html__('(Sending time: 24 hours before expire time.)', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Enable', 'pointfindert2d') ,
                  '0' => esc_html__('Disable', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,
              array(
                'id' => 'setup33_emaillimits_listingexpired',
                'type' => 'button_set',
                'title' => esc_html__('Item Expiration', 'pointfindert2d') ,
                'desc'		=> esc_html__('If this option is enabled, the owner of item will receive an email after item expires.', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Enable', 'pointfindert2d') ,
                  '0' => esc_html__('Disable', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,
              array(
                'id' => 'setup33_emaillimits_adminemailsafterupload',
                'type' => 'button_set',
                'title' => esc_html__('New Upload: Admin Notification', 'pointfindert2d') ,
                'desc'		=> esc_html__('Do you want to receive an email after new item is uploaded?', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Yes', 'pointfindert2d') ,
                  '0' => esc_html__('No', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,
              array(
                'id' => 'setup33_emaillimits_adminemailsafteredit',
                'type' => 'button_set',
                'title' => esc_html__('Item Edit: Admin Notification', 'pointfindert2d') ,
                'desc'		=> esc_html__('Do you want to receive an email after item is edited?', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Yes', 'pointfindert2d') ,
                  '0' => esc_html__('No', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,

              array(
                'id' => 'setup33_emaillimits_useremailsaftertrash',
                'type' => 'button_set',
                'title' => esc_html__('Item Delete: User Notification', 'pointfindert2d') ,
                'desc'		=> esc_html__('Do you want to send an email after item is deleted by admin?', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Yes', 'pointfindert2d') ,
                  '0' => esc_html__('No', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,

              array(
                'id' => 'setup33_emaillimits_copyofcontactform',
                'type' => 'button_set',
                'title' => esc_html__('Item Contact Form: Send a copy to Admin', 'pointfindert2d') ,
                'desc'		=> esc_html__('Do you want to send a copy of every single item contact form to yourself?', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Yes', 'pointfindert2d') ,
                  '0' => esc_html__('No', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,

              array(
                'id' => 'setup33_emaillimits_copyofreviewform',
                'type' => 'button_set',
                'title' => esc_html__('Item Review Form: Send a copy to Admin', 'pointfindert2d') ,
                'desc'		=> esc_html__('Do you want to send a copy of every single item review form to yourself?', 'pointfindert2d'),
                'options' => array(
                  '1' => esc_html__('Yes', 'pointfindert2d') ,
                  '0' => esc_html__('No', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,
            )
        );
      
      /**
      *End: Email Limits
      **/






      /**
      *Start: Email Settings
      **/
        $this->sections[] = array(
          'id' => 'setup33_emailsettings',
          'icon' => ' el-icon-wrench-alt',
          'title' => esc_html__('Email Settings', 'pointfindert2d'),
          'fields' => array(
              array(
                'id' => 'setup33_emailsettings_ed',
                'type' => 'button_set',
                'title' => esc_html__('PointFinder Email System', 'pointfindert2d') ,
                'options' => array(
                  '1' => esc_html__('Enabled', 'pointfindert2d') ,
                  '0' => esc_html__('Disabled', 'pointfindert2d')
                ) ,
                'desc' => esc_html__('If this disabled, then you can use another smtp plugin. Note: System will use PointFinder templates while sending email even if you disable this.','pointfindert2d'),
                'default' => 1
                
              ) ,
              array(
                            'id'        => 'setup33_emailsettings_sitename',
                            'type'      => 'text',
                            'title'     => esc_html__('Site Name', 'pointfindert2d'),
                            'default'   => '',
                'hint' => array(
                  'content'   => esc_html__('Please write site name for email header.','pointfindert2d')
                ),
                'required' => array('setup33_emailsettings_ed','=',1)
                        ),
              array(
                            'id'        => 'setup33_emailsettings_fromname',
                            'type'      => 'text',
                            'title'     => esc_html__('From Name', 'pointfindert2d'),
                            'default'   => '',
                'hint' => array(
                  'content'   => esc_html__('Email from this name.','pointfindert2d')
                ),
                'required' => array('setup33_emailsettings_ed','=',1)
                        ),
              array(
                            'id'        => 'setup33_emailsettings_fromemail',
                            'type'      => 'text',
                            'title'     => esc_html__('From Email', 'pointfindert2d'),
                            'validate'  => 'email',
                            'msg'       => esc_html__('Please write a correct email.','pointfindert2d'),
                            'default'   => '',
                'text_hint' => array(
                  'title'     => esc_html__('Valid Email Required!','pointfindert2d'),
                  'content'   => esc_html__('This field required a valid email address.','pointfindert2d')
                ),
                'required' => array('setup33_emailsettings_ed','=',1)
                        ),
                        array(
                            'id'        => 'setup33_emailsettings_mainemail',
                            'type'      => 'text',
                            'title'     => esc_html__('Receive Email', 'pointfindert2d'),
                            'validate'  => 'email',
                            'msg'       => esc_html__('Please write a correct email.','pointfindert2d'),
                            'desc'       => esc_html__('This email address will receive all system emails such as payment, item submission, etc.','pointfindert2d'),
                            'default'   => '',
                'text_hint' => array(
                  'title'     => esc_html__('Valid Email Required!','pointfindert2d'),
                  'content'   => esc_html__('This field required a valid email address.','pointfindert2d')
                ),
                'required' => array('setup33_emailsettings_ed','=',1)
                        ),
                        array(
                'id' => 'setup33_emailsettings_mailtype',
                'type' => 'button_set',
                'title' => esc_html__('Content Type', 'pointfindert2d') ,
                'options' => array(
                  '1' => esc_html__('HTML', 'pointfindert2d') ,
                  '0' => esc_html__('Plain Text', 'pointfindert2d')
                ) ,
                'hint' => array(
                  'content'   => esc_html__('Do you want to send emails Plain Text or HTML format? Recommended: HTML','pointfindert2d')
                ),
                'default' => '1',
                'required' => array('setup33_emailsettings_ed','=',1)
                
              ) ,
                        array(
                'id' => 'setup33_emailsettings_auth',
                'type' => 'button_set',
                'title' => esc_html__('SMTP Authentication', 'pointfindert2d') ,
                'options' => array(
                  '1' => esc_html__('Enable', 'pointfindert2d') ,
                  '0' => esc_html__('Disable', 'pointfindert2d')
                ) ,
                'default' => '0',
                'required' => array('setup33_emailsettings_ed','=',1)
                
              ) ,
              array(
                            'id'        => 'setup33_emailsettings_smtpaccount',
                            'type'      => 'password',
                            'username'  => true,
                            'title'     => 'SMTP Account',
                            'hint' => array(
                  'content'   => esc_html__('Email server outgoing username & password.','pointfindert2d')
                ),
                'required'	=> array(array('setup33_emailsettings_auth','=',1),array('setup33_emailsettings_ed','=',1))
                        ),
                        array(
                            'id'        => 'setup33_emailsettings_smtp',
                            'type'      => 'text',
                            'title'     => esc_html__('SMTP Server', 'pointfindert2d'),
                            'default'   => '',
                'hint' => array(
                  'content'   => esc_html__('Please write your SMTP server host name or IP address.','pointfindert2d')
                ),
                'required' => array('setup33_emailsettings_ed','=',1)
                        ),
                        array(
                            'id'        => 'setup33_emailsettings_smtpport',
                            'type'      => 'text',
                            'title'     => esc_html__('SMTP Port', 'pointfindert2d'),
                            'default'   => '25',
                            'class'	=> 'small-text',
                            'required' => array('setup33_emailsettings_ed','=',1)
                        ),
                        array(
                            'id'        => 'setup33_emailsettings_secure',
                            'type'      => 'button_set',
                            'title'     => esc_html__('SMTP Secure', 'pointfindert2d'),
                            'options'   => array(
                                '' => esc_html__('None','pointfindert2d'), 
                                'ssl' => esc_html__('SSL','pointfindert2d'), 
                                'tls' => esc_html__('TLS','pointfindert2d')
                            ), 
                            'default'   => '',
                            'required' => array('setup33_emailsettings_ed','=',1)
                        ),
                        array(
                            'id'        => 'setup33_emailsettings_debug',
                            'type'      => 'button_set',
                            'title'     => esc_html__('SMTP DEBUG', 'pointfindert2d'),
                            'options'   => array(
                                '1' => esc_html__('Enable','pointfindert2d'), 
                                '0' => esc_html__('Disable','pointfindert2d')
                            ), 
                            'default'   => 0,
                            'desc'     => esc_html__('Warning: If this enabled then you will see the error text on smtp error. Recommended: Disabled', 'pointfindert2d'),
                            'required' => array('setup33_emailsettings_ed','=',1)
                        )
                       
              
            )
        );

        $this->sections[] = array(
          'id' => 'setup34_emailcontents',
          'icon' => 'el-icon-pencil-alt',
          'title' => esc_html__('Email Contents', 'pointfindert2d'),
          'fields' => array(
              
            )
        );
      /**
      *End: Email Settings
      **/

    
    
      /**
      *Start: Email Contents
      **/
        /**
        *Start: User System Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_loginemails',
            'subsection' => true,
            'title' => esc_html__('User Registration', 'pointfindert2d'),
            'desc'	=> esc_html__('You can change email contents by using below options.', 'pointfindert2d'),
            'fields' => array(
              /**
              *Registration Email
              **/
              array(
                'id'        => 'setup35_loginemails_register-start',
                'type'      => 'section',
                'title'     => esc_html__('Registration Email', 'pointfindert2d'),
                'subtitle'  => esc_html__('This email will be sent after user registration.', 'pointfindert2d'),
                'indent'    => true,
              ),
              array(
                'id'        => 'setup35_loginemails_register_subject',
                'type'      => 'text',
                'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                'default'	  => esc_html__('Registration Completed','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_loginemails_register_title',
                'type'      => 'text',
                'title'     => esc_html__('Email Title', 'pointfindert2d'),
                'default'	=> esc_html__('New User Registration','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_loginemails_register_contents',
                'type'      => 'editor',
                'args'	=> array(
                  'media_buttons'	=> false,
                  'teeny'	=> true,
                  'wpautop' => true
                ),
                'title'     => esc_html__('Email Content', 'pointfindert2d'),
                'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%').'<br>'.sprintf(esc_html__('%s : Display password', 'pointfindert2d'),'%%password%%'),
                'validate'  => 'html',
              ),
              array(
                'id'        => 'setup35_loginemails_register-end',
                'type'      => 'section',
                'indent'    => false, 
              ),
              array(
                'id'    => 'opt-divide',
                'type'  => 'divide'
              ),

              /**
              *Registration Email to Admin
              **/
              array(
                'id'        => 'setup35_loginemails_registeradm-start',
                'type'      => 'section',
                'title'     => esc_html__('Registration Email to Admin', 'pointfindert2d'),
                'subtitle'  => esc_html__('This email will be sent after user registration.', 'pointfindert2d'),
                'indent'    => true,
              ),
              array(
                'id'        => 'setup35_loginemails_registeradm_subject',
                'type'      => 'text',
                'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                'default'	=> esc_html__('Registration Completed','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_loginemails_registeradm_title',
                'type'      => 'text',
                'title'     => esc_html__('Email Title', 'pointfindert2d'),
                'default'	=> esc_html__('New User Registration','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_loginemails_registeradm_contents',
                'type'      => 'editor',
                'args'	=> array(
                  'media_buttons'	=> false,
                  'teeny'	=> true,
                  'wpautop' => true
                  ),
                'title'     => esc_html__('Email Content', 'pointfindert2d'),
                'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%'),
                'validate'  => 'html',
              ),
              array(
                'id'        => 'setup35_loginemails_registeradm-end',
                'type'      => 'section',
                'indent'    => false, 
              ),
              array(
                'id'    => 'opt-divide',
                'type'  => 'divide'
              ),

              /**
              *Forgot Password Email
              **/
              array(
                  'id'        => 'setup35_loginemails_forgot-start',
                  'type'      => 'section',
                  'title'     => esc_html__('Forgot Password Email', 'pointfindert2d'),
                  'subtitle'  => esc_html__('This email will be sent when forgotten password requests.', 'pointfindert2d'),
                  'indent'    => true,
                ),
                array(
                  'id'        => 'setup35_loginemails_forgot_subject',
                  'type'      => 'text',
                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                  'default'	=> esc_html__('Lost Password Reset','pointfindert2d'),
                ),
                array(
                  'id'        => 'setup35_loginemails_forgot_title',
                  'type'      => 'text',
                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                  'default'	=> esc_html__('Lost Password Reset','pointfindert2d'),
                ),
                array(
                  'id'        => 'setup35_loginemails_forgot_contents',
                  'type'      => 'editor',
                  'args'	=> array(
                    'media_buttons'	=> false,
                    'teeny'	=> true
                    ),
                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                  'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%').'<br>'.sprintf(esc_html__('%s : Display reset password link', 'pointfindert2d'),'%%keylink%%'),
                  'validate'  => 'html',
                ),
                array(
                  'id'        => 'setup35_loginemails_forgot-end',
                  'type'      => 'section',
                  'indent'    => false, 
                ),
              )
          );
        /**
        *End: User System Email Contents
        **/









        /**
        *Start: CONTACT Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_contactformemails',
            'subsection' => true,
            'title' => esc_html__('Contact Form', 'pointfindert2d'),
            'desc'	=> esc_html__('You can change email contents by using below options.', 'pointfindert2d'),
            'fields' => array(
              
              array(
                            'id'        => 'setup35_contactform_subject',
                            'type'      => 'text',
                            'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                            'default'	=> esc_html__('Contact Form','pointfindert2d'),
                        ),
              array(
                            'id'        => 'setup35_contactform_title',
                            'type'      => 'text',
                            'title'     => esc_html__('Email Title', 'pointfindert2d'),
                            'default'	=> esc_html__('New Contact Form','pointfindert2d'),
                        ),
              array(
                            'id'        => 'setup35_contactform_contents',
                            'type'      => 'editor',
                            'args'	=> array(
                              'media_buttons'	=> false,
                              'teeny'	=> true,
                              'wpautop' => true
                              ),
                            'title'     => esc_html__('Email Content', 'pointfindert2d'),
                            'subtitle'	=> sprintf(esc_html__('%s : Display name', 'pointfindert2d'),'%%name%%').
                            '<br>'.sprintf(esc_html__('%s : Display email', 'pointfindert2d'),'%%email%%').
                            '<br>'.sprintf(esc_html__('%s : Display subject', 'pointfindert2d'),'%%subject%%').
                            '<br>'.sprintf(esc_html__('%s : Display phone', 'pointfindert2d'),'%%phone%%').
                            '<br>'.sprintf(esc_html__('%s : Display message', 'pointfindert2d'),'%%msg%%').
                            '<br>'.sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%datetime%%'),
                            'validate'  => 'html',
                        ),
              

              )
          );
        /**
        *End: CONTACT Email Contents
        **/








        /**
        *Start: Submission Email Contents to USER
        **/
          $this->sections[] = array(
            'id' => 'setup35_submissionemails',
            'subsection' => true,
            'title' => sprintf(esc_html__('Item Submission (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
            'heading' => esc_html__('New Uploaded Item User Notification Emails', 'pointfindert2d'),
            'desc'	=> sprintf(esc_html__('You can change email contents for %s notification by using below options.', 'pointfindert2d'),esc_html__('user','pointfindert2d')),
            'fields' => array(

                 /**
                *Waiting for PAYMENT email
                **/

                            array(
                                'id'        => 'setup35_submissionemails_waitingpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('New Item; Waiting for PAYMENT', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when an item is uploaded and waiting for payment process', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_waitingpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item is waiting for payment','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_waitingpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item is waiting for payment','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_waitingpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_waitingpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),



                /**
                *Waiting for APPROVAL Email
                **/

                  array(
                                'id'        => 'setup35_submissionemails_waitingapproval-start',
                                'type'      => 'section',
                                'title'     => esc_html__('New Item; Waiting for APPROVAL', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after an item is uploaded and payment process is completed.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_waitingapproval_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item is waiting for approval','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_waitingapproval_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item is waiting for approval','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_waitingapproval',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_waitingapproval-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),


                     
                        /**
                *Item APPROVED email
                **/

                  array(
                                'id'        => 'setup35_submissionemails_approveditem-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item; APPROVED', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after an item is approved by admin.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_approveditem_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been approved for listing','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_approveditem_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Approved','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_approveditem',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link', 'pointfindert2d'),'%%itemlink%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_approveditem-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),


                        /**
                *Item REJECTED email
                **/

                            array(
                                'id'        => 'setup35_submissionemails_rejected-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item; REJECTED', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when an item is rejected by admin.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_rejected_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been rejected for listing','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_rejected_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Rejected','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_rejected',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_rejected-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Item DELETED email
                **/

                            array(
                                'id'        => 'setup35_submissionemails_deleted-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item; DELETED', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when an item is sent to trash (removed) by admin.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_deleted_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been deleted','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_deleted_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Deleted','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_deleted',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_deleted-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
              )
          );
        /**
        *End: Submission Email Contents to USER
        **/






        /**
        *Start: Submission Email Contents to ADMIN
        **/
          $this->sections[] = array(
            'id' => 'setup35_submissionemailsadmin',
            'subsection' => true,
            'title' => sprintf(esc_html__('Item Submission (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
            'heading' => esc_html__('Item Upload Emails for the Admin', 'pointfindert2d'),
            'desc'	=> sprintf(esc_html__('You can change email contents for %s notification by using below options.', 'pointfindert2d'),esc_html__('admin','pointfindert2d')),
            'fields' => array(

                /**
                *New item submitted
                **/

                            array(
                                'id'        => 'setup35_submissionemails_newitem-start',
                                'type'      => 'section',
                                'title'     => esc_html__('New Item; Uploaded', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when new item is uploaded and waiting for approval process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_newitem_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New item has been uploaded','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_newitem_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New item has been uploaded','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_newitem',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link (For admin)', 'pointfindert2d'),'%%itemlinkadmin%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_newitem-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),


                /**
                *Item Updated email
                **/

                            array(
                                'id'        => 'setup35_submissionemails_updateditem-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item; Edited', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when existing item is updated and waiting for approval process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_submissionemails_updateditem_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item edited','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_updateditem_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item edited','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_submissionemails_updateditem',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link (For admin)', 'pointfindert2d'),'%%itemlinkadmin%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_submissionemails_updateditem-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
              )
          );
        /**
        *End: Submission Email Contents to ADMIN
        **/





        /**
        *Start: Payment Email Contents (USER)
        **/
          $this->sections[] = array(
            'id' => 'setup35_paymentemails',
            'subsection' => true,
            'title' => sprintf(esc_html__('Payments (PPP) (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
            'heading' => sprintf(esc_html__('Payment System (PAY PER POST): %s Notifications', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
            'fields' => array(
                /**
                *Direct Payment completed email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentemails_paymentcompleted-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_paymentcompleted_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Payment completed','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_paymentcompleted_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Payment completed','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_paymentcompleted',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_paymentcompleted-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                /**
                *Recurring Payment completed email to USER
                **/

                            array(
                                'id'        => 'setup35_paymentemails_paymentcompletedrec-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Recurring Payment Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_paymentcompletedrec_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_paymentcompletedrec_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_paymentcompletedrec',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
                                  .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_paymentcompletedrec-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                        
                        /**
                *Bank Payment waiting email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentemails_bankpaymentwaiting-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_bankpaymentwaiting_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_bankpaymentwaiting_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_bankpaymentwaiting',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_bankpaymentwaiting-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Bank Payment cancelled email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentemails_bankpaymentcancel-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Cancelled', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a cancelled bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_bankpaymentcancel_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_bankpaymentcancel_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_bankpaymentcancel',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_bankpaymentcancel-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

              )
          );
        /**
        *End: Payment Email Contents (USER)
        **/




        /**
        *Start: Payment Email Contents (ADMIN)
        **/
          $this->sections[] = array(
            'id' => 'setup35_paymentemailsadmin',
            'subsection' => true,
            'title' => sprintf(esc_html__('Payments (PPP) (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
            'heading' => sprintf(esc_html__('Payment System (PAY PER POST): %s Notifications', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
            'fields' => array(
                        /**
                *Direct Payment completed email to ADMIN
                **/
                            
                            array(
                                'id'        => 'setup35_paymentemails_newdirectpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_newdirectpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New payment has been received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newdirectpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New payment has been received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newdirectpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_newdirectpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                          /**
                *Recurring Payment completed email to ADMIN
                **/
                            
                            array(
                                'id'        => 'setup35_paymentemails_newrecpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Recurring Payment Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_newrecpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newrecpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newrecpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
                                  .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_newrecpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Bank Payment received email to ADMIN
                **/
                            
                            array(
                                'id'        => 'setup35_paymentemails_newbankpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_newbankpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newbankpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_newbankpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentemails_newbankpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
              )
          );
        /**
        *End: Payment Email Contents (ADMIN)
        **/



        /**
        *Start: Payment Membership Email Contents (USER)
        **/
          $this->sections[] = array(
            'id' => 'setup35_paymentmemberemails',
            'subsection' => true,
            'title' => sprintf(esc_html__('Payments (Member) (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
            'heading' => sprintf(esc_html__('Payment System (Membership System): %s Notifications', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
            'fields' => array(

                /**
                *Free Payment completed email to USER - done
                **/
                            array(
                                'id'        => 'setup35_paymentmemberemails_freecompleted-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Free Plan Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded free plan process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_freecompleted_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Package Activated','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_freecompleted_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Package Activated','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_freecompleted',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display package title', 'pointfindert2d'),'%%packagename%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_freecompleted-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                /**
                *Direct Payment completed email to USER - done
                **/
                            array(
                                'id'        => 'setup35_paymentmemberemails_paymentcompleted-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompleted_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Payment completed','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompleted_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Payment completed','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompleted',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Displays package name', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Displays package price tag', 'pointfindert2d'),'%%packagepricetag%%').'<br>'
                                  .sprintf(esc_html__('%s : Displays package description', 'pointfindert2d'),'%%packagedescription%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_paymentcompleted-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                /**
                *Recurring Payment completed email to USER - done
                **/

                            array(
                                'id'        => 'setup35_paymentmemberemails_paymentcompletedrec-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Recurring Payment Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompletedrec_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompletedrec_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_paymentcompletedrec',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order number', 'pointfindert2d'),'%%ordernumber%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
                                  .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_paymentcompletedrec-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                        
                        /**
                *Bank Payment waiting email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Completed', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Bank Payment cancelled email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentcancel-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Cancelled', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a cancelled bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentcancel_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentcancel_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentcancel',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentcancel-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Bank Payment approved email to USER
                **/
                            array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentapp-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Approved', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a approved bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentapp_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request approved','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentapp_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Bank transfer request approved','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_bankpaymentapp',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%'),
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_bankpaymentapp-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

              )
          );
        /**
        *End: Payment Membership Email Contents (USER)
        **/


        /**
        *Start: Payment Membership Email Contents (ADMIN)
        **/
          $this->sections[] = array(
            'id' => 'setup35_paymentmemberemailsadmin',
            'subsection' => true,
            'title' => sprintf(esc_html__('Payments (Member) (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
            'heading' => sprintf(esc_html__('Payment System (Membership System): %s Notifications', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
            'fields' => array(
                /**
                *Free Payment completed email to ADMIN - done
                **/
                            
                            array(
                                'id'        => 'setup35_paymentmemberemails_newfreepayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_newfreepayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New free plan ordered','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newfreepayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New free plan ordered','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newfreepayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%ordereditlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_newfreepayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Direct Payment completed email to ADMIN - done
                **/
                            
                            array(
                                'id'        => 'setup35_paymentmemberemails_newdirectpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_newdirectpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New payment has been received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newdirectpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New payment has been received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newdirectpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%ordereditlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display package name', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Displays package price tag', 'pointfindert2d'),'%%packagepricetag%%').'<br>'
                                  .sprintf(esc_html__('%s : Displays package description', 'pointfindert2d'),'%%packagedescription%%').'<br>'
                                  ,
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_newdirectpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                          /**
                *Recurring Payment completed email to ADMIN - done
                **/
                            
                            array(
                                'id'        => 'setup35_paymentmemberemails_newrecpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Recurring Payment Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_newrecpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newrecpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newrecpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display User ID', 'pointfindert2d'),'%%userid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display order number', 'pointfindert2d'),'%%ordernumber%%').'<br>'
                                  .sprintf(esc_html__('%s : Display order edit link', 'pointfindert2d'),'%%ordereditadminlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
                                  .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_newrecpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Bank Payment received email to ADMIN
                **/
                            
                            array(
                                'id'        => 'setup35_paymentmemberemails_newbankpayment-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Bank Payment Request Received Email Content', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentmemberemails_newbankpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newbankpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentmemberemails_newbankpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%orderadminlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_paymentmemberemails_newbankpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
              )
          );
        /**
        *End: Payment Membership Email Contents (ADMIN)
        **/




        /**
        *Start: Expiry/Expired Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_autoemailsadmin',
            'subsection' => true,
            'title' => esc_html__('Auto System (PPP/Expiry)', 'pointfindert2d'),
            'fields' => array(
                        /**
                *Direct Payment before expire email content
                **/
                            
                            array(
                                'id'        => 'setup35_autoemailsadmin_directbeforeexpire-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Direct Payment: Item Expiring Notification ', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent before item expires.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_directbeforeexpire_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_directbeforeexpire_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_directbeforeexpire',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_autoemailsadmin_directbeforeexpire-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                        /**
                *Direct Payment after expire email content
                **/
                            
                            array(
                                'id'        => 'setup35_autoemailsadmin_directafterexpire-start',
                                'type'      => 'section',
                                'title'     => sprintf(esc_html__('%s: Item Expired Notification', 'pointfindert2d'),esc_html__('Direct Payment','pointfindert2d')),
                                'subtitle'  => esc_html__('This email will be sent after item is expired.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_autoemailsadmin_directafterexpire_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_autoemailsadmin_directafterexpire_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_autoemailsadmin_directafterexpire',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_autoemailsadmin_directafterexpire-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                          /**
                *Recurring Payment expired email content
                **/
                            
                            array(
                                'id'        => 'setup35_autoemailsadmin_expiredrecpayment-start',
                                'type'      => 'section',
                                'title'     => sprintf(esc_html__('%s: Item Expired Notification', 'pointfindert2d'),esc_html__('Recurring Payment','pointfindert2d')),
                                'subtitle'  => esc_html__('This email will be sent after item is expired.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_paymentemails_expiredrecpayment_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_expiredrecpayment_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_paymentemails_expiredrecpayment',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
                                  .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                                  .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                                  .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_autoemailsadmin_expiredrecpayment-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                            

              )
          );
        /**
        *End: Expiry/Expired Email Contents
        **/

        /**
        *Start: Membership Expiry/Expired Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_autoemailsmemberadmin',
            'subsection' => true,
            'title' => esc_html__('Auto System (Member/Expiry)', 'pointfindert2d'),
            'fields' => array(
              /**
              *Direct Payment before expire email content - done
              **/
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directbeforeexpire-start',
                'type'      => 'section',
                'title'     => esc_html__('Direct Payment: Plan Expiring Notification ', 'pointfindert2d'),
                'subtitle'  => esc_html__('This email will be sent before plan expires.', 'pointfindert2d'),
                'indent'    => true, 
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_directbeforeexpire_subject',
                'type'      => 'text',
                'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_directbeforeexpire_title',
                'type'      => 'text',
                'title'     => esc_html__('Email Title', 'pointfindert2d'),
                'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_directbeforeexpire',
                'type'      => 'editor',
                'args'	=> array(
                  'media_buttons'	=> false,
                  'teeny'	=> true
                  ),
                'title'     => esc_html__('Email Content', 'pointfindert2d'),
                'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
                .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                'validate'  => 'html',
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directbeforeexpire-end',
                'type'      => 'section',
                'indent'    => false, 
              ),
              /**
              *Direct Payment after expire email content - done
              **/
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directafterexpire-start',
                'type'      => 'section',
                'title'     => sprintf(esc_html__('%s: Plan Expired Notification', 'pointfindert2d'),esc_html__('Direct Payment','pointfindert2d')),
                'subtitle'  => esc_html__('This email will be sent after plan is expired.', 'pointfindert2d'),
                'indent'    => true, 
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directafterexpire_subject',
                'type'      => 'text',
                'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directafterexpire_title',
                'type'      => 'text',
                'title'     => esc_html__('Email Title', 'pointfindert2d'),
                'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directafterexpire',
                'type'      => 'editor',
                'args'	=> array(
                  'media_buttons'	=> false,
                  'teeny'	=> true
                  ),
                'title'     => esc_html__('Email Content', 'pointfindert2d'),
                'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
                .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
                'validate'  => 'html',
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_directafterexpire-end',
                'type'      => 'section',
                'indent'    => false, 
              ),
              /**
              *Recurring Payment expired email content - done
              **/
              array(
                'id'        => 'setup35_autoemailsmemberadmin_expiredrecpayment-start',
                'type'      => 'section',
                'title'     => sprintf(esc_html__('%s: Plan Expired Notification', 'pointfindert2d'),esc_html__('Recurring Payment','pointfindert2d')),
                'subtitle'  => esc_html__('This email will be sent after plan is expired.', 'pointfindert2d'),
                'indent'    => true, 
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_expiredrecpayment_subject',
                'type'      => 'text',
                'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                'default'	=> esc_html__('Recurring Profile Cancelled','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_expiredrecpayment_title',
                'type'      => 'text',
                'title'     => esc_html__('Email Title', 'pointfindert2d'),
                'default'	=> esc_html__('Recurring Profile Cancelled','pointfindert2d'),
              ),
              array(
                'id'        => 'setup35_paymentmemberemails_expiredrecpayment',
                'type'      => 'editor',
                'args'	=> array(
                  'media_buttons'	=> false,
                  'teeny'	=> true
                ),
                'title'     => esc_html__('Email Content', 'pointfindert2d'),
                'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
                .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
                .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
                .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>',
                'validate'  => 'html',
              ),
              array(
                'id'        => 'setup35_autoemailsmemberadmin_expiredrecpayment-end',
                'type'      => 'section',
                'indent'    => false, 
              ),
            )
          );
        /**
        *End: Membership Expiry/Expired Email Contents
        **/




        /**
        *Start: Item Contact Form Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_itemcontact',
            'subsection' => true,
            'title' => esc_html__('Item Contact Form', 'pointfindert2d'),
            'fields' => array(
                        /**
                *Item Contact Form to User email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemcontact_enquiryformuser-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Contact Form: To User', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item contact form submitted.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemcontact_enquiryformuser_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Contact Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_enquiryformuser_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Contact Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_enquiryformuser',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemcontact_enquiryformuser-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                        /**
                *Item Contact Form to Admin email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemcontact_enquiryformadmin-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Contact Form: To Admin', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item contact form submitted.(A copy to Admin)', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemcontact_enquiryformadmin_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('(User) Contact Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_enquiryformadmin_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('(User) Contact Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_enquiryformadmin',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemcontact_enquiryformadmin-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

              )
          );
        /**
        *End: Item Contact Form Email Contents
        **/





        /**
        *Start: Item Review Form Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_itemreview',
            'subsection' => true,
            'title' => esc_html__('Item Review Form', 'pointfindert2d'),
            'fields' => array(
                        /**
                *Item Review Form to User email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemreview_reviewformuser-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Review Form: To User', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item review form submitted.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemreview_reviewformuser_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Review Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewformuser_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Review Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewformuser',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemreview_reviewformuser-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                        /**
                *Item Review Form to Admin email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemreview_reviewformadmin-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Review Form: To Admin', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item review form submitted.(A copy to Admin)', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemreview_reviewformadmin_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('(User) Review Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewformadmin_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('(User) Review Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewformadmin',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display review edit link', 'pointfindert2d'),'%%reveditlink%%').'<br>'
                                  .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemreview_reviewformadmin-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

                        /**
                *Item Review Flag Form to Admin email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemreview_reviewflagformadmin-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Review Flag Form: To Admin', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a review comment has been flagged.(to Admin)', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemreview_reviewflagformadmin_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('A review flagged for re-check','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewflagformadmin_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('A review flagged for re-check','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemreview_reviewflagformadmin',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display review info', 'pointfindert2d'),'%%reviewinfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender reason', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemreview_reviewflagformadmin-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),

              )
          );
        /**
        *End: Item Review Form Email Contents
        **/



        /**
        *Start: Item Report Form Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_itemreport',
            'subsection' => true,
            'title' => esc_html__('Item Report Form', 'pointfindert2d'),
            'fields' => array(
                        /**
                *Item Report Form to User email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemcontact_report-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Report Form: To User', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item report form, submitted.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemcontact_report_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Report Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_report_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Report Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_report',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender UserID', 'pointfindert2d'),'%%userid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemcontact_report-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                       

              )
          );
        /**
        *End: Item Report Form Email Contents
        **/


        /**
        *Start: Item Claim Form Email Contents
        **/
          $this->sections[] = array(
            'id' => 'setup35_itemclaim',
            'subsection' => true,
            'title' => esc_html__('Item Claim Form', 'pointfindert2d'),
            'fields' => array(
                        /**
                *Item Claim Form to Admin email content
                **/
                            
                            array(
                                'id'        => 'setup35_itemcontact_claim-start',
                                'type'      => 'section',
                                'title'     => esc_html__('Item Claim Form: To Admin', 'pointfindert2d'),
                                'subtitle'  => esc_html__('This email will be sent when a user item claim form, submitted.', 'pointfindert2d'),
                                'indent'    => true, 
                                
                            ),
                              array(
                                  'id'        => 'setup35_itemcontact_claim_subject',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Subject', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Claim Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_claim_title',
                                  'type'      => 'text',
                                  'title'     => esc_html__('Email Title', 'pointfindert2d'),
                                  'default'	=> esc_html__('Item Claim Form Received','pointfindert2d'),
                              ),
                    array(
                                  'id'        => 'setup35_itemcontact_claim',
                                  'type'      => 'editor',
                                  'args'	=> array(
                                    'media_buttons'	=> false,
                                    'teeny'	=> true
                                    ),
                                  'title'     => esc_html__('Email Content', 'pointfindert2d'),
                                  'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
                                  .sprintf(esc_html__('%s : Display sender UserID', 'pointfindert2d'),'%%userid%%').'<br>'
                                  .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
                                  'validate'  => 'html',
                              ),
                          array(
                                'id'        => 'setup35_itemcontact_claim-end',
                                'type'      => 'section',
                                'indent'    => false, 
                            ),
                       

              )
          );
        /**
        *End: Item Claim Form Email Contents
        **/



      /**
      *End: Email Contents
      **/


      /**
      *Start: Email Template Settings
      **/
        $this->sections[] = array(
          'id' => 'setup35_template',
          'icon' => 'el-icon-website-alt',
          'title' => esc_html__('Email Template', 'pointfindert2d'),
          'fields' => array(
              array(
                'id' => 'setup35_template_rtl',
                'type' => 'button_set',
                'title' => esc_html__('Text Direction', 'pointfindert2d') ,
                'options' => array(
                  '1' => esc_html__('Show Right to Left', 'pointfindert2d') ,
                  '0' => esc_html__('Show Left to Right', 'pointfindert2d')
                ) ,
                'default' => '0'
                
              ) ,

              array(
                'id' => 'setup35_template_logo',
                'type' => 'button_set',
                'title' => esc_html__('Template Logo', 'pointfindert2d') ,
                'options' => array(
                  '1' => esc_html__('Show Logo', 'pointfindert2d') ,
                  '0' => esc_html__('Show Text', 'pointfindert2d')
                ) ,
                'default' => '1'
                
              ) ,

              array(
                            'id'        => 'setup35_template_logotext',
                            'type'      => 'text',
                            'title'     => esc_html__('Logo Text', 'pointfindert2d'),
                            'required'   => array('setup35_template_logo','=','0'),
                            'text_hint' => array(
                                'title'     => '',
                                'content'   => esc_html__('Please type your logo text. Ex: Pointfinder','pointfindert2d')
                            )
                        ),

              array(
                            'id'        => 'setup35_template_mainbgcolor',
                            'type'      => 'color',
                            'title'     => esc_html__('Main Background Color', 'pointfindert2d'),
                            'default'   => '#F0F1F3',
                            'validate'  => 'color',
                            'transparent'	=> false
                        ),

              array(
                            'id'        => 'setup35_template_headerfooter',
                            'type'      => 'color',
                            'title'     => esc_html__('Header / Footer: Background Color', 'pointfindert2d'),
                            'default'   => '#f7f7f7',
                            'validate'  => 'color',
                             'transparent'	=> false
                        ),

                        array(
                            'id'        => 'setup35_template_headerfooter_line',
                            'type'      => 'color',
                            'title'     => esc_html__('Header / Footer: Line Color', 'pointfindert2d'),
                            'default'   => '#F25555',
                            'validate'  => 'color',
                             'transparent'	=> false
                        ),

                        
                        array(
                            'id'        => 'setup35_template_headerfooter_text',
                            'type'      => 'link_color',
                            'title'     => esc_html__('Header / Footer: Text/Link Color', 'pointfindert2d'),
                            //'regular'   => false, 
                            //'hover'     => false,
                            'active'    => false,
                            'visited'   => false,
                            'default'   => array(
                                'regular'   => '#494949',
                                'hover'     => '#F25555',
                            )
                        ),

                        array(
                            'id'        => 'setup35_template_contentbg',
                            'type'      => 'color',
                            'title'     => esc_html__('Content: Background Color', 'pointfindert2d'),
                            'default'   => '#ffffff',
                            'validate'  => 'color',
                             'transparent'	=> false
                        ),

                        array(
                            'id'        => 'setup35_template_contenttext',
                            'type'      => 'link_color',
                            'title'     => esc_html__('Content: Text/Link Color', 'pointfindert2d'),
                            //'regular'   => false, 
                            //'hover'     => false,
                            'active'    => false,
                            'visited'   => false,
                            'default'   => array(
                                'regular'   => '#494949',
                                'hover'     => '#F25555',
                            )
                        ),

            array(
              'id'        => 'setup35_template_footertext',
              'type'      => 'textarea',
              'title'     => esc_html__('Footer Text', 'pointfindert2d'),
              'desc'		=> esc_html__('%%siteurl%% : Site URL', 'pointfindert2d').'<br>'.esc_html__('%%sitename%% : Site Name', 'pointfindert2d'),
              'default'	=> __('This is an automated email from <a href="%%siteurl%%">%%sitename%%</a>','pointfindert2d')
            ),
          )
        );
      /**
      *End: Email Template Settings
      **/
    /**
    *EMAIL SETTINGS
    **/
    
  }

  public function setArguments(){
    $this->args = array(
      'opt_name'             => 'pointfindermail_options',
      "global_variable" 	   => "pointfindermail_option",
      'display_name'         => esc_html__('Point Finder Mail System Config','pointfindert2d'),
      'menu_type'            => 'submenu',
      'page_parent'          => 'pointfinder_tools',
      'menu_title'           => esc_html__('Mail System Config','pointfindert2d'),
      'page_title'           => esc_html__('Point Finder Mail System Config', 'pointfindert2d'),
      'admin_bar'            => false,
      'allow_sub_menu'       => false,
      'admin_bar_priority'   => 50,
      'global_variable'      => '',
      'dev_mode'             => false,
      'update_notice'        => false,
      'menu_icon'            => 'dashicons-email',
      'page_slug'            => '_pfmailoptions',
      'save_defaults'        => true,
      'default_show'         => false,
      'default_mark'         => '',
      'transient_time'       => 60 * MINUTE_IN_SECONDS,
      'output'               => false,
      'output_tag'           => false,
      'database'             => '',
      'system_info'          => false,
      'domain'               => 'redux-framework',
      'hide_reset'           => true,
      'update_notice'        => false,
    );
    $this->args['global_variable'] = 'pointfindermail_option';

  }
}
new Redux_Framework_PF_Mail_Config();

function PFPredefinedEmails($value,$data){

  switch ($value) {

    case 'registration':
      $setup35_loginemails_register_subject = esc_attr(PFMSIssetControl('setup35_loginemails_register_subject','',''));
      $setup35_loginemails_register_title = esc_attr(PFMSIssetControl('setup35_loginemails_register_title','',''));
      $mail_text = $setup35_loginemails_register_contents = PFMSIssetControl('setup35_loginemails_register_contents','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%password%%', $data['password'], $mail_text );
        $mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
      }

      return array(
        'subject' => $setup35_loginemails_register_subject, 
        'title' => $setup35_loginemails_register_title,
        'content' => $mail_text);

      break;


    case 'registrationadmin':
      $setup35_loginemails_register_subject = esc_attr(PFMSIssetControl('setup35_loginemails_registeradm_subject','',''));
      $setup35_loginemails_register_title = esc_attr(PFMSIssetControl('setup35_loginemails_registeradm_title','',''));
      $mail_text = $setup35_loginemails_register_contents = PFMSIssetControl('setup35_loginemails_registeradm_contents','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
      }

      return array(
        'subject' => $setup35_loginemails_register_subject, 
        'title' => $setup35_loginemails_register_title,
        'content' => $mail_text);

      break;


    case 'lostpassword':
      $setup35_loginemails_forgot_subject = esc_attr(PFMSIssetControl('setup35_loginemails_forgot_subject','',''));
      $setup35_loginemails_forgot_title = esc_attr(PFMSIssetControl('setup35_loginemails_forgot_title','',''));
      $mail_text = $setup35_loginemails_forgot_contents = PFMSIssetControl('setup35_loginemails_forgot_contents','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%keylink%%', $data['keylink'], $mail_text );
        $mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
      }

      return array(
        'subject' => $setup35_loginemails_forgot_subject, 
        'title' => $setup35_loginemails_forgot_title,
        'content' => $mail_text);

      break;

    case 'itemapproved':// to USER

      $setup35_submissionemails_approveditem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_approveditem_subject','',''));
      $setup35_submissionemails_approveditem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_approveditem_title','',''));
      $mail_text = $setup35_submissionemails_approveditem = PFMSIssetControl('setup35_submissionemails_approveditem','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemlink%%', get_permalink($data['ID']), $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_approveditem_subject, 
        'title' => $setup35_submissionemails_approveditem_title,
        'content' => $mail_text);

      break;

    case 'itemrejected':// to USER

      $setup35_submissionemails_rejected_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_rejected_subject','',''));
      $setup35_submissionemails_rejected_title = esc_attr(PFMSIssetControl('setup35_submissionemails_rejected_title','',''));
      $mail_text = $setup35_submissionemails_rejected = PFMSIssetControl('setup35_submissionemails_rejected','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_rejected_subject, 
        'title' => $setup35_submissionemails_rejected_title,
        'content' => $mail_text);

      break;

    case 'itemdeleted':// to USER

      $setup35_submissionemails_deleted_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_deleted_subject','',''));
      $setup35_submissionemails_deleted_title = esc_attr(PFMSIssetControl('setup35_submissionemails_deleted_title','',''));
      $mail_text = $setup35_submissionemails_deleted = PFMSIssetControl('setup35_submissionemails_deleted','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_deleted_subject, 
        'title' => $setup35_submissionemails_deleted_title,
        'content' => $mail_text);

      break;

    case 'waitingapproval':// to USER

      $setup35_submissionemails_waitingapproval_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingapproval_subject','',''));
      $setup35_submissionemails_waitingapproval_title = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingapproval_title','',''));
      $mail_text = $setup35_submissionemails_waitingapproval = PFMSIssetControl('setup35_submissionemails_waitingapproval','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_waitingapproval_subject, 
        'title' => $setup35_submissionemails_waitingapproval_title,
        'content' => $mail_text);

      break;

    case 'waitingpayment': // to USER

      $setup35_submissionemails_waitingpayment_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingpayment_subject','',''));
      $setup35_submissionemails_waitingpayment_title = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingpayment_title','',''));
      $mail_text = $setup35_submissionemails_waitingpayment = PFMSIssetControl('setup35_submissionemails_waitingpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_waitingpayment_subject, 
        'title' => $setup35_submissionemails_waitingpayment_title,
        'content' => $mail_text);

      break;

    case 'updateditemsubmission': // to ADMIN
      
      $setup35_submissionemails_updateditem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_updateditem_subject','',''));
      $setup35_submissionemails_updateditem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_updateditem_title','',''));
      $mail_text = $setup35_submissionemails_updateditem = PFMSIssetControl('setup35_submissionemails_updateditem','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemlinkadmin%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_updateditem_subject, 
        'title' => $setup35_submissionemails_updateditem_title,
        'content' => $mail_text);

      break;

    case 'newitemsubmission': // to ADMIN

      $setup35_submissionemails_newitem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_newitem_subject','',''));
      $setup35_submissionemails_newitem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_newitem_title','',''));
      $mail_text = $setup35_submissionemails_newitem = PFMSIssetControl('setup35_submissionemails_newitem','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemlinkadmin%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
      }

      return array(
        'subject' => $setup35_submissionemails_newitem_subject, 
        'title' => $setup35_submissionemails_newitem_title,
        'content' => $mail_text);

      break;

    case 'newpaymentreceived': // to ADMIN

      $setup35_paymentemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newdirectpayment_subject','',''));
      $setup35_paymentemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newdirectpayment_title','',''));
      $mail_text = $setup35_paymentemails_newdirectpayment = PFMSIssetControl('setup35_paymentemails_newdirectpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_newdirectpayment_subject, 
        'title' => $setup35_paymentemails_newdirectpayment_title,
        'content' => $mail_text);

      break;

    case 'recurringprofilecreated': // to ADMIN

      $setup35_paymentemails_newrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newrecpayment_subject','',''));
      $setup35_paymentemails_newrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newrecpayment_title','',''));
      $mail_text = $setup35_paymentemails_newrecpayment = PFMSIssetControl('setup35_paymentemails_newrecpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
        $mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_newrecpayment_subject, 
        'title' => $setup35_paymentemails_newrecpayment_title,
        'content' => $mail_text);

      break;

    case 'newbankpreceived': // to ADMIN

      $setup35_paymentemails_newbankpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newbankpayment_subject','',''));
      $setup35_paymentemails_newbankpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newbankpayment_title','',''));
      $mail_text = $setup35_paymentemails_newbankpayment = PFMSIssetControl('setup35_paymentemails_newbankpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_newbankpayment_subject, 
        'title' => $setup35_paymentemails_newbankpayment_title,
        'content' => $mail_text);

      break;

    case 'paymentcompleted': // to USER

      $setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompleted_subject','',''));
      $setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompleted_title','',''));
      $mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentemails_paymentcompleted','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_paymentcompleted_subject, 
        'title' => $setup35_paymentemails_paymentcompleted_title,
        'content' => $mail_text);

      break;

    case 'recprofilecreated': // to USER

      $setup35_paymentemails_paymentcompletedrec_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompletedrec_subject','',''));
      $setup35_paymentemails_paymentcompletedrec_title = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompletedrec_title','',''));
      $mail_text = $setup35_paymentemails_paymentcompletedrec = PFMSIssetControl('setup35_paymentemails_paymentcompletedrec','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
        $mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_paymentcompletedrec_subject, 
        'title' => $setup35_paymentemails_paymentcompletedrec_title,
        'content' => $mail_text);

      break;

    case 'bankpaymentwaiting': // to USER

      $setup35_paymentemails_bankpaymentwaiting_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting_subject','',''));
      $setup35_paymentemails_bankpaymentwaiting_title = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting_title','',''));
      $mail_text = $setup35_paymentemails_bankpaymentwaiting = PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_bankpaymentwaiting_subject, 
        'title' => $setup35_paymentemails_bankpaymentwaiting_title,
        'content' => $mail_text);

      break;

    case 'bankpaymentcancel': // to USER

      $setup35_paymentemails_bankpaymentcancel_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentcancel_subject','',''));
      $setup35_paymentemails_bankpaymentcancel_title = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentcancel_title','',''));
      $mail_text = $setup35_paymentemails_bankpaymentcancel = PFMSIssetControl('setup35_paymentemails_bankpaymentcancel','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_bankpaymentcancel_subject, 
        'title' => $setup35_paymentemails_bankpaymentcancel_title,
        'content' => $mail_text);

      break;

    case 'directafterexpire': // to USER

      $setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsadmin_directafterexpire_subject','',''));
      $setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsadmin_directafterexpire_title','',''));
      $mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsadmin_directafterexpire','','');

      
      if(PFControlEmptyArr($data)){
        $pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
        $pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));

        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', get_the_title($data['ID']), $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($pointfinder_order_price), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
        'title' => $setup35_autoemailsadmin_directafterexpire_title,
        'content' => $mail_text
      );

      break;

    case 'directbeforeexpire': //to USER

      $setup35_autoemailsadmin_directbeforeexpire_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_directbeforeexpire_subject','',''));
      $setup35_autoemailsadmin_directbeforeexpire_title = esc_attr(PFMSIssetControl('setup35_paymentemails_directbeforeexpire_title','',''));
      $mail_text = $setup35_autoemailsadmin_directbeforeexpire = PFMSIssetControl('setup35_paymentemails_directbeforeexpire','','');
      
      if(PFControlEmptyArr($data)){
        //$pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
        //$pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));

        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', '<a href="'.get_permalink( $data['ID'] ).'">'.get_the_title($data['ID']).'</a>', $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format'),strtotime($data['expiredate'])), $mail_text );
        //$mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($pointfinder_order_price), $mail_text );
        //$mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_directbeforeexpire_subject, 
        'title' => $setup35_autoemailsadmin_directbeforeexpire_title,
        'content' => $mail_text
      );

      break;

    case 'expiredrecpayment': // to USER

      $setup35_autoemailsadmin_expiredrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_expiredrecpayment_subject','',''));
      $setup35_autoemailsadmin_expiredrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_expiredrecpayment_title','',''));
      $mail_text = $setup35_autoemailsadmin_expiredrecpayment = PFMSIssetControl('setup35_paymentemails_expiredrecpayment','','');

      
      if(PFControlEmptyArr($data)){
        $pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
        $pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));

        $mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%itemname%%', get_the_title($data['ID']), $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($pointfinder_order_price), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_expiredrecpayment_subject, 
        'title' => $setup35_autoemailsadmin_expiredrecpayment_title,
        'content' => $mail_text
      );

      break;

    case 'enquiryformuser': // to USER

      $setup35_itemcontact_enquiryformuser_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformuser_subject','',''));
      $setup35_itemcontact_enquiryformuser_title = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformuser_title','',''));
      $mail_text = $setup35_itemcontact_enquiryformuser = PFMSIssetControl('setup35_itemcontact_enquiryformuser','','');

      
      if(PFControlEmptyArr($data)){
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        if(!empty($data['phone'])){
          $mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
        }else{
          $mail_text = str_replace( '%%phone%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemcontact_enquiryformuser_subject, 
        'title' => $setup35_itemcontact_enquiryformuser_title,
        'content' => $mail_text
      );

      break;

    case 'enquiryformadmin': // to ADMIN

      $setup35_itemcontact_enquiryformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformadmin_subject','',''));
      $setup35_itemcontact_enquiryformadmin_title = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformadmin_title','',''));
      $mail_text = $setup35_itemcontact_enquiryformadmin = PFMSIssetControl('setup35_itemcontact_enquiryformadmin','','');

      
      if(PFControlEmptyArr($data)){
         
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        if(!empty($data['user'])){
          $user = get_user_by( 'id', $data['user'] );
          if($user != false){
            $mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
          }else{
            $mail_text = str_replace( '%%userinfo%%', '', $mail_text );
          }
        }else{
          $mail_text = str_replace( '%%userinfo%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        if(!empty($data['phone'])){
          $mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
        }else{
          $mail_text = str_replace( '%%phone%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemcontact_enquiryformadmin_subject, 
        'title' => $setup35_itemcontact_enquiryformadmin_title,
        'content' => $mail_text
      );

      break;

    case 'reviewformuser': // to USER

      $setup35_itemreview_reviewformuser_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformuser_subject','',''));
      $setup35_itemreview_reviewformuser_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformuser_title','',''));
      $mail_text = $setup35_itemreview_reviewformuser = PFMSIssetControl('setup35_itemreview_reviewformuser','','');

      
      if(PFControlEmptyArr($data)){
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemreview_reviewformuser_subject, 
        'title' => $setup35_itemreview_reviewformuser_title,
        'content' => $mail_text
      );

      break;

    case 'reviewformadmin': // to ADMIN

      $setup35_itemreview_reviewformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformadmin_subject','',''));
      $setup35_itemreview_reviewformadmin_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformadmin_title','',''));
      $mail_text = $setup35_itemreview_reviewformadmin = PFMSIssetControl('setup35_itemreview_reviewformadmin','','');

      
      if(PFControlEmptyArr($data)){
        
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        if(!empty($data['user'])){
          $user = get_user_by( 'id', $data['user'] );
          $mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%userinfo%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%reveditlink%%', '<a href="'.admin_url('post.php?post='.$data['revid'].'&action=edit').'">'.esc_html__('Edit Review','pointfindert2d').'</a>', $mail_text );
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemreview_reviewformadmin_subject, 
        'title' => $setup35_itemreview_reviewformadmin_title,
        'content' => $mail_text
      );

      break;

    case 'reportitemmail': // to ADMIN

      $setup35_itemcontact_report_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_report_subject','',''));
      $setup35_itemcontact_report_title = esc_attr(PFMSIssetControl('setup35_itemcontact_report_title','',''));
      $mail_text = $setup35_itemcontact_report = PFMSIssetControl('setup35_itemcontact_report','','');

      
      if(PFControlEmptyArr($data)){
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        if(!empty($data['user'])){
          $user = get_user_by( 'id', $data['user'] );
          $mail_text = str_replace( '%%userid%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%userid%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemcontact_report_subject, 
        'title' => $setup35_itemcontact_report_title,
        'content' => $mail_text
      );

      break;

    case 'claimitemmail': // to ADMIN

      $setup35_itemcontact_claim_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_claim_subject','',''));
      $setup35_itemcontact_claim_title = esc_attr(PFMSIssetControl('setup35_itemcontact_claim_title','',''));
      $mail_text = $setup35_itemcontact_claim = PFMSIssetControl('setup35_itemcontact_claim','','');

      
      if(PFControlEmptyArr($data)){
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
        }
        if(!empty($data['user'])){
          $user = get_user_by( 'id', $data['user'] );
          $mail_text = str_replace( '%%userid%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%userid%%', '', $mail_text );
        }
        if(!empty($data['phone'])){
          $mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
        }else{
          $mail_text = str_replace( '%%phone%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemcontact_claim_subject, 
        'title' => $setup35_itemcontact_claim_title,
        'content' => $mail_text
      );

      break;

    case 'reviewflagemail': // to ADMIN

      $setup35_itemreview_reviewflagformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewflagformadmin_subject','',''));
      $setup35_itemreview_reviewflagformadmin_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewflagformadmin_title','',''));
      $mail_text = $setup35_itemreview_reviewflagformadmin = PFMSIssetControl('setup35_itemreview_reviewflagformadmin','','');

      
      if(PFControlEmptyArr($data)){
        if(!empty($data['item'])){
          $mail_text = str_replace( '%%reviewinfo%%', '<a href="'.admin_url('post.php?post='.$data['item'].'&action=edit').'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
        }
        if(!empty($data['user'])){
          $user = get_user_by( 'id', $data['user'] );
          $mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
        }else{
          $mail_text = str_replace( '%%userinfo%%', '', $mail_text );
        }
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_itemreview_reviewflagformadmin_subject, 
        'title' => $setup35_itemreview_reviewflagformadmin_title,
        'content' => $mail_text
      );

      break;
      
    case 'contactformemail': // to ADMIN

      $setup35_contactform_subject = esc_attr(PFMSIssetControl('setup35_contactform_subject','',''));
      $setup35_contactform_title = esc_attr(PFMSIssetControl('setup35_contactform_title','',''));
      $mail_text = $setup35_contactform_contents = PFMSIssetControl('setup35_contactform_contents','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
        $mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
        $mail_text = str_replace( '%%msg%%', $data['message'], $mail_text );
        $mail_text = str_replace( '%%subject%%', $data['subject'], $mail_text );
        $mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
        $mail_text = str_replace( '%%datetime%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
      }

      return array(
        'subject' => $setup35_contactform_subject, 
        'title' => $setup35_contactform_title,
        'content' => $mail_text
      );

      break;

    /*Membership Emails*/

    case 'expiredrecpaymentmember': // to USER

      $setup35_autoemailsadmin_expiredrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment_subject','',''));
      $setup35_autoemailsadmin_expiredrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment_title','',''));
      $mail_text = $setup35_autoemailsadmin_expiredrecpayment = PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', get_the_title($data['orderid']), $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text);
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_expiredrecpayment_subject, 
        'title' => $setup35_autoemailsadmin_expiredrecpayment_title,
        'content' => $mail_text
      );

      break;

    case 'recprofilecreatedmember': // to USER

      $setup35_paymentemails_paymentcompletedrec_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec_subject','',''));
      $setup35_paymentemails_paymentcompletedrec_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec_title','',''));
      $mail_text = $setup35_paymentemails_paymentcompletedrec = PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%ordernumber%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
        $mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_paymentcompletedrec_subject, 
        'title' => $setup35_paymentemails_paymentcompletedrec_title,
        'content' => $mail_text);

      break;

    case 'freecompletedmember': // to USER

      $setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_freecompleted_subject','',''));
      $setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_freecompleted_title','',''));
      $mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentmemberemails_freecompleted','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_paymentcompleted_subject, 
        'title' => $setup35_paymentemails_paymentcompleted_title,
        'content' => $mail_text);

      break;

    case 'paymentcompletedmember': // to USER

      $setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted_subject','',''));
      $setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted_title','',''));
      $mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%packagepricetag%%', $data['packagepricetag'], $mail_text );
        $mail_text = str_replace( '%%packagedescription%%', $data['packagedescription'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_paymentcompleted_subject, 
        'title' => $setup35_paymentemails_paymentcompleted_title,
        'content' => $mail_text);

      break;

    case 'directafterexpiremember': // to USER

      $setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_subject','',''));
      $setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_title','',''));
      $mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', get_the_title($data['orderid']), $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
        'title' => $setup35_autoemailsadmin_directafterexpire_title,
        'content' => $mail_text
      );

      break;

    case 'directafterexpiremember': // to USER

      $setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_subject','',''));
      $setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_title','',''));
      $mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', $data['orderid'], $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
        'title' => $setup35_autoemailsadmin_directafterexpire_title,
        'content' => $mail_text
      );

      break;

    case 'directbeforeexpiremember': // to USER

      $setup35_autoemailsadmin_directbeforeexpire_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire_subject','',''));
      $setup35_autoemailsadmin_directbeforeexpire_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire_title','',''));
      $mail_text = $setup35_autoemailsadmin_directbeforeexpire = PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire','','');

      
      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', $data['orderid'], $mail_text );
        $mail_text = str_replace( '%%expiredate%%', date(get_option('date_format')." ".get_option('time_format'),strtotime($data['expiredate'])), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_autoemailsadmin_directbeforeexpire_subject, 
        'title' => $setup35_autoemailsadmin_directbeforeexpire_title,
        'content' => $mail_text
      );

      break;

    case 'bankpaymentwaitingmember': // to USER

      $setup35_paymentemails_bankpaymentwaiting_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting_subject','',''));
      $setup35_paymentemails_bankpaymentwaiting_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting_title','',''));
      $mail_text = $setup35_paymentemails_bankpaymentwaiting = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_bankpaymentwaiting_subject, 
        'title' => $setup35_paymentemails_bankpaymentwaiting_title,
        'content' => $mail_text);

      break;

    case 'bankpaymentcancelmember': // to USER

      $setup35_paymentemails_bankpaymentcancel_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel_subject','',''));
      $setup35_paymentemails_bankpaymentcancel_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel_title','',''));
      $mail_text = $setup35_paymentemails_bankpaymentcancel = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', $data['ID'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_bankpaymentcancel_subject, 
        'title' => $setup35_paymentemails_bankpaymentcancel_title,
        'content' => $mail_text);

      break;

    case 'bankpaymentapprovedmember': // to USER

      $setup35_paymentemails_bankpaymentapp_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp_subject','',''));
      $setup35_paymentemails_bankpaymentapp_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp_title','',''));
      $mail_text = $setup35_paymentemails_bankpaymentapp = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_bankpaymentapp_subject, 
        'title' => $setup35_paymentemails_bankpaymentapp_title,
        'content' => $mail_text);

      break;

    case 'recurringprofilecreatedmember': // to ADMIN

      $setup35_paymentemails_newrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newrecpayment_subject','',''));
      $setup35_paymentemails_newrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newrecpayment_title','',''));
      $mail_text = $setup35_paymentemails_newrecpayment = PFMSIssetControl('setup35_paymentmemberemails_newrecpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%userid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%ordernumber%%', $data['title'], $mail_text );
        $mail_text = str_replace( '%%ordereditadminlink%%', admin_url('post.php?post='.$data['orderid'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
        $mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_newrecpayment_subject, 
        'title' => $setup35_paymentemails_newrecpayment_title,
        'content' => $mail_text);

      break;

    case 'freepaymentreceivedmember': // to ADMIN

      $setup35_paymentmemberemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newfreepayment_subject','',''));
      $setup35_paymentmemberemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newfreepayment_title','',''));
      $mail_text = $setup35_paymentmemberemails_newdirectpayment = PFMSIssetControl('setup35_paymentmemberemails_newfreepayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', $data['ID'], $mail_text );
        $mail_text = str_replace( '%%ordereditlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentmemberemails_newdirectpayment_subject, 
        'title' => $setup35_paymentmemberemails_newdirectpayment_title,
        'content' => $mail_text);

      break;

    case 'newpaymentreceivedmember': // to ADMIN

      $setup35_paymentmemberemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment_subject','',''));
      $setup35_paymentmemberemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment_title','',''));
      $mail_text = $setup35_paymentmemberemails_newdirectpayment = PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', $data['ordername'], $mail_text );
        $mail_text = str_replace( '%%ordereditlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
        $mail_text = str_replace( '%%packagepricetag%%', $data['packagepricetag'], $mail_text );
        $mail_text = str_replace( '%%packagedescription%%', $data['packagedescription'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentmemberemails_newdirectpayment_subject, 
        'title' => $setup35_paymentmemberemails_newdirectpayment_title,
        'content' => $mail_text
      );

      break;

    case 'newbankpreceivedmember': // to ADMIN

      $setup35_paymentemails_newbankpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newbankpayment_subject','',''));
      $setup35_paymentemails_newbankpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newbankpayment_title','',''));
      $mail_text = $setup35_paymentemails_newbankpayment = PFMSIssetControl('setup35_paymentmemberemails_newbankpayment','','');

      if(PFControlEmptyArr($data)){
        $mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
        $mail_text = str_replace( '%%orderadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
        $mail_text = str_replace( '%%paymenttotal%%', pointfinder_reformat_pricevalue_for_frontend($data['paymenttotal']), $mail_text );
        $mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
      }

      return array(
        'subject' => $setup35_paymentemails_newbankpayment_subject, 
        'title' => $setup35_paymentemails_newbankpayment_title,
        'content' => $mail_text);

      break;


  }
}

function PF_CreateInvoice($params = array()){

  $defaults = array( 
    'user_id' => '',
    'item_id' => 0,
    'order_id' => '',
    'description' => '',// Basic Package
    'processname' => '', // Recurring or Direct or Bank etc..,
    'amount' => 0,// 20$
    'gst' => 0,
    'qst' => 0,
    'datetime' => strtotime("now"),
    'packageid' => 0,
    'status' => 'publish'// pendingpayment
  );

  /*
  Pay Per Post:
    1-) Order Title (ID)
    2-) Item ID (Title)
    3-) Process Type (Recurring or Direct or Bank etc..)
    4-) User ID (We will get username etc..)
    5-) Date
    6-) Amount
    7-) Status
      a-) Pending for Bank Payment. If completed change to completed.
      b-) Completed for other payment systems.

  Membership System
    1-) Order Title (ID)
    2-) Package Name (packageid)
    3-) Process Type (Recurring or Direct or Bank etc..)
    4-) User ID (We will get username etc..)
    5-) Date
    6-) Amount
    7-) Status
      a-) Pending for Bank Payment. If completed change to completed.
      b-) Completed for other payment systems.

  */
  
  $params = array_merge($defaults, $params);

  $arg_invoice = array(
    'post_type'    => 'pointfinderinvoices',
    'post_title'	=> $params['description'],
    'post_status'   => $params['status'],
    'post_author'   => $params['user_id'],
  );

  $invoice_post_id = wp_insert_post($arg_invoice);

  /*Invoice Meta*/
  update_post_meta($invoice_post_id, 'pointfinder_invoice_date', $params['datetime']);
  update_post_meta($invoice_post_id, 'pointfinder_invoice_orderid', $params['order_id']);
  update_post_meta($invoice_post_id, 'pointfinder_invoice_amount', $params['amount']);
  update_post_meta($invoice_post_id, 'pointfinder_invoice_gst', $params['gst']);
  update_post_meta($invoice_post_id, 'pointfinder_invoice_qst', $params['qst']);
  update_post_meta($invoice_post_id, 'pointfinder_invoice_invoicetype', $params['processname']);

  if (!empty($params['item_id'])) {
    update_post_meta($invoice_post_id, 'pointfinder_invoice_itemid', $params['item_id']);
  }
  if (!empty($params['packageid'])) {
    update_post_meta($invoice_post_id, 'pointfinder_invoice_packageid', $params['packageid']);
  }

  return $invoice_post_id;
}

//function GetPFTermInfoH($id, $taxonomy,$pflang = '',$type, $showLink = TRUE){
function GetPFTermInfoH($id, $taxonomy,$pflang = '',$type){
  $termnames = '';
  $postterms = wp_get_post_terms( $id, $taxonomy,array('fields' => 'all','orderby'=>'term_order','order'=>'ASC'));
  
  if($postterms){
    $postterms_count = count($postterms);
    $i = 1;
    foreach($postterms as $postterm){
      if (isset($postterm->term_id)) {
        if(function_exists('icl_t')) {
          if (!empty($pflang)) {
            $term_idx = icl_object_id($postterm->term_id,$taxonomy,true,$pflang);
          }else{
            $term_idx = icl_object_id($postterm->term_id,$taxonomy,true,PF_current_language());
          }

          $postterm = get_term( $term_idx, $taxonomy );
        }

        $term_link = get_term_link( $postterm->term_id, $taxonomy );
        $term_name = $postterm->name;

        if (is_wp_error($term_link) === true) {$term_link = '#';}					
        if (is_wp_error($term_name) === true) {$term_name = '';}
        if ($type == 2) {
          /*
          if($showLink){
            $termnames .= '<a href="'.$term_link.'?type-annonce=1134">'.$term_name.'</a>';
          }else{
            $termnames .= $term_name;
          }
          */
          $termnames .= '<a href="'.$term_link.'">'.$term_name.'</a>';
          if ($i != $postterms_count) {
            $termnames .= ' / ';
          }
        }else{
          /*
          if($showLink){
            $termnames .= '<a href="'.$term_link.'?type-annonce=1134">'.$term_name.'</a>';
          }else{
            $termnames .= $term_name;
          }
          */
          $termnames .= '<a href="'.$term_link.'">'.$term_name.'</a>';
        }

        $i++;
      }
    }
  }
  return $termnames;
}

function get_excerpt($limit, $source = null){
  if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
  $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $limit);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  $excerpt = $excerpt.' (...) <a href="'.get_the_permalink().'" title="'.esc_html__('Learn more about','pointfindert2d').' '.get_the_title().'">'.esc_html__('Learn more','pointfindert2d').'</a>';
  return $excerpt;
}

function PFExpireItemManual($params){
  $defaults = array( 
    'order_id' => '',
    'post_id' => '',
    'post_author' => '',
    'payment_type' => 'direct',
    'payment_err' => ''
  );

  $params = array_merge($defaults, $params);

  switch ($params['payment_type']) {
    case 'direct':
      $expire_message_var = esc_html__('Schedule System','pointfindert2d');
      break;

    case 'web_accept':
      $expire_message_var = sprintf(esc_html__('IPN System (%s)','pointfindert2d'),$params['payment_err']);
      break;
    
    default:
      $expire_message_var = esc_html__('IPN System','pointfindert2d');
      break;
  }

  $expire_message = sprintf(esc_html__('Item & Order Status changed to Pending Payment by %s : (Item Expired)','pointfindert2d'), $expire_message_var);
  
  global $wpdb;
  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$params['post_id']));
  if(!empty($params['order_id'])){
    $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$params['order_id']));
  }
  
  PFCreateProcessRecord(
    array( 
      'user_id' => $params['post_author'],
      'item_post_id' => $params['post_id'],
      'processname' => $expire_message
    )
  );
}

function pf_modify_contact_methods_child($profile_fields) {
	// Add new fields
	$profile_fields['user_address'] = esc_html__('Address','pointfindert2d');
	$profile_fields['user_postalcode'] = esc_html__('Postal Code','pointfindert2d');
	$profile_fields['user_country'] = esc_html__('Country','pointfindert2d'); // devient province
	$profile_fields['user_twitter'] = esc_html__('Twitter','pointfindert2d');
	$profile_fields['user_facebook'] = esc_html__('Facebook','pointfindert2d');
	$profile_fields['user_googleplus'] = esc_html__('Google+','pointfindert2d');
	$profile_fields['user_linkedin'] = esc_html__('LinkedIn','pointfindert2d');
	$profile_fields['user_phone'] = esc_html__('Telephone','pointfindert2d');
	$profile_fields['user_mobile'] = esc_html__('Mobile','pointfindert2d');
	$profile_fields['user_vatnumber'] = esc_html__('Vat Number','pointfindert2d');

	return $profile_fields;
}

function pfedit_my_widget_title_child($title = '', $instance = array(), $id_base = '') {
	if (!empty($id_base)) {
		if (empty($instance['title'])) {
			if ($id_base != 'search') {
        if(!empty($title)){
          echo '<div class="pfwidgettitle"><div class="widgetheader">'.$title.'</div></div><div class="pfwidgetinner">';
        }else{
          echo '<div class="pfwidgetinner">';
        }
			} else {
				echo '<div class="pfwidgettitle pfemptytitle"><div class="widgetheader"></div></div><div class="pfwidgetinner pfemptytitle">';
			}
			
		}else{
			echo '<div class="pfwidgettitle"><div class="widgetheader">'.$title.'</div></div><div class="pfwidgetinner">';
		}
	}else{
		if (!empty($title)) {
			echo '<div class="pfwidgettitle"><div class="widgetheader">'.$title.'</div></div><div class="pfwidgetinner">';
		}else{
			echo '<div class="pfwidgettitle pfemptytitle"><div class="widgetheader"></div></div><div class="pfwidgetinner pfemptytitle">';
		}
	}
}

function OF_statusText($status){
  $status_text = '';
  switch($status){
    case 'pendingapproval':
      $status_text = esc_html__('Pending Approval','pointfindert2d');
      break;
    case 'rejected':
      $status_text = esc_html__('Rejected','pointfindert2d');
      break;
    case 'editimage':
      $status_text = esc_html__('Edit Image','pointfindert2d');
      break;
    case 'editdesc':
      $status_text = esc_html__('Edit Description','pointfindert2d');
      break;
    case 'editprice':
      $status_text = esc_html__('Edit Additional Information (Price, etc.)','pointfindert2d');
      break;
    case 'editadr':
      $status_text = esc_html__('Edit Address','pointfindert2d');
      break;
    case 'edittag':
      $status_text = esc_html__('Edit Tag','pointfindert2d');
      break;
    case 'editatchm':
      $status_text = esc_html__('Edit Attachment','pointfindert2d');
      break;
  }
  return $status_text;
}

function pointfinder_all_item_status_changes_child($new_status, $old_status, $post) {
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

  /**
  *Start : Status going to PUBLISH from PENDINGAPPROVAL / REJECTED - PFITEMS
  **/
  if($new_status == 'publish' && $post->post_type == $setup3_pointposttype_pt1){
    if(
      $old_status == 'pendingapproval'
      ||
      $old_status == 'rejected'
      ||
      $old_status == 'editimage'
      ||
      $old_status == 'editdesc'
      ||
      $old_status == 'editprice'
      ||
      $old_status == 'editadr'
      ||
      $old_status == 'edittag'
      ||
      $old_status == 'editatchm'
    ){
      global $wpdb;
      $order_post_id = $wpdb->get_var( $wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %d", 
        'pointfinder_order_itemid',
        $post->ID
      ) );

      $stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

      $pointfinder_order_listingtime = get_post_meta( $order_post_id, 'pointfinder_order_listingtime', true );

      $exp_date = date("Y-m-d H:i:s", strtotime("+".$pointfinder_order_listingtime." days"));
      $app_date = date("Y-m-d H:i:s");

      $exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));

      $edit_record_check = get_post_meta( $order_post_id, 'pointfinder_order_itemedit', true );

      $check_featured = get_post_meta( $post->ID, 'webbupointfinder_item_featuredmarker', true );

      if (empty($edit_record_check)) { 
        update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
        if(!empty($check_featured)){
          update_post_meta( $order_post_id, 'pointfinder_order_expiredate_featured', $exp_date_featured);
        }
        update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
      }else{
        update_post_meta($order_post_id, 'pointfinder_order_itemedit', 0 );
      };

      $old_status_text = OF_statusText($old_status);
      
      // - Creating record for process system.
      PFCreateProcessRecord(
        array( 
          'user_id' => $post->post_author,
          'item_post_id' => $post->ID,
          'processname' => sprintf(esc_html__('Item status changed from %s to Publish by admin','pointfindert2d'),$old_status_text)
        )
      );
      
      $user_info = get_userdata( $post->post_author );
      
      pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $user_info->user_email,
          'predefined' => 'itemapproved',
          'data' => array('ID' => $post->ID,'title'=>$post->post_title),
        )
      );
    }
  }
  /**
  *End : Status going to PUBLISH from PENDINGAPPROVAL / REJECTED
  **/

  /**
  *Start : Status going to REJECTED from PENDINGAPPROVAL, PUBLISH & others - PFITEMS
  **/
  if($new_status == 'rejected' && $post->post_type == $setup3_pointposttype_pt1){
    if(
      $old_status == 'pendingapproval'
      ||
      $old_status == 'publish'
      ||
      $old_status == 'editimage'
      ||
      $old_status == 'editdesc'
      ||
      $old_status == 'editprice'
      ||
      $old_status == 'editadr'
      ||
      $old_status == 'edittag'
      ||
      $old_status == 'editatchm'
    ){
      $old_status_text = OF_statusText($old_status);

      $membership_user_item_limit = get_user_meta( $post->post_author, 'membership_user_item_limit', true );
      if (!empty($membership_user_item_limit)){
        $membership_user_item_limit = $membership_user_item_limit + 1;
        update_user_meta( $post->post_author, 'membership_user_item_limit', $membership_user_item_limit);
      }
      
      // - Creating record for process system.
      PFCreateProcessRecord(
        array( 
          'user_id' => $post->post_author,
          'item_post_id' => $post->ID,
          'processname' => sprintf(esc_html__('Item status changed from %s to Rejected by admin','pointfindert2d'),$old_status_text)
        )
      );
      
      $user_info = get_userdata( $post->post_author );
      
      pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $user_info->user_email,
          'predefined' => 'itemrejected',
          'data' => array('ID' => $post->ID,'title'=>$post->post_title),
        )
      );
    }
  }
  /**
  *End : Status going to REJECTED from PENDINGAPPROVAL, PUBLISH & others - PFITEMS
  **/
  
  /**
  *Start : Status going to EDIT(SOMETHING) from PENDINGAPPROVAL, PUBLISH & others - PFITEMS
  **/
  if(
    (
      $new_status == 'editimage'
      ||
      $new_status == 'editdesc'
      ||
      $new_status == 'editprice'
      ||
      $new_status == 'editadr'
      ||
      $new_status == 'edittag'
      ||
      $new_status == 'editatchm'
    )
    &&
    $post->post_type == $setup3_pointposttype_pt1
  ){
    if(
      $old_status == 'pendingapproval'
      ||
      $old_status == 'publish'
      ||
      $old_status == 'editimage'
      ||
      $old_status == 'editdesc'
      ||
      $old_status == 'editprice'
      ||
      $old_status == 'editadr'
      ||
      $old_status == 'edittag'
      ||
      $old_status == 'editatchm'
    ){
      $old_status_text = OF_statusText($old_status);
      $new_status_text = OF_statusText($new_status);

      // - Creating record for process system.
      PFCreateProcessRecord(
        array( 
          'user_id' => $post->post_author,
          'item_post_id' => $post->ID,
          'processname' => sprintf(esc_html__('Item status changed from %s to %s by admin','pointfindert2d'),$old_status_text,$new_status_text)
        )
      );
      
      $user_info = get_userdata( $post->post_author );
      
      $status_text_long = '';
      switch($new_status){
        case 'editimage':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the image','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
        case 'editdesc':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the description','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
        case 'editprice':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the Additional Information section','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
        case 'editadr':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the address','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
        case 'edittag':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the tags','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
        case 'editatchm':
          $status_text_long = esc_html__('Please,','pointfindert2d').' <u>'.esc_html__('edit the attachment file','pointfindert2d').'</u> '.esc_html__('of this ad :','pointfindert2d');
          break;
      }
      
      pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $user_info->user_email,
          'title' => sprintf(esc_html__('Approval status of your ad : %s','pointfindert2d'),$new_status_text),
          'content' => '<p>'.esc_html__('A change to your ad is necessary for us to approve','pointfindert2d').'.</p><p>'.$status_text_long.' <a href="'.get_permalink($post).'">'.$post->post_title.'</a></p>',
          'subject' => esc_html__($new_status_text,'pointfindert2d')
        )
      );
    }
  }
  /**
  *End : Status going to EDIT(SOMETHING) from PENDINGAPPROVAL, PUBLISH & others - PFITEMS
  **/

  /**
  *Start : Status going to TRASH from ANY - PFITEMS
  **/
  if($new_status == 'trash' && $post->post_type == $setup3_pointposttype_pt1){
    $order_control = PFU_CheckOrderID($post->ID);
    if($order_control){
      $old_status_text = OF_statusText($old_status);

      /* - Creating record for process system. */
      PFCreateProcessRecord(
        array( 
          'user_id' => $post->post_author,
          'item_post_id' => $post->ID,
          'processname' => sprintf(esc_html__('Item status changed from %s to TRASH by admin','pointfindert2d'),$old_status_text)
        )
      );

      $setup33_emaillimits_useremailsaftertrash = PFMSIssetControl('setup33_emaillimits_useremailsaftertrash','','1');
      if($setup33_emaillimits_useremailsaftertrash == 1){
        $user_info = get_userdata( $post->post_author );
        pointfinder_mailsystem_mailsender(
          array(
            'toemail' => $user_info->user_email,
            'predefined' => 'itemdeleted',
            'data' => array('ID' => $post->ID,'title'=>$post->post_title),
          )
        );
      }
    }
  }
  /**
  *End : Status going to TRASH from ANY
  **/

  /**
  *Start : Status going to PUBLISH from PENDINGPAYMENT - PFITEMS
  **/
  if($new_status == 'publish' && $post->post_type == $setup3_pointposttype_pt1){
    if($old_status == 'pendingpayment'){
      global $wpdb;
      $order_post_id = $wpdb->get_var( $wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %d", 
        'pointfinder_order_itemid',
        $post->ID
      ) );

      $stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

      $pointfinder_order_listingtime = get_post_meta( $order_post_id, 'pointfinder_order_listingtime', true );
      $exp_date = date("Y-m-d H:i:s", strtotime("+".$pointfinder_order_listingtime." days"));
      $app_date = date("Y-m-d H:i:s");

      $exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
      $check_featured = get_post_meta( $post->ID, 'webbupointfinder_item_featuredmarker', true );
      update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
      if(!empty($check_featured)){update_post_meta( $order_post_id, 'pointfinder_order_expiredate_featured', $exp_date_featured);}
      update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
      

      $bank_check = get_post_meta($order_post_id, 'pointfinder_order_bankcheck',true);
      
      if ($bank_check == 1) { 
        update_post_meta($order_post_id, 'pointfinder_order_bankcheck', '0');
        $bank_invid = get_post_meta( $order_post_id, 'pointfinder_order_invoice', true );
        if ($bank_invid != false) {
          $wpdb->UPDATE($wpdb->posts,array('post_status' => 'publish'),array('ID' => $bank_invid));
        }
      };

      $wpdb->UPDATE($wpdb->posts,array('post_status' => 'completed'),array('ID' => $order_post_id));

      if ($bank_check == 1) {
        $pointfinder_order_price = get_post_meta( $order_post_id, 'pointfinder_order_price', true );
        pointfinder_order_fallback_operations($order_post_id,$pointfinder_order_price);
      }
      
      /* - Creating record for process system. */
      PFCreateProcessRecord(
        array( 
          'user_id' => $post->post_author,
          'item_post_id' => $post->ID,
          'processname' => esc_html__('Item status changed from Pending Payment to Publish by admin','pointfindert2d')
        )
      );

      /* - Sending an email to user. */
      $user_info = get_userdata( $post->post_author );
      $email_subject = 'itemapproved';

      pointfinder_mailsystem_mailsender(
        array(
          'toemail' => $user_info->user_email,
          'predefined' => $email_subject,
          'data' => array('ID' => $post->ID,'title'=>$post->post_title),
        )
      );
    }
  }
  /**
  *End : Status going to PUBLISH from PENDINGPAYMENT
  **/

  /**
  *Start : Status going to PUBLISH from PENDINGAPPROVAL / REJECTED - REVIEWS
  **/
  if($post->post_type == 'pointfinderreviews'){
    $item_id = get_post_meta( $post->ID, 'webbupointfinder_review_itemid', true );
    $total_results_exit = pfcalculate_total_review_ot($item_id);
    if (!empty($total_results_exit)) {
      update_post_meta( $item_id, "webbupointfinder_item_reviewcount", $total_results_exit['totalresult']);
    } else {
      update_post_meta( $item_id, "webbupointfinder_item_reviewcount", 0);
    }
  }
  /**
  *End : Status going to PUBLISH from PENDINGAPPROVAL / REJECTED
  **/
}

function pf_custom_post_status(){
  register_post_status( 'pendingapproval', array(
    'label'                     => esc_html__( 'Pending Approval', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Pending Approval <span class="count">(%s)</span>', 'Pending Approval <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'rejected', array(
    'label'                     => esc_html__( 'Rejected', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'editimage', array(
    'label'                     => esc_html__( 'Edit Image', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Image <span class="count">(%s)</span>', 'Edit Image <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'editdesc', array(
    'label'                     => esc_html__( 'Edit Description', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Description <span class="count">(%s)</span>', 'Edit Description <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'editprice', array(
    'label'                     => esc_html__( 'Edit Additional Information (Price, etc.)', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Additional Information (Price, etc.) <span class="count">(%s)</span>', 'Edit Additional Information (Price, etc.) <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'editadr', array(
    'label'                     => esc_html__( 'Edit Address', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Address <span class="count">(%s)</span>', 'Edit Address <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'edittag', array(
    'label'                     => esc_html__( 'Edit Tag', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Tag <span class="count">(%s)</span>', 'Edit Tag <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'editatchm', array(
    'label'                     => esc_html__( 'Edit Attachment', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Edit Attachment <span class="count">(%s)</span>', 'Edit Attachment <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'pendingpayment', array(
    'label'                     => esc_html__( 'Pending Payment', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>' , 'pointfindert2d'),
  ) );

  register_post_status( 'completed', array(
    'label'                     => esc_html__( 'Payment Completed', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Payment Completed <span class="count">(%s)</span>', 'Payment Completed <span class="count">(%s)</span>', 'pointfindert2d' ),
  ) );

  register_post_status( 'pfcancelled', array(
    'label'                     => esc_html__( 'Payment Cancelled', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Payment Cancelled <span class="count">(%s)</span>', 'Payment Cancelled <span class="count">(%s)</span>', 'pointfindert2d' ),
  ) );

  register_post_status( 'pfsuspended', array(
    'label'                     => esc_html__( 'Payment Suspended', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Payment Suspended <span class="count">(%s)</span>', 'Payment Suspended <span class="count">(%s)</span>', 'pointfindert2d' ),
  ) );

  register_post_status( 'pfonoff', array(
    'label'                     => esc_html__( 'Deactived by User', 'pointfindert2d' ),
    'public'                    => true,
    'exclude_from_search'       => true,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Deactived by User <span class="count">(%s)</span>', 'Deactived by User <span class="count">(%s)</span>', 'pointfindert2d' ),
  ) );
}

function PF_Modified_post_submit_meta_box($post, $args = array() ) {
  global $action;

  $post_type = $post->post_type;
  $post_type_object = get_post_type_object($post_type);
  $can_publish = current_user_can($post_type_object->cap->publish_posts);
  
  ?>
  <div class="submitbox pointfinder" id="submitpost">
    <div id="minor-publishing">
      <div style="display:none;">
        <?php submit_button( esc_html__( 'Save' ,'pointfindert2d'), 'button', 'save' ); ?>
      </div>
      <div class="clear"></div>
    </div><!-- #minor-publishing-actions -->

    <div id="misc-publishing-actions">
      <div class="misc-pub-section misc-pub-post-status"><label for="post_status"><?php esc_html_e('Status:','pointfindert2d') ?></label>
        <span id="post-status-display">
          <?php
          switch ( $post->post_status ) {
            case 'publish':
              esc_html_e('Published','pointfindert2d');
              break;
            case 'pendingpayment':
              esc_html_e('Pending Payment','pointfindert2d');
              break;
            case 'pendingapproval':
              esc_html_e('Pending Approval','pointfindert2d');
              break;
            case 'editimage':
              esc_html_e('Edit Image','pointfindert2d');
              break;
            case 'editdesc':
              esc_html_e('Edit Description','pointfindert2d');
              break;
            case 'editprice':
              esc_html_e('Edit Additional Information (Price, etc.)','pointfindert2d');
              break;
            case 'editadr':
              esc_html_e('Edit Address','pointfindert2d');
              break;
            case 'edittag':
              esc_html_e('Edit Tag','pointfindert2d');
              break;
            case 'editatchm':
              esc_html_e('Edit Attachment','pointfindert2d');
              break;
            case 'rejected':
              esc_html_e('Rejected','pointfindert2d');
              break;
            case 'pfonoff':
              esc_html_e('Deactived by User','pointfindert2d');
              break;
          }
          ?>
        </span>
        <?php if ( 'publish' == $post->post_status || 'pendingpayment' == $post->post_status || 'pendingapproval' == $post->post_status || $can_publish ) { ?>
        <a href="#post_status" <?php if ( 'private' == $post->post_status ) { ?>style="display:none;" <?php } ?>class="edit-post-status hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit','pointfindert2d' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit status' ,'pointfindert2d'); ?></span></a>

        <div id="post-status-select" class="hide-if-js">
          <input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('pendingapproval' == $post->post_status ) ? 'pendingapproval' : $post->post_status); ?>" />
          <select name='post_status' id='post_status'>
            <option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php esc_html_e('Published','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'pendingpayment' ); ?> value='pendingpayment'><?php esc_html_e('Pending Payment','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'pendingapproval' ); ?> value='pendingapproval'><?php esc_html_e('Pending Approval','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'rejected' ); ?> value='rejected'><?php esc_html_e('Rejected','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'editimage' ); ?> value='editimage'><?php esc_html_e('Edit Image','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'editdesc' ); ?> value='editdesc'><?php esc_html_e('Edit Description','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'editprice' ); ?> value='editprice'><?php esc_html_e('Edit Additional Information (Price, etc.)','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'editadr' ); ?> value='editadr'><?php esc_html_e('Edit Address','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'edittag' ); ?> value='edittag'><?php esc_html_e('Edit Tag','pointfindert2d') ?></option>
            <option<?php selected( $post->post_status, 'editatchm' ); ?> value='editatchm'><?php esc_html_e('Edit Attachment','pointfindert2d') ?></option>
          </select>
          <a href="#post_status" class="save-post-status hide-if-no-js button"><?php esc_html_e('OK','pointfindert2d'); ?></a>
          <a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php esc_html_e('Cancel','pointfindert2d'); ?></a>
        </div>

        <?php } ?>
      </div><!-- .misc-pub-section -->

      <div class="misc-pub-section misc-pub-visibility" id="visibility">
        <?php esc_html_e('Visibility:','pointfindert2d'); ?> <span id="post-visibility-display"><?php

        if ( 'private' == $post->post_status ) {
          $post->post_password = '';
          $visibility = 'private';
          $visibility_trans = esc_html__('Private','pointfindert2d');
        } elseif ( !empty( $post->post_password ) ) {
          $visibility = 'password';
          $visibility_trans = esc_html__('Password protected','pointfindert2d');
        } elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
          $visibility = 'public';
          $visibility_trans = esc_html__('Public, Sticky','pointfindert2d');
        } else {
          $visibility = 'public';
          $visibility_trans = esc_html__('Public','pointfindert2d');
        }

        echo esc_html( $visibility_trans ); ?></span>
        <?php if ( $can_publish ) { ?>
        <a href="#visibility" class="edit-visibility hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit' ,'pointfindert2d'); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit visibility' ,'pointfindert2d'); ?></span></a>

        <div id="post-visibility-select" class="hide-if-js">
          <input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo esc_attr($post->post_password); ?>" />
          <input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo esc_attr( $visibility ); ?>" />
          <input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked( $visibility, 'public' ); ?> /> <label for="visibility-radio-public" class="selectit"><?php esc_html_e('Public','pointfindert2d'); ?></label><br />
          <input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked( $visibility, 'password' ); ?> /> <label for="visibility-radio-password" class="selectit"><?php esc_html_e('Password protected','pointfindert2d'); ?></label><br />
          <span id="password-span"><label for="post_password"><?php esc_html_e('Password:','pointfindert2d'); ?></label> <input type="text" name="post_password" id="post_password" value="<?php echo esc_attr($post->post_password); ?>"  maxlength="20" /><br /></span>
          <input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $visibility, 'private' ); ?> /> <label for="visibility-radio-private" class="selectit"><?php esc_html_e('Private','pointfindert2d'); ?></label><br />

          <p>
           <a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php esc_html_e('OK','pointfindert2d'); ?></a>
           <a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel"><?php esc_html_e('Cancel','pointfindert2d'); ?></a>
          </p>
        </div>
        <?php } ?>

      </div><!-- .misc-pub-section -->

      <?php
      /* translators: Publish box date format, see http://php.net/date */
      $datef = 'M j, Y @ G:i';
      if ( 0 != $post->ID ) {
        if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
          $stamp = esc_attr__('Scheduled for: <b>%1$s</b>','pointfindert2d');
        } else if ( 'publish' == $post->post_status || 'private' == $post->post_status ) { // already published
          $stamp = esc_attr__('Published on: <b>%1$s</b>','pointfindert2d');
        } else if ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
          $stamp = esc_attr__('Publish <b>immediately</b>','pointfindert2d');
        } else if ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
          $stamp = esc_attr__('Schedule for: <b>%1$s</b>','pointfindert2d');
        } else { // draft, 1 or more saves, date specified
          $stamp = esc_attr__('Publish on: <b>%1$s</b>','pointfindert2d');
        }
        $date = date_i18n( $datef, strtotime( $post->post_date ) );
      } else { // draft (no saves, and thus no date specified)
        $stamp = esc_attr__('Publish <b>immediately</b>','pointfindert2d');
        $date = date_i18n( $datef, strtotime( current_time('mysql') ) );
      }

      if ( ! empty( $args['args']['revisions_count'] ) ){
        $revisions_to_keep = wp_revisions_to_keep( $post );
      ?>


      <div class="misc-pub-section misc-pub-revisions">
        <?php
          if ( $revisions_to_keep > 0 && $revisions_to_keep <= $args['args']['revisions_count'] ) {
            echo '<span title="' . esc_attr( sprintf( esc_html__( 'Your site is configured to keep only the last %s revisions.','pointfindert2d'),
              number_format_i18n( $revisions_to_keep ) ) ) . '">';
            printf( esc_html__( 'Revisions: %s','pointfindert2d' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '+</b>' ,'pointfindert2d');
            echo '</span>';
          } else {
            printf( esc_html__( 'Revisions: %s','pointfindert2d' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '</b>' ,'pointfindert2d');
          }
        ?>
        <a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span aria-hidden="true"><?php esc_html__( 'Browse', 'revisions' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Browse revisions' ,'pointfindert2d'); ?></span></a>
      </div>
      <?php };

      if ( $can_publish){ // Contributors don't get to choose the date of publish ?>
      <div class="misc-pub-section curtime misc-pub-curtime" style="display:none;">
        <span id="timestamp">
        <?php printf($stamp, $date); ?></span>
        <a href="#edit_timestamp" class="edit-timestamp hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit' ,'pointfindert2d'); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit date and time' ,'pointfindert2d'); ?></span></a>
        <div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'), 1); ?></div>
      </div><?php // /misc-pub-section ?>
      <?php }; ?>

      <?php
      /**
       * Fires after the post time/date setting in the Publish meta box.
       *
       * @since 2.9.0
       */
      do_action( 'post_submitbox_misc_actions' );
      ?>
    </div>


  </div>
  <div class="clear"></div>


  <div id="major-publishing-actions">
    <?php
    /**
     * Fires at the beginning of the publishing actions section of the Publish meta box.
     *
     * @since 2.7.0
     */
    do_action( 'post_submitbox_start' );
    ?>
    <div id="delete-action">
    <?php
    if ( current_user_can( "delete_post", $post->ID ) ) {
      if ( !EMPTY_TRASH_DAYS )
        $delete_text = esc_html__('Delete Permanently','pointfindert2d');
      else
        $delete_text = esc_html__('Move to Trash','pointfindert2d');
      ?>
    <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
    } ?>
    </div>

    <div id="publishing-action">
      <span class="spinner"></span>
      
      <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_html_e('Update','pointfindert2d') ?>" />
      <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_html_e('Update','pointfindert2d') ?>" />
      
    </div>
    <div class="clear"></div>

  </div>

  <?php
}

function pointfinder_items_edit_columns_child( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'estatephoto' => esc_html__( 'Photo','pointfindert2d'),
    'title' => esc_html__( 'Title','pointfindert2d'),
    'istatus' => esc_html__( 'Status','pointfindert2d'),
    'content' => esc_html__( 'Content','pointfindert2d'),
    'ltype' => esc_html__( 'List Type','pointfindert2d'),
    'author' => esc_html__( 'Author','pointfindert2d'),
    'date' => esc_html__( 'Date','pointfindert2d'),
  );
  return $columns;
}

function pointfinder_items_manage_columns_child( $column, $post_id ) {
  
  global $post;
  $noimg_url = get_template_directory_uri().'/images/noimg.png';

  switch( $column ) {
    case 'content':
      the_content();
      break;
    
    case 'estatephoto' :
      $post_featured_image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'pointfinderlistthumbimg' )); 
      if ($post_featured_image) {  
        echo $post_featured_image;  
      } else {  
        echo '<img src="' . $noimg_url.'" class="pointfinderlistthumbimg" />';  
      }  
      break;

    case 'istatus' :
      switch ($post->post_status) {
        case 'publish':
          echo '<span style="color:green">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
          break;
        case 'pendingapproval':
          echo '<span style="color:red">'.esc_html__( 'Pending Approval', 'pointfindert2d' ).'</span>';
          break;
        case 'pendingpayment':
          echo '<span style="color:red">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
          break;
        case 'rejected':
          echo '<span style="color:red">'.esc_html__( 'Rejected', 'pointfindert2d' ).'</span>';
          break;
        case 'editimage':
          echo '<span style="color:orange">'.esc_html__( 'Edit Image', 'pointfindert2d' ).'</span>';
          break;
        case 'editdesc':
          echo '<span style="color:orange">'.esc_html__( 'Edit Description', 'pointfindert2d' ).'</span>';
          break;
        case 'editprice':
          echo '<span style="color:orange">'.esc_html__( 'Edit Additional Information (Price, etc.)', 'pointfindert2d' ).'</span>';
          break;
        case 'editadr':
          echo '<span style="color:orange">'.esc_html__( 'Edit Address', 'pointfindert2d' ).'</span>';
          break;
        case 'edittag':
          echo '<span style="color:orange">'.esc_html__( 'Edit Tag', 'pointfindert2d' ).'</span>';
          break;
        case 'editatchm':
          echo '<span style="color:orange">'.esc_html__( 'Edit Attachment', 'pointfindert2d' ).'</span>';
          break;
        default:
          echo '';
          break;
      }
      break;

    case 'ltype':
      echo get_the_term_list( $post_id, 'pointfinderltypes', '<ul class="pointfinderpflistterms"><li>', ',</li><li>', '</li></ul>' );
      break;		
      
  }
}

function pointfinder_membership_count_ui($user_idx){
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
  global $wpdb;
  
  /*Count User's Items*/
  $user_post_count = 0;
  $user_post_count = $wpdb->get_var(
    $wpdb->prepare(
      "SELECT count(*) FROM $wpdb->posts where post_author = %d and post_type = %s and post_status IN('publish','rejected','editimage','editdesc','editprice','editadr','edittag','editatchm','pendingapproval','pendingpayment','completed','pfcancelled','pfsuspended')",
      $user_idx,
      $setup3_pointposttype_pt1
    )
  );

  /*Count User's Featured Items*/
  $users_post_featured = 0;
  $users_post_featured = $wpdb->get_var(
    $wpdb->prepare(
      "SELECT count(*) FROM $wpdb->posts db1 INNER JOIN $wpdb->postmeta db2 ON db2.post_id = db1.ID where db1.post_author = %d and db1.post_type = %s and db1.post_status IN('publish','rejected','editimage','editdesc','editprice','editadr','edittag','editatchm','pendingapproval','pendingpayment','completed','pfcancelled','pfsuspended') and db2.meta_key = %s and db2.meta_value = %d",
      $user_idx,
      $setup3_pointposttype_pt1,
      'webbupointfinder_item_featuredmarker',
      1
    )
  );

  return array('item_count'=> $user_post_count, 'fitem_count'=>$users_post_featured);
}

function PFExpireItemManualMember($params){
  /*
  * Expire Order Record.	
  */
  $defaults = array( 
    'order_id' => '',
    'post_author' => '',
    'payment_type' => 'direct',
    'payment_err' => ''
  );

  $params = array_merge($defaults, $params);

  global $wpdb;

  switch ($params['payment_type']) {
    case 'direct':
      $expire_message_var = esc_html__('Schedule System','pointfindert2d');
      break;

    case 'web_accept':
      $expire_message_var = sprintf(esc_html__('IPN System (%s)','pointfindert2d'),$params['payment_err']);
      break;

    case 'pags':
      $expire_message_var = sprintf(esc_html__('PagSeguro: IPN System (%s)','pointfindert2d'),$params['payment_err']);
      break;
    
    default:
      $expire_message_var = esc_html__('IPN System','pointfindert2d');
      break;
  }

  $expire_message = sprintf(esc_html__('Plan & Order Status changed to Pending Payment by %s : (Item Expired)','pointfindert2d'), $expire_message_var);
  
  
  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$params['order_id']));

  /*
  * Start : Find this user's all items and record before expire
  */
    $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
    $user_posts = $wpdb->get_results($wpdb->prepare(
      "SELECT ID, post_status FROM $wpdb->posts WHERE post_author = %d and post_status IN('publish','rejected','editimage','editdesc','editprice','editadr','edittag','editatchm','pendingapproval','pendingpayment','completed','pfcancelled','pfsuspended') and post_type = %s",
      $params['post_author'],
      $setup3_pointposttype_pt1
    ),'ARRAY_A');

    $old_history = get_user_meta($params['post_author'],'membership_user_history',true );
    
    if ($old_history == false) {
      $json_array = '';
    } else {
      $json_array = json_decode($old_history,true);
      $user_posts = array_merge($user_posts,$json_array);
    }
    
      $json_array = json_encode($user_posts);

    update_user_meta( $params['post_author'], 'membership_user_history', $json_array);
  /*
  * End : Find this user's all items and record before expire
  */

  /*
  * Start : Expire user's posts
  */
    $wpdb->query(
      $wpdb->prepare(
        "UPDATE $wpdb->posts SET post_status = 'pendingpayment' WHERE post_author = %d and post_status IN('publish','rejected','editimage','editdesc','editprice','editadr','edittag','editatchm','pendingapproval','pendingpayment','completed','pfcancelled','pfsuspended') and post_type = %s",
        $params['post_author'],
        $setup3_pointposttype_pt1
      )
    );
  /*
  * End : Expire user's posts
  */

  PFCreateProcessRecord(
    array( 
      'user_id' => $params['post_author'],
      'item_post_id' => $params['order_id'],
      'processname' => $expire_message,
      'membership' => 1
    )
  );
}

function pf_ajax_imagesystem_child(){
  
	//Security
	check_ajax_referer( 'pfget_imagesystem', 'security');
  
	header('Content-Type: text/html; charset=UTF-8;');

	$iid = '';
	$output = '';

	if(isset($_POST['iid']) && $_POST['iid']!=''){
		$iid = sanitize_text_field($_POST['iid']);
	}

	if(isset($_POST['id']) && $_POST['id']!=''){
		$id = sanitize_text_field($_POST['id']);
	}

	if(isset($_POST['process']) && $_POST['process']!=''){
		$process = sanitize_text_field($_POST['process']);
	}

	$oldup = $olduptext = '';
	if(isset($_POST['oldup']) && $_POST['oldup']!=''){
		$oldup = sanitize_text_field($_POST['oldup']);
	}

	if ($oldup == 1) {
		$olduptext = '-old';
	}


	/*Image Remove Process*/
	if (!empty($iid) && !empty($id) && $process == 'd') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {
			wp_delete_attachment( $iid, true );
			delete_post_meta( $id, 'webbupointfinder_item_images', $iid );
		}
		
	};

	/*Image Change Process*/
	if (!empty($iid) && !empty($id) && $process == 'c') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;

		if (get_current_user_id() == $post_author) {
			$imageID_of_featured = get_post_thumbnail_id($id);
			add_post_meta($id, 'webbupointfinder_item_images', $imageID_of_featured);
			delete_post_meta( $id, 'webbupointfinder_item_images', $iid );
			set_post_thumbnail( $id, $iid );
		}
	}


	/*Image List Process*/
	if (!empty($id) && $process == 'l') {
		$content_post = get_post($id);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {

			/*Create HTML*/
			if ($id != '') {
				$images_of_thispost = get_post_meta($id,'webbupointfinder_item_images');
				/*Featured Image*/
				$imageID_of_featured = 0;
				$imageID_of_featured = get_post_thumbnail_id($id);
        
        if (PFControlEmptyArr($images_of_thispost) || !empty($imageID_of_featured)) {
					$images_count = count($images_of_thispost);
					$output_images = '';

					// Start:First export featured
          if(!empty($imageID_of_featured)){
            $image_src = wp_get_attachment_image_src( $imageID_of_featured, 'thumbnail' );
            $output_images .= '<li>
                                  <div class="pf-itemimage-container">
                                  <img src="'.aq_resize($image_src[0],90,90,true).'">
                                  <div class="pf-itemimage-delete">
                                    <a class="pf-delete-standartimg'.$olduptext.'" data-pfimgno="'.$imageID_of_featured.'" data-pfpid="'.$id.'" data-pffeatured="yes">'.esc_html__('Remove', 'pointfindert2d').'</a>
                                  </div>
                                  <div class="pfitemedit-featured">
                                    <div>'.esc_html__('Cover Photo', 'pointfindert2d').'</div>
                                  </div>
                                </div>
                              </li>';
          }
					// End:First export featured

					foreach ($images_of_thispost as $image_number) {
            if($image_number != $imageID_of_featured){
              $image_src = wp_get_attachment_image_src( $image_number, 'thumbnail' );
              $output_images .= '<li>
                                  <div class="pf-itemimage-container">
                                    <img src="'.aq_resize($image_src[0],90,90,true).'">
                                    <div class="pf-itemimage-delete">
                                      <a class="pf-delete-standartimg'.$olduptext.'" data-pfimgno="'.$image_number.'" data-pfpid="'.$id.'" data-pffeatured="no">'.esc_html__( 'Remove', 'pointfindert2d' ).'</a>
                                    </div>
                                    <div class="pfitemedit-featured">
                                      <a class="pf-change-standartimg'.$olduptext.'" data-pfimgno="'.$image_number.'" data-pfpid="'.$id.'" title="'.esc_html__('You can change your cover photo by clicking here', 'pointfindert2d').'">'.esc_html__('Set as Cover', 'pointfindert2d').'</a>
                                    </div>
                                  </div>
                                </li>';
            }
					}
					$output .= '<section class="pfuploadform-mainsec">';
						$output .= '<label for="file" class="lbl-text">'.esc_html__('UPLOADED IMAGES','pointfindert2d').':</label>';
						$output .= '<ul class="pfimages-ul">'.$output_images.'</ul>';
					$output .= '</section>';
					
					echo $output;
				}
			}
		}
	}

	die();
}

// Function that will return our Wordpress menu
function shortcode_menu($atts, $content = null) {
	extract(shortcode_atts(array(  
		'menu'            => '', 
		'container'       => 'div', 
		'container_class' => '', 
		'container_id'    => '', 
		'menu_class'      => 'menu', 
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => '',
		'theme_location'  => ''), 
		$atts));
 
 
	return wp_nav_menu( array( 
		'menu'            => $menu, 
		'container'       => $container, 
		'container_class' => $container_class, 
		'container_id'    => $container_id, 
		'menu_class'      => $menu_class, 
		'menu_id'         => $menu_id,
		'echo'            => false,
		'fallback_cb'     => $fallback_cb,
		'before'          => $before,
		'after'           => $after,
		'link_before'     => $link_before,
		'link_after'      => $link_after,
		'depth'           => $depth,
		'walker'          => $walker,
		'theme_location'  => $theme_location));
}
//Create the shortcode
add_shortcode("menu", "shortcode_menu");

function PFGetHeaderBar($post_id='', $post_title=''){
  if($post_id == ''){
    $post_id = get_the_ID(); 
  }

  $_page_titlebararea = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebararea");

  if($_page_titlebararea == 1){
    $_page_defaultheaderbararea = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_defaultheaderbararea");
    $_page_titlebarcustomtext = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomtext");
    $_page_titlebarcustomsubtext = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomsubtext");
    
    if ($_page_defaultheaderbararea == 1) {
      if(function_exists('PFGetDefaultPageHeader')){
        PFGetDefaultPageHeader(array('pagename' => get_the_title(),'taxinfo'=>$_page_titlebarcustomsubtext,'taxname'=>$_page_titlebarcustomtext));
        return;
      }
    }

    $_page_titlebarareatext = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarareatext");
    $_page_titlebarcustomtext_color = redux_post_meta( "pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomtext_color" );
    
      
      $_page_titlebarcustomheight = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomheight");
      $_page_titlebarcustombg = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustombg");
      $_page_titlebarcustomtext_bgcolor = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomtext_bgcolor");
      $_page_titlebarcustomtext_bgcolorop = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_titlebarcustomtext_bgcolorop");
      $setup43_themecustomizer_headerbar_shadowopt = redux_post_meta("pointfinderthemefmb_options", $post_id, "webbupointfinder_page_shadowopt");
     
      if (PFControlEmptyArr($_page_titlebarcustombg)) {
        $_page_titlebarcustombg_repeat = $_page_titlebarcustombg['background-repeat'];
        $_page_titlebarcustombg_color = $_page_titlebarcustombg['background-color'];
        $_page_titlebarcustombg_fixed = $_page_titlebarcustombg['background-attachment'];
        $_page_titlebarcustombg_image = $_page_titlebarcustombg['background-image'];
      }else{
        $_page_titlebarcustombg_repeat = '';
        $_page_titlebarcustombg_color = '';
        $_page_titlebarcustombg_fixed = '';
        $_page_titlebarcustombg_image = '';
      }


      $_page_custom_css = $_text_custom_css = ' style="';

      if ($_page_titlebarcustomheight != '') {
          $_page_custom_css .= 'height:'.$_page_titlebarcustomheight.'px;';
      } 

      if ($_page_titlebarcustombg_image != '') {
          $_page_custom_css .= 'background-image:url('.$_page_titlebarcustombg_image.');';
      } 
      if ($_page_titlebarcustombg_repeat != '') {
          $_page_custom_css .= 'background-repeat: '.$_page_titlebarcustombg_repeat.';';
      }
      if ($_page_titlebarcustombg_color != '') {
          $_page_custom_css .= 'background-color:'.$_page_titlebarcustombg_color.';';
      } 
      if ($_page_titlebarcustombg_fixed != '') {
          $_page_custom_css .= 'background-attachment :'.$_page_titlebarcustombg_fixed.';';
      }  
      if ($_page_titlebarcustomtext_color != '') {
          $_page_custom_css .= 'color:'.$_page_titlebarcustomtext_color.';';
          $_text_custom_css .= 'color:'.$_page_titlebarcustomtext_color.';';

      } 

      if ($_page_titlebarcustomtext_bgcolor != '') {
        $color_output = pointfinderhex2rgbex($_page_titlebarcustomtext_bgcolor,$_page_titlebarcustomtext_bgcolorop);
        $_text_custom_css .= 'background-color: '.$color_output['rgb'].';background-color: '.$color_output['rgba'].'; ';
        $_text_custom_css_main = ' pfwbg';
      $_text_custom_css_sub = ' pfwbg';
      }else{
        $_text_custom_css_main = '';
        $_text_custom_css_sub = '';
      }

      $_page_custom_css .= '';
      $_text_custom_css .= '"';

      
      
      $pagetitletext = '<div class="main-titlebar-text'.$_text_custom_css_main.'"'.$_text_custom_css.'>';

      if($_page_titlebarareatext == 1){

          if ($_page_titlebarcustomtext != '') {
              $pagetitletext .= $_page_titlebarcustomtext;
          }else{
            $pagetitletext .= get_the_title();
          }
          

          if ($_page_titlebarcustomsubtext != '') {
              $pagesubtext = '<div class="sub-titlebar-text'.$_text_custom_css_sub.'"'.$_text_custom_css.'>'.$_page_titlebarcustomsubtext.'</div>';
          }else{
            $pagesubtext = '';
          }
      }else{
        $pagetitletext .= get_the_title();
        $pagesubtext = '';
      }

      if($post_title != ''){$pagetitletext.=' / '.$post_title;}
      $pagetitletext .= '</div>';
      
      
      echo '
      <section role="pageheader"'.$_page_custom_css.'" class="pf-page-header">
      ';
      if ($setup43_themecustomizer_headerbar_shadowopt != 0) {
    echo '<div class="pfheaderbarshadow'.$setup43_themecustomizer_headerbar_shadowopt.'"></div>';
  }
      echo '
        <div class="pf-container">
          <div class="pf-row">
            <div class="col-lg-12">
              <div class="pf-titlebar-texts">'.$pagetitletext.$pagesubtext.'</div>
              <div class="pf-breadcrumbs clearfix">'.pf_the_breadcrumb(
                array(
                  '_text_custom_css' => $_text_custom_css,
                  '_text_custom_css_main' => $_text_custom_css_main
              )
                ).'</div>
            </div>
          </div>
        </div>
      </section>';
  }
}

function prefix_my_dump() {
  /*
  $post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
  
  // WP_Query arguments
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
        'compare' => 'NOT EXISTS',
      ),
    ),
  );

  // The Query
  $the_query = new WP_Query( $args );

  // The Loop
  if ( $the_query->have_posts() ) {
    print '<p>Oui résultats :</p>';
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      echo '<ul>';
      echo '<li>' . $the_query->post->ID.'</li>';
      echo '<li>' . $the_query->post->post_title.'</li>';
      echo '<li>' . $the_query->post->post_author.'</li>';
      echo '</ul>';
    }
  } else {
    print '<p>NON pas de résultats</p>';
  }

  // Restore original Post Data
  wp_reset_postdata();
  */
}
add_action( 'wp_footer', 'prefix_my_dump' );




/*
add_filter( 'search_rewrite_rules', 'wpse15418_search_rewrite_rules' );
function wpse15418_search_rewrite_rules( $search_rewrite_rules ){
  global $wp_rewrite;
  //$wp_rewrite->add_rewrite_tag( '%fp_action%', '([^/]+)', 'action=' );
  $wp_rewrite->add_rewrite_tag( '%fp_location%', '([^/]+)', 'location=' );
  //$wp_rewrite->add_rewrite_tag( '%fp_action%', '([^/]+)', 'action=' );
  $search_structure = $wp_rewrite->get_search_permastruct();
  return $wp_rewrite->generate_rewrite_rules( $search_structure . '/location/%fp_location%', EP_SEARCH );
}
function lou_add_lang_query_var($vars) {
  // tell WP to expect the lang query_var, which you can then later use
  $vars[] = 'action';
  $vars[] = 'keyword';
  $vars[] = 'listingtype';
  $vars[] = 'location';
  $vars[] = 'industry';
  $vars[] = 'serialized';

  // return the new list of query vars, which includes our lang param
  return array_unique($vars);
}
add_filter('query_vars', 'lou_add_lang_query_var', 10, 1);
*/
 
add_filter('acf/settings/remove_wp_meta_box', '__return_false');
// Schedule the event on plugin activation
register_activation_hook(__FILE__, 'schedule_error_log_deletion');



// Hook the function that will be executed when the event is triggered
add_action('relevanssi_update_counts', 'delete_error_log');

function delete_error_log() {
    $error_log_path = '/public_html/error_log';

    // Check if the error log file exists
    if (file_exists($error_log_path)) {
        // Delete the error log file
        unlink($error_log_path);
    }
}





?>