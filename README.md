# CheckSocials Connector

A small WordPress plugin that lets [CheckSocials](https://checksocials.com) automatically verify
your site with Google Search Console — no copying codes, no digging through settings menus.

## What it does

This plugin has exactly one job: it lets CheckSocials place Google's site-verification tag into
your site's `<head>` automatically. That's the one thing a normal WordPress login can't do on its
own, and the only reason this plugin exists.

It does **not** handle publishing — that already works today through a standard WordPress
[Application Password](https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/),
which you set up once when you connect your site on the CheckSocials dashboard.

## Why there's nothing to configure

Most connector plugins ask you to paste a pairing code somewhere. This one doesn't need one:
it only accepts requests from someone who's already allowed to manage your site — exactly what
the Application Password you gave CheckSocials already grants. Install it, activate it, and it's
ready. There's no settings page because there's nothing to set.

## Installation

1. Download the latest release: [checksocials-connector.zip](../../releases/latest/download/checksocials-connector.zip)
2. In your WordPress dashboard, go to **Plugins → Add New → Upload Plugin**.
3. Choose the downloaded `.zip` file, click **Install Now**, then **Activate**.
4. That's it — nothing else to do here. The next time CheckSocials needs to verify your site
   with Google Search Console, it happens automatically.

## Requirements

- WordPress 5.6 or later (for Application Password support).
- A site already connected to CheckSocials via an Application Password (Articles tab →
  "Verbinden" on the WordPress card).

## Troubleshooting

Some hosting providers and security plugins (e.g. Wordfence) strip the `Authorization` header
before it reaches WordPress, which breaks Application-Password authentication entirely — this
would already affect publishing, not just this plugin. If verification isn't completing
automatically, check with your host whether `Authorization` headers are passed through to PHP.

## License

GPL-2.0-or-later
