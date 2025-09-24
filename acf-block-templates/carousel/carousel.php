<?php
/**
 * Pitchfork Glide - Carousel block
 *
 * - Implements the "spin anything" wrapper from glide.js
 *
 * @package pitchfork-glide
 */

/**
 * Set initial get_field declarations.
 */

/**
 * Set block classes
 * - Get additional classes from the 'advanced' field in the editor.
 * - Get alignment setting from toolbar if enabled in theme.json, or set default value
 * - Include any default classs for the block in the intial array.
 */

$block_attr = array( 'uds-template');
if ( ! empty( $block['className'] ) ) {
	$block_attr[] = $block['className'];
}

/**
 * Additional margin/padding settings
 * Returns a string for inclusion with style=""
 */
$spacing = pitchfork_blocks_acf_calculate_spacing( $block );

/**
 * Include block.json support for HTML anchor.
 */
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . $block['anchor'] . '"';
}

/**
 * Block logic here.
 */

/**
 * Create the outer wrapper for the block output.
 */
$attr  = implode( ' ', $block_attr );
$output = '<div ' . $anchor . ' class="' . $attr . '" style="' . $spacing . '">';

/**
 * Inner Block attributes, example templates and output string.
 */
$allowed_blocks = array( 'core/group', 'core/heading', 'core/paragraph', 'core/list' );
$template       = array(
	array(
		'core/heading',
		array(
			'level'   => 4,
			'content' => 'Template sample content',
		),
	),
);

$output .= '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';


/**
 * Close the block, echo the output.
 */
$output .= '</div>';
echo $output;
