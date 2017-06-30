<?php

namespace Admin_Ajax;

/**
*	PSR-4
*   @todo detect if composer autoload is being used
*	@param string
*/
function autoload( $class ){
	if( strpos($class, __NAMESPACE__) !== 0 )
		return;

	$file = __DIR__ .'/lib/'. str_replace('\\', '/', $class) . '.php';
	if( file_exists($file) )
		require $file;

}
spl_autoload_register( __NAMESPACE__.'\autoload' );

new No_Thank_You;





