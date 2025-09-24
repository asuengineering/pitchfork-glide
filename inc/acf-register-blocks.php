<?php
/**
 * File: acf-register-blocks.php
 *
 * @package         starter_plugin
 *
 * This file is responsible for loading all of our block 'register.php' files
 * (found in the individual block folders) so that we can register our custom
 * blocks. We do this by hooking into ACF Pro's 'acf/init' action.
 */

/**
 * Register a custom block category for our blocks to live in. We hook into
 * the block_categories_all() filter to do this.
 */

if ( ! function_exists( 'pitchfork_glide_custom_category' ) ) {
	/**
	 * Merges our custom category in with the others.
	 *
	 * @param array                   $categories The existing block categories.
	 * @param WP_Block_Editor_Context $editor_context Editor context.
	 */
	function pitchfork_glide_custom_category( $categories, $editor_context ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'pitchfork-glide',
					'title' => __( 'Pitchfork Glide', 'pitchfork-glide' ),
				),
			)
		);
	}
}
add_filter( 'block_categories_all', 'pitchfork_glide_custom_category', 30, 2 );

/**
 * Register blocks.
 */

function pitchfork_glide_acf_blocks_init() {

	// Icons kept in a separate file.
	require_once PITCHFORK_GLIDE . '/acf-block-templates/icons.php';

	// UDS Carousel, container block for various carousel configurations.
	register_block_type(
		PITCHFORK_GLIDE . 'acf-block-templates/carousel',
		array(
			'icon'     => $block_icon->gallery_thumbnails,
			'category' => 'pitchfork-carousel',
		)
	);
}
add_action( 'acf/init', 'pitchfork_glide_acf_blocks_init', 30, 2 );
