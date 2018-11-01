<?php
/**
 * Booklovers Framework: theme variables storage
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('booklovers_storage_get')) {
	function booklovers_storage_get($var_name, $default='') {
		global $BOOKLOVERS_STORAGE;
		return isset($BOOKLOVERS_STORAGE[$var_name]) ? $BOOKLOVERS_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('booklovers_storage_set')) {
	function booklovers_storage_set($var_name, $value) {
		global $BOOKLOVERS_STORAGE;
		$BOOKLOVERS_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('booklovers_storage_empty')) {
	function booklovers_storage_empty($var_name, $key='', $key2='') {
		global $BOOKLOVERS_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($BOOKLOVERS_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($BOOKLOVERS_STORAGE[$var_name][$key]);
		else
			return empty($BOOKLOVERS_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('booklovers_storage_isset')) {
	function booklovers_storage_isset($var_name, $key='', $key2='') {
		global $BOOKLOVERS_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($BOOKLOVERS_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($BOOKLOVERS_STORAGE[$var_name][$key]);
		else
			return isset($BOOKLOVERS_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('booklovers_storage_inc')) {
	function booklovers_storage_inc($var_name, $value=1) {
		global $BOOKLOVERS_STORAGE;
		if (empty($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = 0;
		$BOOKLOVERS_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('booklovers_storage_concat')) {
	function booklovers_storage_concat($var_name, $value) {
		global $BOOKLOVERS_STORAGE;
		if (empty($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = '';
		$BOOKLOVERS_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('booklovers_storage_get_array')) {
	function booklovers_storage_get_array($var_name, $key, $key2='', $default='') {
		global $BOOKLOVERS_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($BOOKLOVERS_STORAGE[$var_name][$key]) ? $BOOKLOVERS_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($BOOKLOVERS_STORAGE[$var_name][$key][$key2]) ? $BOOKLOVERS_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('booklovers_storage_set_array')) {
	function booklovers_storage_set_array($var_name, $key, $value) {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if ($key==='')
			$BOOKLOVERS_STORAGE[$var_name][] = $value;
		else
			$BOOKLOVERS_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('booklovers_storage_set_array2')) {
	function booklovers_storage_set_array2($var_name, $key, $key2, $value) {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if (!isset($BOOKLOVERS_STORAGE[$var_name][$key])) $BOOKLOVERS_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$BOOKLOVERS_STORAGE[$var_name][$key][] = $value;
		else
			$BOOKLOVERS_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('booklovers_storage_set_array_after')) {
	function booklovers_storage_set_array_after($var_name, $after, $key, $value='') {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if (is_array($key))
			booklovers_array_insert_after($BOOKLOVERS_STORAGE[$var_name], $after, $key);
		else
			booklovers_array_insert_after($BOOKLOVERS_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('booklovers_storage_set_array_before')) {
	function booklovers_storage_set_array_before($var_name, $before, $key, $value='') {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if (is_array($key))
			booklovers_array_insert_before($BOOKLOVERS_STORAGE[$var_name], $before, $key);
		else
			booklovers_array_insert_before($BOOKLOVERS_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('booklovers_storage_push_array')) {
	function booklovers_storage_push_array($var_name, $key, $value) {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($BOOKLOVERS_STORAGE[$var_name], $value);
		else {
			if (!isset($BOOKLOVERS_STORAGE[$var_name][$key])) $BOOKLOVERS_STORAGE[$var_name][$key] = array();
			array_push($BOOKLOVERS_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('booklovers_storage_pop_array')) {
	function booklovers_storage_pop_array($var_name, $key='', $defa='') {
		global $BOOKLOVERS_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($BOOKLOVERS_STORAGE[$var_name]) && is_array($BOOKLOVERS_STORAGE[$var_name]) && count($BOOKLOVERS_STORAGE[$var_name]) > 0) 
				$rez = array_pop($BOOKLOVERS_STORAGE[$var_name]);
		} else {
			if (isset($BOOKLOVERS_STORAGE[$var_name][$key]) && is_array($BOOKLOVERS_STORAGE[$var_name][$key]) && count($BOOKLOVERS_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($BOOKLOVERS_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('booklovers_storage_inc_array')) {
	function booklovers_storage_inc_array($var_name, $key, $value=1) {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if (empty($BOOKLOVERS_STORAGE[$var_name][$key])) $BOOKLOVERS_STORAGE[$var_name][$key] = 0;
		$BOOKLOVERS_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('booklovers_storage_concat_array')) {
	function booklovers_storage_concat_array($var_name, $key, $value) {
		global $BOOKLOVERS_STORAGE;
		if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
		if (empty($BOOKLOVERS_STORAGE[$var_name][$key])) $BOOKLOVERS_STORAGE[$var_name][$key] = '';
		$BOOKLOVERS_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('booklovers_storage_call_obj_method')) {
	function booklovers_storage_call_obj_method($var_name, $method, $param=null) {
		global $BOOKLOVERS_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($BOOKLOVERS_STORAGE[$var_name]) ? $BOOKLOVERS_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($BOOKLOVERS_STORAGE[$var_name]) ? $BOOKLOVERS_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('booklovers_storage_get_obj_property')) {
	function booklovers_storage_get_obj_property($var_name, $prop, $default='') {
		global $BOOKLOVERS_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($BOOKLOVERS_STORAGE[$var_name]->$prop) ? $BOOKLOVERS_STORAGE[$var_name]->$prop : $default;
	}
}

// Global variables in function
if (!function_exists('booklovers_storage_global_vars')) {
    function booklovers_storage_global_vars($variable) {
          if (!empty($variable) && $variable = 'post'){
           global $post;
           return $post;
        } 
          if (!empty($variable) && $variable = 'wp_query'){
           global $wp_query;
           return $wp_query;
        } 
    }
}

// Merge two-dim array element
if (!function_exists('booklovers_storage_merge_array')) {
    function booklovers_storage_merge_array($var_name, $key, $arr) {
        global $BOOKLOVERS_STORAGE;
        if (!isset($BOOKLOVERS_STORAGE[$var_name])) $BOOKLOVERS_STORAGE[$var_name] = array();
        if (!isset($BOOKLOVERS_STORAGE[$var_name][$key])) $BOOKLOVERS_STORAGE[$var_name][$key] = array();
        $BOOKLOVERS_STORAGE[$var_name][$key] = array_merge($BOOKLOVERS_STORAGE[$var_name][$key], $arr);
    }
}

?>