<?php

namespace App\Snippets;

/**
 * Hide the content editor for specific page templates (clean builder pages).
 */
add_action('admin_head', function () {

    if (!function_exists('get_current_screen')) {
        return;
    }

    $screen = get_current_screen();

    if (!$screen || $screen->post_type !== 'page') {
        return;
    }

    if (!isset($_GET['post'])) {
        return;
    }

    $page_templates = [
        'page-builder.blade.php',
    ];

    $template = get_page_template_slug((int) $_GET['post']);

    if (in_array($template, $page_templates, true)) {
        echo '<style>
            #postdivrich,
            .block-editor {
                display: none !important;
            }
        </style>';
    }
});