<?php
/*
	Template Name: Full-width
*/
?>
<?php get_header(); ?>
			
			<div class="divider"></div>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php if ( has_post_thumbnail() ) { ?>
			
			<div class="page-thumbnail">
				
				<h1><?php the_title(); ?></h1>
				<?php the_post_thumbnail('page-thumbnail'); ?>
			
			</div>
			
			<?php } else { ?>
			
			<div class="page-heading">
			
				<h1><?php the_title(); ?></h1>
			
			</div>
			
			<?php } ?>
			
			<?php endwhile; else : ?>
			<?php endif; ?>
			
			<div class="divider"></div>
			
			<div id="primary-content">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php the_content(); ?>
			
			<?php endwhile; else : ?>
			<?php endif; ?>
			
			<div class="clearfix"></div>
			
			<div class="divider"></div>
		
		</div><!-- end primary-content -->
		
<?php get_footer(); ?>