<?php
global $post;

$post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
$post_type_courtier = PFSAIssetControl('setup3_pointposttype_pt8','','pfitemfinder');

?>
<div class="vc_row wpb_row vc_row-fluid" style="padding-bottom:40px;">
  <div class="pf-container">
    <div class="pf-row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h2 id="pages">Pages</h2>
        <ul>
          <?php
          $list_page_array = array();
          $taxo_types_annonce =  get_terms( 'pointfinderltypes', array( 'hide_empty' => false, 'parent' => 0 ) );
          foreach($taxo_types_annonce as $taxo_type_annonce ) {
            $taxo_type_annonce_link = get_term_link( $taxo_type_annonce );
            $taxo_type_annonce_children = get_terms( 'pointfinderltypes', array( 'hide_empty' => false, 'parent' => $taxo_type_annonce->term_id ) );
            if(!empty($taxo_type_annonce_children)){
              $html_structure = '<li>
                                    <a href="'.$taxo_type_annonce_link.'" title="'.$taxo_type_annonce->description.'">'.$taxo_type_annonce->name.'</a>
                                    <ul>';
              foreach( $taxo_type_annonce_children as $taxo_type_annonce_child ) {
                $taxo_type_annonce_child_link = get_term_link( $taxo_type_annonce_child );
                $html_structure .= '  <li><a href="'.$taxo_type_annonce_child_link.'" title="'.$taxo_type_annonce_child->description.'">'.$taxo_type_annonce_child->name.'</a></li>';
              }
              $html_structure .= '  </ul>
                                  </li>';
              $list_page_array[$taxo_type_annonce->name] = $html_structure;
            }else{
              $list_page_array[$taxo_type_annonce->name] = '<li><a href="'.$taxo_type_annonce_link.'" title="'.$taxo_type_annonce->description.'">'.$taxo_type_annonce->name.'</a></li>';
            }
          }
          // Add pages you'd like to exclude in the exclude here
          $list_pages = get_pages(
            array(
              'exclude' => '1796,4,5419,5214,6137,6158,5957',
            )
          );
          foreach($list_pages as $list_page){
            $list_page_array[$list_page->post_title] = '<li><a href="'.get_page_link( $list_page->ID ) .'">'.$list_page->post_title.'</a></li>';
          }
          setlocale(LC_ALL,'fr_FR');
          ksort($list_page_array,SORT_LOCALE_STRING);
          foreach($list_page_array as $list_page_element){
            echo $list_page_element;
          }
          ?>
        </ul>

        <?php
        // Add categories you'd like to exclude in the exclude here
        $cats = get_categories('exclude=');
        foreach ($cats as $cat) {
          ?>
        <h2><?php echo $cat->cat_name; ?></h2>
        <ul>
          <?php
          //query_posts('posts_per_page=-1&amp;cat='.$cat->cat_ID);
          $articles = get_posts(
                        array(
                          'category' => $cat->cat_ID,
                          'numberposts' => -1,
                          'orderby' => 'title',
                          'order' => 'ASC',
                        )
                      );
          foreach($articles as $post){
            setup_postdata( $post );
            $category = get_the_category();
            // Only display a post link once, even if it's in multiple categories
            if ($category[0]->cat_ID == $cat->cat_ID) {
              ?>
              <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </li>
              <?php
            }
          }
          wp_reset_postdata();
          ?>
        </ul>
          <?php
        }
        ?>
        
        <h2 id="authors"><?php echo esc_html__('Brokers','pointfindert2d'); ?></h2>
        <ul>
          <?php
          $courtiers = get_posts(
                        array(
                          'post_type' => $post_type_courtier,
                          'numberposts' => -1,
                          'orderby' => 'title',
                          'order' => 'ASC',
                        )
                      );
          foreach($courtiers as $post){
            setup_postdata( $post );
            ?>
            <li>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
            <?php
          }
          wp_reset_postdata();
          ?>
        </ul>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h2><?php echo esc_html__('Ads','pointfindert2d'); ?></h2>
        <?php
        $taxo_types_annonce =  get_terms( 'pointfinderltypes', array( 'hide_empty' => false, 'parent' => 0 ) );
        foreach($taxo_types_annonce as $taxo_type_annonce ) {
          ?>
        <h3><?php echo $taxo_type_annonce->name; ?></h3>
          <?php
          $taxo_type_annonce_children = get_terms( 'pointfinderltypes', array( 'hide_empty' => false, 'parent' => $taxo_type_annonce->term_id ) );
          if(!empty($taxo_type_annonce_children)){
            foreach( $taxo_type_annonce_children as $taxo_type_annonce_child ) {
              ?>
        <h4><?php echo $taxo_type_annonce_child->name; ?></h4>
              <?php
              $annonces = get_posts(
                            array(
                              'post_type' => $post_type_annonce,
                              'numberposts' => -1,
                              'orderby' => 'date',
                              'order' => 'DESC',
                              'tax_query' => array(
                                array(
                                  'taxonomy' => 'pointfinderltypes',
                                  'field'    => 'slug',
                                  'terms'    => array( $taxo_type_annonce_child->slug )
                                )
                              )
                            )
                          );
              if($annonces){
                ?>
        <ul>
                <?php
                foreach($annonces as $post){
                  setup_postdata( $post );
                  ?>
          <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </li>
                  <?php
                }
                wp_reset_postdata();
                ?>
        </ul>
                <?php
              }
            }
          }else{
            $annonces = get_posts(
                          array(
                            'post_type' => $post_type_annonce,
                            'numberposts' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => array(
                              array(
                                'taxonomy' => 'pointfinderltypes',
                                'field'    => 'slug',
                                'terms'    => array( $taxo_type_annonce->slug )
                              )
                            )
                          )
                        );
            if($annonces){
              ?>
        <ul>
              <?php
              foreach($annonces as $post){
                setup_postdata( $post );
                ?>
                <li>
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
                <?php
              }
              wp_reset_postdata();
              ?>
        </ul>
              <?php
            }
          }
        }
        /*
        $terms = get_terms( array(
            'taxonomy' => 'pointfinderltypes',
            'hide_empty' => false,
            //'parent' => 0
        ) );
        foreach($terms as $term){
          echo '<pre>';
          echo var_dump($term);
          echo '</pre>';
          echo $term->name;
          //echo $term->term_id;
          echo '<ul>';
          $term_children = get_terms( array(
            'taxonomy' => 'pointfinderltypes',
            'hide_empty' => false,
            //'child_of' => $term->term_id,
            'parent' => "52"
          ) );
          foreach($term_children as $term_child){
            echo '<li>'.$term_child->name.'</li>';
          }
          echo '</ul>';
        }*/
        ?>
      </div>
    </div>
  </div>
</div>