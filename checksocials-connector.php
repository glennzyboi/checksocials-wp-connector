<?php
/**
 * Plugin Name: CheckSocials Connector
 * Description: Lets CheckSocials automatically verify this site with Google Search Console. No setup required — it authenticates using the same WordPress Application Password you already gave CheckSocials to publish articles.
 * Version: 1.0.1
 * Requires at least: 5.6
 * Requires PHP: 7.2
 * Author: CheckSocials
 * License: GPL-2.0-or-later
 * Update URI: false
 */

if (!defined('ABSPATH')) {
    exit; // No direct access.
}

const CHECKSOCIALS_GSC_TAG_OPTION = 'checksocials_gsc_tag';
const CHECKSOCIALS_NS = 'checksocials/v1';
const CHECKSOCIALS_VERSION = '1.0.1';

/**
 * Inject the Google Search Console verification meta tag into <head>. This is
 * the one thing a WordPress Application Password cannot do on its own — hence
 * this plugin exists at all.
 */
function checksocials_render_meta_tag(): void
{
    $tag = get_option(CHECKSOCIALS_GSC_TAG_OPTION);
    if (is_string($tag) && $tag !== '') {
        echo '<meta name="google-site-verification" content="' . esc_attr($tag) . '" />' . "\n";
    }
}
add_action('wp_head', 'checksocials_render_meta_tag');

/**
 * Shared permission check for the REST routes. No separate secret or pairing
 * code: both routes are gated by WordPress's own standard REST authentication.
 * Any request carrying valid credentials for a user who can manage_options —
 * which is exactly what the Application Password you already created for
 * CheckSocials satisfies — is allowed through. Nothing to configure here.
 */
function checksocials_can_manage(): bool
{
    return current_user_can('manage_options');
}

/**
 * Health check: confirms the plugin is installed, active, and reachable with
 * the caller's credentials.
 */
function checksocials_status(): WP_REST_Response
{
    return new WP_REST_Response(['ok' => true, 'version' => CHECKSOCIALS_VERSION], 200);
}

/**
 * Store the GSC verification tag — printed in <head> on every page from then
 * on (see checksocials_render_meta_tag).
 */
function checksocials_store_tag(WP_REST_Request $request)
{
    $tag = trim((string) $request->get_param('tag'));
    if ($tag === '') {
        return new WP_Error('checksocials_bad_tag', 'Empty verification tag.', ['status' => 400]);
    }
    update_option(CHECKSOCIALS_GSC_TAG_OPTION, $tag);
    return new WP_REST_Response(['ok' => true], 200);
}

function checksocials_register_routes(): void
{
    register_rest_route(CHECKSOCIALS_NS, '/status', [
        'methods'             => 'GET',
        'permission_callback' => 'checksocials_can_manage',
        'callback'            => 'checksocials_status',
    ]);

    register_rest_route(CHECKSOCIALS_NS, '/verification', [
        'methods'             => 'POST',
        'permission_callback' => 'checksocials_can_manage',
        'callback'            => 'checksocials_store_tag',
    ]);
}
add_action('rest_api_init', 'checksocials_register_routes');
