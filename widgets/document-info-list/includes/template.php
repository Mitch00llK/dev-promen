<?php
/**
 * Template for Document Info List Widget
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Generate unique ID for animation and accessibility
$widget_id = $this->get_id();
$container_id = Promen_Accessibility_Utils::generate_id('document-info-list', $widget_id);
$column_class = 'two-columns' === $settings['column_layout'] ? 'document-info-list two-columns' : 'document-info-list one-column';

// Container attributes
$container_class = "document-info-list-container promen-widget";
$container_attributes = '';

// GSAP animation preparation
if ('yes' === $settings['enable_animation']) {
    $container_class .= ' document-info-list--animated';
    $animation_type = $settings['animation_type'];
    $animation_delay = $settings['animation_delay']['size'];
    
    $container_attributes .= ' data-animation="' . esc_attr($animation_type) . '"';
    $container_attributes .= ' data-animation-delay="' . esc_attr($animation_delay) . '"';
    $container_attributes .= ' data-animation-id="' . esc_attr($widget_id) . '"';
}

// Year title border class
$year_title_border_class = 'yes' === $settings['year_title_border_bottom'] ? ' has-border' : '';
?>

<section class="<?php echo esc_attr($container_class); ?>" 
         id="<?php echo esc_attr($container_id); ?>"
         role="region" 
         aria-label="<?php echo esc_attr__('Lijst met documenten en bestanden die u kunt downloaden en bekijken', 'promen-elementor-widgets'); ?>"
         <?php echo $container_attributes; ?>>
    <?php 
    // Loop through each year section
    if (!empty($settings['year_sections'])) : 
        foreach ($settings['year_sections'] as $section_index => $year_section) : 
    ?>
        <div class="document-info-year-section" 
             data-section-index="<?php echo esc_attr($section_index); ?>"
             role="group"
             aria-label="<?php echo esc_attr(sprintf(__('Documenten uit het jaar %s die u kunt downloaden', 'promen-elementor-widgets'), $year_section['year'])); ?>">
            <?php if (!empty($year_section['year'])) :
                $year_tag = $settings['year_tag'];
                $year_id = Promen_Accessibility_Utils::generate_id('year-title', $widget_id . '-' . $section_index);
            ?>
                <<?php echo esc_html($year_tag); ?> class="document-info-year-title<?php echo esc_attr($year_title_border_class); ?>"
                                                   id="<?php echo esc_attr($year_id); ?>">
                    <?php echo esc_html($year_section['year']); ?>
                </<?php echo esc_html($year_tag); ?>>
            <?php endif; ?>
            
            <?php if (!empty($year_section['documents'])) : 
                $list_id = Promen_Accessibility_Utils::generate_id('documents-list', $widget_id . '-' . $section_index);
            ?>
                <div class="<?php echo esc_attr($column_class); ?>" 
                     id="<?php echo esc_attr($list_id); ?>"
                     role="list" 
                     aria-labelledby="<?php echo esc_attr($year_id); ?>"
                     aria-label="<?php echo esc_attr(sprintf(__('Documenten uit het jaar %s die u kunt downloaden', 'promen-elementor-widgets'), $year_section['year'])); ?>">
                    <?php foreach ($year_section['documents'] as $doc_index => $document) : 
                        $item_id = Promen_Accessibility_Utils::generate_id('document-item', $widget_id . '-' . $section_index . '-' . $doc_index);
                        $icon_id = Promen_Accessibility_Utils::generate_id('document-icon', $widget_id . '-' . $section_index . '-' . $doc_index);
                    ?>
                        <article class="document-info-item" 
                                 data-item-index="<?php echo esc_attr($doc_index); ?>"
                                 id="<?php echo esc_attr($item_id); ?>"
                                 role="listitem"
                                 tabindex="0"
                                 aria-labelledby="<?php echo !empty($document['document_title']) ? esc_attr($icon_id) : ''; ?>">
                            <div class="document-info-content">
                                <?php if (!empty($document['document_file']['url'])) : 
                                    $file_url = $document['document_file']['url'];
                                    $file_title = !empty($document['document_title']) ? $document['document_title'] : esc_html__('Download Document', 'promen-elementor-widgets');
                                    $tooltip_text = !empty($settings['tooltip_text']) ? $settings['tooltip_text'] : esc_html__('Download bestand', 'promen-elementor-widgets');
                                    
                                    // Get filename and file info for download
                                    $file_name = basename($file_url);
                                    $file_id = $document['document_file']['id'];
                                    
                                    // Get proper attachment URL - prioritize direct URL for public access
                                    $attachment_url = wp_get_attachment_url($file_id);
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
                                        data-file-id="<?php echo esc_attr($file_id); ?>"
                                        data-tooltip="<?php echo esc_attr($tooltip_text); ?>"
                                        aria-label="<?php echo esc_attr(sprintf(__('Klik om %s te downloaden', 'promen-elementor-widgets'), $file_title)); ?>"
                                        aria-describedby="<?php echo esc_attr($icon_id); ?>">
                                    <?php if (!empty($document['document_icon']['value'])) : ?>
                                        <div class="document-info-icon<?php echo 'yes' === $settings['icon_background_show'] ? ' with-bg' : ''; ?>"
                                             id="<?php echo esc_attr($icon_id); ?>"
                                             role="img"
                                             aria-label="<?php echo esc_attr__('Icoon dat een document of bestand representeert', 'promen-elementor-widgets'); ?>">
                                            <?php \Elementor\Icons_Manager::render_icon($document['document_icon'], ['aria-hidden' => 'true']); ?>
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
                                    <?php if (!empty($document['document_icon']['value'])) : ?>
                                        <div class="document-info-icon<?php echo 'yes' === $settings['icon_background_show'] ? ' with-bg' : ''; ?>"
                                             id="<?php echo esc_attr($icon_id); ?>"
                                             role="img"
                                             aria-label="<?php echo esc_attr__('Icoon dat een document of bestand representeert', 'promen-elementor-widgets'); ?>">
                                            <?php \Elementor\Icons_Manager::render_icon($document['document_icon'], ['aria-hidden' => 'true']); ?>
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

<?php if ('yes' === $settings['enable_animation']) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof DocumentInfoListAnimations !== 'undefined') {
        new DocumentInfoListAnimations(
            '<?php echo esc_js($widget_id); ?>',
            '<?php echo esc_js($animation_type); ?>',
            <?php echo esc_js($animation_delay); ?>
        );
    }
}, { passive: true });
</script>
<?php endif; ?>

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
/* Base Styles */
.document-info-list-container {
    width: 100%;
}

.document-info-year-section {
    margin-bottom: 40px;
}

.document-info-year-section:last-child {
    margin-bottom: 0;
}

.document-info-year-title {
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.document-info-year-title.has-border {
    border-bottom: 1px solid #eeeeee;
}

.document-info-list {
    display: grid;
    width: 100%;
}

.document-info-list.two-columns {
    grid-template-columns: 1fr 1fr;
    column-gap: 30px;
}

.document-info-list.one-column {
    grid-template-columns: 1fr;
}

.document-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.document-info-content {
    flex: 1;
}

.document-info-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.document-info-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.document-info-icon.with-bg {
    background-color: #f5f5f5;
    border-radius: 50%;
    width: 48px;
    height: 48px;
}

.document-info-document-title {
    font-weight: 500;
}

.document-info-link-wrapper {
    margin-top: 10px;
    margin-left: 63px; /* Aligns with the icon + margin */
}

.document-info-link {
    display: inline-block;
    color: #0073aa;
    text-decoration: none;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    padding-bottom: 2px;
    cursor: pointer;
}

.document-info-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1px;
    background-color: currentColor;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease-out;
}



/* Responsive Styles */
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
}
</style> 