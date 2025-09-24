<?php
/**
 * ACF Configurations.
 * - Add save/load points for JSON feature.
 *
 * @package pitchfork-glide
 */


/**
 * Register a new loading point for the Local JSON feature for this plugin.
 */
function pitchfork_glide_acf_json_load_point( $paths ) {
	$paths[] = PITCHFORK_GLIDE . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'pitchfork_glide_acf_json_load_point' );


/**
 * Create a save point for specifc JSON files for the plugin's ACF groups.
 *
 * Key list
 * - UDS Carousel Images: Accordion - group_68d18eda2590a
 *
 *
 * @return $paths
 */
function pitchfork_glide_field_groups( $path ) {
    $path = PITCHFORK_GLIDE . '/acf-json';
    return $path;
}
add_filter( 'acf/settings/save_json/key=group_68d18eda2590a', 'pitchfork_glide_field_groups' );
