<?php 

function kodeverftet_add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

add_filter( 'body_class', 'kodeverftet_add_slug_body_class' );


/**
 * Add the post thumbnail, if available, before the content in feeds.
 *
 * @param string $content The post content.
 *
 * @return string
 */
function kodeverftet_rss_post_thumbnail( $content ) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . $content;
	}

	return $content;
}

add_filter( 'the_excerpt_rss', 'kodeverftet_rss_post_thumbnail' );
add_filter( 'the_content_feed', 'kodeverftet_rss_post_thumbnail' );


/** Change "Howdy Admin" in Admin Bar */
function kodeverftet_replace_howdy( $wp_admin_bar ) {

	$new_howdy = __('Welcome,', 'kodeverftet-utils');

	$my_account = $wp_admin_bar->get_node( 'my-account' );
	$wp_admin_bar->add_node(
		array(
			'id'    => 'my-account',
			'title' => str_replace( 'Howdy,', $new_howdy, $my_account->title ),
		)
	);
}

add_filter( 'admin_bar_menu', 'wpcode_snippet_replace_howdy', 25 );


/**
 * Allow SVG uploads for administrator users.
 *
 * @param array $upload_mimes Allowed mime types.
 *
 * @return mixed
 */
add_filter(
	'upload_mimes',
	function ( $upload_mimes ) {
		// By default, only administrator users are allowed to add SVGs.
		// To enable more user types edit or comment the lines below but beware of
		// the security risks if you allow any user to upload SVG files.
		if ( ! current_user_can( 'administrator' ) ) {
			return $upload_mimes;
		}

		$upload_mimes['svg']  = 'image/svg+xml';
		$upload_mimes['svgz'] = 'image/svg+xml';

		return $upload_mimes;
	}
);

/**
 * Add SVG files mime check.
 *
 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
 * @param string       $file Full path to the file.
 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
 */
add_filter(
	'wp_check_filetype_and_ext',
	function ( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {

		if ( ! $wp_check_filetype_and_ext['type'] ) {

			$check_filetype  = wp_check_filetype( $filename, $mimes );
			$ext             = $check_filetype['ext'];
			$type            = $check_filetype['type'];
			$proper_filename = $filename;

			if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
				$ext  = false;
				$type = false;
			}

			$wp_check_filetype_and_ext = compact( 'ext', 'type', 'proper_filename' );
		}

		return $wp_check_filetype_and_ext;

	},
	10,
	5
);


/** Change Admin Panel Footer Text */
add_filter(
	'admin_footer_text',
	function ( $footer_text ) {
		// Edit the line below to customize the footer text.
		$footer_text = 'Powered by <a href="https://www.wordpress.org" target="_blank" rel="noopener">WordPress</a> | WordPress Tutorials: <a href="https://www.wpbeginner.com" target="_blank" rel="noopener">WPBeginner</a>';
		
		return $footer_text;
	}
);


/** Change Excerpt Length */

add_filter(
	'excerpt_length',
	function ( $length ) {
		// Number of words to display in the excerpt.
		return 40;
	},
	500
);

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );
