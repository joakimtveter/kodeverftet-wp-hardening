/*
Plugin Name:  WP Utilities
Plugin URI:   https://joakimtveter.no
Description:  A plugin for hardening security and adding basic often used funcionallity.
Version:      1.0
Author:       Joakim Tveter
Author URI:   https://joakimtveter.no
License:      MIT
Text Domain:  kodeverftet-wp-utils
Domain Path:  /languages
*/

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
