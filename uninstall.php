<?php
/**
 * Runs only when the plugin is deleted (not on deactivate — a temporary
 * deactivate shouldn't drop a working verification tag). Removes the one
 * option this plugin stores so nothing is left orphaned in wp_options.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('checksocials_gsc_tag');
