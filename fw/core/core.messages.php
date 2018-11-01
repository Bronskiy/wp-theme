<?php
/**
 * Booklovers Framework: messages subsystem
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('booklovers_messages_theme_setup')) {
	add_action( 'booklovers_action_before_init_theme', 'booklovers_messages_theme_setup' );
	function booklovers_messages_theme_setup() {
		// Core messages strings
		add_filter('booklovers_action_add_scripts_inline', 'booklovers_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('booklovers_get_error_msg')) {
	function booklovers_get_error_msg() {
		return booklovers_storage_get('error_msg');
	}
}

if (!function_exists('booklovers_set_error_msg')) {
	function booklovers_set_error_msg($msg) {
		$msg2 = booklovers_get_error_msg();
		booklovers_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('booklovers_get_success_msg')) {
	function booklovers_get_success_msg() {
		return booklovers_storage_get('success_msg');
	}
}

if (!function_exists('booklovers_set_success_msg')) {
	function booklovers_set_success_msg($msg) {
		$msg2 = booklovers_get_success_msg();
		booklovers_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('booklovers_get_notice_msg')) {
	function booklovers_get_notice_msg() {
		return booklovers_storage_get('notice_msg');
	}
}

if (!function_exists('booklovers_set_notice_msg')) {
	function booklovers_set_notice_msg($msg) {
		$msg2 = booklovers_get_notice_msg();
		booklovers_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('booklovers_set_system_message')) {
	function booklovers_set_system_message($msg, $status='info', $hdr='') {
		update_option('booklovers_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('booklovers_get_system_message')) {
	function booklovers_get_system_message($del=false) {
		$msg = get_option('booklovers_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			booklovers_del_system_message();
		return $msg;
	}
}

if (!function_exists('booklovers_del_system_message')) {
	function booklovers_del_system_message() {
		delete_option('booklovers_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

//if (!function_exists('booklovers_messages_add_scripts_inline')) {
//	function booklovers_messages_add_scripts_inline() {
//		echo '<script type="text/javascript">'
//
//			. "if (typeof BOOKLOVERS_STORAGE == 'undefined') var BOOKLOVERS_STORAGE = {};"
//
//			// Strings for translation
//			. 'BOOKLOVERS_STORAGE["strings"] = {'
//				. 'ajax_error: 			"' . addslashes(esc_html__('Invalid server answer', 'booklovers')) . '",'
//				. 'bookmark_add: 		"' . addslashes(esc_html__('Add the bookmark', 'booklovers')) . '",'
//				. 'bookmark_added:		"' . addslashes(esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'booklovers')) . '",'
//				. 'bookmark_del: 		"' . addslashes(esc_html__('Delete this bookmark', 'booklovers')) . '",'
//				. 'bookmark_title:		"' . addslashes(esc_html__('Enter bookmark title', 'booklovers')) . '",'
//				. 'bookmark_exists:		"' . addslashes(esc_html__('Current page already exists in the bookmarks list', 'booklovers')) . '",'
//				. 'search_error:		"' . addslashes(esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'booklovers')) . '",'
//				. 'email_confirm:		"' . addslashes(esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'booklovers')) . '",'
//				. 'reviews_vote:		"' . addslashes(esc_html__('Thanks for your vote! New average rating is:', 'booklovers')) . '",'
//				. 'reviews_error:		"' . addslashes(esc_html__('Error saving your vote! Please, try again later.', 'booklovers')) . '",'
//				. 'error_like:			"' . addslashes(esc_html__('Error saving your like! Please, try again later.', 'booklovers')) . '",'
//				. 'error_global:		"' . addslashes(esc_html__('Global error text', 'booklovers')) . '",'
//				. 'name_empty:			"' . addslashes(esc_html__('The name can\'t be empty', 'booklovers')) . '",'
//				. 'name_long:			"' . addslashes(esc_html__('Too long name', 'booklovers')) . '",'
//				. 'email_empty:			"' . addslashes(esc_html__('Too short (or empty) email address', 'booklovers')) . '",'
//				. 'email_long:			"' . addslashes(esc_html__('Too long email address', 'booklovers')) . '",'
//				. 'email_not_valid:		"' . addslashes(esc_html__('Invalid email address', 'booklovers')) . '",'
//				. 'subject_empty:		"' . addslashes(esc_html__('The subject can\'t be empty', 'booklovers')) . '",'
//				. 'subject_long:		"' . addslashes(esc_html__('Too long subject', 'booklovers')) . '",'
//				. 'text_empty:			"' . addslashes(esc_html__('The message text can\'t be empty', 'booklovers')) . '",'
//				. 'text_long:			"' . addslashes(esc_html__('Too long message text', 'booklovers')) . '",'
//				. 'send_complete:		"' . addslashes(esc_html__("Send message complete!", 'booklovers')) . '",'
//				. 'send_error:			"' . addslashes(esc_html__('Transmit failed!', 'booklovers')) . '",'
//				. 'login_empty:			"' . addslashes(esc_html__('The Login field can\'t be empty', 'booklovers')) . '",'
//				. 'login_long:			"' . addslashes(esc_html__('Too long login field', 'booklovers')) . '",'
//				. 'login_success:		"' . addslashes(esc_html__('Login success! The page will be reloaded in 3 sec.', 'booklovers')) . '",'
//				. 'login_failed:		"' . addslashes(esc_html__('Login failed!', 'booklovers')) . '",'
//				. 'password_empty:		"' . addslashes(esc_html__('The password can\'t be empty and shorter then 4 characters', 'booklovers')) . '",'
//				. 'password_long:		"' . addslashes(esc_html__('Too long password', 'booklovers')) . '",'
//				. 'password_not_equal:	"' . addslashes(esc_html__('The passwords in both fields are not equal', 'booklovers')) . '",'
//				. 'registration_success:"' . addslashes(esc_html__('Registration success! Please log in!', 'booklovers')) . '",'
//				. 'registration_failed:	"' . addslashes(esc_html__('Registration failed!', 'booklovers')) . '",'
//				. 'geocode_error:		"' . addslashes(esc_html__('Geocode was not successful for the following reason:', 'booklovers')) . '",'
//				. 'googlemap_not_avail:	"' . addslashes(esc_html__('Google map API not available!', 'booklovers')) . '",'
//				. 'editor_save_success:	"' . addslashes(esc_html__("Post content saved!", 'booklovers')) . '",'
//				. 'editor_save_error:	"' . addslashes(esc_html__("Error saving post data!", 'booklovers')) . '",'
//				. 'editor_delete_post:	"' . addslashes(esc_html__("You really want to delete the current post?", 'booklovers')) . '",'
//				. 'editor_delete_post_header:"' . addslashes(esc_html__("Delete post", 'booklovers')) . '",'
//				. 'editor_delete_success:	"' . addslashes(esc_html__("Post deleted!", 'booklovers')) . '",'
//				. 'editor_delete_error:		"' . addslashes(esc_html__("Error deleting post!", 'booklovers')) . '",'
//				. 'editor_caption_cancel:	"' . addslashes(esc_html__('Cancel', 'booklovers')) . '",'
//				. 'editor_caption_close:	"' . addslashes(esc_html__('Close', 'booklovers')) . '"'
//				. '};'
//
//			. '</script>';
//	}
//}

if (!function_exists('booklovers_messages_add_scripts_inline')) {
    function booklovers_messages_add_scripts_inline($vars=array()) {
        // Strings for translation
        $vars["strings"] = array(
            'ajax_error' => esc_html__('Invalid server answer', 'booklovers'),
            'bookmark_add' => esc_html__('Add the bookmark', 'booklovers'),
            'bookmark_added' => esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'booklovers'),
            'bookmark_del' => esc_html__('Delete this bookmark', 'booklovers'),
            'bookmark_title' => esc_html__('Enter bookmark title', 'booklovers'),
            'bookmark_exists' => esc_html__('Current page already exists in the bookmarks list', 'booklovers'),
            'search_error' => esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'booklovers'),
            'email_confirm' => esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'booklovers'),
            'reviews_vote' => esc_html__('Thanks for your vote! New average rating is:', 'booklovers'),
            'reviews_error' => esc_html__('Error saving your vote! Please, try again later.', 'booklovers'),
            'error_like' => esc_html__('Error saving your like! Please, try again later.', 'booklovers'),
            'error_global' => esc_html__('Global error text', 'booklovers'),
            'name_empty' => esc_html__('The name can\'t be empty', 'booklovers'),
            'name_long' => esc_html__('Too long name', 'booklovers'),
            'email_empty' => esc_html__('Too short (or empty) email address', 'booklovers'),
            'email_long' => esc_html__('Too long email address', 'booklovers'),
            'email_not_valid' => esc_html__('Invalid email address', 'booklovers'),
            'subject_empty' => esc_html__('The subject can\'t be empty', 'booklovers'),
            'subject_long' => esc_html__('Too long subject', 'booklovers'),
            'text_empty' => esc_html__('The message text can\'t be empty', 'booklovers'),
            'text_long' => esc_html__('Too long message text', 'booklovers'),
            'send_complete' => esc_html__("Send message complete!", 'booklovers'),
            'send_error' => esc_html__('Transmit failed!', 'booklovers'),
            'login_empty' => esc_html__('The Login field can\'t be empty', 'booklovers'),
            'login_long' => esc_html__('Too long login field', 'booklovers'),
            'login_success' => esc_html__('Login success! The page will be reloaded in 3 sec.', 'booklovers'),
            'login_failed' => esc_html__('Login failed!', 'booklovers'),
            'password_empty' => esc_html__('The password can\'t be empty and shorter then 4 characters', 'booklovers'),
            'password_long' => esc_html__('Too long password', 'booklovers'),
            'password_not_equal' => esc_html__('The passwords in both fields are not equal', 'booklovers'),
            'registration_success' => esc_html__('Registration success! Please log in!', 'booklovers'),
            'registration_failed' => esc_html__('Registration failed!', 'booklovers'),
            'geocode_error' => esc_html__('Geocode was not successful for the following reason:', 'booklovers'),
            'googlemap_not_avail' => esc_html__('Google map API not available!', 'booklovers'),
            'editor_save_success' => esc_html__("Post content saved!", 'booklovers'),
            'editor_save_error' => esc_html__("Error saving post data!", 'booklovers'),
            'editor_delete_post' => esc_html__("You really want to delete the current post?", 'booklovers'),
            'editor_delete_post_header' => esc_html__("Delete post", 'booklovers'),
            'editor_delete_success' => esc_html__("Post deleted!", 'booklovers'),
            'editor_delete_error' => esc_html__("Error deleting post!", 'booklovers'),
            'editor_caption_cancel' => esc_html__('Cancel', 'booklovers'),
            'editor_caption_close' => esc_html__('Close', 'booklovers')
        );
        return $vars;
    }
}
?>