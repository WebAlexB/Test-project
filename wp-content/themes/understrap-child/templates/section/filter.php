<?php
/**
 * The template for filter post Object of indestructibility sections
 *
 * @package WordPress
 * @subpackage Understrap Theme
 * @since Understrap Theme
 */

$objects = get_field( 'add_object_of_indestruct' );
$types   = [];
if ( $objects ) :
	foreach ( $objects as $object ) :
		$types [] = $building_type = get_field( 'understrap_building_type', $object->ID );
	endforeach;
endif;
$args  = array(
	'numberposts' => - 1,
	'post_type'   => 'object-of-indestruct'
);
$query = new WP_Query( $args ); ?>
<div class="row">
	<?php if ( is_array( $types ) ) : ?>
		<div class="col">
			<label for="floor"><?php echo __( 'House', 'understrap' ); ?></label>
			<select id="type" name="type" class="form-control" aria-label="Default select example">
				<option selected><?php echo __( 'Select type', 'understrap' ); ?></option>
				<?php foreach ( array_unique( $types ) as $type ) : ?>
					<option value="<?php echo esc_html( $type ); ?>"><?php echo esc_html( $type ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>
	<div class="col">
		<label for="floor"><?php echo __( 'Select floor (between 1 and 10)', 'understrap' ); ?></label>
		<input id="floor" type="number" class="form-control" placeholder="floor" min="1" max="10">
	</div>
	<button id="filter-submit" type="submit"
	        class="btn btn-primary"><?php echo __( 'Submit', 'understrap' ); ?></button>
</div>
<?php if ( $query->have_posts() ): ?>
	<div class="container">
		<div class="row mt-n5" style="padding-top: 30px;">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="col-md-6 col-lg-4 mt-5 wow fadeInUp" data-wow-delay=".2s"
				     style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="blog-grid">
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
		</div>
	</div>
	<div class="response"></div>
<?php endif;
wp_reset_query(); ?>
