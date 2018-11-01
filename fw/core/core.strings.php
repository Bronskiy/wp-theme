<?php
/**
 * Booklovers Framework: strings manipulations
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'BOOKLOVERS_MULTIBYTE' ) ) define( 'BOOKLOVERS_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('booklovers_strlen')) {
	function booklovers_strlen($text) {
		return BOOKLOVERS_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('booklovers_strpos')) {
	function booklovers_strpos($text, $char, $from=0) {
		return BOOKLOVERS_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('booklovers_strrpos')) {
	function booklovers_strrpos($text, $char, $from=0) {
		return BOOKLOVERS_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('booklovers_substr')) {
	function booklovers_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = booklovers_strlen($text)-$from;
		}
		return BOOKLOVERS_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('booklovers_strtolower')) {
	function booklovers_strtolower($text) {
		return BOOKLOVERS_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('booklovers_strtoupper')) {
	function booklovers_strtoupper($text) {
		return BOOKLOVERS_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('booklovers_strtoproper')) {
	function booklovers_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<booklovers_strlen($text); $i++) {
			$ch = booklovers_substr($text, $i, 1);
			$rez .= booklovers_strpos(' .,:;?!()[]{}+=', $last)!==false ? booklovers_strtoupper($ch) : booklovers_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('booklovers_strrepeat')) {
	function booklovers_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('booklovers_strshort')) {
	function booklovers_strshort($str, $maxlength, $add='...') {
	//	if ($add && booklovers_substr($add, 0, 1) != ' ')
	//		$add .= ' ';
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= booklovers_strlen($str)) 
			return strip_tags($str);
		$str = booklovers_substr(strip_tags($str), 0, $maxlength - booklovers_strlen($add));
		$ch = booklovers_substr($str, $maxlength - booklovers_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = booklovers_strlen($str) - 1; $i > 0; $i--)
				if (booklovers_substr($str, $i, 1) == ' ') break;
			$str = trim(booklovers_substr($str, 0, $i));
		}
		if (!empty($str) && booklovers_strpos(',.:;-', booklovers_substr($str, -1))!==false) $str = booklovers_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('booklovers_strclear')) {
	function booklovers_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (booklovers_substr($text, 0, booklovers_strlen($open))==$open) {
					$pos = booklovers_strpos($text, '>');
					if ($pos!==false) $text = booklovers_substr($text, $pos+1);
				}
				if (booklovers_substr($text, -booklovers_strlen($close))==$close) $text = booklovers_substr($text, 0, booklovers_strlen($text) - booklovers_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('booklovers_get_slug')) {
	function booklovers_get_slug($title) {
		return booklovers_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('booklovers_strmacros')) {
	function booklovers_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('booklovers_unserialize')) {
	function booklovers_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			return $data;
		} else
			return $str;
	}
}
?>