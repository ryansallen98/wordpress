<?php

namespace App\Snippets;

add_filter('use_block_editor_for_post', __NAMESPACE__ . '\\disable_gutenberg_for_specific_template', 10, 2);

function disable_gutenberg_for_specific_template($use_block_editor, $post)
{
    if (!$post || $post->post_type !== 'page') {
        return $use_block_editor;
    }

    $page_templates = [
        'page-builder.blade.php',
    ];

    $template = get_page_template_slug($post->ID);

    if (in_array($template, $page_templates, true)) {
        return false; // force Classic Editor
    }

    return $use_block_editor;
}