<?php
/**
 * Text Content Block Widget Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Content_Block_Render {

    /**
     * Render the widget output on the frontend
     */
    public static function render_widget($widget, $settings) {
        // Start widget container
        echo '<div class="promen-text-content-block">';
        
        // Check if sidebar is enabled
        $has_sidebar = !empty($settings['show_contact_sidebar']) && $settings['show_contact_sidebar'] === 'yes';
        $sidebar_position = !empty($settings['sidebar_position']) ? $settings['sidebar_position'] : 'right';
        
        // Start flex container
        echo '<div class="promen-text-content-block__container' . ($has_sidebar ? ' has-sidebar sidebar-' . esc_attr($sidebar_position) : '') . '">';
        
        // If sidebar position is left, render it first
        if ($has_sidebar && $sidebar_position === 'left') {
            self::render_contact_sidebar($widget, $settings);
        }
        
        // Start main content wrapper
        echo '<div class="promen-text-content-block__main-content">';
        
        // Render heading
        self::render_heading($widget, $settings);
        
        // Get content view type
        $content_view_type = !empty($settings['content_view_type']) ? $settings['content_view_type'] : 'standard';
        
        if ($content_view_type === 'standard') {
            // Standard content view - render main content, list, blockquote, and additional text
            self::render_main_content($widget, $settings);
        self::render_list($widget, $settings);
        self::render_blockquote($widget, $settings);
        self::render_additional_text($widget, $settings);
        } else {
            // Flexible content view - render flexible content
            self::render_flexible_content($widget, $settings);
        }
        
        // End main content wrapper
        echo '</div>';
        
        // If sidebar position is right, render it last
        if ($has_sidebar && $sidebar_position === 'right') {
            self::render_contact_sidebar($widget, $settings);
        }
        
        // End flex container
        echo '</div>';
        
        // End widget container
        echo '</div>';
    }
    
    /**
     * Render the heading
     */
    private static function render_heading($widget, $settings) {
        if (empty($settings['show_heading']) || $settings['show_heading'] !== 'yes') {
            return;
        }
        
        $heading_tag = !empty($settings['heading_tag']) ? $settings['heading_tag'] : 'h2';
        $heading_text = !empty($settings['heading_text']) ? $settings['heading_text'] : '';
        
        if (!empty($heading_text)) {
            echo '<' . esc_attr($heading_tag) . ' class="promen-text-content-block__heading">' . esc_html($heading_text) . '</' . esc_attr($heading_tag) . '>';
        }
    }
    
    /**
     * Render the main content
     */
    private static function render_main_content($widget, $settings) {
        if (empty($settings['show_main_content']) || $settings['show_main_content'] !== 'yes') {
            return;
        }
        
        $main_content = !empty($settings['main_content']) ? $settings['main_content'] : '';
        
        if (!empty($main_content)) {
            echo '<div class="promen-text-content-block__content">' . wp_kses_post($main_content) . '</div>';
        }
    }
    
    /**
     * Render the list
     */
    private static function render_list($widget, $settings) {
        if (empty($settings['show_list']) || $settings['show_list'] !== 'yes') {
            return;
        }
        
        $list_type = !empty($settings['list_type']) ? $settings['list_type'] : 'bullet';
        $list_items = !empty($settings['list_items']) ? $settings['list_items'] : [];
        
        if (!empty($list_items)) {
            $list_tag = $list_type === 'numbered' ? 'ol' : 'ul';
            echo '<' . $list_tag . ' class="promen-text-content-block__list ' . esc_attr($list_type) . '">';
            
            foreach ($list_items as $item) {
                echo '<li>' . wp_kses_post($item['list_item_text']) . '</li>';
            }
            
            echo '</' . $list_tag . '>';
        }
    }
    
    /**
     * Render the blockquote
     */
    private static function render_blockquote($widget, $settings) {
        if (empty($settings['show_blockquote']) || $settings['show_blockquote'] !== 'yes') {
            return;
        }
        
        $blockquote_content = !empty($settings['blockquote_content']) ? $settings['blockquote_content'] : '';
        
        if (!empty($blockquote_content)) {
            // Add class to hide quotes if needed
            $quote_class = '';
            if (isset($settings['blockquote_show_quotes']) && $settings['blockquote_show_quotes'] !== 'yes') {
                $quote_class = ' hide-quotes';
            }
            
            echo '<blockquote class="promen-text-content-block__blockquote' . esc_attr($quote_class) . '">' . wp_kses_post($blockquote_content) . '</blockquote>';
        }
    }
    
    /**
     * Render the additional text
     */
    private static function render_additional_text($widget, $settings) {
        if (empty($settings['show_additional_text']) || $settings['show_additional_text'] !== 'yes') {
            return;
        }
        
        $additional_text = !empty($settings['additional_text']) ? $settings['additional_text'] : '';
        
        if (!empty($additional_text)) {
            echo '<div class="promen-text-content-block__additional-text">' . wp_kses_post($additional_text) . '</div>';
        }
    }
    
    /**
     * Render the contact sidebar
     */
    private static function render_contact_sidebar($widget, $settings) {
        // Determine if sidebar should be sticky
        $sticky_class = !empty($settings['sidebar_sticky']) && $settings['sidebar_sticky'] === 'yes' ? ' sticky' : '';
        
        // Get positions for sidebar elements
        $contact_position = isset($settings['contact_position']) ? intval($settings['contact_position']) : 1;
        $job_vacancy_position = isset($settings['job_vacancy_position']) ? intval($settings['job_vacancy_position']) : 2;
        $newsletter_position = isset($settings['newsletter_position']) ? intval($settings['newsletter_position']) : 3;
        
        // Check which elements are enabled
        $show_contact = !empty($settings['show_contact_sidebar']) && $settings['show_contact_sidebar'] === 'yes';
        $show_job_vacancy = !empty($settings['show_job_vacancies']) && $settings['show_job_vacancies'] === 'yes';
        $show_newsletter = !empty($settings['show_newsletter_form']) && $settings['show_newsletter_form'] === 'yes';
        
        // Create an array of elements with their positions
        $sidebar_elements = [];
        
        if ($show_contact) {
            $sidebar_elements[$contact_position] = 'contact';
        }
        
        if ($show_job_vacancy) {
            $sidebar_elements[$job_vacancy_position] = 'job_vacancy';
        }
        
        if ($show_newsletter) {
            $sidebar_elements[$newsletter_position] = 'newsletter';
        }
        
        // Sort elements by position
        ksort($sidebar_elements);
        
        // Start sidebar wrapper
        echo '<div class="promen-text-content-block__sidebar-wrapper">';
        
        // Render elements in order
        foreach ($sidebar_elements as $position => $element_type) {
            switch ($element_type) {
                case 'contact':
                    self::render_contact_info($widget, $settings, $sticky_class);
                    break;
                    
                case 'job_vacancy':
                    self::render_job_vacancy($widget, $settings);
                    break;
                    
                case 'newsletter':
                    self::render_newsletter_form($widget, $settings);
                    break;
            }
        }
        
        // End sidebar wrapper
        echo '</div>';
    }
    
    /**
     * Render just the contact info part
     */
    private static function render_contact_info($widget, $settings, $sticky_class) {
        // Start contact sidebar container
        echo '<div class="promen-text-content-block__sidebar' . esc_attr($sticky_class) . '">';
        
        // Render contact image if available
        if (!empty($settings['contact_image']['url'])) {
            echo '<div class="promen-text-content-block__contact-image">';
            echo '<img src="' . esc_url($settings['contact_image']['url']) . '" alt="Contact Person">';
            echo '</div>';
        }
        
        // Render sidebar title
        if (!empty($settings['sidebar_title'])) {
            echo '<span class="promen-text-content-block__sidebar-title">' . esc_html($settings['sidebar_title']) . '</span>';
        }
        
        // Render contact person name
        if (!empty($settings['contact_person_label'])) {
            echo '<div class="promen-text-content-block__contact-person">' . esc_html($settings['contact_person_label']) . '</div>';
        }
        
        // Start contact details container
        echo '<div class="promen-text-content-block__contact-details">';
        
        // Render email if available
        if (!empty($settings['contact_email'])) {
            echo '<div class="contact-item contact-email">';
            echo '<a href="mailto:' . esc_attr($settings['contact_email']) . '">';
            echo '<span class="icon"><i aria-hidden="true" class="fas fa-envelope"></i></span> ';
            echo esc_html($settings['contact_email']);
            echo '</a>';
            echo '</div>';
        }
        
        // Render phone if available
        if (!empty($settings['contact_phone'])) {
            echo '<div class="contact-item contact-phone">';
            echo '<a href="tel:' . esc_attr(preg_replace('/[^0-9+]/', '', $settings['contact_phone'])) . '">';
            echo '<span class="icon"><i aria-hidden="true" class="fas fa-phone"></i></span> ';
            echo esc_html($settings['contact_phone']);
            echo '</a>';
            echo '</div>';
        }
        
        // End contact details container
        echo '</div>';
        
        // End contact sidebar container
        echo '</div>';
    }
    
    /**
     * Render the job vacancy section
     */
    private static function render_job_vacancy($widget, $settings) {
        // Get section title
        $section_title = !empty($settings['job_vacancy_section_title']) ? $settings['job_vacancy_section_title'] : esc_html__('Vacature in het kort', 'promen-elementor-widgets');
        
        // Get vacancy items
        $vacancy_items = !empty($settings['job_vacancy_items']) ? $settings['job_vacancy_items'] : [];
        
        // Get button text and link
        $button_text = !empty($settings['job_vacancy_button_text']) ? $settings['job_vacancy_button_text'] : esc_html__('Solliciteer direct', 'promen-elementor-widgets');
        $button_link = !empty($settings['job_vacancy_button_link']['url']) ? $settings['job_vacancy_button_link'] : ['url' => '#'];
        
        // Start job vacancy container
        echo '<div class="promen-text-content-block__job-vacancy">';
        
        // Render section title
        if (!empty($section_title)) {
            echo '<div class="promen-text-content-block__job-vacancy-title">' . esc_html($section_title) . '</div>';
        }
        
        // Render vacancy items
        if (!empty($vacancy_items)) {
            echo '<div class="promen-text-content-block__job-vacancy-items">';
            
            foreach ($vacancy_items as $item) {
                echo '<div class="promen-text-content-block__job-vacancy-item">';
                
                if (!empty($item['vacancy_label'])) {
                    echo '<div class="promen-text-content-block__job-vacancy-item-label">' . esc_html($item['vacancy_label']) . '</div>';
                }
                
                if (!empty($item['vacancy_value'])) {
                    echo '<div class="promen-text-content-block__job-vacancy-item-value">' . esc_html($item['vacancy_value']) . '</div>';
                }
                
                echo '</div>';
            }
            
            echo '</div>';
        }
        
        // Render button
        if (!empty($button_text) && !empty($button_link['url'])) {
            $target = !empty($button_link['is_external']) ? ' target="_blank"' : '';
            $nofollow = !empty($button_link['nofollow']) ? ' rel="nofollow"' : '';
            
            echo '<div class="promen-text-content-block__job-vacancy-button-wrapper">';
            echo '<a href="' . esc_url($button_link['url']) . '"' . $target . $nofollow . ' class="promen-text-content-block__job-vacancy-button">';
            echo esc_html($button_text) . ' <i aria-hidden="true" class="fas fa-chevron-right"></i>';
            echo '</a>';
            echo '</div>';
        }
        
        // End job vacancy container
        echo '</div>';
    }
    
    /**
     * Render the newsletter subscription form
     */
    private static function render_newsletter_form($widget, $settings) {
        // Check if we have a Gravity Form ID
        $gravity_form_id = !empty($settings['gravity_form_id']) ? $settings['gravity_form_id'] : '';
        $newsletter_title = !empty($settings['newsletter_title']) ? $settings['newsletter_title'] : '';
        $privacy_note = !empty($settings['privacy_note']) ? $settings['privacy_note'] : '';
        $privacy_link = !empty($settings['privacy_link']['url']) ? $settings['privacy_link'] : ['url' => '#'];
        $button_text = !empty($settings['subscribe_button_text']) ? $settings['subscribe_button_text'] : '';
        
        // Start newsletter container
        echo '<div class="promen-text-content-block__newsletter">';
        
        // Newsletter title
        if (!empty($newsletter_title)) {
            echo '<div class="promen-text-content-block__newsletter-title">' . esc_html($newsletter_title) . '</div>';
        }
        
        // If we have a Gravity Form ID, use the shortcode
        if (!empty($gravity_form_id)) {
            // Use do_shortcode to render the Gravity Form
            echo do_shortcode('[gravityform id="' . esc_attr($gravity_form_id) . '" title="false" description="false" ajax="true"]');
        } else {
            // Fallback to a styled newsletter form that matches the screenshot
            echo '<div class="promen-text-content-block__newsletter-form">';
            
            // Input field
            echo '<div class="newsletter-input-wrapper">';
            echo '<input type="email" class="newsletter-email" placeholder="' . esc_attr__('Uw e-mailadres', 'promen-elementor-widgets') . '">';
            echo '</div>';
            
            // Button
            if (!empty($button_text)) {
                echo '<button type="button" class="newsletter-submit">';
                echo esc_html($button_text) . ' <i aria-hidden="true" class="fas fa-chevron-right"></i>';
                echo '</button>';
            }
            
            echo '</div>';
            
            // Add a note about setting up a Gravity Form
            echo '<div class="newsletter-setup-note" style="font-size: 12px; color: #666; margin-top: 10px;">';
            echo esc_html__('Please set a Gravity Form ID in the widget settings.', 'promen-elementor-widgets');
            echo '</div>';
        }
        
        // Privacy note
        if (!empty($privacy_note)) {
            echo '<div class="promen-text-content-block__privacy-note">';
            echo esc_html__('Bij het inschrijven ga je akkoord met onze ', 'promen-elementor-widgets');
            
            // Add privacy policy link
            $target = !empty($privacy_link['is_external']) ? ' target="_blank"' : '';
            $nofollow = !empty($privacy_link['nofollow']) ? ' rel="nofollow"' : '';
            echo '<a href="' . esc_url($privacy_link['url']) . '"' . $target . $nofollow . '>' . esc_html__('Privacyverklaring', 'promen-elementor-widgets') . '</a>';
            
            echo '</div>';
        }
        
        // End newsletter container
        echo '</div>';
    }

    /**
     * Render the flexible content
     */
    private static function render_flexible_content($widget, $settings) {
        $flexible_items = !empty($settings['flexible_content_items']) ? $settings['flexible_content_items'] : [];
        
        if (empty($flexible_items)) {
            return;
        }
        
        echo '<div class="promen-text-content-block__flexible-content">';
        
        foreach ($flexible_items as $item) {
            $content_type = !empty($item['content_type']) ? $item['content_type'] : 'text';
            
            echo '<div class="promen-text-content-block__flexible-item promen-text-content-block__flexible-' . esc_attr($content_type) . '">';
            
            switch ($content_type) {
                case 'text':
                    $text_content = !empty($item['text_content']) ? $item['text_content'] : '';
                    if (!empty($text_content)) {
                        echo '<div class="promen-text-content-block__flexible-text">' . wp_kses_post($text_content) . '</div>';
                    }
                    break;
                    
                case 'heading':
                    $heading_text = !empty($item['heading_text']) ? $item['heading_text'] : '';
                    $heading_tag = !empty($item['heading_tag']) ? $item['heading_tag'] : 'h2';
                    
                    if (!empty($heading_text)) {
                        echo '<' . esc_attr($heading_tag) . ' class="promen-text-content-block__flexible-heading">' . esc_html($heading_text) . '</' . esc_attr($heading_tag) . '>';
                    }
                    break;
                    
                case 'image':
                    $image = !empty($item['image']['url']) ? $item['image'] : null;
                    $image_caption = !empty($item['image_caption']) ? $item['image_caption'] : '';
                    $image_alignment = !empty($item['image_alignment']) ? $item['image_alignment'] : 'center';
                    $image_size = !empty($item['image_size']) ? $item['image_size'] : 'large';
                    
                    if (!empty($image)) {
                        echo '<figure class="promen-text-content-block__flexible-image text-align-' . esc_attr($image_alignment) . '">';
                        
                        if (!empty($image['id'])) {
                            // Use WordPress image functions if we have an ID
                            echo wp_get_attachment_image($image['id'], $image_size, false, [
                                'class' => 'promen-text-content-block__image',
                                'alt' => !empty($image_caption) ? esc_attr($image_caption) : esc_attr__('Content image', 'promen-elementor-widgets'),
                            ]);
                        } else {
                            // Fallback to URL if no ID is available
                            echo '<img src="' . esc_url($image['url']) . '" class="promen-text-content-block__image" alt="' . 
                                (!empty($image_caption) ? esc_attr($image_caption) : esc_attr__('Content image', 'promen-elementor-widgets')) . '">';
                        }
                        
                        if (!empty($image_caption)) {
                            echo '<figcaption>' . esc_html($image_caption) . '</figcaption>';
                        }
                        
                        echo '</figure>';
                    }
                    break;
                    
                case 'blockquote':
                    $blockquote_content = !empty($item['blockquote_content']) ? $item['blockquote_content'] : '';
                    
                    if (!empty($blockquote_content)) {
                        // Add class to hide quotes if needed
                        $quote_class = '';
                        if (isset($item['blockquote_show_quotes']) && $item['blockquote_show_quotes'] !== 'yes') {
                            $quote_class = ' hide-quotes';
                        }
                        
                        echo '<blockquote class="promen-text-content-block__blockquote' . esc_attr($quote_class) . '">' . wp_kses_post($blockquote_content) . '</blockquote>';
                    }
                    break;
                    
                case 'spacer':
                    $spacer_height = !empty($item['spacer_height']['size']) ? $item['spacer_height']['size'] . $item['spacer_height']['unit'] : '40px';
                    echo '<div class="promen-text-content-block__flexible-spacer" style="height: ' . esc_attr($spacer_height) . ';"></div>';
                    break;
                
                case 'video':
                    $video_type = !empty($item['video_type']) ? $item['video_type'] : 'youtube';
                    $video_class = 'promen-text-content-block__flexible-video';
                    $video_ratio = !empty($item['video_ratio']) ? $item['video_ratio'] : '169';
                    
                    // Prepare video options
                    $video_autoplay = !empty($item['video_autoplay']) && $item['video_autoplay'] === 'yes';
                    $video_loop = !empty($item['video_loop']) && $item['video_loop'] === 'yes';
                    $video_controls = !empty($item['video_controls']) && $item['video_controls'] === 'yes';
                    $video_mute = !empty($item['video_mute']) && $item['video_mute'] === 'yes';
                    
                    echo '<div class="' . esc_attr($video_class) . '" data-ratio="' . esc_attr($video_ratio) . '">';
                    
                    if ($video_type === 'youtube') {
                        // YouTube Video
                        $youtube_url = !empty($item['youtube_url']) ? $item['youtube_url'] : '';
                        
                        if (!empty($youtube_url)) {
                            // Extract YouTube ID from URL
                            preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:embed\/|watch\?v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $youtube_url, $matches);
                            $youtube_id = isset($matches[1]) ? $matches[1] : '';
                            
                            if (!empty($youtube_id)) {
                                $youtube_params = [
                                    'autoplay' => $video_autoplay ? 1 : 0,
                                    'loop' => $video_loop ? 1 : 0,
                                    'controls' => $video_controls ? 1 : 0,
                                    'mute' => $video_mute ? 1 : 0,
                                    'rel' => 0,
                                    'modestbranding' => 1,
                                ];
                                
                                // Ensure playlist is set for loop functionality
                                if ($video_loop) {
                                    $youtube_params['playlist'] = $youtube_id;
                                }
                                
                                $youtube_params_str = http_build_query($youtube_params);
                                
                                echo '<div class="elementor-video-container" style="--aspect-ratio: ' . esc_attr(self::get_aspect_ratio($video_ratio)) . ';">
                                    <iframe src="https://www.youtube.com/embed/' . esc_attr($youtube_id) . '?' . esc_attr($youtube_params_str) . '" 
                                    frameborder="0" allowfullscreen></iframe>
                                </div>';
                            }
                        }
                    } elseif ($video_type === 'vimeo') {
                        // Vimeo Video
                        $vimeo_url = !empty($item['vimeo_url']) ? $item['vimeo_url'] : '';
                        
                        if (!empty($vimeo_url)) {
                            // Extract Vimeo ID from URL
                            preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:vimeo\.com\/)([0-9]+)/', $vimeo_url, $matches);
                            $vimeo_id = isset($matches[1]) ? $matches[1] : '';
                            
                            if (!empty($vimeo_id)) {
                                $vimeo_params = [
                                    'autoplay' => $video_autoplay ? 1 : 0,
                                    'loop' => $video_loop ? 1 : 0,
                                    'muted' => $video_mute ? 1 : 0,
                                    'title' => 0,
                                    'byline' => 0,
                                    'portrait' => 0,
                                ];
                                
                                $vimeo_params_str = http_build_query($vimeo_params);
                                
                                echo '<div class="elementor-video-container" style="--aspect-ratio: ' . esc_attr(self::get_aspect_ratio($video_ratio)) . ';">
                                    <iframe src="https://player.vimeo.com/video/' . esc_attr($vimeo_id) . '?' . esc_attr($vimeo_params_str) . '" 
                                    frameborder="0" allowfullscreen></iframe>
                                </div>';
                            }
                        }
                    } else {
                        // Self Hosted Video
                        $video_url = !empty($item['hosted_video']['url']) ? $item['hosted_video']['url'] : '';
                        $poster_url = !empty($item['video_poster']['url']) ? $item['video_poster']['url'] : '';
                        
                        if (!empty($video_url)) {
                            $video_attrs = [];
                            if ($video_autoplay) $video_attrs[] = 'autoplay';
                            if ($video_loop) $video_attrs[] = 'loop';
                            if ($video_controls) $video_attrs[] = 'controls';
                            if ($video_mute) $video_attrs[] = 'muted';
                            
                            echo '<div class="elementor-video-container" style="--aspect-ratio: ' . esc_attr(self::get_aspect_ratio($video_ratio)) . ';">
                                <video ' . implode(' ', $video_attrs) . (!empty($poster_url) ? ' poster="' . esc_url($poster_url) . '"' : '') . ' playsinline>
                                    <source src="' . esc_url($video_url) . '" type="video/mp4">
                                    ' . esc_html__('Your browser does not support the video tag.', 'promen-elementor-widgets') . '
                                </video>
                            </div>';
                        }
                    }
                    
                    echo '</div>';
                    break;

                case 'collapsible':
                    $collapsible_content = self::prepare_collapsible_block($item);
                    if (empty($collapsible_content['html'])) {
                        break;
                    }

                    $collapsible_id = 'promen-collapsible-' . uniqid();
                    $is_expanded = !empty($item['collapsible_default_state']) && $item['collapsible_default_state'] === 'expanded';
                    $title = !empty($item['collapsible_title']) ? $item['collapsible_title'] : esc_html__('Meer informatie', 'promen-elementor-widgets');
                    
                    echo '<div class="promen-text-content-block__collapsible" data-promen-collapsible>';
                        echo '<button type="button" class="promen-text-content-block__collapsible-trigger" aria-expanded="' . ($is_expanded ? 'true' : 'false') . '" aria-controls="' . esc_attr($collapsible_id) . '">';
                            echo '<span class="promen-text-content-block__collapsible-title">' . esc_html($title) . '</span>';
                            echo '<span class="promen-text-content-block__collapsible-icon" aria-hidden="true"></span>';
                        echo '</button>';

                        echo '<div id="' . esc_attr($collapsible_id) . '" class="promen-text-content-block__collapsible-panel" role="region" aria-hidden="' . ($is_expanded ? 'false' : 'true') . '"' . ($is_expanded ? '' : ' hidden') . '>';
                            echo '<div class="promen-text-content-block__collapsible-text">' . $collapsible_content['html'] . '</div>';
                            if (!empty($collapsible_content['plain'])) {
                                $play_label = esc_html__('Voorlezen', 'promen-elementor-widgets');
                                $stop_label = esc_html__('Stop voorlezen', 'promen-elementor-widgets');
                                echo '<div class="promen-text-content-block__collapsible-toolbar">';
                                    echo '<button type="button" class="promen-text-content-block__tts" data-tts-text="' . esc_attr($collapsible_content['plain']) . '" data-tts-label-play="' . esc_attr($play_label) . '" data-tts-label-stop="' . esc_attr($stop_label) . '">';
                                        echo '<span class="promen-text-content-block__tts-icon" aria-hidden="true"><i class="fa-solid fa-play" aria-hidden="true"></i></span>';
                                        echo '<span class="promen-text-content-block__tts-label">' . esc_html($play_label) . '</span>';
                                    echo '</button>';
                                echo '</div>';
                            }
                        echo '</div>';
                    echo '</div>';

                    break;
            }
            
            echo '</div>'; // End flexible item
        }
        
        echo '</div>'; // End flexible content
    }

    /**
     * Get aspect ratio value from the ratio setting
     */
    private static function get_aspect_ratio($ratio) {
        $ratio_values = [
            '169' => '0.5625',  // 16:9
            '219' => '0.4285',  // 21:9
            '43' => '0.75',     // 4:3
            '32' => '0.6666',   // 3:2
            '11' => '1',        // 1:1
        ];
        
        return isset($ratio_values[$ratio]) ? $ratio_values[$ratio] : $ratio_values['169'];
    }

    /**
     * Prepare collapsible block content
     */
    private static function prepare_collapsible_block($item) {
        $result = [
            'html' => '',
            'plain' => '',
        ];

        $document_content = [];
        if (!empty($item['collapsible_document'])) {
            $document_content = self::extract_document_text($item['collapsible_document']);
        }

        $html_content = !empty($document_content['html']) ? $document_content['html'] : '';
        $plain_text = !empty($document_content['plain']) ? $document_content['plain'] : '';

        if (empty($html_content) && !empty($item['collapsible_manual_text'])) {
            $html_content = wp_kses_post($item['collapsible_manual_text']);
            $plain_text = wp_strip_all_tags($html_content);
        }

        if (!empty($html_content)) {
            // Make sentences containing "zegt:" bold
            $html_content = self::bold_sentences_with_zegt($html_content);
            $result['html'] = $html_content;
            $result['plain'] = self::normalize_plain_text($plain_text);
        }

        return $result;
    }

    /**
     * Make sentences containing "zegt:" bold
     * 
     * @param string $html_content The HTML content to process
     * @return string Processed HTML with bold sentences
     */
    private static function bold_sentences_with_zegt($html_content) {
        if (empty($html_content)) {
            return $html_content;
        }

        // Pattern to match "zegt:" (case insensitive, with optional spaces)
        // Matches: "zegt:", "zegt :", "Zegt:", etc.
        $pattern = '/\b(zegt\s*:)/i';
        
        // Process each paragraph separately to preserve HTML structure
        $processed_content = preg_replace_callback(
            '/(<p[^>]*>)(.*?)(<\/p>)/is',
            function($matches) use ($pattern) {
                $open_tag = $matches[1];
                $content = $matches[2];
                $close_tag = $matches[3];
                
                // Strip HTML tags temporarily to check for "zegt:"
                $text_content = wp_strip_all_tags($content);
                
                // Check if content contains "zegt:"
                if (preg_match($pattern, $text_content)) {
                    // Split into sentences (preserve delimiters)
                    // Match sentence boundaries: . ! ? followed by space or end of string
                    $sentences = preg_split('/([.!?]+(?:\s+|$))/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
                    $processed = '';
                    
                    foreach ($sentences as $sentence) {
                        $trimmed = trim($sentence);
                        if (empty($trimmed)) {
                            $processed .= $sentence;
                            continue;
                        }
                        
                        // Strip HTML to check if sentence contains "zegt:"
                        $sentence_text = wp_strip_all_tags($sentence);
                        if (preg_match($pattern, $sentence_text)) {
                            // Wrap in strong, but preserve existing HTML structure
                            // Check if already wrapped in strong
                            if (stripos($sentence, '<strong') === false) {
                                $processed .= '<strong>' . $sentence . '</strong>';
                            } else {
                                $processed .= $sentence;
                            }
                        } else {
                            $processed .= $sentence;
                        }
                    }
                    
                    return $open_tag . $processed . $close_tag;
                }
                
                return $matches[0];
            },
            $html_content
        );
        
        return $processed_content;
    }

    /**
     * Extract text from an uploaded document
     */
    private static function extract_document_text($document_field) {
        $result = [
            'html' => '',
            'plain' => '',
        ];

        if (empty($document_field['id']) && empty($document_field['url'])) {
            return $result;
        }

        $file_path = '';
        $extension = '';
        $temp_file = null;
        $content = '';

        if (!empty($document_field['id'])) {
            $file_path = get_attached_file($document_field['id']);
            if ($file_path && file_exists($file_path)) {
                $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            }
        }

        if (empty($file_path) && !empty($document_field['url'])) {
            // Create a cache key for this document URL
            $cache_key = 'promen_doc_text_' . md5($document_field['url']);
            $cached_data = get_transient($cache_key);

            if ($cached_data !== false) {
                return $cached_data;
            }

            $path = parse_url($document_field['url'], PHP_URL_PATH);
            $extension = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : '';
            
            // Download remote file temporarily for DOCX processing
            if ($extension === 'docx') {
                $temp_file = download_url($document_field['url']);
                if (!is_wp_error($temp_file)) {
                    $file_path = $temp_file;
                }
            } else {
                $remote_response = wp_remote_get($document_field['url'], ['timeout' => 10]);
                if (!is_wp_error($remote_response) && wp_remote_retrieve_response_code($remote_response) === 200) {
                    $content = wp_remote_retrieve_body($remote_response);
                }
            }
        }

        // Handle DOCX files
        if ($extension === 'docx' && !empty($file_path) && file_exists($file_path)) {
            $docx_text = self::extract_docx_text($file_path);
            
            // Clean up temporary file if it was downloaded
            if ($temp_file !== null && file_exists($temp_file)) {
                @unlink($temp_file);
            }
            
            if (!empty($docx_text)) {
                $paragraphs = array_filter(array_map('trim', preg_split('/\R+/', $docx_text)));
                
                if (!empty($paragraphs)) {
                    $html = '';
                    foreach ($paragraphs as $paragraph) {
                        if (!empty($paragraph)) {
                            $html .= '<p>' . esc_html($paragraph) . '</p>';
                        }
                    }
                    
                    $result['html'] = $html;
                    $result['plain'] = $docx_text;

                    // Cache the result for 24 hours if we possess a URL acting as a key
                    if (isset($cache_key) && !empty($document_field['url'])) {
                        set_transient($cache_key, $result, DAY_IN_SECONDS);
                    }
                }
            }
            
            return $result;
        }

        // Handle other file types
        $content = '';
        if (!empty($file_path) && file_exists($file_path)) {
            $content = file_get_contents($file_path);
        }

        if (empty($content)) {
            return $result;
        }

        $content = trim($content);

        if ($content === '') {
            return $result;
        }

        $html_extensions = ['html', 'htm'];
        $text_extensions = ['txt', 'text', 'md', 'markdown'];

        if (in_array($extension, $html_extensions, true)) {
            $result['html'] = wp_kses_post($content);
            $result['plain'] = wp_strip_all_tags($content);
            return $result;
        }

        if (!in_array($extension, array_merge($html_extensions, $text_extensions), true)) {
            // Attempt to treat unknown types as plain text
            $text_extensions[] = $extension;
        }

        $paragraphs = array_filter(array_map('trim', preg_split('/\R+/', $content)));

        if (!empty($paragraphs)) {
            $html = '';
            foreach ($paragraphs as $paragraph) {
                $html .= '<p>' . esc_html($paragraph) . '</p>';
            }

            $result['html'] = $html;
            $result['plain'] = implode(' ', $paragraphs);
        }

        if (isset($cache_key) && !empty($document_field['url'])) {
            set_transient($cache_key, $result, DAY_IN_SECONDS);
        }

        return $result;
    }

    /**
     * Extract plain text from DOCX file
     * DOCX files are ZIP archives containing XML files
     * Extracts only text content, no formatting
     * 
     * @param string $file_path Path to the DOCX file
     * @return string Extracted plain text with preserved paragraphs
     */
    private static function extract_docx_text($file_path) {
        if (!file_exists($file_path)) {
            return '';
        }

        // Check if ZipArchive is available
        if (!class_exists('ZipArchive')) {
            return '';
        }

        $zip = new ZipArchive();
        $result = $zip->open($file_path, ZipArchive::RDONLY);
        
        if ($result !== true) {
            return '';
        }

        // Read the main document XML file
        $xml_content = $zip->getFromName('word/document.xml');
        $zip->close();

        if (empty($xml_content)) {
            return '';
        }

        // Load XML and extract text nodes
        // Suppress warnings for malformed XML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xml_content);
        libxml_clear_errors();

        if ($xml === false) {
            return '';
        }

        // Register namespaces
        $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        // Extract paragraphs - each <w:p> is a paragraph
        $paragraphs = $xml->xpath('//w:p');
        
        $text_paragraphs = [];
        
        if (!empty($paragraphs)) {
            foreach ($paragraphs as $paragraph) {
                // Get all text runs within this paragraph
                $text_runs = $paragraph->xpath('.//w:t');
                
                $paragraph_text = '';
                if (!empty($text_runs)) {
                    foreach ($text_runs as $text_run) {
                        $text = (string) $text_run;

                        // Respect xml:space attribute if present
                        $attributes = $text_run->attributes('xml', true);
                        $preserve_space = isset($attributes['space']) && strtolower((string) $attributes['space']) === 'preserve';

                        if (!$preserve_space) {
                            $text = trim($text);
                        }

                        if ($text === '') {
                            continue;
                        }

                        // Add a space if the previous character isn't whitespace
                        // and the current run doesn't start with whitespace
                        $needs_space = $paragraph_text !== '' &&
                            !preg_match('/\s$/u', $paragraph_text) &&
                            !preg_match('/^\s/u', $text);

                        if ($needs_space) {
                            $paragraph_text .= ' ';
                        }

                        $paragraph_text .= $text;
                    }
                }
                
                // Only add non-empty paragraphs
                $paragraph_text = trim($paragraph_text);
                if (!empty($paragraph_text)) {
                    $text_paragraphs[] = $paragraph_text;
                }
            }
        }

        // Join paragraphs with newlines to preserve structure
        $extracted_text = implode("\n", $text_paragraphs);
        
        // Normalize multiple whitespace but preserve newlines
        $extracted_text = preg_replace('/[ \t]+/u', ' ', $extracted_text);
        $extracted_text = preg_replace('/\n\s*\n/u', "\n\n", $extracted_text);
        $extracted_text = trim($extracted_text);

        return $extracted_text;
    }

    /**
     * Normalize text for text-to-speech
     * Removes HTML, normalizes whitespace, and cleans up text
     */
    private static function normalize_plain_text($text) {
        if (empty($text)) {
            return '';
        }

        // Remove all HTML tags
        $stripped = wp_strip_all_tags($text);
        
        // Replace HTML entities with their characters
        $stripped = html_entity_decode($stripped, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Normalize whitespace - replace multiple spaces/tabs/newlines with single space
        $condensed = preg_replace('/[\s\t\n\r]+/u', ' ', $stripped);
        
        // Remove zero-width spaces and other invisible characters
        $condensed = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $condensed);
        
        // Clean up around punctuation
        $condensed = preg_replace('/\s+([,.!?;:])/u', '$1', $condensed);
        $condensed = preg_replace('/([,.!?;:])\s+/u', '$1 ', $condensed);
        
        return trim($condensed);
    }

    /**
     * Render the social sharing buttons
     */
    public static function render_social_sharing($settings) {
        if (empty($settings['show_social_sharing']) || $settings['show_social_sharing'] !== 'yes') {
            return;
        }

        $position = isset($settings['social_sharing_position']) ? $settings['social_sharing_position'] : 'bottom';
        $alignment = isset($settings['social_sharing_alignment']) ? $settings['social_sharing_alignment'] : 'left';
        $current_url = esc_url(get_permalink());
        $share_title = get_the_title();
        $page_title = isset($settings['social_sharing_title']) ? esc_html($settings['social_sharing_title']) : esc_html__('Share this content', 'promen-elementor-widgets');
        
        $icon_size = isset($settings['social_sharing_icon_size']['size']) ? $settings['social_sharing_icon_size']['size'] : 24;
        $icon_spacing = isset($settings['social_sharing_icon_spacing']['size']) ? $settings['social_sharing_icon_spacing']['size'] : 15;
        
        $style = 'font-size: ' . $icon_size . 'px; margin-right: ' . $icon_spacing . 'px;';
        
        $output = '<div class="promen-text-content-block__social-sharing">';
        
        if (!empty($page_title)) {
            $output .= '<h4 class="promen-text-content-block__social-sharing-title">' . $page_title . '</h4>';
        }
        
        $output .= '<div class="promen-text-content-block__social-share-buttons text-' . $alignment . '">';
        
        // Facebook
        if (!empty($settings['share_facebook']) && $settings['share_facebook'] === 'yes') {
            $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($current_url);
            $output .= '<a href="' . $facebook_url . '" target="_blank" rel="noopener noreferrer" class="social-share-item facebook">';
            $output .= '<i class="fab fa-facebook-f social-sharing-icon" style="' . $style . '"></i>';
            $output .= '</a>';
        }
        
        // Twitter/X
        if (!empty($settings['share_twitter']) && $settings['share_twitter'] === 'yes') {
            $twitter_url = 'https://twitter.com/intent/tweet?url=' . urlencode($current_url) . '&text=' . urlencode($share_title);
            $output .= '<a href="' . $twitter_url . '" target="_blank" rel="noopener noreferrer" class="social-share-item twitter">';
            $output .= '<i class="fab fa-twitter social-sharing-icon" style="' . $style . '"></i>';
            $output .= '</a>';
        }
        
        // LinkedIn
        if (!empty($settings['share_linkedin']) && $settings['share_linkedin'] === 'yes') {
            $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($current_url);
            $output .= '<a href="' . $linkedin_url . '" target="_blank" rel="noopener noreferrer" class="social-share-item linkedin">';
            $output .= '<i class="fab fa-linkedin-in social-sharing-icon" style="' . $style . '"></i>';
            $output .= '</a>';
        }
        
        // WhatsApp
        if (!empty($settings['share_whatsapp']) && $settings['share_whatsapp'] === 'yes') {
            $whatsapp_url = 'https://api.whatsapp.com/send?text=' . urlencode($share_title . ' ' . $current_url);
            $output .= '<a href="' . $whatsapp_url . '" target="_blank" rel="noopener noreferrer" class="social-share-item whatsapp">';
            $output .= '<i class="fab fa-whatsapp social-sharing-icon" style="' . $style . '"></i>';
            $output .= '</a>';
        }
        
        // Email
        if (!empty($settings['share_email']) && $settings['share_email'] === 'yes') {
            $email_subject = urlencode($share_title);
            $email_body = urlencode($share_title . ' ' . $current_url);
            $email_url = 'mailto:?subject=' . $email_subject . '&body=' . $email_body;
            $output .= '<a href="' . $email_url . '" class="social-share-item email">';
            $output .= '<i class="fas fa-envelope social-sharing-icon" style="' . $style . '"></i>';
            $output .= '</a>';
        }
        
        $output .= '</div>'; // end social-share-buttons
        $output .= '</div>'; // end social-sharing
        
        echo $output;
    }

    /**
     * Render the text content block widget frontend output
     */
    public static function render_text_content_block_widget($settings) {
        $heading = isset($settings['heading']) ? $settings['heading'] : '';
        $template_select = isset($settings['template_select']) ? $settings['template_select'] : 'default';
        $flexible_content = isset($settings['flexible_content']) ? $settings['flexible_content'] : array();

        ?>
        <div class="promen-text-content-block__container <?php echo esc_attr($template_select); ?>">
            <?php if ($template_select === 'default' || $template_select === 'sidebar_left'): ?>
                <div class="promen-text-content-block__content">
                    <?php 
                    if (!empty($heading)) {
                        echo '<h2 class="promen-text-content-block__heading">' . esc_html($heading) . '</h2>';
                    }
                    
                    // Show social sharing at the top if position is 'top' or 'both'
                    if (!empty($settings['show_social_sharing']) && $settings['show_social_sharing'] === 'yes' && 
                       (!empty($settings['social_sharing_position']) && 
                       ($settings['social_sharing_position'] === 'top' || $settings['social_sharing_position'] === 'both'))) {
                        self::render_social_sharing($settings);
                    }
                    
                    // Render flexible content
                    self::render_flexible_content($flexible_content);
                    
                    // Show social sharing at the bottom if position is 'bottom' or 'both'
                    if (!empty($settings['show_social_sharing']) && $settings['show_social_sharing'] === 'yes' && 
                       (empty($settings['social_sharing_position']) || 
                       $settings['social_sharing_position'] === 'bottom' || 
                       $settings['social_sharing_position'] === 'both')) {
                        self::render_social_sharing($settings);
                    }
                    ?>
                </div>

                <?php if (isset($settings['show_contact_sidebar']) && $settings['show_contact_sidebar'] === 'yes'): ?>
                <div class="promen-text-content-block__sidebar-wrapper">
                    <?php self::render_contact_sidebar($settings); ?>
                </div>
                <?php endif; ?>
            <?php elseif ($template_select === 'sidebar_right'): ?>
                <?php if (isset($settings['show_contact_sidebar']) && $settings['show_contact_sidebar'] === 'yes'): ?>
                <div class="promen-text-content-block__sidebar-wrapper">
                    <?php self::render_contact_sidebar($settings); ?>
                </div>
                <?php endif; ?>

                <div class="promen-text-content-block__content">
                    <?php 
                    if (!empty($heading)) {
                        echo '<h2 class="promen-text-content-block__heading">' . esc_html($heading) . '</h2>';
                    }
                    
                    // Show social sharing at the top if position is 'top' or 'both'
                    if (!empty($settings['show_social_sharing']) && $settings['show_social_sharing'] === 'yes' && 
                       (!empty($settings['social_sharing_position']) && 
                       ($settings['social_sharing_position'] === 'top' || $settings['social_sharing_position'] === 'both'))) {
                        self::render_social_sharing($settings);
                    }
                    
                    // Render flexible content
                    self::render_flexible_content($flexible_content);
                    
                    // Show social sharing at the bottom if position is 'bottom' or 'both'
                    if (!empty($settings['show_social_sharing']) && $settings['show_social_sharing'] === 'yes' && 
                       (empty($settings['social_sharing_position']) || 
                       $settings['social_sharing_position'] === 'bottom' || 
                       $settings['social_sharing_position'] === 'both')) {
                        self::render_social_sharing($settings);
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
} 