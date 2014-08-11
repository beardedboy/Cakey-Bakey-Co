
        </div><!-- end container -->

        <footer class = "main_footer">
            <div class = "container">
                <div class = "row">
                    <div class = "col-7-12 main_footer_left_col">
                    <?php if ( has_nav_menu( 'footer-one' ) ) {
                         wp_nav_menu( footerNav1() );
                    }?>
                    <?php if ( has_nav_menu( 'footer-two' ) ) {
                         wp_nav_menu( footerNav2() );
                    }?>
                    <?php if ( has_nav_menu( 'footer-three' ) ) {
                         wp_nav_menu( footerNav3() );
                    }?>
                    </div><!-- end col-7-12 main_footer_left_col -->
                    <div class = "col-5-12 main_footer_right_col">
                        
                    </div><!-- end col-5-12 main_footer_right_col-->
                </div><!-- end row -->
                </div><!-- end container -->
        </footer><!-- end main_footer -->
        <?php wp_footer(); ?>

        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>-->

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>