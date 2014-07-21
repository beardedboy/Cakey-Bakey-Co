<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title(); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <?php wp_head(); ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class = "container">
        <header class = "row">
            <div class = "col-12-12">
                <nav class = "nav nav_main" role = "navigation">
                    <a href = "#" class = "nav_main_btn nav_main_btn-menu">MENU</a>
                    <?php wp_nav_menu( mainNav() ); ?>
                </nav><!-- end nav nav_main -->
                <hr class = "hr hr-double" />
            </div><!-- end col-12-12 -->
        </header><!-- end header -->