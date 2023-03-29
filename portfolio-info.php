<?php

add_action( 'fusion_after_portfolio_side_content', 'add_fields_to_single_portfolio_post' );

function add_fields_to_single_portfolio_post() {
	
	$project_client = get_field( 'client' );
	if ( $project_client ) : ?>
		<div class="project-info-box">
			<h4><?php esc_html_e( 'Client:', 'Avada' ); ?></h4>
			<span><?php esc_html_e( $project_client, 'Avada' ); ?></span>
		</div>
	<?php endif;

	$project_location = get_field( 'location' );
	if ( $project_location ) : ?>
		<div class="project-info-box">
			<h4><?php esc_html_e( 'Location:', 'Avada' ); ?></h4>
			<span><?php esc_html_e( $project_location, 'Avada' ); ?></span>
		</div>
	<?php endif;

	$project_value = get_field( 'value' );
	if ( $project_value ) : ?>
		<div class="project-info-box">
			<h4><?php esc_html_e( 'Value:', 'Avada' ); ?></h4>
			<span><?php esc_html_e( $project_value, 'Avada' ); ?></span>
		</div>
	<?php endif;

	$project_square_feet = get_field( 'square_feet' );
	if ( $project_square_feet ) : ?>
		<div class="project-info-box">
			<h4><?php esc_html_e( 'Square Feet:', 'Avada' ); ?></h4>
			<span><?php esc_html_e( $project_square_feet, 'Avada' ); ?></span>
		</div>
	<?php endif;

	$project_description = get_field( 'project_description' );
	if ( $project_description ) : ?>
		<div class="project-info-box">
			<h3><?php esc_html_e( 'Project Description:', 'Avada' ); ?></h3>
			<span><?php esc_html_e( $project_description, 'Avada' ); ?></span>
		</div>
	<?php endif;

}