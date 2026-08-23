<?php
/**
 * Filters and actions
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Add links to humans.txt and security.txt in <head>
   ========================================================== */
add_action( 'wp_head', function () {
	echo "<!-- humans.txt : informations sur l'auteur du site -->\n";
	echo '<link rel="author" href="https://maxgremez.com/humans.txt">' . "\n";
	echo "<!-- security.txt : politique de divulgation responsable (RFC 9116) -->\n";
	echo '<link rel="security" href="https://maxgremez.com/.well-known/security.txt">' . "\n";
} );

/* ==========================================================
   Browser Tab Notification
   ========================================================== */
/*
// via https://www.wpbeginner.com/wp-tutorials/how-to-easily-add-browser-tab-notification-in-wordpress/
// via https://stackoverflow.com/questions/73854669/woocommerce-change-page-title-when-tab-is-not-active
// via https://www.hostinger.com/tutorials/wordpress-javascript#How_to_Add_JavaScript_to_WordPress_Manually_Using_wp_head_and_wp_footer_Hooks
// Emoji reference: https://unicode.org/emoji/charts/full-emoji-list.html
// Example: 1F44B → 👋 & 1F3FC → skin tone modifier = U+1F44B U+1F3FC → 👋🏼
*/
/**
 * Outputs a script that changes the browser tab title when the page loses focus.
 *
 * @return void
 */
function wpsh_browser_tab_notification() {
	?>
	<script>
		(function () {
			let timer = null;
			const title    = document.title;
			const altTitle = '\u{1F44B}\u{1F3FC} Eh !';

			window.addEventListener('blur', function () {
				timer = window.setInterval(function () {
					document.title = document.title === altTitle ? title : altTitle;
				}, 1750);
			});

			window.addEventListener('focus', function () {
				document.title = title;
				if (timer) {
					clearInterval(timer);
					timer = null;
				}
			});
		})();
	</script>
	<?php
}
add_action( 'wp_footer', 'wpsh_browser_tab_notification' );

/* ==========================================================
   Suppress the "_load_textdomain_just_in_time" doing_it_wrong notice
   ========================================================== */
/*
// via Julio Potier: https://gist.github.com/JulioPotier/57cbf7ce937bcd934a1fa0dcc26590eb
// Works around a WordPress core bug (since 6.7) that logs "Function
// _load_textdomain_just_in_time was called incorrectly" for translations
// loaded before the 'init' hook.
*/
add_filter( 'doing_it_wrong_trigger_error', function ( $bool, $function_name ) {
	if ( '_load_textdomain_just_in_time' === $function_name ) {
		$bool = false;
	}
	return $bool;
}, 10, 2 );

/* ==========================================================
   Remove Async Decoding from WordPress Images
   ========================================================== */
/*
// via https://www.wpexplorer.com/remove-async-decoding-wordpress-images/
*/
// Disable the decoding attribute globally :
// Removes the decoding attribute from images added inside post content.
add_filter( 'wp_img_tag_add_decoding_attr', '__return_false' );

// Remove the decoding attribute from featured images and the Post Image block.
add_filter( 'wp_get_attachment_image_attributes', function ( $attributes ) {
	unset( $attributes['decoding'] );
	return $attributes;
} );

/* ==========================================================
   Change the sender name and address in WordPress emails (example)
   ========================================================== */
/*
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#removeimagelinks
// Function to change email address
//	function wpb_sender_email( $original_email_address ) {
//	  return 'support@maxgremez.com';
//	}
// Function to change sender name (ex : Wordpress)
//	function wpb_sender_name( $original_email_from ) {
//	  return 'WordPress debug report';
//	}
// Hooking up our functions to WordPress filters
//	add_filter( 'wp_mail_from', 'wpb_sender_email' );
//	add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
*/
