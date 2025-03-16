<?php
/**********************************************************************************************************************************
*
* Custom Widgets for PointFinder Child
* 
* Author: Occasion Franchise
*
* 
*
***********************************************************************************************************************************/

/**
*START: SEARCH ITEMS WIDGET
**/
class fp_advanced_search_w_child extends WP_Widget {
  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'fp_advanced_search_w_child', 

      // Widget name will appear in UI
      esc_html__('FP - Advanced Search', 'pointfindert2d'), 

      // Widget description
      array( 'description' => esc_html__( 'Advanced Search to complete homepage minimal search form', 'pointfindert2d' ),'classname' => 'fp_advanced_search' ) 
    );
  }


  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) ){
      echo $args['before_title'] . $title . $args['after_title'];
    }

    if(!wp_style_is('pfsearch-select2-css', 'enqueued')){ wp_enqueue_style('pfsearch-select2-css'); }
    if(!wp_script_is('pfsearch-select2-js', 'enqueued')){ wp_enqueue_script('pfsearch-select2-js'); }    

      /**
      *Start: Search Form
      **/
      ?>
      <form id="pointfinder-search-form-manual" method="get" action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
        <div class="pfsearch-content golden-forms">
        <div class="pfsearchformerrors">
          <ul>
          </ul>
          <a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d')?></a>
        </div>
        <?php 
        $setup1s_slides = PFSAIssetControl('setup1s_slides','','');
        
        if(is_array($setup1s_slides)){
          /**
          *Start: Get search data & apply to query arguments.
          **/
          $pfgetdata = $_GET;
          
          if(is_array($pfgetdata)){
            $pfformvars = array();
            
            foreach ($pfgetdata as $key => $value) {
              if (!empty($value) && $value != 'pfs') {
                $pfformvars[$key] = $value;
              }
            }
            
            $pfformvars = PFCleanArrayAttr('PFCleanFilters',$pfformvars);
          }
          /**
          *End: Get search data & apply to query arguments.
          **/
          
          $PFListSF = new PF_SF_Val();
          foreach ($setup1s_slides as &$value) {
            $PFListSF->GetValue($value['title'],$value['url'],$value['select'],1,$pfformvars,0,0,1,1);
          }

          /*Sense Category*/
          $current_post_id = get_the_id();

          if (!empty($current_post_id) && (is_single())) {
            $current_post_terms = get_the_terms( $current_post_id, 'pointfinderltypes');

            if (isset($current_post_terms) && $current_post_terms != false) {
              foreach ($current_post_terms as $key => $value) {
                $category_selected_auto = $value->term_id;
              }
            }
          }elseif( (is_category() || is_archive() || is_tag() || is_tax())){
            global $wp_query;

            if(isset($wp_query->query_vars['taxonomy'])){
              $taxonomy_name = $wp_query->query_vars['taxonomy'];
              if ($taxonomy_name == 'pointfinderltypes') {
                $term_slug = $wp_query->query_vars['term'];
                $term_name = get_term_by('slug', $term_slug, $taxonomy_name,'ARRAY_A');
                if (isset($term_name['term_id'])) {
                  $category_selected_auto = $term_name['term_id'];
                }
              }
            }
          }

          /*Get Listing Type Item Slug*/
          $fltf = pointfinder_find_requestedfields('pointfinderltypes');
          $features_field = pointfinder_find_requestedfields('pointfinderfeatures');
          $itemtypes_field = pointfinder_find_requestedfields('pointfinderitypes');
          $conditions_field = pointfinder_find_requestedfields('pointfinderconditions');

          $stp_syncs_it = PFSAIssetControl('stp_syncs_it','',1);
          $stp_syncs_co = PFSAIssetControl('stp_syncs_co','',1);
          $setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1','',1);

          $second_request_process = false;
          $second_request_text = "{features:'',itemtypes:'',conditions:''}";
          $multiple_itemtypes = $multiple_features = $multiple_conditions =  '';

          if (!empty($features_field) || !empty($itemtypes_field) || !empty($conditions_field)) {
            $second_request_process = true;
            $second_request_text = '{';
            if (!empty($features_field) && $setup4_sbf_c1 == 0) {
              $second_request_text .= "features:'$features_field'";
              $multiple_features = PFSFIssetControl('setupsearchfields_'.$features_field.'_multiple','','0');
            }
            if (!empty($itemtypes_field) && $stp_syncs_it == 0) {
              if (!empty($features_field) && $setup4_sbf_c1 == 0) {
                $second_request_text .= ",";
              }
              $second_request_text .= "itemtypes:'$itemtypes_field'";
              $multiple_itemtypes = PFSFIssetControl('setupsearchfields_'.$itemtypes_field.'_multiple','','0');
            }
            if (!empty($conditions_field) && $stp_syncs_co == 0) {
              if ((!empty($features_field) && $setup4_sbf_c1 == 0) || (!empty($itemtypes_field) && $stp_syncs_it == 0)) {
                $second_request_text .= ",";
              }
              $second_request_text .= "conditions:'$conditions_field'";
              $multiple_conditions = PFSFIssetControl('setupsearchfields_'.$conditions_field.'_multiple','','0');
            }

            if (!empty($multiple_itemtypes)) {
              if (!empty($second_request_text)) {
                $second_request_text .= ",";
              }
              $second_request_text .= "mit:'1'";
            }

            if (!empty($multiple_features)) {
              if (!empty($second_request_text)) {
                $second_request_text .= ",";
              }
              $second_request_text .= "mfe:'1'";
            }

            if (!empty($multiple_conditions)) {
              if (!empty($second_request_text)) {
                $second_request_text .= ",";
              }
              $second_request_text .= "mco:'1'";
            }

            $second_request_text .= '}';
          }

          $pfformvars_json = isset($pfformvars) ? json_encode($pfformvars) : json_encode(array());
      
          echo $PFListSF->FieldOutput;
          echo '<div id="pfsearchsubvalues"></div>';
          echo '<input id="fp_default_search_value" type="hidden" name="s" value=""/>';
          echo '<input type="hidden" name="serialized" value="1"/>';
          echo '<input type="hidden" name="action" value="pfs"/>';
          echo '<a class="button pfsearch" id="pf-search-button-manual"><i class="pfadmicon-glyph-627"></i> '.esc_html__('SEARCH', 'pointfindert2d').'</a>';
          echo '<script type="text/javascript">
          (function($) {
              "use strict";
              $.pffieldsids = '.$second_request_text.'
              $.pfsliderdefaults = {};$.pfsliderdefaults.fields = Array();

              $(function(){
                $("#pointfinder-search-form-manual").submit(function(){
                  $("#fp_default_search_value").val($("#keyword").val());
                });
              '.$PFListSF->ScriptOutput;
              echo 'var pfsearchformerrors = $(".pfsearchformerrors");
              
                  $("#pointfinder-search-form-manual").validate({
                        debug:false,
                        onfocus: false,
                        onfocusout: false,
                        onkeyup: false,
                        rules:{'.$PFListSF->VSORules.'},messages:{'.$PFListSF->VSOMessages.'},
                        ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
                        validClass: "pfvalid",
                        errorClass: "pfnotvalid pfadmicon-glyph-858",
                        errorElement: "li",
                        errorContainer: pfsearchformerrors,
                        errorLabelContainer: $("ul", pfsearchformerrors),
                        invalidHandler: function(event, validator) {
                          var errors = validator.numberOfInvalids();
                          if (errors) {
                              pfsearchformerrors.show("slide",{direction : "up"},100)
                              $(".pfsearch-err-button").click(function(){
                                  pfsearchformerrors.hide("slide",{direction : "up"},100)
                                  return false;
                              });
                          }else{
                              pfsearchformerrors.hide("fade",300)
                          }
                        }
                  });
              ';

              if ($fltf != 'none') {
                  $ajaxloads = PFSFIssetControl('setupsearchfields_'.$fltf.'_ajaxloads','','0');
                  $as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

                  if ($as_mobile_dropdowns == 1) {
                      echo '
                      $(function(){
                          $("#'.$fltf.'" ).change(function(e) {
                            $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                            ';
                            if ($second_request_process) {
                              echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                            }
                            echo '
                          });
                          $(document).one("ready",function(){
                              if ($("#'.$fltf.'" ).val() !== 0) {
                                 $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                                 ';
                                 if ($second_request_process) {
                                   echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                                 }
                                 echo '
                              }
                          });
                          setTimeout(function(){
                             $(".select2-container" ).attr("title","");
                             $("#'.$fltf.'" ).attr("title","")
                              
                          },300);
                      });
                      ';
                  }else{
                      echo '
                     
                      $("#'.$fltf.'" ).change(function(e) {
                        $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                        ';
                        if ($second_request_process) {
                          echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                        }
                        echo '
                      });
                      $(document).one("ready",function(){
                          if ($("#'.$fltf.'" ).val() !== 0) {
                             $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                             ';
                             if ($second_request_process) {
                               echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                             }
                             echo '
                          }
                      });
                      setTimeout(function(){
                         $(".select2-container" ).attr("title","");
                         $("#'.$fltf.'" ).attr("title","")
                          
                      },300);
                    
                      ';
                  }
              }
              echo '
              });'.$PFListSF->ScriptOutputDocReady;
        }

            if (!empty($category_selected_auto)) {
                if($ajaxloads == 1){
                  echo '
                    $(document).ready(function(){
                            if ($("#'.$fltf.'_sel" )) {
                                $("#'.$fltf.'_sel" ).select2("val","'.$category_selected_auto.'");
                            }
                        });
                    ';
                }else{
                  echo '
                    $(document).ready(function(){
                          if ($("#'.$fltf.'" )) {
                              $("#'.$fltf.'" ).select2("val","'.$category_selected_auto.'");
                          }
                      });
                  ';
                }
            }
            echo'   
                
            })(jQuery);
            </script>';
          
            unset($PFListSF);
      ?>
      </div>
      </form>
      <?php
      /**
      *End: Search Form
      **/
    echo $args['after_widget'];
  }
  
  // Widget Backend 
  public function form( $instance ) {
    $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    
    return $instance;
  }
}
/**
*END: SEARCH ITEMS WIDGET
**/

?>