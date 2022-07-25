<?php
/**
 * Yksittäinen resepti
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
		while ( have_posts() ) : the_post();
?>
			
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( has_post_thumbnail() ) : ?>
<div class="entry-thumb  resepti-thumb">
	<?php the_post_thumbnail( 'fooding-homepage-1' ); ?>
</div>
<?php endif; ?>

<header class="entry-header">
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<div class="entry-meta">
		<?php fooding_posted_on(); 

	echo '</div><div class="entry-content">';
					if (rwmb_meta('resepti_ei_paistamista')) {
						echo '<div>Ei vaadi paistamista.';
					}
					else {
						$yks = rwmb_meta( 'resepti_yksikko' );
						if ($yks === "C") {
							$yks = "°C";
						}
						echo '<div class="resepti-wrap"><p><img src="'.  get_template_directory_uri(). '/assets/images/oven.png" style="width:14px;height:14px;"/> Paistolämpötila: ' . rwmb_meta( 'resepti_lampotila' ) . ' ' . $yks . '</p>';
						echo '<p><img src="'.  get_template_directory_uri(). '/assets/images/time.png" style="width:14px;height:14px;"/> Paistoaika: ' . rwmb_meta( 'resepti_paistoaika' ). '</p>';
					}
						echo '<p><img src="'.  get_template_directory_uri(). '/assets/images/time.png" style="width:14px;height:14px;"/> Muut valmistelut: '.rwmb_meta( 'resepti_valmistusaika' ).'</p></div><p>kappalemäärä: '.rwmb_meta('resepti_kappalemaara').' kpl</p>';
						$maara = get_post_meta($post->ID, 'resepti-maara', true);
						$mitta = get_post_meta($post->ID, 'resepti-mitta', true);
						$aines = get_post_meta($post->ID, 'resepti-aines', true);
						echo '<div class="resepti-ainekset"><h4>Ainekset</h4><div class="resepti-ainekset-wrap">';
						if (is_array($maara) && is_array($mitta) && is_array($aines)) {
							$maara_div = '<div>';
							$mitta_div = '<div>';
							$aines_div = '<div>';
							for ($i=0; $i<count($maara); $i++) {
								if ($i == count($maara)-1) {
									$maara_div .= '<p>'.$maara[$i].'</p></div>';
									$mitta_div .= '<p>'.$mitta[$i].'</p></div>';
									$aines_div .= '<p>'.$aines[$i].'</p></div>';
								}
								else {
									$maara_div .= '<p>'.$maara[$i].'</p>';
									$mitta_div .= '<p>'.$mitta[$i].'</p>';
									$aines_div .= '<p>'.$aines[$i].'</p>';
								}
							}
						}
						else {
							echo '<p>Ei aineksia</p>';
						}
						echo $maara_div;
						echo $mitta_div;
						echo $aines_div;
						echo '</div></div>';
				
						echo '<div class="resepti-vaiheet"><h4>Vaiheet</h4>';
						$vaiheet = rwmb_meta( 'resepti_vaihe' );
						if (is_array($vaiheet)) {
							for ($i=0; $i<count($vaiheet); $i++) {
								$n = $i+1;
								echo '<p>'.$n.'. '.$vaiheet[$i].'</p>';
							}
						}
						echo '</div>';
		
		?>

		

	</div><!-- .entry-meta -->
</header><!-- .entry-header -->

<div class="entry-content">
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fooding' ),
			'after'  => '</div>',
		) );
	?>
</div><!-- .entry-content -->

<?php
the_post_navigation( array(
		'prev_text'                  => '<span class="resepti-next-prev"><img src="'.  get_template_directory_uri(). '/assets/images/left-arrow.png" style="width:17px;height:17px;"/></span> %title',
		'next_text'                  => '</span> %title <img src="'.  get_template_directory_uri(). '/assets/images/right-arrow.png" style="width:17px;height:17px;"/>',
		'in_same_term'               => true,
		'screen_reader_text' 		 => esc_html__( 'Jatka lukemista', 'fooding' ),
) );
?>

<footer class="entry-footer">
	<?php fooding_entry_footer(); ?>
</footer><!-- .entry-footer -->

</article><!-- #post-## -->
<?php
// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
