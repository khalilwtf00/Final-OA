<?php 
  get_header();

	global $wp_query;
  
  //if(isset($wp_query->query_vars['taxonomy'])){ pas besoin, on est dans un template "taxonomy"
  $taxonomy_name = $wp_query->query_vars['taxonomy'];
  $term_slug = $wp_query->query_vars['term'];
  $term_name = get_term_by('slug', $term_slug, $taxonomy_name, 'ARRAY_A');
  
  if(function_exists('PFGetDefaultCatPageHeader')){
    PFGetDefaultCatPageHeader(
      array(
        'taxname' => $term_name['name'],
        // Breadcrumb vers la page parente
        'taxnamebr' => '<a href="'.get_permalink(1074).'">'.get_the_title(1074).'</a>',
        'taxinfo'=>$term_name['description'],
        'pf_cat_textcolor' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_textcolor']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_textcolor']:'',
        'pf_cat_backcolor' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_backcolor']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_backcolor']:'',
        'pf_cat_bgimg' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgimg']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgimg']:'',
        'pf_cat_bgrepeat' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgrepeat']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgrepeat']:'',
        'pf_cat_bgsize' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgsize']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgsize']:'',
        'pf_cat_bgpos' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgpos']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgpos']:'',
        'pf_cat_headerheight' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_headerheight']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_headerheight']:'',
      )
    );
  }
  echo do_shortcode('[vc_row widthopt="" fixedbg="" footerrow="" el_class="author_page_spacing"][vc_column width="3/4"][pf_agentlist pagelimit="10" taxoterm="'.$term_slug.'"][/vc_column][vc_column width="1/4"][vc_widget_sidebar sidebar_id="pointfinder-authorpage-area"][/vc_column][/vc_row]');

  get_footer();
?>