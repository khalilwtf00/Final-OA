<?php

function template_alertes_html($annonces_details){
  $debut = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="apple-mobile-web-app-capable" content="yes" /><meta name="apple-mobile-web-app-status-bar-style" content="black" /><meta name="format-detection" content="telephone=no" /><title>'.$annonces_details['sujet'].'</title><style type="text/css">
        /* Resets */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        a[x-apple-data-detectors]{
            color:inherit !important;
            text-decoration:none !important;
            font-size:inherit !important;
            font-family:inherit !important;
            font-weight:inherit !important;
            line-height:inherit !important;
        }        
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        .yshortcuts a {border-bottom: none !important;}
        .rnb-del-min-width{ min-width: 0 !important; }

        /* Add new outlook css start */
        .templateContainer{
            max-width:590px !important;
            width:auto !important;
        }
        /* Add new outlook css end */

        /* Image width by default for 3 columns */
        img[class="rnb-col-3-img"] {
        max-width:170px;
        }

        /* Image width by default for 2 columns */
        img[class="rnb-col-2-img"] {
        max-width:264px;
        }

        /* Image width by default for 2 columns aside small size */
        img[class="rnb-col-2-img-side-xs"] {
        max-width:180px;
        }

        /* Image width by default for 2 columns aside big size */
        img[class="rnb-col-2-img-side-xl"] {
        max-width:350px;
        }

        /* Image width by default for 1 column */
        img[class="rnb-col-1-img"] {
        max-width:550px;
        }

        /* Image width by default for header */
        img[class="rnb-header-img"] {
        max-width:590px;
        }

        /* Ckeditor line-height spacing */
        .rnb-force-col p, ul, ol{margin:0px!important;}
        .rnb-del-min-width p, ul, ol{margin:0px!important;}

        /* tmpl-2 preview */
        .rnb-tmpl-width{ width:100%!important;}

        /* tmpl-11 preview */
        .rnb-social-width{padding-right:15px!important;}

        /* tmpl-11 preview */
        .rnb-social-align{float:right!important;}

        @media only screen and (min-width:590px){
        /* mac fix width */
        .templateContainer{width:590px !important;}
        }

        @media screen and (max-width: 360px){
        /* yahoo app fix width "tmpl-2 tmpl-10 tmpl-13" in android devices */
        .rnb-yahoo-width{ width:360px !important;}
        }

        @media screen and (max-width: 380px){
        /* fix width and font size "tmpl-4 tmpl-6" in mobile preview */
        .element-img-text{ font-size:24px !important;}
        .element-img-text2{ width:230px !important;}
        .content-img-text-tmpl-6{ font-size:24px !important;}
        .content-img-text2-tmpl-6{ width:220px !important;}
        }

        @media screen and (max-width: 480px) {
        td[class="rnb-container-padding"] {
        padding-left: 10px !important;
        padding-right: 10px !important;
        }

        /* force container nav to (horizontal) blocks */
        td.rnb-force-nav {
        display: inherit;
        }
        }

        @media only screen and (max-width: 600px) {

        /* center the address &amp; social icons */
        .rnb-text-center {text-align:center !important;}

        /* force container columns to (horizontal) blocks */
        td.rnb-force-col {
        display: block;
        padding-right: 0 !important;
        padding-left: 0 !important;
        width:100%;
        }

        table.rnb-container {
         width: 100% !important;
        }

        table.rnb-btn-col-content {
        width: 100% !important;
        }
        table.rnb-col-3 {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;

        /* change left/right padding and margins to top/bottom ones */
        margin-bottom: 10px;
        padding-bottom: 10px;
        /*border-bottom: 1px solid #eee;*/
        }

        table.rnb-last-col-3 {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;
        }

        table[class~="rnb-col-2"] {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;

        /* change left/right padding and margins to top/bottom ones */
        margin-bottom: 10px;
        padding-bottom: 10px;
        /*border-bottom: 1px solid #eee;*/
        }

        table.rnb-col-2-noborder-onright {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;

        /* change left/right padding and margins to top/bottom ones */
        margin-bottom: 10px;
        padding-bottom: 10px;
        }

        table.rnb-col-2-noborder-onleft {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;

        /* change left/right padding and margins to top/bottom ones */
        margin-top: 10px;
        padding-top: 10px;
        }

        table.rnb-last-col-2 {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;
        }

        table.rnb-col-1 {
        /* unset table align="left/right" */
        float: none !important;
        width: 100% !important;
        }

        img.rnb-col-3-img {
        /**max-width:none !important;**/
        width:100% !important;
        }

        img.rnb-col-2-img {
        /**max-width:none !important;**/
        width:100% !important;
        }

        img.rnb-col-2-img-side-xs {
        /**max-width:none !important;**/
        width:100% !important;
        }

        img.rnb-col-2-img-side-xl {
        /**max-width:none !important;**/
        width:100% !important;
        }

        img.rnb-col-1-img {
        /**max-width:none !important;**/
        width:100% !important;
        }

        img.rnb-header-img {
        /**max-width:none !important;**/
        width:100% !important;
        margin:0 auto;
        }

        img.rnb-logo-img {
        /**max-width:none !important;**/
        width:100% !important;
        }

        td.rnb-mbl-float-none {
        float:inherit !important;
        }

        .img-block-center{text-align:center !important;}

        .logo-img-center
        {
            float:inherit !important;
        }

        /* tmpl-11 preview */
        .rnb-social-align{margin:0 auto !important; float:inherit !important;}

        /* tmpl-11 preview */
        .rnb-social-center{display:inline-block;}

        /* tmpl-11 preview */
        .social-text-spacing{margin-bottom:0px !important; padding-bottom:0px !important;}

        /* tmpl-11 preview */
        .social-text-spacing2{padding-top:15px !important;}

    }</style><!--[if gte mso 11]><style type="text/css">table{border-spacing: 0; }table td {border-collapse: separate;}</style><![endif]--><!--[if !mso]><!--><style type="text/css">table{border-spacing: 0;} table td {border-collapse: collapse;}</style> <!--<![endif]--><!--[if gte mso 15]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--><!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--></head><body>

<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" class="main-template" bgcolor="#f9fafc" style="background-color:#f9fafc;">
  <tbody><tr style="display:none !important; font-size:1px; mso-hide: all;"><td>'.$annonces_details['pre_header'].'</td><td></td></tr>
    <tr>
      <td align="center" valign="top">
        <!--[if gte mso 9]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="590" style="width:590px;">
        <tr>
        <td align="center" valign="top" width="590" style="width:590px;">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="max-width:590px!important; width: 590px;">
          <tbody>
            <tr>
              <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <div>
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="590" style="width:590px;">
                <![endif]-->
            <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:100%; background-color:#f9fafc;" name="Layout_13">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="background-color: #f9fafc;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#f9fafc" style="background-color: rgb(249, 250, 252); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">

                                        <tbody><tr>
                                            <td height="20" style="font-size:1px; line-height:1px;"> </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="rnb-container-padding" bgcolor="#f9fafc" style="background-color: #f9fafc;" align="left">

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
                                                    <tbody><tr>
                                                        <td class="rnb-force-col" valign="top" style="padding-right: 0px;">

                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left" class="rnb-col-1">

                                                                <tbody><tr>
                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div style="line-height: 16px; text-align: center;"><span style="font-size:11px;"><span style="color:#808080;">Si vous avez de la difficulté à visionner ce courriel,</span> <a href="{{ mirror }}" style="text-decoration: underline; color: rgb(52, 153, 219);">ouvrez-le dans votre navigateur</a>.</span></div>
</td>
                                                                </tr>
                                                                </tbody></table>

                                                            </td></tr>
                                                </tbody></table></td>
                                        </tr>
                                        <tr>
                                            <td height="20" style="font-size:1px; line-height:1px;border-bottom:0px;"> </td>
                                        </tr>
                                    </tbody></table>
                    </td>
                </tr>
            </tbody></table><!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->

              </div></td>
            </tr>
            <tr>

        <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <div>
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="590" style="width:590px;">
                <![endif]-->
            <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:590px; background-color:#f9fafc;" name="Layout_1" id="Layout_1">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="min-width:590px; background-color: #f9fafc;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); border-radius: 0px; padding-left: 20px; padding-right: 20px; border-collapse: separate;">
                            <tbody><tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                            <tr>
                                <td valign="top" class="rnb-container-padding" bgcolor="#ffffff" style="background-color: #ffffff;" align="left">
                                    <table width="100%" cellpadding="0" border="0" align="center" cellspacing="0">
                                        <tbody><tr>
                                            <td valign="top" align="center">
                                                <table cellpadding="0" border="0" align="center" cellspacing="0" class="logo-img-center"> 
                                                    <tbody><tr>
                                                        <td valign="middle" align="center">
                                                            <div style="border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block; " cellspacing="0" cellpadding="0" border="0"><div><a style="text-decoration:none;" target="_blank" href="https://occasionsaffaires.ca"><img width="340" vspace="0" hspace="0" border="0" alt="Occasions Affaires" style="float: left;max-width:340px;" class="rnb-logo-img" src="http://img.mailinblue.com/2042699/images/rnb/original/5c0e91d88145233681168401.png"></a></div></div></td>
                                                    </tr>
                                                </tbody></table>
                                                </td>
                                        </tr>
                                    </tbody></table></td>
                            </tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
            <!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
              </div></td>
            </tr>
            <tr>
              <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <div>

                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="590" style="width:590px;">
                <![endif]-->
            
            <table width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="background-color:#f9fafc;" name="Layout_" id="Layout_"><tbody><tr>
                    <td align="center" valign="top" bgcolor="#f9fafc" style="background-color: #f9fafc;"><table border="0" width="100%" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="height: 0px; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding-left: 20px; padding-right: 20px;"><tbody><tr>
                                <td class="rnb-container-padding" bgcolor="#ffffff" style="background-color: #ffffff; font-size: px;font-family: ; color: ;">

                                    <table border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container" align="center" style="margin:auto;">
                                        <tbody><tr>

                                            <td class="rnb-force-col" align="center">

                                                <table border="0" cellspacing="0" cellpadding="0" align="center" class="rnb-col-1">

                                                    <tbody><tr>
                                                        <td height="10"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style="font-family:Arial,Helvetica,sans-serif; color:#3c4858; text-align:center;">

                                                            <span style="color:#3c4858;"><strong><span style="font-size:16px;">'.$annonces_details['sujet'].'</span></strong></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10"></td>
                                                    </tr>
                                                    </tbody></table>
                                                </td></tr>
                                    </tbody></table></td>
                            </tr>

                        </tbody></table>

                    </td>
                </tr>

            </tbody></table><!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
              </div></td>
            </tr>';
  $fin = '<tr>
              <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">
                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px; background-color:#f9fafc;" name="Layout_" id="Layout_">
                  <tbody>
                    <tr>
                      <td class="rnb-del-min-width" valign="top" align="center" bgcolor="#f9fafc" style="min-width:590px; background-color:#f9fafc;">
                        <table width="100%" cellpadding="0" border="0" height="30" cellspacing="0" bgcolor="#f9fafc" style="background-color:#f9fafc;">
                          <tbody>
                            <tr>
                              <td valign="top" height="30">
                                <img width="20" height="30" style="display:block; max-height:30px; max-width:20px;" alt="" src="http://img.mailinblue.com/new_images/rnb/rnb_space.gif">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>

        <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:590px; background-color:#f9fafc;" name="Layout_" id="Layout_">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="min-width:590px; background-color: #f9fafc;">
                        <table width="590" class="rnb-container" cellpadding="0" border="0" align="center" cellspacing="0">
                            <tbody><tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                            <tr>
                                <td valign="top" class="rnb-container-padding" style="font-size: 14px; font-family: Arial,Helvetica,sans-serif; color: #888888;" align="left">

                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
                                        <tbody><tr>
                                            <td class="rnb-force-col" style="padding-right:20px; padding-left:20px; mso-padding-alt: 0 0 0 20px;" valign="top">

                                                <table border="0" valign="top" cellspacing="0" cellpadding="0" width="264" align="left" class="rnb-col-2" style="border-bottom:0;">

                                                    <tbody><tr>
                                                        <td valign="top">
                                                            <table cellpadding="0" border="0" align="left" cellspacing="0" class="rnb-btn-col-content">
                                                                <tbody><tr>
                                                                    <td valign="middle" align="left" style="font-size:14px; font-family:Arial,Helvetica,sans-serif; color:#888888;" class="rnb-text-center">
                                                                        <div><div><span style="font-size:12px;">Réseau Franchise Performance<br>
<a href="mailto:marketing@occasionsaffaires.ca" style="text-decoration: underline; color: rgb(102, 102, 102);">marketing@occasionsaffaires.ca</a></span></div>
</div>
                                                                    </td></tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                                </td><td ng-if="item.text.align==\'left\'" class="rnb-force-col rnb-social-width" valign="top" style="mso-padding-alt: 0 20px 0 0; padding-right: 15px;">

                                                <table border="0" valign="top" cellspacing="0" cellpadding="0" width="246" align="right" class="rnb-last-col-2">

                                                    <tbody><tr>
                                                        <td valign="top">
                                                            <table cellpadding="0" border="0" cellspacing="0" class="rnb-social-align" style="float: right;" align="right">
                                                                <tbody><tr>
                                                                    <td valign="middle" class="rnb-text-center" ng-init="width=setSocialIconsBlockWidth(item)" width="85" align="right">
                                                                        <div class="rnb-social-center">
                                                                        <table align="left" style="float:left; display: inline-block; mso-table-lspace:0pt; mso-table-rspace:0pt;" border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody><tr>
                                                                                <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 2px 5px 0px;" align="left">
                                                                        <span style="color:#ffffff; font-weight:normal;">
                                                                            <a target="_blank" href="https://www.facebook.com/Occasions.Affaires.Quebec"><img alt="Facebook" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="http://img.mailinblue.com/new_images/rnb/theme2/rnb_ico_fb.png"></a></span>
                                                                        </td></tr></tbody></table>
                                                                        </div><div class="rnb-social-center">
                                                                        <table align="left" style="float:left; display: inline-block; mso-table-lspace:0pt; mso-table-rspace:0pt;" border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody><tr>
                                                                                <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 2px 5px 0px;" align="left">
                                                                        <span style="color:#ffffff; font-weight:normal;">
                                                                            <a target="_blank" href="https://www.linkedin.com/in/occasion-franchise-963505105/"><img alt="LinkedIn" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="http://img.mailinblue.com/new_images/rnb/theme2/rnb_ico_in.png"></a></span>
                                                                        </td></tr></tbody></table>
                                                                        </div></td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                                </td></tr>
                                    </tbody></table></td>
                            </tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                        </tbody></table>

                    </td>
                </tr></tbody></table>
            </td>
    </tr><tr>

        <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <div>
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="590" style="width:590px;">
                <![endif]-->
            <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:100%; background-color:#f9fafc;" name="Layout_16">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="background-color: #f9fafc;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#f9fafc" style="background-color: rgb(249, 250, 252); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">

                                        <tbody><tr>
                                            <td height="20" style="font-size:1px; line-height:1px;"> </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="rnb-container-padding" bgcolor="#f9fafc" style="background-color: #f9fafc;" align="left">

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
                                                    <tbody><tr>
                                                        <td class="rnb-force-col" valign="top" style="padding-right: 0px;">

                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left" class="rnb-col-1">

                                                                <tbody><tr>
                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div style="line-height: 16px; text-align: center;"><span style="color:#808080;"><span style="font-size:11px;">Ce courriel a été envoyé à {{EMAIL}}.<br>
Vous avez reçu ce courriel parce que vous êtes inscrit aux alertes d’annonces récentes d’Occasions Affaires.<br>
Pour ne plus recevoir cette infolettre, <a href="{{UNSUBSCRIBE}}" style="text-decoration: underline; color: rgb(52, 153, 219);">désabonnez-vous ici</a>.</span></span></div>
</td>
                                                                </tr>
                                                                </tbody></table>

                                                            </td></tr>
                                                </tbody></table></td>
                                        </tr>
                                        <tr>
                                            <td height="20" style="font-size:1px; line-height:1px;border-bottom:0px;"> </td>
                                        </tr>
                                    </tbody></table>
                    </td>
                </tr>
            </tbody></table><!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->

            </div></td>
    </tr><tr>

        <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">

            <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:590px; background-color:#f9fafc;" name="Layout_4" id="Layout_4">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="min-width:590px; background-color: #f9fafc;">
                        <table width="590" class="rnb-container rnb-yahoo-width" cellpadding="0" border="0" align="center" cellspacing="0" style="padding-right:20px; padding-left:20px;">
                            <tbody><tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                            <tr>
                                <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif;">
                                    <div><div>© 2025 Réseau Franchise Performance inc.</div>
</div>
                                </td></tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
            </td>
    </tr></tbody></table>
            <!--[if gte mso 9]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                        </td>
        </tr>
        </tbody></table>

</body></html>';

  $count_annonce = 1;
  $total_count_annonce = 0;
  $total_annonces = count($annonces_details['annonces']);
  $html_annonces = '';
  foreach($annonces_details['annonces'] as $annonce){
    $total_count_annonce++;
    if($count_annonce == 1){
      $html_annonces .= '<tr>
              <td align="center" valign="top" bgcolor="#f9fafc" style="background-color:#f9fafc;">
                <div>
                  <!--[if mso]>
                  <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                  <tr>
                  <![endif]-->
                  
                  <!--[if mso]>
                  <td valign="top" width="590" style="width:590px;">
                  <![endif]-->
                  <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" bgcolor="#f9fafc" style="min-width:100%; background-color:#f9fafc;" name="Layout_5" id="Layout_5">
                    <tbody>
                      <tr>
                        <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#f9fafc" style="background-color: #f9fafc;">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding-left: 20px; padding-right: 20px;">
                            <tbody>
                              <tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                              </tr>
                              <tr>
                                <td valign="top" class="rnb-container-padding" bgcolor="#ffffff" style="background-color: #ffffff;" align="left">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
                                    <tbody>
                                      <tr>';
    }
    
    $padding = "20px";
    $class = "rnb-col-3";
    if($count_annonce == 3){ // troisième annonce#
      $padding = "0px";
      $class = "rnb-last-col-3";
    }
    $html_annonces .= '<td class="rnb-force-col" width="170" valign="top" style="padding-right: '.$padding.';">
                                          <table border="0" valign="top" cellspacing="0" cellpadding="0" align="left" class="'.$class.'" width="170">
                                            <tbody>
                                              <tr>
                                                <td width="100%" class="img-block-center" valign="top" align="left">
                                                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                      <tr>
                                                        <td width="100%" valign="top" align="left" class="img-block-center">
                                                          <table style="display: inline-block;" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                              <tr>
                                                                <td>
                                                                  <div style="border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;">
                                                                    <div>
                                                                      <a target="_blank" href="'.$annonce['url'].'">
                                                                        <img border="0" width="170" hspace="0" vspace="0" alt="" class="rnb-col-3-img" src="'.$annonce['thumbnail'].'" style="vertical-align: top; max-width: 940px; float: left;">
                                                                      </a>
                                                                    </div>
                                                                    <div style="clear:both;"></div>
                                                                  </div>
                                                                </td>
                                                              </tr>
                                                            </tbody>
                                                          </table>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td height="6" class="col_td_gap" style="font-size:1px; line-height:1px;"> </td>
                                              </tr>
                                              <tr>
                                                <td style="font-size:24px; font-family:Arial,Helvetica,sans-serif; color:#3c4858; text-align:left;">
                                                  <span style="color:#3c4858; "><div style="line-height:16px;"><a href="'.$annonce['url'].'" style="text-decoration: none; color: rgb(57, 61, 64);"><span style="font-size:14px;"><strong>'.$annonce['title'].'</strong></span></a></div></span>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td height="6" class="col_td_gap" style="font-size:1px; line-height:1px;"> </td>
                                              </tr>
                                              <tr>
                                                <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
                                                  <div>
                                                    <div><span style="font-size:12px;"><strong>Type :</strong> '.$annonce['secteur_activite'].'</span></div>
                                                    <div><span style="font-size:12px;"><strong>Lieu :</strong> '.$annonce['lieu'].'</span></div>
                                                    <div><span style="font-size:12px;"><strong>Prix :</strong> '.$annonce['prix'].'</span></div>
                                                  </div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td height="6" class="col_td_gap" style="font-size:1px; line-height:1px;"> </td>
                                              </tr>
                                              <tr>
                                                <td valign="top">
                                                  <table cellpadding="0" border="0" align="left" cellspacing="0" class="rnb-btn-col-content" style="border-collapse: separate;margin:0 auto;">
                                                    <tbody>
                                                      <tr>
                                                        <td width="auto" valign="middle" bgcolor="#2f89c4" align="left" height="32" style="font-size:14px; font-family:Arial,Helvetica,sans-serif; text-align:center; color:#ffffff; font-weight:normal; padding-left:18px; padding-right:18px; background-color:#2f89c4; border-radius:0px;border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;">
                                                          <span style="color:#ffffff; font-weight:normal;">
                                                            <a style="text-decoration:none; color:#ffffff; font-weight:normal;" target="_blank" href="'.$annonce['url'].'">Voir l’annonce</a>
                                                          </span>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>';
    
    if(
      $count_annonce < 3
      &&
      $total_count_annonce == $total_annonces
    ){ // Détermine le nombre de colonne manquante pour terminer une ligne
      $colonnes_manquantes = 3 - $count_annonce;
      for ($i = 1; $i <= $colonnes_manquantes; $i++) {
        $padding = "20px";
        $class = "rnb-col-3";
        if($i == $colonnes_manquantes){ // troisième annonce#
          $padding = "0px";
          $class = "rnb-last-col-3";
        }
        $html_annonces .= '<td class="rnb-force-col" width="170" valign="top" style="padding-right: '.$padding.';">
                            <table border="0" valign="top" cellspacing="0" cellpadding="0" align="left" class="'.$class.'" width="170">
                              <tbody>
                                <tr></tr>
                              </tbody>
                            </table>
                          </td>';
      }
    }
    
    if(
      $count_annonce == 3
      ||
      $total_count_annonce == $total_annonces
    ){
      $html_annonces .= '</tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td height="20" style="font-size:1px; line-height:1px;"> </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table><!--[if mso]>
                  </td>
                  <![endif]-->
                  
                  <!--[if mso]>
                  </tr>
                  </table>
                  <![endif]-->
                </div>
              </td>
            </tr>';
    }
    
    $count_annonce++;
    if($count_annonce == 4){
      $count_annonce = 1;
    }
  }
  
  return $debut . $html_annonces . $fin;
}

?>