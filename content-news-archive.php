<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>


<div class="mx-news-wrapper">
	
	<div class="mx-news-calendar">
		
		<?php if( dynamic_sidebar( 'sidebar-calendar' ) ) :

			dynamic_sidebar( 'sidebar-calendar' );

		endif; ?>
		
	</div>

	<!-- template -->
	<div class="mx-one-news" id="mx_one_news_template" style="display: none;">
		<h3></h3>
		<div class="mx-image-wrap">
			<a href="#"><img src="#" alt="/"></a>
		</div>
		<div class="mx-excerpt-wrap"><p></p></div>
	</div>

	<div class="mx-news-content">
		
		<!-- news container -->

		<?php $news = new WP_Query(

			array(
				'post_type' 		=> 'post',
				'posts_pet_page'	=> -1,
				'order'				=> 'DESC'
			)

		); ?>


		<?php if( $news->have_posts() ) : ?>


			<?php while( $news->have_posts() ) : $news->the_post(); ?>

				<div class="mx-one-news">					

					<h3>
						<?php the_title(); ?>
					</h3>

					<div class="mx-image-wrap">

						<?php the_post_thumbnail(); ?>
						
					</div>

					<div class="mx-excerpt-wrap">

						<?php the_excerpt(); ?>
						
					</div>

				</div>

				


			<?php endwhile; ?>

		<?php endif; ?>


	</div>

</div>
