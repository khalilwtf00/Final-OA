<?php
add_action('pointfinder_schedule_hooks_hourly', 'send_entreprise_campaign');
function send_entreprise_campaign()
{
    global $wpdb;
    $table_infolettre = $wpdb->prefix . 'fp_infolettre';
    $nbr_annonces_min = 6; // Nombre d'annonces nécessaire pour envoyer une alerte
    $reccurence_max = 1209600; // Temps maximum entre chaque alerte (en secondes) / 1209600 = 2 semaines
    $dernier_envoi_trop_vieux = FALSE;
    // Infos des alertes
    $nom_infolettre = "Alerte OA";
    $annonces_details = array();
    $annonces_details['sujet'] = "Dernières annonces d'Occasions Affaires";
    $campaign_tag = "OA - Vente d’entreprises et de commerces";
    $campaign_name = "OA - Vente d’entreprises et de commerces - " . date("d F Y à H:i:s");
    $recipients["listIds"] = array(5);
    $recipients = (object) $recipients;
    $sender = array(
        'name' => "Occasions Affaires",
        'email' => 'marketing@occasionsaffaires.ca'
    );
    $sender = (object) $sender;

    // Récupère les dernières annonces depuis la dernière campagne envoyée
    $post_type_annonce = PFSAIssetControl('setup3_pointposttype_pt1', '', 'pfitemfinder');

    $args = array(
        'post_type'      => array($post_type_annonce),
        'post_status'    => array('publish'),
        'nopaging'       => false,
        'paged'          => '1',
        'posts_per_page' => '6',
        'tax_query'      => array(
            array(
                'taxonomy'         => 'pointfinderltypes',
                'terms'            => '1134',
                'include_children' => true,
            ),
        ),
    );

    // Récupère la date quand la dernière infolettre a été envoyée
    $date_dernier_envoi = $wpdb->get_var('SELECT date FROM ' . $table_infolettre . ' WHERE sent = 1 AND nom_infolettre = "' . $nom_infolettre . '" ORDER BY date DESC LIMIT 1');
    if ($date_dernier_envoi) {
        $args['date_query'] = array(
            array(
                'after' => $date_dernier_envoi,
            ),
        );
        $dernier_envoi_timestamp = strtotime($date_dernier_envoi);
        $date_now = time();
        $difference = $date_now - $dernier_envoi_timestamp;
        if ($difference >= $reccurence_max) {
            $dernier_envoi_trop_vieux = TRUE;
        }
    } else { // S'il n'y a jamais eu d'envoi
        $dernier_envoi_trop_vieux = TRUE;
    }

    $the_query = new WP_Query($args);
    // Détermine s'il faut envoyer l'infolettre ou non
    $envoyer_infolettre = FALSE;
    $nbr_annonces = $the_query->post_count;

    if (($dernier_envoi_trop_vieux || $nbr_annonces >= $nbr_annonces_min) && $nbr_annonces > 0) {
        $envoyer_infolettre = TRUE;
    } elseif ($nbr_annonces == 0) {
        $wpdb->insert(
            $table_infolettre,
            array(
                'nom_infolettre' => $nom_infolettre,
                'action'         => "Pas assez d'annonce",
                'nbr_annonces'   => 0,
                'sent'           => 0,
                'date'           => current_time('mysql')
            )
        );
    }

    if ($envoyer_infolettre && $the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            $item_id = get_the_ID();
            $item_title = get_the_title();

            if (has_post_thumbnail()) {
                $post_thumbnail_url_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                $post_thumbnail_url = aq_resize($post_thumbnail_url_full[0], 170, 128, true);
            } else {
                $post_thumbnail_url = get_stylesheet_directory_uri() . '/images/noimg_170x128.png';
            }

            // Autres infos
            $secteurs_activite = get_the_terms($item_id, 'pointfinderconditions');
            $secteur_activite = $secteurs_activite[0]->name;
            $lieux = get_the_terms($item_id, 'pointfinderlocations');
            $lieu = $lieux[0]->name;
            $prix = get_post_meta($item_id, 'webbupointfinder_item_prix', true);
            $url = get_permalink();

            $annonces_details['annonces'][] = array(
                'id'               => $item_id,
                'title'            => $item_title,
                'thumbnail'        => $post_thumbnail_url,
                'secteur_activite' => $secteur_activite,
                'lieu'             => $lieu,
                'prix'             => $prix,
                'url'              => $url
            );
        }
    }

    // Restore original Post Data
    wp_reset_postdata();

    if ($envoyer_infolettre) {
        error_log("envoie infolettre", 0);
        $current_date_UTC = current_time('Y-m-d\TH:i:s\Z', TRUE);
        $scheduled_date = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $current_date_UTC);
        $scheduled_date->modify('+1 day');
        $scheduled_date->setTime(10, 0);
        // récupère le offset de timezone avec gmt (pour gérer les heures avanceées)
        $this_tz = new DateTimeZone('America/New_York');
        $now = new DateTime("now", $this_tz);
        $offsetTimezone = $this_tz->getOffset($now);
        $offsetTimezone_formatted = -$offsetTimezone / 60 / 60;
        $formated_scheduled_date = $scheduled_date->format('Y-m-d\TH:i:s-0' . $offsetTimezone_formatted . ':00');

        require_once("template_alertes_html.php");
        if ($nbr_annonces < 2) {
            $annonces_details['pre_header'] = $nbr_annonces . " nouvelle annonce parue sur Occasions Affaires";
        } else {
            $annonces_details['pre_header'] = $nbr_annonces . " nouvelles annonces parues sur Occasions Affaires";
        }

        $template_html = template_alertes_html($annonces_details);

        $fields = array(
            "recipients"    => $recipients,
            "tag"           => $campaign_tag,
            "sender"        => $sender,
            "scheduledAt"   => $formated_scheduled_date,
            "name"          => $campaign_name,
            "subject"       => $annonces_details['sujet'],
            "replyTo"       => $sender->email,
            "toField"       => "[FIRST NAME] [LAST NAME]",
            "mirrorActive"  => FALSE,
            "recurring"     => FALSE,
            "type"          => "classic",
            "htmlContent"   => $template_html
        );
        $json_fields = json_encode($fields);

        $response = wp_remote_post(
            "https://api.brevo.com/v3/emailCampaigns",
            array(
                'headers' => array(
                    'Api-Key'      => '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',
                    'Content-Type' => 'application/json'
                ),
                'body'    => $json_fields
            )
        );

 $insert_result = $wpdb->insert(
    $table_infolettre,
    array(
                        'nom_infolettre' => $nom_infolettre,
                        'action'         => "Campagne programmée avec succès",
                        'nbr_annonces'   => $nbr_annonces,
                        'sent'           => 1,
                        'date'           => current_time('mysql') // on touche pas! (correct)
    )
);

if ( false === $insert_result ) {
    // Error occurred while inserting data into the database
    $wpdb_error = $wpdb->last_error;
    error_log( 'Error inserting data into the database: ' . $wpdb_error );
} else {
    // Data successfully inserted into the database
    error_log( 'Campaign data inserted successfully into the database.' );
}
    }
}
?>
