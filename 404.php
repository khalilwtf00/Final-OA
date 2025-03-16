<?php get_header(); ?>

    <section role="main">
      <div class="pf-container">
        <div class="pf-row">
          <div class="col-lg-12">
            <form method="get" class="form-search" action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
              <div class="pf-notfound-page" style="margin:50px auto 70px auto;">
                  <h1>404</h1>
                  <h2 style="margin-bottom:30px;"><?php esc_html_e( 'Page not found', 'pointfindert2d' ); ?></h2>
                  <p><?php _e("Explorez <a href='".site_url()."' style='text-decoration:underline;color:#689031;'>nos annonces d'entreprises à vendre au Québec</a> ou notre <a href='".get_category_link(49)."' style='text-decoration:underline;color:#689031;'>répertoire de franchises et d'occasions d'affaires</a>.",'pointfindert2d');?></p>
                  <p><?php _e("Naviguez <strong>par emplacement</strong>, <strong>par secteur d'activité</strong> ou directement par le champ de recherche suivant:",'pointfindert2d'); ?></p>
                  <div class="row">
                    <div class="pfadmdad input-group col-sm-4 col-sm-offset-4">
                      <i class="pfadmicon-glyph-386"></i>
                      <input type="text" name="s" class="form-control" onclick="this.value='';"  onfocus="if(this.value==''){this.value=''};" onblur="if(this.value==''){this.value=''};" value="<?php esc_html_e( 'Search', 'pointfindert2d' ); ?>">
                      <span class="input-group-btn"><button onc class="btn btn-success" type="submit"><?php esc_html_e( 'Search', 'pointfindert2d' ); ?></button></span>
                    </div>
                  </div>
                  <p style="margin:30px 0"><a class="btn btn-primary btn-sm" href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e( 'Else, return home', 'pointfindert2d' ); ?></a></p>
                  <p style="font-style:italic;color:#666;"><?php _e("Occasions Affaires est le meilleur site web spécialisé dans les opportunités d'affaires au Québec",'pointfindert2d'); ?></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

<?php get_footer(); ?>