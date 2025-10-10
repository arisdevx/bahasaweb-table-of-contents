<?php
/**
 * Plugin Name: Bahasaweb Table of Contents
 * Plugin URI: https://bahasaweb.com
 * Description: Automatically generate a table of contents from H2 headings in your posts. Simple Gutenberg block that creates SEO-friendly navigation with anchor links.
 * Version: 1.0.0
 * Author: Aris Munandar
 * Author URI: https://bahasaweb.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bahasaweb-table-of-contents
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BWTOC_VERSION', '1.0.0');
define('BWTOC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BWTOC_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Register the block
 */
function bwtoc_register_block() {
    // Register block script
    wp_register_script(
        'bwtoc-block-editor',
        BWTOC_PLUGIN_URL . 'build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-block-editor', 'wp-data'),
        BWTOC_VERSION,
        true
    );

    // Register editor style
    wp_register_style(
        'bwtoc-block-editor-style',
        BWTOC_PLUGIN_URL . 'build/editor.css',
        array('wp-edit-blocks'),
        BWTOC_VERSION
    );

    // Register frontend style
    wp_register_style(
        'bwtoc-block-style',
        BWTOC_PLUGIN_URL . 'build/style.css',
        array(),
        BWTOC_VERSION
    );

    // Register the block
    register_block_type('bahasaweb/table-of-contents', array(
        'editor_script' => 'bwtoc-block-editor',
        'editor_style' => 'bwtoc-block-editor-style',
        'style' => 'bwtoc-block-style',
        'render_callback' => 'bwtoc_render_block',
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Daftar isi'
            )
        )
    ));
}
add_action('init', 'bwtoc_register_block');

/**
 * Render callback for the block
 */
function bwtoc_render_block($attributes) {
    global $post;
    
    if (!$post) {
        return '';
    }
    
    $title = isset($attributes['title']) ? $attributes['title'] : 'Daftar isi';
    
    // Get post content
    $content = $post->post_content;
    
    // Parse blocks to get all headings
    $blocks = parse_blocks($content);
    $headings = bwtoc_extract_headings($blocks);
    
    if (empty($headings)) {
        return '';
    }
    
    // Build the table of contents HTML
    $html = '<div class="bahasaweb-toc">';
    $html .= '<h2>' . esc_html($title) . '</h2>';
    $html .= '<ul>';
    
    foreach ($headings as $heading) {
        $html .= sprintf(
            '<li><a href="#%s" data-level="%d">%s</a></li>',
            esc_attr($heading['id']),
            esc_attr($heading['level']),
            esc_html($heading['text'])
        );
    }
    
    $html .= '</ul>';
    $html .= '</div>';
    
    return $html;
}

/**
 * Extract headings from blocks recursively
 */
function bwtoc_extract_headings($blocks, &$headings = array()) {
    foreach ($blocks as $block) {
        // Check if it's a heading block (H2)
        if ($block['blockName'] === 'core/heading') {
            $level = isset($block['attrs']['level']) ? $block['attrs']['level'] : 2;
            
            // Only process H2 headings
            if ($level === 2) {
                $content = $block['innerHTML'];
                
                // Extract text and ID from heading
                if (preg_match('/<h2[^>]*id=["\']([^"\']+)["\'][^>]*>(.*?)<\/h2>/is', $content, $matches)) {
                    $id = $matches[1];
                    $text = wp_strip_all_tags($matches[2]);
                    
                    $headings[] = array(
                        'id' => $id,
                        'text' => $text,
                        'level' => $level
                    );
                } elseif (preg_match('/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches)) {
                    // If no ID exists, create one from the text
                    $text = wp_strip_all_tags($matches[1]);
                    $id = sanitize_title($text);
                    
                    $headings[] = array(
                        'id' => $id,
                        'text' => $text,
                        'level' => $level
                    );
                }
            }
        }
        
        // Process inner blocks recursively
        if (!empty($block['innerBlocks'])) {
            bwtoc_extract_headings($block['innerBlocks'], $headings);
        }
    }
    
    return $headings;
}

/**
 * Add IDs to H2 headings in content
 */
function bwtoc_add_ids_to_headings($content) {
    // Match all H2 tags
    $content = preg_replace_callback(
        '/<h2(?![^>]*id=)([^>]*)>(.*?)<\/h2>/is',
        function($matches) {
            $text = wp_strip_all_tags($matches[2]);
            $id = sanitize_title($text);
            return '<h2' . $matches[1] . ' id="' . $id . '">' . $matches[2] . '</h2>';
        },
        $content
    );
    
    return $content;
}
add_filter('the_content', 'bwtoc_add_ids_to_headings', 9);

/**
 * Enqueue block category
 */
function bwtoc_block_category($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'bahasaweb',
                'title' => 'Bahasaweb',
            ),
        )
    );
}
add_filter('block_categories_all', 'bwtoc_block_category', 10, 1);
