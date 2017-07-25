<?php
/*
Plugin Name: 	admin-ajax.php, no thank you!
Author: 		pinecone-dot-website, postpostmodern
Author URI: 	https://rack.and.pinecone.website/
Description: 	Changes the wp-admin/admin-ajax.php endpoint to /ajax/
Domain Path:	/lang
Plugin URI: 	https://github.com/pinecone-dot-website/admin-ajax-dot-php-no-thank-you
Text Domain:	
Version:		0.6.0
*/

register_activation_hook( __FILE__, create_function("", '$ver = "5.3"; if( version_compare(phpversion(), $ver, "<") ) die( "This plugin requires PHP version $ver or greater be installed." );') );

require __DIR__.'/index.php';
