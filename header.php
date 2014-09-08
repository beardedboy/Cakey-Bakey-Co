<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title(''); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
        <style>
            @font-face {
                    font-family: "cakeybakeyco";
                    src:url("<?php bloginfo('template_directory'); ?>/fonts/cakeybakeyco.eot");
                    src:url("<?php bloginfo('template_directory'); ?>/fonts/cakeybakeyco.eot?#iefix") format("embedded-opentype"),
                    url("<?php bloginfo('template_directory'); ?>/fonts/cakeybakeyco.woff") format("woff"),
                    url("<?php bloginfo('template_directory'); ?>/fonts/cakeybakeyco.ttf") format("truetype"),
                    url("<?php bloginfo('template_directory'); ?>/fonts/cakeybakeyco.svg#cakeybakeyco") format("svg");
                    font-weight: normal;
                    font-style: normal;
            }
        </style>
        <?php wp_head(); ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class = "container">
        <header class = "main_header">
            <div class = "main_header_row">
                <div class = "main_header_row-header">
                    <div class = "logo_container">
                        <a class = "logo_home_link" href = "<?php get_site_url(); ?>">
                            <h1 class = "ir logo logo_main">Cakey Bakey Co.</h1>
                        </a>
                    </div><!-- end logo_container -->
                </div>
                <div class = "main_header_row-nav">
                    <hr class = "hr hr_double hr_nav" />
                    
                    <nav class = "nav nav_main" role = "navigation">
                        <a href = "#" data-icon="f" class = "nav_main_btn nav_main_btn-menu">MENU</a>
                        <?php if ( has_nav_menu( 'main-nav' ) ) {
                            wp_nav_menu( mainNav() );
                        } ?>   
                    </nav><!-- end nav nav_main -->
                </div><!-- end col-12-12 -->
            </div><!-- end row -->
        </header><!-- end header -->
        <hr class = "hr hr_double-reversed" />