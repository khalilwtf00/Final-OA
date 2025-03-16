    <?php
    
    if (!is_page_template('pf-empty-page.php' ) && !is_page_template('terms-conditions.php' )) {
      $setup42_searchpagemap_headeritem = PFSAIssetControl('setup42_searchpagemap_headeritem','','1');
      $general_ct_page_layout = PFSAIssetControl('general_ct_page_layout','','1');
      ?>
      </div>
    </div>

    <div id="pf-membersystem-dialog"></div>
    <a title="<?php echo esc_html__('Back to Top','pointfindert2d'); ?>" class="pf-up-but"><i class="pfadmicon-glyph-859"></i></a>
      <?php 
      $processpage = true;

      if (is_search() && $setup42_searchpagemap_headeritem == 2) {
        $processpage = false;
      }
      if(
        (is_category() || is_tax() || is_archive())
        &&
        $general_ct_page_layout == 3
        ){
        $processpage = false;
      }
      
      if ($processpage) {
        /*
        * Start: Footer Row option
        */
        global $post;
       if (isset($post) && is_object($post) && isset($post->ID)) {
    $webbupointfinder_gbf_status = get_post_meta($post->ID, 'webbupointfinder_gbf_status', true);
} else {
    $webbupointfinder_gbf_status = ''; // Set a default value if $post is not available
}

          if (PFASSIssetControl('gbf_status','',0) == 1 || !empty($webbupointfinder_gbf_status)) {
            $footer_row1 = $footer_row2 = $footer_row3 = $footer_row4 = '';

            if (!empty($webbupointfinder_gbf_status)) {
              $footer_cols = get_post_meta( $post->ID, 'webbupointfinder_gbf_cols', true );

              $footer_row1 = get_post_meta( $post->ID, 'webbupointfinder_gbf_sidebar1', true );
              $footer_row2 = get_post_meta( $post->ID, 'webbupointfinder_gbf_sidebar2', true );
              $footer_row3 = get_post_meta( $post->ID, 'webbupointfinder_gbf_sidebar3', true );
              $footer_row4 = get_post_meta( $post->ID, 'webbupointfinder_gbf_sidebar4', true );

              $gbfooterrowstatus = ' gbfooterrow=""';
              $pgfooterrowstatus = ' pgfooterrow="yes"';
              $pgfooterrow = 1;

            }elseif (empty($webbupointfinder_gbf_status) && PFASSIssetControl('gbf_status','',0) == 1) {
              $footer_cols = PFASSIssetControl('gbf_cols','',4);

              $footer_row1 = PFASSIssetControl('gbf_sidebar1','','');
              $footer_row2 = PFASSIssetControl('gbf_sidebar2','','');
              $footer_row3 = PFASSIssetControl('gbf_sidebar3','','');
              $footer_row4 = PFASSIssetControl('gbf_sidebar4','','');

              $gbfooterrowstatus = ' gbfooterrow="yes"';
              $pgfooterrowstatus = ' pgfooterrow=""';
            }
            
            if ($pgfooterrow == 0) {
              $text_bouton = esc_html__('Subscribe to our newsletter','pointfindert2d');
              echo do_shortcode('[vc_row content_placement="middle" widthopt="" fixedbg="" footerrow="" css=".vc_custom_1523041057431{padding-top: 20px !important;padding-bottom: 20px !important;background-color: #86ba40 !important;}"][vc_column width="1/2"][vc_single_image image="6951" img_size="full"][/vc_column][vc_column width="1/2" css=".vc_custom_1523041232713{margin-bottom: 0px !important;}"][vc_btn title="'.$text_bouton.'" style="outline-custom" custom_background="#1e73be" outline_custom_color="#ffffff" outline_custom_hover_background="#ffffff" outline_custom_hover_text="#1e73be" align="right" link="url:'.urlencode(get_permalink(5227)).'"][/vc_column][/vc_row]');
              echo '<div class="wpf-footer-row-move">';
            }else{
              echo '<div class="wpf-footer-row-move wpf-footer-row-movepg">';
            }
            
            $foutput = '';
            $foutput .= '[vc_row footerrow=""'.$gbfooterrowstatus.$pgfooterrowstatus.']';

            switch ($footer_cols) {
              case 4:
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row1.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row2.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row3.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row4.'"][/vc_column]';
                break;

              case 3:
                $foutput .= '[vc_column width="1/3" el_id="footer_of_left" offset="vc_col-sm-4"][vc_widget_sidebar sidebar_id="'.$footer_row1.'"][/vc_column]';
                $foutput .= '[vc_column width="1/3" el_id="footer_of_center" offset="vc_col-sm-4"][vc_widget_sidebar sidebar_id="'.$footer_row2.'"][/vc_column]';
                $foutput .= '[vc_column width="1/3" el_id="footer_of_right" offset="vc_col-sm-4"][vc_widget_sidebar sidebar_id="'.$footer_row3.'"][/vc_column]';
                break;

              case 2:
                $foutput .= '[vc_column width="1/2"][vc_widget_sidebar sidebar_id="'.$footer_row1.'"][/vc_column]';
                $foutput .= '[vc_column width="1/2"][vc_widget_sidebar sidebar_id="'.$footer_row2.'"][/vc_column]';
                break;

              case 1:
                $foutput .= '[vc_column width="1/1"][vc_widget_sidebar sidebar_id="'.$footer_row1.'"][/vc_column]';
                break;
              
              default:
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row1.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row2.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row3.'"][/vc_column]';
                $foutput .= '[vc_column width="1/4"][vc_widget_sidebar sidebar_id="'.$footer_row4.'"][/vc_column]';
                break;
            }
            
            $foutput .= '[/vc_row]';
            echo do_shortcode($foutput);
          }else{
            echo '<div class="wpf-footer-row-move">';
          }
        //}
          
      /*
      * End: Footer Row option
      */
      }
      ?>
    </div>
      <?php
      $setup_footerbar_status = PFSAIssetControl('setup_footerbar_status','','1');
      if ($setup_footerbar_status == 1 && $processpage) {
        ?>
    <footer class="wpf-footer">
        <?php
        $setup_footerbar_text_copy = PFSAIssetControl('setup_footerbar_text_copy','','');
        $setup_footerbar_width = PFSAIssetControl('setup_footerbar_width','','0');


        if ($setup_footerbar_width == 0) {
          echo '<div class="pf-container"><div class="pf-row clearfix">';
        }
        ?>
      <div class="wpf-footer-text col-lg-12">
          <?php echo wp_kses_post($setup_footerbar_text_copy);?>
      </div>
        <?php 
        if (PFSAIssetControl('setup_footerbar_text_copy_align','','left') == 'right') {
           $footer_menu_text = ' pfleftside';
        }else{
            $footer_menu_text = ' pfrightside';
        }
        echo '<ul class="pf-footer-menu'.$footer_menu_text.'">';pointfinder_footer_navigation_menu();echo '</ul>';?>
        <?php 
        if ($setup_footerbar_width == 0) {
          echo '</div></div>';
        }
        ?>
    </footer>

    <div id="iyzipay-checkout-form" class="popup"></div>
        <?php 
      }
    }
    
    wp_footer();
    
    ?>
	</body>
</html>