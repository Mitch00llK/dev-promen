<?php
namespace Promen\Widgets\DocumentInfoList\Render;

use Elementor\Icons_Manager;
use Promen_Accessibility_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Document_Info_List_Render {

	public static function render_widget( $widget, $settings = null ) {
		// If settings are not passed, get them from the widget instance
		if ( null === $settings ) {
			$settings = $widget->get_settings_for_display();
		}

		// Generate unique ID for animation and accessibility
		$widget_id = $widget->get_id();
		$container_id = Promen_Accessibility_Utils::generate_id('document-info-list', $widget_id);
		
		// Safe access for column_layout
		$column_layout = isset($settings['column_layout']) ? $settings['column_layout'] : 'two-columns';
		$column_class = 'two-columns' === $column_layout ? 'document-info-list two-columns' : 'document-info-list one-column';

		// Container attributes
		$container_class = "document-info-list-container promen-widget";
		$container_attributes = '';



		// Year title border class
		$year_title_border = isset($settings['year_title_border_bottom']) ? $settings['year_title_border_bottom'] : 'no';
		$year_title_border_class = 'yes' === $year_title_border ? ' has-border' : '';
		
		?>
		<section class="<?php echo esc_attr($container_class); ?>" 
				 id="<?php echo esc_attr($container_id); ?>"
				 role="region" 
				 aria-label="<?php echo esc_attr__('Lijst met documenten en bestanden die u kunt downloaden en bekijken', 'promen-elementor-widgets'); ?>"
				 <?php echo $container_attributes; ?>>
			<?php 
			// Loop through each year section
			$year_sections = isset($settings['year_sections']) ? $settings['year_sections'] : [];
			if (!empty($year_sections)) : 
				foreach ($year_sections as $section_index => $year_section) : 
			?>
				<div class="document-info-year-section" 
					 data-section-index="<?php echo esc_attr($section_index); ?>"
					 role="group"
					 aria-label="<?php echo esc_attr(sprintf(__('Documenten uit het jaar %s die u kunt downloaden', 'promen-elementor-widgets'), isset($year_section['year']) ? $year_section['year'] : '')); ?>">
					<?php if (!empty($year_section['year'])) :
						$year_tag = isset($settings['year_tag']) ? $settings['year_tag'] : 'h3';
						$year_id = Promen_Accessibility_Utils::generate_id('year-title', $widget_id . '-' . $section_index);
					?>
						<<?php echo esc_html($year_tag); ?> class="document-info-year-title<?php echo esc_attr($year_title_border_class); ?>"
														   id="<?php echo esc_attr($year_id); ?>">
							<?php echo esc_html($year_section['year']); ?>
						</<?php echo esc_html($year_tag); ?>>
					<?php endif; ?>
					
					<?php 
					$documents = isset($year_section['documents']) ? $year_section['documents'] : [];
					if (!empty($documents)) : 
						$list_id = Promen_Accessibility_Utils::generate_id('documents-list', $widget_id . '-' . $section_index);
					?>
						<div class="<?php echo esc_attr($column_class); ?>" 
							 id="<?php echo esc_attr($list_id); ?>"
							 role="list" 
							 aria-labelledby="<?php echo esc_attr($year_id); ?>"
							 aria-label="<?php echo esc_attr(sprintf(__('Documenten uit het jaar %s die u kunt downloaden', 'promen-elementor-widgets'), isset($year_section['year']) ? $year_section['year'] : '')); ?>">
							<?php foreach ($documents as $doc_index => $document) : 
								$item_id = Promen_Accessibility_Utils::generate_id('document-item', $widget_id . '-' . $section_index . '-' . $doc_index);
								$icon_id = Promen_Accessibility_Utils::generate_id('document-icon', $widget_id . '-' . $section_index . '-' . $doc_index);
							?>
								<article class="document-info-item" 
										 data-item-index="<?php echo esc_attr($doc_index); ?>"
										 id="<?php echo esc_attr($item_id); ?>"
										 role="listitem"
										 tabindex="0"
										 <?php if (!empty($document['document_title'])) : ?>aria-labelledby="<?php echo esc_attr($icon_id); ?>"<?php endif; ?>>
									<div class="document-info-content">
										<?php if (!empty($document['document_file']['url'])) : 
											$file_url = $document['document_file']['url'];
											$file_title = !empty($document['document_title']) ? $document['document_title'] : esc_html__('Download Document', 'promen-elementor-widgets');
											$tooltip_text = isset($settings['tooltip_text']) ? $settings['tooltip_text'] : esc_html__('Download bestand', 'promen-elementor-widgets');
											
											// Get filename and file info for download
											$file_name = basename($file_url);
											$file_id_val = isset($document['document_file']['id']) ? $document['document_file']['id'] : 0;
											
											// Get proper attachment URL - prioritize direct URL for public access
											$attachment_url = wp_get_attachment_url($file_id_val);
											if (!$attachment_url) {
												$attachment_url = $file_url; // Fallback to original URL
											}
											
											// Ensure URL is absolute and publicly accessible
											if (!is_admin() && !str_starts_with($attachment_url, 'http')) {
												$attachment_url = home_url($attachment_url);
											}
										?>
										<button type="button"
												class="document-info-header document-info-download-link" 
												data-file-url="<?php echo esc_attr($attachment_url); ?>"
												data-file-name="<?php echo esc_attr($file_name); ?>"
												data-file-id="<?php echo esc_attr($file_id_val); ?>"
												data-tooltip="<?php echo esc_attr($tooltip_text); ?>"
												aria-label="<?php echo esc_attr(sprintf(__('Klik om %s te downloaden', 'promen-elementor-widgets'), $file_title)); ?>"
												aria-describedby="<?php echo esc_attr($icon_id); ?>">
											<?php if (!empty($document['document_icon']['value'])) : 
												$show_bg = isset($settings['icon_background_show']) ? $settings['icon_background_show'] : 'yes';
											?>
												<div class="document-info-icon<?php echo 'yes' === $show_bg ? ' with-bg' : ''; ?>"
													 id="<?php echo esc_attr($icon_id); ?>"
													 role="img"
													 aria-label="<?php echo esc_attr__('Icoon dat een document of bestand representeert', 'promen-elementor-widgets'); ?>">
													<?php Icons_Manager::render_icon($document['document_icon'], ['aria-hidden' => 'true']); ?>
												</div>
											<?php endif; ?>
											
											<?php if (!empty($document['document_title'])) : ?>
												<div class="document-info-document-title">
													<?php echo esc_html($document['document_title']); ?>
												</div>
											<?php endif; ?>
										</button>
										<?php else : ?>
										<div class="document-info-header">
											<?php if (!empty($document['document_icon']['value'])) : 
												$show_bg = isset($settings['icon_background_show']) ? $settings['icon_background_show'] : 'yes';
											?>
												<div class="document-info-icon<?php echo 'yes' === $show_bg ? ' with-bg' : ''; ?>"
													 id="<?php echo esc_attr($icon_id); ?>"
													 role="img"
													 aria-label="<?php echo esc_attr__('Icoon dat een document of bestand representeert', 'promen-elementor-widgets'); ?>">
													<?php Icons_Manager::render_icon($document['document_icon'], ['aria-hidden' => 'true']); ?>
												</div>
											<?php endif; ?>
											
											<?php if (!empty($document['document_title'])) : ?>
												<div class="document-info-document-title">
													<?php echo esc_html($document['document_title']); ?>
												</div>
											<?php endif; ?>
										</div>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
				<?php endforeach;
			endif; ?>
		</section>



		<script>
		// Add AJAX download nonce for fallback
		window.promenDownloadNonce = '<?php echo wp_create_nonce('promen_download_file'); ?>';
		window.promenAjaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
		
		<?php
		// Generate responsive CSS for mobile breakpoints
		$tablet_breakpoint = isset($settings['tablet_breakpoint']) ? $settings['tablet_breakpoint'] : 768;
		$mobile_breakpoint = isset($settings['mobile_breakpoint']) ? $settings['mobile_breakpoint'] : 480;
		?>
		<style>
		@media (max-width: <?php echo esc_attr($tablet_breakpoint); ?>px) {
			.document-info-list.two-columns {
				grid-template-columns: 1fr;
			}
		}

		@media (max-width: <?php echo esc_attr($mobile_breakpoint); ?>px) {
			.document-info-item {
				flex-direction: column;
			}
			
			.document-info-link-wrapper {
				margin-left: 0;
			}

			.document-info-download-link {
				padding: 12px;
				margin: -12px -12px 2px -12px;
			}

			.document-info-download-link::before {
				bottom: calc(100% + 12px);
				font-size: 11px;
				padding: 6px 10px;
			}
		}
		</style> 
		<?php
	}
}
