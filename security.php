<!php

/** Remove WordPress Version Number */
add_filter('the_generator', '__return_empty_string');

/** Hide Login Errors in WordPress */
add_filter(
	'login_errors',
	function ( $error ) {
		return __('Username or password was incorrect!', 'kodeverftet-wp-utils');
	}
);

/** 
*  Disable XML-RPC
*  TODO: Make this a setting in WP-admin
*/
add_filter( 'xmlrpc_enabled', '__return_false' );


/** 
  TODO: Disable Author Archives
  TODO: Disable Author enumeration
  TODO: Disable Plugin & Theme Editor
*/
