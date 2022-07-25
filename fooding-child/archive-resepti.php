<?php
/**
 * Kaikki reseptit
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fooding
 */

get_header();

?>


<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		$archive_layout = get_theme_mod( 'fooding_archive_layout', 'default' );
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="entry-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			echo '<div class="resepti-haku"><p>Artikkelit-kategorialla löydät leipomiseen ja sivustomme toimintaan liittyviä kirjoituksiamme. Muilla Kategorioilla löydät reseptejä.';
			 echo do_shortcode('[searchandfilter fields="search,category,post_tag" types=",checkbox,checkbox" hierarchical=",1" headings=",Categories,Tags" post_types="post,resepti"]'); 
			 echo '</div>';
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				 switch ( $archive_layout ) {
 		 			case 'grid':
 		 				get_template_part( 'template-parts/content', 'grid' );
 		 				break;

 		 			default:
 		 				get_template_part( 'template-parts/content', 'grid-large' );
 		 				break;
 		 		}


			endwhile;

		else : ?>
			<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Ei tuloksia', 'fooding' ); ?></h1>
			</header><!-- .page-header --> <?php
			 get_template_part( 'template-parts/content', 'none' ); 
		endif;


		echo '<div class="post-pagination">';
		the_posts_pagination(array(
			'prev_next' => true,
			'prev_text' => '',
			'next_text' => '',
			'before_page_number' => '<span class="screen-reader-text">' . esc_html__('Page', 'fooding') . ' </span>',
		));
		echo '</div>';

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
<?php

 get_footer(); 
