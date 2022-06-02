<?php get_header(); ?>
<div class="main-heading">
	<h1><?php the_title(); ?></h1>
</div>
<section>
	<?php if (have_posts()): while (have_posts()): the_post(); ?>
		<?php getPost(); ?>
	<?php endwhile; endif; ?>
</section>
<?php the_posts_pagination(); ?>
<?php get_footer(); ?>