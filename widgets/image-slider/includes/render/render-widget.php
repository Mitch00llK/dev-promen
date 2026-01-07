<?php
namespace Promen\Widgets\ImageSlider\Render;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Image_Slider_Render {

	public static function render_widget( $widget ) {
		$settings = $widget->get_settings_for_display();

		// Debug output
		if ( current_user_can( 'administrator' ) ) {
			echo '<!-- Image Slider Widget Debug: Render file loaded -->';
		}

		// Get slider images
		$slider_images = $settings['slider_images'];
		$image_count = count( $slider_images );

		// Determing if we should use slider (more than 3 images)
		// Or if forced by layout settings? The original code had $use_slider = $image_count > 3;
		// But usually users want slider even with few images if they chose slider layout.
		// However, I will stick to original logic for now to avoid breaking changes, unless I see a control that forces it.
		// The original code: $use_slider = $image_count > 3;
		$use_slider = $image_count > 3;

		// Get responsive settings
		$columns_desktop = $settings['columns_desktop'] ?? '3';
		$columns_tablet = $settings['columns_tablet'] ?? '2';
		$columns_mobile = $settings['columns_mobile'] ?? '1';

		$grid_classes = "promen-slider-grid desktop-columns-{$columns_desktop} tablet-columns-{$columns_tablet} mobile-columns-{$columns_mobile}";

		// Slider settings
		// $slider_template = isset($settings['slider_template']) ? $settings['slider_template'] : 'default';

		// Prepare slider settings
		$slider_settings = [
			'slidesPerView' => isset( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : 1,
			'spaceBetween' => isset( $settings['space_between']['size'] ) ? intval( $settings['space_between']['size'] ) : 30,
			'navigation' => self::get_safe_setting( $widget, 'slider_navigation', '' ) === 'yes',
			'pagination' => self::get_safe_setting( $widget, 'slider_pagination', '' ) === 'yes',
			'loop' => self::get_safe_setting( $widget, 'slider_loop', '' ) === 'yes',
			'effect' => isset( $settings['slider_effect'] ) ? $settings['slider_effect'] : 'slide',
			'autoplay' => self::get_safe_setting( $widget, 'slider_autoplay', '' ) === 'yes' ? [
				'delay' => isset( $settings['slider_autoplay_delay'] ) ? intval( $settings['slider_autoplay_delay'] ) : 5000,
				'disableOnInteraction' => false,
			] : false,
			'speed' => isset( $settings['slider_speed'] ) ? intval( $settings['slider_speed'] ) : 500,
			'centeredSlides' => self::get_safe_setting( $widget, 'centered_slides', '' ) === 'yes',
			'breakpoints' => [
				// Mobile (0px and up)
				0 => [
					'slidesPerView' => isset( $settings['slides_per_view_mobile'] ) ? $settings['slides_per_view_mobile'] : 1,
					'spaceBetween' => isset( $settings['space_between_mobile']['size'] ) ? intval( $settings['space_between_mobile']['size'] ) : 20,
				],
				// Tablet (768px and up)
				768 => [
					'slidesPerView' => isset( $settings['slides_per_view_tablet'] ) ? $settings['slides_per_view_tablet'] : 2,
					'spaceBetween' => isset( $settings['space_between_tablet']['size'] ) ? intval( $settings['space_between_tablet']['size'] ) : 30,
				],
				// Desktop (1025px and up)
				1025 => [
					'slidesPerView' => isset( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : 1,
					'spaceBetween' => isset( $settings['space_between']['size'] ) ? intval( $settings['space_between']['size'] ) : 30,
				],
			],
		];

		// Gradient overlay settings
		$gradient_overlay = isset( $settings['gradient_overlay'] ) && $settings['gradient_overlay'] === 'yes';
		$gradient_color = isset( $settings['gradient_color_start'] ) ? $settings['gradient_color_start'] : '#ffffff';
		$gradient_opacity = isset( $settings['gradient_opacity']['size'] ) ? intval( $settings['gradient_opacity']['size'] ) : 90;
		$gradient_width = isset( $settings['gradient_width']['size'] ) ? intval( $settings['gradient_width']['size'] ) : 15;

		// Convert opacity to decimal
		$gradient_opacity_decimal = $gradient_opacity / 100;

		// Create RGBA color for gradient
		$rgb = sscanf( $gradient_color, "#%02x%02x%02x" );
		$rgba_start = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, {$gradient_opacity_decimal})";
		$rgba_end = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, 0)";

		// Gradient styles
		$gradient_left_style = "background: linear-gradient(to right, {$rgba_start} 0%, {$rgba_end} 100%); width: {$gradient_width}%;";
		$gradient_right_style = "background: linear-gradient(to left, {$rgba_start} 0%, {$rgba_end} 100%); width: {$gradient_width}%;";
		?>

		<div class="promen-image-slider-widget">
			<?php if ( self::get_safe_setting( $widget, 'show_title', '' ) === 'yes' ) : ?>
				<div class="promen-slider-title-wrapper">
					<?php 
					if ( function_exists( 'promen_render_split_title' ) ) {
						echo promen_render_split_title( $widget, $settings, 'section_title', 'promen-slider' ); 
					}
					?>
				</div>
			<?php endif; ?>

			<?php if ( $use_slider ) : ?>
				<?php
				// Generate unique ID for this slider instance
				$slider_id = 'promen-image-slider-' . uniqid();

				// Prepare slider attributes
				$slider_attributes = [
					'data-slides-per-view' => $slider_settings['slidesPerView'],
					'data-space-between' => $slider_settings['spaceBetween'],
					'data-navigation' => $slider_settings['navigation'] ? 'true' : 'false',
					'data-pagination' => $slider_settings['pagination'] ? 'true' : 'false',
					'data-loop' => $slider_settings['loop'] ? 'true' : 'false',
					'data-effect' => $slider_settings['effect'],
					'data-autoplay' => $slider_settings['autoplay'] ? 'true' : 'false',
					'data-autoplay-delay' => $slider_settings['autoplay'] ? $slider_settings['autoplay']['delay'] : 5000,
					'data-speed' => $slider_settings['speed'],
					'data-centered-slides' => $slider_settings['centeredSlides'] ? 'true' : 'false',
					// Responsive breakpoints
					'data-slides-per-view-mobile' => $slider_settings['breakpoints'][0]['slidesPerView'],
					'data-space-between-mobile' => $slider_settings['breakpoints'][0]['spaceBetween'],
					'data-slides-per-view-tablet' => $slider_settings['breakpoints'][768]['slidesPerView'],
					'data-space-between-tablet' => $slider_settings['breakpoints'][768]['spaceBetween'],
				];

				$slider_attr_string = '';
				foreach ( $slider_attributes as $key => $value ) {
					$slider_attr_string .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
				}
				?>

				<div class="promen-slider-container">
					<?php if ( $gradient_overlay ) : ?>
						<div class="promen-slider-gradient-left" style="<?php echo esc_attr( $gradient_left_style ); ?>"></div>
						<div class="promen-slider-gradient-right" style="<?php echo esc_attr( $gradient_right_style ); ?>"></div>
					<?php endif; ?>
					
					<!-- Slider main container -->
					<div id="<?php echo esc_attr( $slider_id ); ?>" class="swiper promen-image-slider"<?php echo $slider_attr_string; ?>>
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper">
							<?php foreach ( $slider_images as $index => $item ) : ?>
								<!-- Slides -->
								<div class="swiper-slide">
									<?php self::render_image_item( $widget, $item ); ?>
								</div>
							<?php endforeach; ?>
						</div>
						
						<?php if ( $slider_settings['pagination'] ) : ?>
							<!-- Pagination -->
							<div class="swiper-pagination"></div>
						<?php endif; ?>
						
						<?php if ( $slider_settings['navigation'] ) : ?>
							<!-- Navigation buttons -->
							<div class="swiper-button-prev" aria-label="<?php echo esc_attr__( 'Previous slide', 'promen-elementor-widgets' ); ?>"></div>
							<div class="swiper-button-next" aria-label="<?php echo esc_attr__( 'Next slide', 'promen-elementor-widgets' ); ?>"></div>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<!-- Regular grid layout for 3 or fewer images -->
				<div class="<?php echo esc_attr( $grid_classes ); ?>">
					<?php foreach ( $slider_images as $index => $item ) : ?>
						<?php self::render_image_item( $widget, $item ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private static function render_image_item( $widget, $item ) {
		$settings = $widget->get_settings_for_display();
		?>
		<div class="promen-slider-image-wrapper">
			<div class="promen-slider-image elementor-animation-<?php echo esc_attr( self::get_safe_setting( $widget, 'image_hover_animation', '' ) ); ?>">
				<?php if ( ! empty( $item['image']['url'] ) ) : ?>
					<?php 
					// Apply the appropriate height and object-fit settings
					$image_classes = 'promen-slider-img';
					
					// Apply aspect ratio container class if needed
					if ( self::get_safe_setting( $widget, 'image_height', 'default' ) === 'aspect_ratio' ) {
						$image_classes .= ' promen-aspect-ratio-img';
						// Add aspect-ratio class to the container
						echo '<div class="aspect-ratio">';
					}
					
					// Add object-fit class if specified
					if ( self::get_safe_setting( $widget, 'image_height', 'default' ) !== 'default' && ! empty( self::get_safe_setting( $widget, 'image_object_fit', '' ) ) ) {
						$image_classes .= ' object-fit-' . esc_attr( self::get_safe_setting( $widget, 'image_object_fit', '' ) );
					}

					// Get image metadata if using image metadata options
					$image_title = $item['title'];
					$image_description = $item['description'];
					
					if ( ! empty( $item['image']['id'] ) && ( isset( $item['use_image_title'] ) && $item['use_image_title'] === 'yes' || 
													isset( $item['use_image_description'] ) && $item['use_image_description'] === 'yes' ) ) {
						$image_data = get_post( $item['image']['id'] );
						
						if ( $image_data ) {
							// Use image title from attachment if enabled
							if ( isset( $item['use_image_title'] ) && $item['use_image_title'] === 'yes' ) {
								$image_title = $image_data->post_title;
							}
							
							// Use image caption/description from attachment if enabled
							if ( isset( $item['use_image_description'] ) && $item['use_image_description'] === 'yes' ) {
								// Try to use caption first, fall back to content if caption is empty
								$image_description = $image_data->post_excerpt;
								if ( empty( $image_description ) ) {
									$image_description = $image_data->post_content;
								}
							}
						}
					}
					?>
					<img src="<?php echo esc_url( $item['image']['url'] ); ?>" 
							alt="<?php echo esc_attr( $image_title ); ?>" 
							class="<?php echo esc_attr( $image_classes ); ?>">
					<?php if ( self::get_safe_setting( $widget, 'image_height', 'default' ) === 'aspect_ratio' ) : ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php 
				$show_title = self::get_safe_setting( $widget, 'show_image_title', '' ) === 'yes';
				$show_desc = self::get_safe_setting( $widget, 'show_image_description', '' ) === 'yes';
				$show_overlay = $item['show_overlay'] === 'yes';
				$hover_overlay = self::get_safe_setting( $widget, 'show_overlay_on_hover', '' ) === 'yes';

				if ( ( $show_title || $show_desc ) && ( $show_overlay || $hover_overlay ) ) : 
				?>
					<div class="promen-slider-overlay<?php echo $hover_overlay ? ' hover-overlay' : ''; ?>">
						<?php if ( $show_title && ! empty( $image_title ) ) : ?>
							<p class="promen-slider-overlay-title"><?php echo esc_html( $image_title ); ?></p>
						<?php endif; ?>
						
						<?php if ( $show_desc && ! empty( $image_description ) ) : ?>
							<p class="promen-slider-overlay-description"><?php echo esc_html( $image_description ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private static function get_safe_setting( $widget, $setting_name, $default_value ) {
		$settings = $widget->get_settings_for_display();
		return isset( $settings[ $setting_name ] ) ? $settings[ $setting_name ] : $default_value;
	}
}