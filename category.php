<?php 
get_header();

	global $wp_query;
	$pf_category = 0;
	$pf_mapheader_arr = array('pointfinderltypes'=>'','pointfinderitypes'=>'','pointfinderlocations'=>'','pointfinderfeatures'=>'','pointfinderconditions'=>'',);
  $get_termname = $get_term_nameforlink = '';
	
  if(isset($wp_query->query_vars['taxonomy'])){
		$taxonomy_name = $wp_query->query_vars['taxonomy'];
		if (in_array($taxonomy_name, array('pointfinderltypes','pointfinderitypes','pointfinderconditions','pointfinderlocations','pointfinderfeatures'))) {
			
			$term_slug = $wp_query->query_vars['term'];
			$pf_category = 1;
			$term_name = get_term_by('slug', $term_slug, $taxonomy_name,'ARRAY_A');
			
			$get_termname = $term_name['name'];
			$get_term_nameforlink = '<a href="'.get_term_link( $term_name['term_id'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_name['name']) ) . '">'.$term_name['name'].'</a>';

			if (!empty($term_name['parent'])) {
				$term_parent_name = get_term_by('id', $term_name['parent'], $taxonomy_name,'ARRAY_A');
				$get_termname = $term_parent_name['name'].' / '.$term_name['name'];
				$get_term_nameforlink = '<a href="'.get_term_link( $term_name['parent'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_parent_name['name']) ) . '">'.$term_parent_name['name'].'</a> / '.'<a href="'.get_term_link( $term_name['term_id'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_name['name']) ) . '">'.$term_name['name'].'</a>';
			}

			$filter_text = '';

			switch ($taxonomy_name) {
				case 'pointfinderltypes':
					$filter_text .= 'listingtype = "'.$term_name['term_id'].'"';
					$pf_mapheader_arr['pointfinderltypes'] = $term_name['term_id'];
					break;
				
				case 'pointfinderitypes':
					$filter_text .= 'itemtype = "'.$term_name['term_id'].'"';
					$pf_mapheader_arr['pointfinderitypes'] = $term_name['term_id'];
					break;

				case 'pointfinderlocations':
					$filter_text .= 'locationtype = "'.$term_name['term_id'].'"';
					$pf_mapheader_arr['pointfinderlocations'] = $term_name['term_id'];
					break;

				case 'pointfinderfeatures':
					$filter_text .= 'features = "'.$term_name['term_id'].'"';
					$pf_mapheader_arr['pointfinderfeatures'] = $term_name['term_id'];
					break;

				case 'pointfinderconditions':
					$filter_text .= 'conditions = "'.$term_name['term_id'].'"';
					$pf_mapheader_arr['pointfinderconditions'] = $term_name['term_id'];
					break;
			}

		}
	}
  
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
	$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');
	$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');

	if ($pf_category == 0) {
    $setup_item_blogcatpage_sidebarpos = PFASSIssetControl('setup_item_blogcatpage_sidebarpos','','2');
		if(function_exists('PFGetDefaultPageHeader')){
      PFGetDefaultPageHeader();
    }
    
		echo '<section role="main">
            <div class="pf-container">
              <div class="pf-row">';
    $currentCategory = get_the_category();
    if($currentCategory[0]->term_id == 49){
      echo '    <div class="col-lg-12" style="margin:20px 0 15px;">'.term_description().'</div>';
    }else{
      echo '    <div class="pf-blogpage-spacing pfb-top"></div>';
    }
    if ($setup_item_blogcatpage_sidebarpos == 3) {
      echo '    <div class="col-lg-12">'.get_template_part('loop').'</div>';
    }else{
      if($setup_item_blogcatpage_sidebarpos == 1){
        echo '  <div class="col-lg-3 col-md-4">';
        if (is_active_sidebar( 'pointfinder-blogcatpages-area' )) {
          get_sidebar('catblog' );
        } else {
          get_sidebar();
        }
        echo '  </div>';
      }
      echo '    <div class="col-lg-9 col-md-8">'.get_template_part('loop').'</div>';
      if($setup_item_blogcatpage_sidebarpos == 2){
        echo '  <div class="col-lg-3 col-md-4">';
          if (is_active_sidebar( 'pointfinder-blogcatpages-area' )) {
            get_sidebar('catblog' );
          } else {
            get_sidebar();
          }
        echo '  </div>';
      }
    }
    echo '    </div>
            </div>
          </section>
          <div class="pf-blogpage-spacing pfb-bottom"></div>';
	}else{
    $general_ct_page_layout = PFSAIssetControl('general_ct_page_layout','','1');

        if ($general_ct_page_layout == 1) {

        	$pointfinderltypesas_vars = get_option('pointfinderltypesas_vars');
       		$pf_cat_imagebg = (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_imagebg']))? $pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_imagebg']: 2;
	        
	        if ($pf_cat_imagebg == 1) {
	        	if(function_exists('PFGetDefaultCatPageHeader')){
	        		PFGetDefaultCatPageHeader(
	        			array(
	        				'taxname' => $get_termname,
	        				'taxnamebr' => $get_term_nameforlink,
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
	        }else{
	        	if(function_exists('PFGetDefaultPageHeader')){
	        		PFGetDefaultPageHeader(
	        			array(
	        				'taxname' => $get_termname,
	        				'taxnamebr' => $get_term_nameforlink,
	        				'taxinfo'=>$term_name['description']
	        			)
	        		);
	        	}
	        }
	    }

	    /* Map Header */
	    if ($general_ct_page_layout == 2) {

	    	/* Get Variables and apply */
			$setup42_searchpagemap_height = PFSAIssetControl('setup42_searchpagemap_height','height','550');
			$setup42_mheight = PFSAIssetControl('setup42_mheight','height','350');
			$setup42_theight = PFSAIssetControl('setup42_theight','height','400');
			
			$setup42_searchpagemap_lat = PFSAIssetControl('setup42_searchpagemap_lat','','');
			$setup42_searchpagemap_lng = PFSAIssetControl('setup42_searchpagemap_lng','','');
			$setup42_searchpagemap_zoom = PFSAIssetControl('setup42_searchpagemap_zoom','','12');
			$setup42_searchpagemap_mobile = PFSAIssetControl('setup42_searchpagemap_mobile','','10');
			$setup42_searchpagemap_type = PFSAIssetControl('setup42_searchpagemap_type','','ROADMAP');
			$setup42_searchpagemap_business = PFSAIssetControl('setup42_searchpagemap_business','','0');
			$setup42_searchpagemap_streetViewControl = PFSAIssetControl('setup42_searchpagemap_streetViewControl','','1');
			$setup42_searchpagemap_style = preg_replace('/\s+/', '',PFSAIssetControl('setup42_searchpagemap_style','',''));
			if (mb_substr($setup42_searchpagemap_style, 0, 1,'UTF-8') == '[' && mb_substr($setup42_searchpagemap_style, -1, 1,'UTF-8') == ']') {
				$setup42_searchpagemap_style = mb_substr($setup42_searchpagemap_style, 1, -1,'UTF-8');
			}
			$setup42_searchpagemap_style = base64_encode( strip_tags( $setup42_searchpagemap_style ));
			$setup42_searchpagemap_height = str_replace('px', '', $setup42_searchpagemap_height);
			$setup42_mheight = str_replace('px', '', $setup42_mheight);
			$setup42_theight = str_replace('px', '', $setup42_theight);
			$setup7_geolocation_status = 0;


			/* Build Map */
			
			$pfg_paged = 1;

			if ( is_front_page() ) {
		        $pfg_paged = (esc_sql(get_query_var('page'))) ? esc_sql(get_query_var('page')) : 1;   
		    } else {
		        $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
		    }

		    /*Get if sort/order/number values exist*/
			if(isset($_GET['pfsearch-filter']) && $_GET['pfsearch-filter']!=''){$pfg_orderby = esc_attr($_GET['pfsearch-filter']);}else{$pfg_orderby = $setup22_searchresults_defaultsortbytype;}
			if(isset($_GET['pfsearch-filter-order']) && $_GET['pfsearch-filter-order']!=''){$pfg_order = esc_attr($_GET['pfsearch-filter-order']);}else{$pfg_order = $setup22_searchresults_defaultsorttype;}
			if(isset($_GET['pfsearch-filter-number']) && $_GET['pfsearch-filter-number']!=''){$pfg_number = esc_attr($_GET['pfsearch-filter-number']);}else{$pfg_number = $setup22_searchresults_defaultppptype;}

			echo do_shortcode('[pf_directory_map setup5_mapsettings_height="'.$setup42_searchpagemap_height.'" setup42_mheight="'.$setup42_mheight.'" setup42_theight="'.$setup42_theight.'" setup5_mapsettings_zoom="'.$setup42_searchpagemap_zoom.'" setup5_mapsettings_zoom_mobile="'.$setup42_searchpagemap_mobile.'" setup8_pointsettings_ajax="0" setup5_mapsettings_autofit="1" setup5_mapsettings_autofitsearch="0" setup5_mapsettings_type="'.$setup42_searchpagemap_type.'" setup5_mapsettings_business="'.$setup42_searchpagemap_business.'" setup5_mapsettings_streetViewControl="'.$setup42_searchpagemap_streetViewControl.'" mapsearch_status="0" mapnot_status="0" setup5_mapsettings_lat="'.$setup42_searchpagemap_lat.'" setup5_mapsettings_lng="'.$setup42_searchpagemap_lng.'" setup5_mapsettings_style="'.$setup42_searchpagemap_style.'" setup7_geolocation_status="0" listingtype="'.$pf_mapheader_arr['pointfinderltypes'].'" itemtype="'.$pf_mapheader_arr['pointfinderitypes'].'" conditions="'.$pf_mapheader_arr['pointfinderconditions'].'" features ="'.$pf_mapheader_arr['pointfinderfeatures'].'" locationtype="'.$pf_mapheader_arr['pointfinderlocations'].'" ppp="'.$pfg_number.'" paged="'.$pfg_paged.'" orderby="'.$pfg_orderby.'" order="'.$pfg_order.'"]');

	    }


		$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
		$setup42_authorpagedetails_defaultppptype = $setup22_searchresults_defaultppptype;

		$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_dlcfc','','3');

		$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;
		$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#ffffff');
		$setup22_searchresults_status_catfilters = PFSAIssetControl('setup22_searchresults_status_catfilters','','1');
		$stp22_infscrl_c = PFSAIssetControl('stp22_infscrl_c','',0);
		$stp22_infscrl_c2 = PFSAIssetControl('stp22_infscrl_c2','',0);
		
		if ($setup22_searchresults_status_catfilters == 1) {
			$filters_text = 'true';
		}else{
			$filters_text = 'false';
		}

		if($general_ct_page_layout == 1 || $general_ct_page_layout == 2){
			if ($general_ct_page_layout == 2) {
				$topmap_status = "1";
			}else{
				$topmap_status = "0";
			}
			$setup_item_catpage_sidebarpos = PFASSIssetControl('setup_item_catpage_sidebarpos','','2');
			echo '<section role="main">';
			if ($general_ct_page_layout == 2) {
				echo '<div class="pf-fullwidth pf-itempage-br-xm pf-itempage-br-xm-nh"><div class="pf-container"><div class="pf-row"><div class="col-lg-12">';
							$br_output = pf_the_breadcrumb(array('taxname' => $get_term_nameforlink));
				echo '<div class="pf-breadcrumbs pf-breadcrumbs-special">'.$br_output.'</div></div></div></div></div>';
			}
		        echo '<div class="pf-page-spacing"></div>';
		        echo '<div class="pf-container"><div class="pf-row clearfix">';
		        	if ($setup_item_catpage_sidebarpos == 3) {
		        		echo '<div class="col-lg-12"><div class="pf-page-container">';
							echo do_shortcode('[pf_itemgrid2 orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" infinite_scroll="'.$stp22_infscrl_c.'" infinite_scroll_lm="'.$stp22_infscrl_c2.'" termname="'.$get_termname.'" topmap="'.$topmap_status.'" '.$filter_text.']' );
						echo '</div></div>';
		        	}else{
		        		if($setup_item_catpage_sidebarpos == 1){
			                echo '<div class="col-lg-3 col-md-4">';
			                    get_sidebar('itemcats' ); 
			                echo '</div>';
			            }
			              
			            echo '<div class="col-lg-9 col-md-8"><div class="pf-page-container">'; 
			            
			            echo do_shortcode('[pf_itemgrid2 orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" infinite_scroll="'.$stp22_infscrl_c.'" infinite_scroll_lm="'.$stp22_infscrl_c2.'" termname="'.$get_termname.'" topmap="'.$topmap_status.'" '.$filter_text.']' );

			            echo '</div></div>';
			            if($setup_item_catpage_sidebarpos == 2){
			                echo '<div class="col-lg-3 col-md-4">';
			                    get_sidebar('itemcats' );
			                echo '</div>';
			            }
		        	}
		            
		        echo '</div></div>';
		        echo '<div class="pf-page-spacing"></div>';
		    echo '</section>';
		}elseif ($general_ct_page_layout == 3) {


			/* Get Variables and apply */

			
			$setup42_searchpagemap_lat = PFSAIssetControl('setup42_searchpagemap_lat','','');
			$setup42_searchpagemap_lng = PFSAIssetControl('setup42_searchpagemap_lng','','');
			$setup42_searchpagemap_zoom = PFSAIssetControl('setup42_searchpagemap_zoom','','12');
			$setup42_searchpagemap_mobile = PFSAIssetControl('setup42_searchpagemap_mobile','','10');
			$setup42_searchpagemap_type = PFSAIssetControl('setup42_searchpagemap_type','','ROADMAP');
			$setup42_searchpagemap_business = PFSAIssetControl('setup42_searchpagemap_business','','0');
			$setup42_searchpagemap_streetViewControl = PFSAIssetControl('setup42_searchpagemap_streetViewControl','','1');
			$setup42_searchpagemap_style = preg_replace('/\s+/', '',PFSAIssetControl('setup42_searchpagemap_style','',''));
			if (mb_substr($setup42_searchpagemap_style, 0, 1,'UTF-8') == '[' && mb_substr($setup42_searchpagemap_style, -1, 1,'UTF-8') == ']') {
				$setup42_searchpagemap_style = mb_substr($setup42_searchpagemap_style, 1, -1,'UTF-8');
			}
			$setup42_searchpagemap_style = base64_encode( strip_tags( $setup42_searchpagemap_style ));
			$setup7_geolocation_status = 0;


			/* Build Map */

		    /*Get if sort/order/number values exist*/
			if(isset($_GET['pfsearch-filter']) && $_GET['pfsearch-filter']!=''){$pfg_orderby = esc_attr($_GET['pfsearch-filter']);}else{$pfg_orderby = $setup22_searchresults_defaultsortbytype;}
			if(isset($_GET['pfsearch-filter-order']) && $_GET['pfsearch-filter-order']!=''){$pfg_order = esc_attr($_GET['pfsearch-filter-order']);}else{$pfg_order = $setup22_searchresults_defaultsorttype;}
			if(isset($_GET['pfsearch-filter-number']) && $_GET['pfsearch-filter-number']!=''){$pfg_number = esc_attr($_GET['pfsearch-filter-number']);}else{$pfg_number = $setup22_searchresults_defaultppptype;}

			echo do_shortcode('[pf_directory_half_map setup5_mapsettings_zoom="'.$setup42_searchpagemap_zoom.'" setup5_mapsettings_zoom_mobile="'.$setup42_searchpagemap_mobile.'" setup5_mapsettings_autofit="1" setup5_mapsettings_autofitsearch="1" setup5_mapsettings_type="'.$setup42_searchpagemap_type.'" setup5_mapsettings_business="'.$setup42_searchpagemap_business.'" setup5_mapsettings_streetViewControl="'.$setup42_searchpagemap_streetViewControl.'" mapsearch_status="1" mapnot_status="1" setup5_mapsettings_lat="'.$setup42_searchpagemap_lat.'" setup5_mapsettings_lng="'.$setup42_searchpagemap_lng.'" setup5_mapsettings_style="'.$setup42_searchpagemap_style.'" setup7_geolocation_status="0" listingtype="'.$pf_mapheader_arr['pointfinderltypes'].'" itemtype="'.$pf_mapheader_arr['pointfinderitypes'].'" conditions="'.$pf_mapheader_arr['pointfinderconditions'].'" features ="'.$pf_mapheader_arr['pointfinderfeatures'].'" locationtype="'.$pf_mapheader_arr['pointfinderlocations'].'"  termname="'.$get_termname.'" csauto="'.$term_name['term_id'].'"]');

		}

	}


get_footer();
?>







