=== CheckSocials Connector ===
Contributors: checksocials
Tags: search console, site verification, seo, google
Requires at least: 5.6
Tested up to: 6.9
Requires PHP: 7.2
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lets CheckSocials automatically verify your site with Google Search Console — no copying codes, no digging through settings menus.

== Description ==

This plugin has exactly one job: it lets [CheckSocials](https://checksocials.com) place Google's site-verification meta tag into your site's `<head>` automatically. That is the one thing a normal WordPress Application Password cannot do on its own, and the only reason this plugin exists.

It does **not** handle publishing — that already works through a standard WordPress [Application Password](https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/), which you set up once when you connect your site on the CheckSocials dashboard.

= Why there's nothing to configure =

Most connector plugins ask you to paste a pairing code somewhere. This one doesn't need one: it only accepts requests from someone who is already allowed to manage your site — exactly what the Application Password you gave CheckSocials grants. Install it, activate it, and it's ready. There is no settings page because there is nothing to set.

= What it registers =

* `GET /wp-json/checksocials/v1/status` — health check (administrators only).
* `POST /wp-json/checksocials/v1/verification` — stores the Google site-verification token (administrators only).
* A `wp_head` hook that prints the stored verification meta tag.

= Privacy =

This plugin collects no data, sets no cookies, and makes no outbound requests of its own. It stores a single option (`checksocials_gsc_tag`, the Google verification token) which is removed when you delete the plugin. Requests to its REST endpoints originate from the CheckSocials platform using credentials you created yourself and can revoke at any time under Users → Profile → Application Passwords.

== Installation ==

1. Install and activate the plugin (Plugins → Add New).
2. That's it — nothing else to configure. The next time CheckSocials needs to verify your site with Google Search Console, it happens automatically.

== Frequently Asked Questions ==

= Does this plugin send data anywhere? =

No. It makes no outbound requests. The CheckSocials platform calls *into* your site over the WordPress REST API, authenticated with the Application Password you created.

= Can I revoke access? =

Yes — delete the Application Password under Users → Profile → Application Passwords, or simply deactivate/delete this plugin. Deleting the plugin also removes the stored verification token.

= Does it slow my site down? =

No. It prints one meta tag in your site's `<head>` and registers two admin-only REST routes. Nothing runs on normal page views beyond that single tag.

== Changelog ==

= 1.0.2 =
* WordPress.org directory readiness: strict input validation and sanitization on the verification endpoint, translatable strings with text domain, complete plugin headers.

= 1.0.1 =
* Hardened for distribution.

= 1.0.0 =
* Initial release: automatic Google Search Console verification for CheckSocials.
