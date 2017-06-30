=== Admin Ajax dot php? No Thank You! ===
Contributors: postpostmodern, pinecone-dot-io
Donate link: https://cash.me/$EricEaglstun
Tags: admin-ajax.php, ajax, javascript
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk

== Description ==
Changes the wp-admin/admin-ajax.php endpoint to /ajax/
Adds an endpoint to the REST API at `/wp-json/wp/v2/admin-ajax` that behaves exactly as wp-admin/admin-ajax.php
- requires PHP 5.3

== Installation ==
1. Place /admin-ajax-dot-php-no-thank-you/ directory in /wp-content/plugins/
1. Enable the rewrite or REST API endpoints and select a default, at Settings > admin-ajax.php Settings [wp-admin/options-general.php?page=admin-ajax.php-no-thank-you]
1. Any place that calls `admin_url( 'admin-ajax.php' )` from PHP or `ajaxurl` from JavaScript will automatically use the new default endpoint instead of `/wp-admin/admin-ajax.php`
1. `/wp-json/wp/v2/admin-ajax` in the REST API is also available for receiving requests.

== Changelog ==
= 0.3.5 =
* fix rest api nonce / authentication, debugger on admin page

= 0.3.0 =
* initial admin settings

= 0.2.0 =
* Move to class & autoload

= 0.1.0 =
* Rest API endpoint added

= .0.0.3 =
* Prep for WP plugin directory

= .0.0.2 =
* Initial functionality, no settings

= .0.0.1 =
* Initial release
