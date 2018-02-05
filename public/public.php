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
