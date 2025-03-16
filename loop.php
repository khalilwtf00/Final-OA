<?php 

  if ( is_front_page() || is_tag()) {
    $pfg_paged = (esc_sql(get_query_var('page'))) ? esc_sql(get_query_var('page')) : '';   
    if (empty($pfg_paged)) {
      $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
    }
  } else {
    $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
  }

  $mp_year = esc_sql( get_query_var('year') );
  $mp_month = esc_sql( get_query_var('monthnum') );
  $mp_day = esc_sql( get_query_var('day') );

  $args = array(
    'paged' => esc_sql($pfg_paged),
    'post_type' => array('post')
  );

  if (!empty($mp_day)) {$args['day'] = $day;}
  if (!empty($mp_month)) {$args['monthnum'] = $mp_month;}
  if (!empty($mp_year)) {$args['year'] = $mp_year;}

  $mp_mdate = esc_sql(get_query_var('m' ));
  if (!empty($mp_mdate)) {
    $mp_date_count = strlen($mp_mdate);

    switch ($mp_date_count) {
      case 8:
        $args['year'] = substr($mp_mdate, 0, 4);
        $args['monthnum'] = substr($mp_mdate, 4, 2);
        $args['day'] = substr($mp_mdate, 6, 2);
        break;
      case 6:
        $args['year'] = substr($mp_mdate, 0, 4);
        $args['monthnum'] = substr($mp_mdate, 4, 2);
        break;
      case 4:
        $args['year'] = substr($mp_mdate, 0, 4);
        break;
      
      default:
        # code...
        break;
    }
  }


  $pfp_cat = esc_sql(get_query_var('cat'));
  if (!empty($pfp_cat)) {
    $args['cat'] = $pfp_cat;
  }

  if(get_query_var('post_format')) {
    $args['tax_query'] = array(
      'relation' => 'OR',
      array(
        'taxonomy' => 'post_format',
        'field'    => 'slug',
        'terms'    => array( ''.esc_sql(get_query_var('post_format')).'' ),
      ),
    );
  }

  if(isset($_GET['author_name'])){
    $current_author = esc_sql(get_user_by('login',$author_name));
  }else{
    $current_author = get_userdata(intval($author));
  }

  if (isset($_GET['s'])) {
    $args['s'] = $_GET['s'];
  }

  if (isset($current_author->ID)) {
    $args['author'] = $current_author->ID;
  }

  if (is_page_template()) {
    $args['post_status'] = array('publish','private');
    $args['posts_per_page'] = get_option('posts_per_page');
  }
  
  $args['order'] = 'ASC';
  $args['orderby'] = 'name';

  get_template_part( 'admin/core/post', 'functions' );


  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ) {
    if (isset($_GET['s'])) {
      echo '<div class="pf-search-resulttag">';
      echo sprintf( esc_html__( '%s Result(s) found! ', 'pointfindert2d' ), $the_query->found_posts );
      echo '</div>';
    }
    while ($the_query->have_posts()) {
      $the_query->the_post(); 	
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(array('pointfinder-post','col-lg-3','col-md-4','col-sm-6','col-xs-12')); ?>>
        <div class="nouvelle-franchise-inner-wrapper">
          <?php
          if ( function_exists( 'get_post_format' )){
            switch (get_post_format()) {
              case 'aside':
                pf_singlepost_title_list();
                pf_singlepost_thumbnail_list_small();
                pf_singlepost_content();
                pf_singlepost_info_list();
                break;

              case 'audio':
                pf_singlepost_title_list();
                pf_singlepost_thumbnail_list_small();
                pf_singlepost_content();
                pf_singlepost_info_list();
                break;

              case 'chat':
                pf_singlepost_title_list();
                pf_singlepost_content();
                pf_singlepost_thumbnail_list_small();
                pf_singlepost_info_list();
                break;

              case 'gallery':
                pf_singlepost_title_list();
                pf_singlepost_content();
                pf_singlepost_info_list();
                break;

              case 'image':
                pf_singlepost_title_list();
                pf_singlepost_content_list();
                pf_singlepost_info_list();                       
                break;

              case 'video':
                pf_singlepost_title_list();
                pf_singlepost_content();
                pf_singlepost_info_list();
                break;

              case 'quote':
              case 'link':
              case 'status':
                pf_singlepost_title_list();
                pf_singlepost_content();
                pf_singlepost_info_list();
                break;
              
              default:
                //pf_singlepost_thumbnail_list();
                // OCCASION FRANCHISE
                // modification de la fonction mise en commentaire ci-haut
                if ( has_post_thumbnail() && wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) !== false) {
                  $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                  $large_image_urlforview = $large_image_url[0];
                  /*
                  if ($large_image_url[1]>=850) {
                    $large_image_urlforview = aq_resize($large_image_url[0],850,267,true);
                    $csstext = '';

                    if ($large_image_urlforview == false) {
                      $large_image_urlforview = $large_image_url[0];
                    }
                  }else{
                    $large_image_urlforview = aq_resize($large_image_url[0],$large_image_url[1],267,true);
                    $csstext = ' style="width:100%" ';
                    if ($large_image_urlforview == false) {
                      $large_image_urlforview = $large_image_url[0];
                    }
                  }
                  */
                  ?>
                  <div class="post-mthumbnail">
                    <div class="inner-postmthumb">
                      <a href="<?php echo get_the_permalink(); ?>">
                        <span class="vertica-align-helper"></span>
                        <img src="<?php echo $large_image_urlforview; ?>" class="attachment-full wp-post-image pf-wp-postimg"<?php echo $csstext; ?> />
                      </a>
                    </div>
                  </div>
                  <?php
                }
                pf_singlepost_title_list();
                ?>
                <div class="post-content clearfix">
                  <?php echo get_excerpt(185); ?>
                </div>
                <div class="nouvelle-franchise-infos">
                  <p><?php echo esc_html__('Personal contribution required:','pointfindert2d'); ?> <?php echo get_post_meta( $post->ID, 'nouvelle_franchise_apport_personnel', true ); ?></p>
                  <p><?php echo esc_html__('Total investment:','pointfindert2d'); ?> <?php echo get_post_meta( $post->ID, 'nouvelle_franchise_investissement_total', true ); ?></p>
                </div>
                <div class="post-minfo">
                  <a href="<?php echo get_the_permalink(); ?>" title="<?php echo esc_html__('Learn more about','pointfindert2d'); ?> <?php echo get_the_title(); ?>"><?php echo esc_html__('Learn more','pointfindert2d'); ?></a>
                </div>
                <?php
                break;
            }
          }else{
            pf_singlepost_title_list();
            pf_singlepost_content();
            pf_singlepost_info_list();
          }
          ?>
        </div>
      </article>
      
      <?php 
    }; 

  }else{ 

    PFPageNotFound();
    
  };
  echo '<div class="pfstatic_paginate clearfix">';
  $big = 999999999;
  echo paginate_links(array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '?paged=%#%',
      'current' => max(1, $pfg_paged),
      'total' => $the_query->max_num_pages,
      'type' => 'list',
  ));
  echo '</div>';
  wp_reset_postdata();
?>