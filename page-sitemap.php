<?php
/*
Template Name: Sitemap Page
*/
get_header();

the_post();
$post_id = get_the_id();

if(PFSAIssetControl('setup4_membersettings_loginregister','','1') == 1){
  get_template_part('admin/estatemanagement/includes/pages/dashboard/dashboard','ipnlistener');
  get_template_part('admin/estatemanagement/includes/pages/dashboard/dashboard','page');
  get_template_part('/partials/sitemap');
}else{
  if(function_exists('PFGetHeaderBar')){
    PFGetHeaderBar($post_id);
  }

  if (!has_shortcode( get_the_content() , 'vc_row' )) {
    echo '<div class="pf-blogpage-spacing pfb-top"></div>
          <section role="main">
            <div class="pf-container">
              <div class="pf-row">
                <div class="col-lg-12">';
                  the_content();
                  get_template_part('/partials/sitemap');
                  echo '
                </div>
              </div>
            </div>
          </section>
          <div class="pf-blogpage-spacing pfb-bottom"></div>';
  }else{
    the_content();
    get_template_part('/partials/sitemap');
  }
}

get_footer(); 
?>