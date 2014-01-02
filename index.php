<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package charter
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php 
					/**
					 * Set up homepage post thumbnails using featured images
					 */
					 
					$post_thumbnail_background = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
				?>
				
				<a class="post-thumbnail" href="<?php echo get_permalink(); ?>" style="background-image: url('<?php echo $post_thumbnail_background[0]; ?>');">
					<h2 class="post-title"><?php the_title(); ?></h2>
				</a>

			<?php endwhile; ?>

			<?php charter_paging_nav(); ?>

		<?php else : ?>

			<h2>Nothing</h2>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
