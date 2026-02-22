<?php

namespace App\Snippets;

add_action('admin_menu', function () {
    // Remove "Editor" (Appearance → Editor / Design)
    remove_submenu_page('themes.php', 'site-editor.php');
}, 100);