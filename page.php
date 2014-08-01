<?php get_header(); ?>

<div class="main_content">
	<?php while(have_posts()):the_post()?>
		<?php the_content(); ?>
	<?php endwhile; ?>

</div><!-- #main-content -->

<?php get_footer(); ?>