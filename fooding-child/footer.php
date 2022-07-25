<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fooding
 */

?>

	</div><!-- #content -->


		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php $enable_staff_picks = esc_attr( get_theme_mod( 'fooding_staff_picks', true ) ) ;

			if ( $enable_staff_picks == true ) {
				get_template_part( 'template-parts/content', 'staff' );
			}

			?>

			<?php if ( is_active_sidebar( 'footer' ) ) {  ?>
			<div class="footer-widgets">
				<div class="container">
					<?php	dynamic_sidebar( 'footer' );	?>
				</div>
			</div>
			<?php } ?>

			<div class="site-info">
				<div class="container">

					<div class="site-copyright">
						<?php printf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'fooding' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
                        <p>Icons made by <a href="https://www.flaticon.com/authors/creativecons" title="CreativeCons">CreativeCons</a>,<a href="https://www.flaticon.com/authors/roundicons" title="Roundicons">Roundicons</a> and <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a><p>
					</div>

					<?php do_action('fooding_footer_site_info'); ?>
				</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div> <!-- end .site-pusher -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
