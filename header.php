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

    <nav class = "nav nav_main" role = "navigation">
        <a href = "#" class = "nav_main_btn nav_main_btn-menu">MENU</a>
        <?php wp_nav_menu( mainNav() ); ?>
        <section class = "basket_wrapper">
            <div class="basket_link">
                <!--<span class = "badge basket_badge">10</span>-->
                <a class = "icon-basket basket_link_icon-mobile icon-basket-empty"></a>
                <span class = "basket_link_title">Basket</span>
                
                <div class = "basket">
                    <ul class = "basket_list">
                    </ul>
                    <footer class = "basket_footer">
                        <div class = "btn_flat btn_flat-full" href="">View basket</div>
                    </footer>
                </div>
            </div>
        </section>
    </nav><!-- end nav nav_main -->

    <hr class = "hr hr-double" />