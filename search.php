<?php 
get_header();
	
  /*
	if(!isset($_GET['s'])){
    // ça utilise le mot clé /search/??? pour trouver quelque chose
    die('avec mot clé search');
    $fpgetdata['action'] = get_query_var('action');
    $fpgetdata['s'] = get_query_var('s');
    $fpgetdata['keyword'] = get_query_var('keyword', $fpgetdata['s']);
    
    $pfgetdata = array_merge($_GET, $fpgetdata);
  }else{
    
    die('pas GET mis');
  }
  */
  
	if (isset($_GET['action']) && $_GET['action'] == 'pfs') {

		/**
		*Start: Get search data & apply to query arguments.
		**/
			$pfgetdata = $_GET;

			$pfne = $pfne2 = $pfsw = $pfsw2 = $pfpointfinder_google_search_coord = $hidden_output = $search_output = '';

			$searchkeys = array('pfsearch-filter','pfsearch-filter-order','pfsearch-filter-number','pfsearch-filter-col');

			if(is_array($pfgetdata)){

				$pfformvars = array();
				$pfgetdata = PFCleanArrayAttr('PFCleanFilters',$pfgetdata);

				foreach($pfgetdata as $key=>$value){

					if (is_array($value)) {if (empty($value[0])) {unset($value[0]);}}

					if(!empty($value)){
						if(isset($pfformvars[$key])){
							$pfformvars[$key] = $pfformvars[$key]. ',' .$value;
						}else{
							$pfformvars[$key] = $value;
						}
						if (!is_array($value)) {
							if(!in_array($key, $searchkeys)){$hidden_output .= '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';}
						}
					}

					if ($key == 'ne') {$pfne = sanitize_text_field($value);}
					if ($key == 'ne2') {$pfne2 = sanitize_text_field($value);}
					if ($key == 'sw') {$pfsw = sanitize_text_field($value);}
					if ($key == 'sw2') {$pfsw2 = sanitize_text_field($value);}
					if ($key == 'pointfinder_google_search_coord') {$pfpointfinder_google_search_coord = sanitize_text_field($value);}

				}

				$hidden_output .= '<input type="hidden" name="s" value=""/>';

				$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
				
				$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish');
				
				if(isset($_GET['pfsearch-filter']) && $_GET['pfsearch-filter']!=''){$pfg_orderbyx = esc_attr($_GET['pfsearch-filter']);}else{$pfg_orderbyx = '';}
				if(isset($_POST['pfg_order']) && $_POST['pfg_order']!=''){$pfg_orderx = esc_attr($_POST['pfg_order']);}else{$pfg_orderx = '';}
				if(isset($_POST['pfg_number']) && $_POST['pfg_number']!=''){$pfg_numberx = esc_attr($_POST['pfg_number']);}else{$pfg_numberx = '';}

				$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
				$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');
				$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');

				if($pfg_orderbyx == ''){
					$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
					$args['orderby'] = array('meta_value_num' => 'DESC' , $setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
					$args['posts_per_page'] = $setup22_searchresults_defaultppptype;
				}else{
					$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
					$args['orderby'] = array('meta_value_num' => 'DESC');
					$args['posts_per_page'] = $pfg_numberx;
				}

				if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
					$args['meta_query'] = array();
				}	

				if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
					$args['tax_query'] = array();
				}

				/* Added with v1.8.7 */
				$pf_query_builder = new PointfinderSearchQueryBuilder($args);
				$pf_query_builder->setQueryValues($pfformvars,'search',$searchkeys);
				$args = $pf_query_builder->getQuery();	
	
			}	
	
		/**
		*End: Get search data & apply to query arguments.
		**/
		/* This code added by Pointfinder and it is safe!! */
		$manualargs = base64_encode(maybe_serialize($args));
		$hidden_output = base64_encode(maybe_serialize($hidden_output));
				
        $setup_item_searchresults_sidebarpos = PFASSIssetControl('setup_item_searchresults_sidebarpos','','2');

		$setup42_searchpagemap_headeritem = PFSAIssetControl('setup42_searchpagemap_headeritem','','1');
		if ($setup42_searchpagemap_headeritem == 0) {
			if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}
		}elseif ($setup42_searchpagemap_headeritem == 1){

			/* Get Variables and apply */
			$setup42_searchpagemap_height = PFSAIssetControl('setup42_searchpagemap_height','height','550');
			$setup42_mheight = PFSAIssetControl('setup42_mheight','height','350');
			$setup42_theight = PFSAIssetControl('setup42_theight','height','400');
			
			$setup42_searchpagemap_lat = PFSAIssetControl('setup42_searchpagemap_lat','','');
			$setup42_searchpagemap_lng = PFSAIssetControl('setup42_searchpagemap_lng','','');
			$setup42_searchpagemap_zoom = PFSAIssetControl('setup42_searchpagemap_zoom','','12');
			$setup42_searchpagemap_mobile = PFSAIssetControl('setup42_searchpagemap_mobile','','10');
			$setup42_searchpagemap_autofitsearch = PFSAIssetControl('setup42_searchpagemap_autofitsearch','','1');
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

			echo do_shortcode('[pf_directory_map setup5_mapsettings_height="'.$setup42_searchpagemap_height.'" setup42_mheight="'.$setup42_mheight.'" setup42_theight="'.$setup42_theight.'" setup5_mapsettings_zoom="'.$setup42_searchpagemap_zoom.'" setup5_mapsettings_zoom_mobile="'.$setup42_searchpagemap_mobile.'" setup8_pointsettings_ajax="0" setup5_mapsettings_autofit="0" setup5_mapsettings_autofitsearch="'.$setup42_searchpagemap_autofitsearch.'" setup5_mapsettings_type="'.$setup42_searchpagemap_type.'" setup5_mapsettings_business="'.$setup42_searchpagemap_business.'" setup5_mapsettings_streetViewControl="'.$setup42_searchpagemap_streetViewControl.'" mapsearch_status="0" mapnot_status="0" setup5_mapsettings_lat="'.$setup42_searchpagemap_lat.'" setup5_mapsettings_lng="'.$setup42_searchpagemap_lng.'" setup5_mapsettings_style="'.$setup42_searchpagemap_style.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" manualargs="'.$manualargs.'" neaddress="'.$pfpointfinder_google_search_coord.'" setup7_geolocation_status="0"]');
		}elseif($setup42_searchpagemap_headeritem == 2){
			/* Half Map */
		}

        if($setup42_searchpagemap_headeritem != 2){
			$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#ffffff');
			$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
			$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_searchresults_defaultlistingtype','','4');
			$setup42_authorpagedetails_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
			$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;

			$setup22_searchresults_status_catfilters = PFSAIssetControl('stp42_fltrs','','1');

			$stp22_infscrl_s = PFSAIssetControl('stp22_infscrl_s','',0);
			$stp22_infscrl_s2 = PFSAIssetControl('stp22_infscrl_s2','',0);
			
			if ($setup22_searchresults_status_catfilters == 1) {
				$filters_text = 'true';
			}else{
				$filters_text = 'false';
			}

			echo '<section role="main">';
		        echo '<div class="pf-page-spacing"></div>';
		        echo '<div class="pf-container"><div class="pf-row clearfix">';
		        	if ($setup_item_searchresults_sidebarpos == 3) {
		        		echo '<div class="col-lg-12"><div class="pf-page-container">';

							echo do_shortcode('[pf_itemgrid2 filters="'.$filters_text.'" manualargs="'.$manualargs.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" itemboxbg="'.$setup22_searchresults_background2.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" infinite_scroll="'.$stp22_infscrl_s.'" infinite_scroll_lm="'.$stp22_infscrl_s2.'" ]' );


						echo '</div></div>';
		        	}else{
		        		if($setup_item_searchresults_sidebarpos == 1){
			                echo '<div class="col-lg-3 col-md-3">';
			                    get_sidebar('itemsearchres' ); 
			                echo '</div>';
			            }
			              
			            echo '<div class="col-lg-9 col-md-9"><div class="pf-page-container">'; 
			            echo do_shortcode('[pf_itemgrid2 filters="'.$filters_text.'" hidden_output="'.$hidden_output.'" manualargs="'.$manualargs.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" itemboxbg="'.$setup22_searchresults_background2.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" infinite_scroll="'.$stp22_infscrl_s.'" infinite_scroll_lm="'.$stp22_infscrl_s2.'" ]' );


			            echo '</div></div>';
			            if($setup_item_searchresults_sidebarpos == 2){
			                echo '<div class="col-lg-3 col-md-3">';
			                    get_sidebar('itemsearchres' );
			                echo '</div>';
			            }
		        	}
		            
		        echo '</div></div>';
		        echo '<div class="pf-page-spacing"></div>';
		    echo '</section>';
		}else{
			/* Half Map */

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

			echo do_shortcode('[pf_directory_half_map setup5_mapsettings_zoom="'.$setup42_searchpagemap_zoom.'" setup5_mapsettings_zoom_mobile="'.$setup42_searchpagemap_mobile.'" setup5_mapsettings_autofit="1" setup5_mapsettings_autofitsearch="1" setup5_mapsettings_type="'.$setup42_searchpagemap_type.'" setup5_mapsettings_business="'.$setup42_searchpagemap_business.'" setup5_mapsettings_streetViewControl="'.$setup42_searchpagemap_streetViewControl.'" mapsearch_status="1" mapnot_status="1" setup5_mapsettings_lat="'.$setup42_searchpagemap_lat.'" setup5_mapsettings_lng="'.$setup42_searchpagemap_lng.'" setup5_mapsettings_style="'.$setup42_searchpagemap_style.'" setup7_geolocation_status="0" listingtype="" itemtype="" conditions="" features ="" locationtype=""  termname="-" csauto=""]');
		}
			

		
	}else{
		if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}

		echo '<div class="pf-blogpage-spacing pfb-top"></div>';
		echo '<section role="main">';
			echo '<div class="pf-container">';
				echo '<div class="pf-row">';
					echo '<div class="col-lg-12">';
						
						get_template_part('loop');

					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</section>';
		echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
	}


get_footer();
?>