<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ):
	function chld_thm_cfg_locale_css( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}

		return $uri;
	}
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );


/**
 *  shortcode filter post object of indestructibility [filter]
 */


function filter_post() {

	get_template_part( 'templates/section/filter' );

	$ret = ob_get_contents();

	ob_end_clean();

	return $ret;

}


add_shortcode( 'filter', 'filter_post' );


/**
 * add scripts
 */
if ( ! function_exists( 'add_scripts' ) ) {
	function add_scripts() {

		if ( is_front_page() || is_home() ) {
			wp_register_script( 'filter', get_stylesheet_directory_uri() . '/js/filter.js', array(), null, true );
			wp_enqueue_script( 'filter' );
			wp_localize_script( 'filter', 'filter_form',
				array(
					'url' => admin_url( 'admin-ajax.php' )
				)
			);
		}

	}
}

add_action( 'wp_enqueue_scripts', 'add_scripts' );


add_action( 'wp_ajax_filter_form', 'filter_form' );
add_action( 'wp_ajax_nopriv_filter_form', 'filter_form' );

/**
 * ajax filter post action
 */
if ( ! function_exists( 'filter_form' ) ) {
	function filter_form() {
		if ( empty( $_POST ) ) {
			die();
		}
		$type  = ( ! empty( sanitize_text_field( $_POST['building_type'] ) ) ) ? sanitize_text_field( $_POST['building_type'] ) : '';
		$floor = ( ! empty( sanitize_text_field( $_POST['building_floor'] ) ) ) ? sanitize_text_field( $_POST['building_floor'] ) : '';

		if ( ! empty( $floor ) || ! empty( $type ) ) {
			$args = array(
				'numberposts' => - 1,
				'post_type'   => 'object-of-indestruct',
				'meta_query'  => array(
					'relation' => 'AND',
					array(
						'key'     => 'understrap_building_type',
						'value'   => $type,
						'compare' => 'LIKE'
					),
					array(
						'key'     => 'understrap_number_of_floors',
						'value'   => $floor,
						'compare' => 'LIKE'
					),
				),
			);
		} else {
			echo '<p class="error" style=" display: flex; justify-content: center; align-items: center; font-size: 20px; font-weight: 600;"">' . __( 'Select type or floor', 'understrap' ) . '</p>';
			die();
		}
		$query = new WP_Query( $args );
		ob_start();
		if ( ! empty( $query ) ) :
			if ( $query->have_posts() ): ?>
				<div class="container">
					<div class="row mt-n5" style="padding-top: 30px;">
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<div class="col-md-6 col-lg-4 mt-5 wow fadeInUp" data-wow-delay=".2s"
							     style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
								<div class="blog-grid-2">
									<div class="blog-grid-img position-relative">
										<a href="<?php the_permalink(); ?>">
											<img src="<?php the_field( 'understrap_image' ); ?>"/>
											<h3 class="h5 mb-3"><?php the_title(); ?></h3>
											<p class="h5 mb-3"><?php the_content(); ?></p>
										</a>
										<h3 class="h5 mb-3"><?php the_field( 'understrap_name_of_the_house' ); ?></h3>
										<p class="display-30"><?php the_field( 'understrap_location_coordinates' ); ?></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
						<div class="response"></div>
					</div>
				</div>
			<?php
			else:
				echo '<p class="error" style=" display: flex; justify-content: center; align-items: center; font-size: 20px; font-weight: 600;">' . __( 'Not Found', 'understrap' ) . '</p>';
			endif;
		endif;
		wp_reset_query();
		echo ob_get_clean();
		die();
	}
}
