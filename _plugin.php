<?php
/*
Plugin Name: 	admin-ajax-dot-php-no-thank-you
Plugin URI: 	https://github.com/pinecone-dot-website/admin-ajax-dot-php-no-thank-you
Description: 	
Author: 		pinecone-dot-website, postpostmodern
Text Domain:	
Domain Path:	/lang
Version:		0.0.1
Author URI: 	https://rack.and.pinecone.website/
*/

register_activation_hook( __FILE__, create_function("", '$ver = "5.3"; if( version_compare(phpversion(), $ver, "<") ) die( "This plugin requires PHP version $ver or greater be installed." );') );

require __DIR__.'/index.php';