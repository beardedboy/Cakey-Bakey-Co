<?php get_header(); ?>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

        <p>Hello world! This is HTML5 Boilerplate.</p>

<?php get_footer(); ?>