<?php
/**
 * Pitchfork Glide - Carousel (Images)
 *
 * - Creates a carousel of images using glide.js
 *
 * @package pitchfork-glide
 */

/**
 * Set initial get_field declarations.
 */
$showcaption = get_field('carousel_images_captions') ?? false;
$showcounter = get_field('carousel_images_counter') ?? false;
$imagelist = (array) get_field('carousel_images_gallery');

/**
 * Set operations mode - slider or carousel.
 */
$slidewrap = get_field('carousel_images_operation') ?? false;
if ($slidewrap) {
	$operation = 'data-glide-type="carousel"';
} else {
	$operation = 'data-glide-type="slider" data-glide-bounded="true"';
}


/**
 * Set block classes
 * - Get additional classes from the 'advanced' field in the editor.
 * - Get alignment setting from toolbar if enabled in theme.json, or set default value
 * - Include any default classs for the block in the intial array.
 */

$block_attr = array( 'pf-carousel', 'pf-carousel-images', 'glide');
if ( ! empty( $block['className'] ) ) {
	$block_attr[] = $block['className'];
}

if ( ! empty( $block['align'] ) ) {
	$block_attr[] = $block['align'];
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
 * Build slide track and bullet navigation.
 */

$slides = '<div class="glide__track" data-glide-el="track"><ul class="glide__slides">';
$slide_count = 0;

$bullets = '<div role="group" class="glide__bullets" data-glide-el="controls[nav]">';

foreach ($imagelist as $image_id) {
    $slides .= '<li class="glide__slide">';
	$slides .= '<div class="uds-img"><figure class="uds-figure">';
    $slides .= wp_get_attachment_image($image_id, 'full', '', array('class' => 'uds-img figure-img img-fluid'));

	if ($showcaption) {
		$slides .= '<figcaption class="figure-caption uds-figure-caption">';
		$slides .= wp_get_attachment_caption($image_id);
		$slides .= '</figcaption>';
	}

	$slides .= '</figure></div></li>';

	$bullets .= '<button type="button" class="glide__bullet" data-glide-dir="=' . $slide_count . '" aria-label="Slide view ' . $slide_count . '"></button>';
	$slide_count++;
}

$slides .= '</div>';
$bullets .= '</div>';

/**
 * Data attributes for glide.js
 */
if ($showcaption) {
	$shadow = 'data-has-shadow="true"';
} else {
	$shadow = '';
}

/**
 * Create the block output.
 */
$attr  = implode( ' ', $block_attr );
$output = $anchor . ' class="' . $attr . '" style="' . $spacing . '"' . $operation . ' '. $shadow;

/**
 * Print the output.
 */
?>

<div <?php echo $output;?>
	data-glide-per-view="1"
	data-glide-gap="16"
	data-glide-focus-at="center"
	data-glide-peek='{"before":160,"after":160}'
	data-glide-breakpoints='{"768": { "peek": 0, "gap": 8 }}'
	data-glide-animation-duration="300">

	<?php echo $slides; ?>

	<?php echo $showcounter ? $bullets : ''; ?>

	<!-- Previous / Next -->
	<div class="glide__arrows" data-glide-el="controls">
		<button class="glide__arrow glide__arrow--left" data-glide-dir="&lt;">
			<span class="fa-solid fa-chevron-left arrow-icon" title="Previous image"></span>
		</button>
		<button class="glide__arrow glide__arrow--right" data-glide-dir="&gt;">
			<span class="fa-solid fa-chevron-right arrow-icon" title="Next image"></span>
		</button>
	</div>

</div>

