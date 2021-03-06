<?php

namespace CARES_Network_Shortcodes;

// Load public-facing style sheet and JavaScript.
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles_scripts' );

// Register our shortcodes.
add_action( 'init', __NAMESPACE__ . '\\register_shortcodes' );


/**
 * Register and enqueue public-facing style sheets and javascript files.
 *
 * @since    1.0.0
 */
function enqueue_styles_scripts() {
	// Scripts
	// wp_enqueue_script( get_plugin_slug() . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), get_plugin_version(), true );
	
	// Styles
	wp_enqueue_style( get_plugin_slug() . '-plugin-style', plugins_url( 'css/cares-shortcode-styles.css', __FILE__ ), array(), get_plugin_version(), 'all' );
}

/**
 * Warn WP that we have some shortcodes to watch out for.
 *
 * @since    1.0.0
 */
function register_shortcodes() {
	add_shortcode( 'progress_bar', __NAMESPACE__ . '\\render_progress_bar' );
	add_shortcode( 'child_page_excerpts_loop', __NAMESPACE__ . '\\render_child_page_excerpts_loop' );

}

/**
 * Build a progress bar.
 * Takes the form: [progress_bar status="2" steps="Uno,Dos,Tres,Cuatro"]
 *
 * @since    1.0.0
 *
 * @return   string    HTML for the progress bar.
 */
function render_progress_bar( $attr ) {
	$atts = shortcode_atts( array(
		'status' => 1,
		'steps' => 'Emergence,Development,Enactment,Implementation'
		), $attr );

	$status = absint( $atts['status'] );
	$steps = array_map( 'trim', explode( ',', $atts['steps'] ) );
	$num_steps = count( $steps );
	// Make sure the status is in range.
	if ( $status > $num_steps ) {
		$status = $num_steps;
	}
	$class = ( $num_steps <= 4 ) ? ' narrow' : '';

	ob_start();
	?>
		<div class="progtrckr-container clear">
			<ol class="progtrckr<?php echo $class; ?>">
				<?php
				$i = 1;
				foreach ( $steps as $step ) {
					$done = ( $i <= $status ) ? 'progtrckr-done' : 'progtrckr-todo';
					?>
					<li class="<?php echo $done; ?>"><?php echo $step; ?></li>
					<?php
					$i++;
				}
				?>
			</ol>
		</div>
	<?php
	return ob_get_clean();
}

/**
 * Build a progress bar.
 * Takes the form: [progress_bar status="2" steps="Uno,Dos,Tres,Cuatro"]
 *
 * @since    1.0.0
 *
 * @return   string    HTML for the progress bar.
 */
function render_child_page_excerpts_loop( $attr ) {
	$atts = shortcode_atts( array(
		'parent_id' => get_the_ID(),
		'orderby'   => 'date',
		'order'     => 'DESC'
		), $attr );

	$parent_id = absint( $atts['parent_id'] );
	$children = new \WP_Query( array( 
		'post_type'   => get_post_type( $parent_id ),
		'post_parent' => $parent_id,
		'orderby'     => $atts['orderby'],
		'order'       => $atts['order'],
	) );

	ob_start();
		if ( $children->have_posts() ) :

			/* Start the Loop */
			while ( $children->have_posts() ) : $children->the_post();
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				</article><!-- #post-## -->
			<?php
			endwhile; // End of the loop.

			wp_reset_postdata();

		else : ?>

			<p><?php _e( 'Sorry, but nothing was found.', 'cares-network-shortcodes' ); ?></p>
			<?php

		endif;
	return ob_get_clean();
}
