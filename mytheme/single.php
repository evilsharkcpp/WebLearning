<?php get_header();?>
<div class="container">
<div class="main-heading">
	<h1><?php the_title(); ?></h1>
    </div>
<section>
	<?php while (have_posts()): the_post();?>
		<?php the_content();?>
		<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		?>
	<?php endwhile; ?>
</section>
</div>
<?php get_footer(); ?>