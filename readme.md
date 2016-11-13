# Wordpress Multisite

## Features
* Child sites (multi-site concept)
* 2 custom post types (Restaurant and Food)
* CPT Restaurant added as custom meta box to CPT Food
* Main site Post is cloned to child site
* Settings page to Enable / Disable cloning
* Cloned posts are non editable

## Installation
* [Install Wordpress](https://codex.wordpress.org/Installing_WordPress).
* In `wp-config.php` add the line `define('WP_ALLOW_MULTISITE', true);`
* Now [Setup multisite](https://codex.wordpress.org/Create_A_Network) using **Tools->Network Setup**.
* Refer `.htaccess` and `wp-config.php` for appropriate settings.
* Create network sites using **My Sites->Network Admin->Sites**.

## Plugins
* Two plugins are included in this repository under `wp-content\plugins`.
* Activate both `Custom Post Types` and `Multisite Post Copier` plugins in **My Sites->Network Admin->Plugins**.
* `Custom Post Types` adds two custom post types `Restaurant` and `Food` where `Restaurant` acts as custom post meta for `Food`.
* `Multisite Post Copier` adds an option to enable to clone posts from main site to children sites.

## Settings
* **Settings->Post Cloner** under main sites admin area contains settings for `Multisite Post Copier`
* Check the `Post Cloner` checkbox and hit `Save Changes` to enable post copier.

### Coding Standard
[WordPress-Extra](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards#standards-subsets)
