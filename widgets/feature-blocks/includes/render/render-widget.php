<?php
namespace Promen\Widgets\FeatureBlocks\Render;

use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Feature_Blocks_Render {

	public static function render_widget( $widget ) {
		$settings = $widget->get_settings_for_display();

		// Main container classes
		$container_classes = [ 'feature-blocks-container' ];
		if ( 'yes' === $settings['stack_on_mobile'] ) {
			$container_classes[] = 'stack-on-mobile';
		}
		if ( 'yes' === $settings['stack_on_tablet'] ) {
			$container_classes[] = 'stack-on-tablet';
		}

		// For backward compatibility
		$responsive_classes = '';
		if ( 'yes' === $settings['stack_on_mobile'] ) {
			$responsive_classes .= ' stack-on-mobile';
		}
		if ( 'yes' === $settings['stack_on_tablet'] ) {
			$responsive_classes .= ' stack-on-tablet';
		}
		$responsive_classes = trim( $responsive_classes );
		?>
		<section class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>" 
				 style="background-color: <?php echo esc_attr( $settings['background_color'] ); ?>;"
				 role="region" 
				 aria-labelledby="<?php echo 'yes' === $settings['show_widget_title'] ? 'feature-blocks-title' : ''; ?>"
				 aria-describedby="feature-blocks-description">
			
			<?php
			if ( 'yes' === $settings['show_widget_title'] && ! empty( $settings['widget_title'] ) ) :
				$widget_title_tag = isset( $settings['widget_title_html_tag'] ) && ! empty( $settings['widget_title_html_tag'] ) ? $settings['widget_title_html_tag'] : 'h3';
				?>
				<header class="widget-title-wrapper">
					<<?php echo esc_attr( $widget_title_tag ); ?> 
					   class="widget-title" 
					   id="feature-blocks-title">
						<?php echo esc_html( $settings['widget_title'] ); ?>
					</<?php echo esc_attr( $widget_title_tag ); ?>>
				</header>
			<?php endif; ?>
			
			<div id="feature-blocks-description" class="sr-only">
				<?php echo esc_html__( 'Interactive feature blocks with images and content. Use Tab to navigate between elements.', 'promen-elementor-widgets' ); ?>
			</div>
			
			<main class="promen-feature-blocks-wrapper <?php echo esc_attr( $responsive_classes ); ?>" 
				  role="main" 
				  aria-label="<?php echo esc_attr__( 'Inhoud met feature blokken en informatie over onze diensten', 'promen-elementor-widgets' ); ?>">
				
				<figure class="promen-feature-main-image" role="img" aria-label="<?php echo esc_attr__( 'Main feature image', 'promen-elementor-widgets' ); ?>">
					<?php if ( ! empty( $settings['main_image']['url'] ) ) : ?>
						<img src="<?php echo esc_url( $settings['main_image']['url'] ); ?>" 
							 alt="<?php echo esc_attr__( 'Hoofdafbeelding die onze services toont', 'promen-elementor-widgets' ); ?>"
							 loading="lazy">
					<?php endif; ?>
					<?php if ( 'yes' === $settings['show_overlay_image'] && ! empty( $settings['overlay_image']['url'] ) ) : ?>
						<div class="overlay-image" role="img" aria-hidden="true">
							<img src="<?php echo esc_url( $settings['overlay_image']['url'] ); ?>" 
								 alt=""
								 loading="lazy">
						</div>
					<?php endif; ?>
				</figure>

				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<?php if ( 'yes' === $settings['show_block_' . $i] ) : ?>
						<article class="promen-feature-block feature-block-<?php echo $i; ?>" 
								 style="<?php
									// Only apply positioning styles when not stacked on current device
									// For simplicity in refactor, we rely on responsive classes and logic in CSS or JS if dynamic detection is needed, 
                                    // but preserving current logic:
									if (
										( ! wp_is_mobile() && 'yes' === $settings['stack_on_mobile'] ) || 
										( ! self::is_tablet() && 'yes' === $settings['stack_on_tablet'] )
									) {
										echo 'position: absolute;';
									}
								 ?>"
								 role="article" 
								 aria-labelledby="feature-title-<?php echo $i; ?>"
								 aria-describedby="feature-content-<?php echo $i; ?>"
								 tabindex="0">
							
							<div class="feature-icon" role="img" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['block_' . $i . '_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
							
							<header class="feature-title-wrapper">
								<?php 
								// Create a settings array for this specific block
								$block_settings = [
									'split_title' => isset( $settings['block_' . $i . '_split_title'] ) ? $settings['block_' . $i . '_split_title'] : 'no',
									'title_part_1' => isset( $settings['block_' . $i . '_title_part_1'] ) ? $settings['block_' . $i . '_title_part_1'] : '',
									'title_part_2' => isset( $settings['block_' . $i . '_title_part_2'] ) ? $settings['block_' . $i . '_title_part_2'] : '',
									'title_html_tag' => isset( $settings['block_' . $i . '_title_html_tag'] ) ? $settings['block_' . $i . '_title_html_tag'] : 'span',
									'block_' . $i . '_title' => isset( $settings['block_' . $i . '_title'] ) ? $settings['block_' . $i . '_title'] : '',
								];
								// Add ID to the title for ARIA labeling
								$block_settings['title_id'] = 'feature-title-' . $i;
                                
                                if ( function_exists( 'promen_render_split_title' ) ) {
								    echo promen_render_split_title( $widget, $block_settings, 'block_' . $i . '_title', 'feature' );
                                } else {
                                    echo esc_html( $block_settings['block_' . $i . '_title'] );
                                }
								?>
							</header>
							
							<div class="feature-content" id="feature-content-<?php echo $i; ?>">
								<p><?php echo esc_html( $settings['block_' . $i . '_content'] ); ?></p>
							</div>
							
							<?php if ( 4 === $i && ! empty( $settings['block_4_button_text'] ) && 'yes' === $settings['show_block_4_button'] ) : ?>
								<footer class="button-wrapper">
									<a href="<?php echo esc_url( $settings['block_4_button_url']['url'] ); ?>" 
									   class="feature-button"
									   role="button"
									   aria-label="<?php echo esc_attr( sprintf( __( 'Klik om meer te leren over %s', 'promen-elementor-widgets' ), $settings['block_4_button_text'] ) ); ?>"
									   <?php if ( $settings['block_4_button_url']['is_external'] ) : ?>
										   target="_blank"
										   rel="noopener noreferrer"
										   aria-describedby="external-link-notice"
									   <?php endif; ?>
									   <?php if ( $settings['block_4_button_url']['nofollow'] ) : ?>
										   rel="nofollow"
									   <?php endif; ?>>
										<span><?php echo esc_html( $settings['block_4_button_text'] ); ?></span>
										<span class="button-arrow" aria-hidden="true">&gt;</span>
									</a>
									<?php if ( $settings['block_4_button_url']['is_external'] ) : ?>
										<span id="external-link-notice" class="sr-only">
											<?php echo esc_html__( 'Opens in new window', 'promen-elementor-widgets' ); ?>
										</span>
									<?php endif; ?>
								</footer>
							<?php endif; ?>
						</article>
					<?php endif; ?>
				<?php endfor; ?>
			</main>
		</section>
		<?php
	}

    private static function is_tablet() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        // Common tablet user agent patterns
        $tablet_patterns = array(
            'iPad', 'Android(?!.*Mobile)', 'Tablet', 'Kindle', 'Silk'
        );
        
        // Check if the user agent matches any tablet pattern
        foreach ($tablet_patterns as $pattern) {
            if (preg_match('/' . $pattern . '/i', $user_agent)) {
                return true;
            }
        }
        
        // Check viewport width if available (requires JavaScript)
        return false;
    }
}
