<?php
/**
 * Booklovers Framework: file system manipulations, styles and scripts usage, etc.
 *
 * @package	booklovers
 * @since	booklovers 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* File system utils
------------------------------------------------------------------------------------- */
// Return path to directory with uploaded images
if (!function_exists('booklovers_get_uploads_dir_from_url')) {	
	function booklovers_get_uploads_dir_from_url($url) {
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		$http_prefix = "http://";
		$https_prefix = "https://";
		
		if (!strncmp($url, $https_prefix, booklovers_strlen($https_prefix)))			//if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace($http_prefix, $https_prefix, $upload_url);
		else if (!strncmp($url, $http_prefix, booklovers_strlen($http_prefix)))		//if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace($https_prefix, $http_prefix, $upload_url);		
	
		// Check if $img_url is local.
		if ( false === booklovers_strpos( $url, $upload_url ) ) return false;
	
		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = ($upload_dir) . ($rel_path);
		
		return $img_path;
	}
}

// Replace uploads url to current site uploads url
if (!function_exists('booklovers_replace_uploads_url')) {	
	function booklovers_replace_uploads_url($str, $uploads_folder='uploads') {
		static $uploads_url = '', $uploads_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = booklovers_replace_uploads_url($v, $uploads_folder);
			}
		} else if (is_string($str)) {
			if (empty($uploads_url)) {
				$uploads_info = wp_upload_dir();
				$uploads_url = $uploads_info['baseurl'];
				$uploads_len = booklovers_strlen($uploads_url);
			}
			$break = '\'" ';
			$pos = 0;
			while (($pos = booklovers_strpos($str, "/{$uploads_folder}/", $pos))!==false) {
				$pos0 = $pos;
				$chg = true;
				while ($pos0) {
					if (booklovers_strpos($break, booklovers_substr($str, $pos0, 1))!==false) {
						$chg = false;
						break;
					}
					if (booklovers_substr($str, $pos0, 5)=='http:' || booklovers_substr($str, $pos0, 6)=='https:')
						break;
					$pos0--;
				}
				if ($chg) {
					$str = ($pos0 > 0 ? booklovers_substr($str, 0, $pos0) : '') . ($uploads_url) . booklovers_substr($str, $pos+booklovers_strlen($uploads_folder)+1);
					$pos = $pos0 + $uploads_len;
				} else 
					$pos++;
			}
		}
		return $str;
	}
}

// Return list files in subfolders
if (!function_exists('booklovers_collect_files')) {	
	function booklovers_collect_files($dir, $ext=array()) {
		if (!is_array($ext)) $ext = array($ext);
		if (booklovers_substr($dir, -1)=='/') $dir = booklovers_substr($dir, 0, booklovers_strlen($dir)-1);
		$list = array();
		if ( is_dir($dir) ) {
			$hdir = @opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( $dir . '/' . $file );
					if ( substr($file, 0, 1) == '.' )
						continue;
					if ( is_dir( $dir . '/' . $file ))
						$list = array_merge($list, booklovers_collect_files($dir . '/' . $file, $ext));
					else if (empty($ext) || in_array($pi['extension'], $ext))
						$list[] = $dir . '/' . $file;
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}

// Replace site url to current site url
if (!function_exists('booklovers_replace_site_url')) {	
	function booklovers_replace_site_url($str, $old_url) {
		static $site_url = '', $site_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = booklovers_replace_site_url($v, $old_url);
			}
		} else if (is_string($str)) {
			if (empty($site_url)) {
				$site_url = get_site_url();
				$site_len = booklovers_strlen($site_url);
				if (booklovers_substr($site_url, -1)=='/') {
					$site_len--;
					$site_url = booklovers_substr($site_url, 0, $site_len);
				}
			}
			if (booklovers_substr($old_url, -1)=='/') $old_url = booklovers_substr($old_url, 0, booklovers_strlen($old_url)-1);
			$break = '\'" ';
			$pos = 0;
			while (($pos = booklovers_strpos($str, $old_url, $pos))!==false) {
				$str = booklovers_unserialize($str);
				if (is_array($str) && count($str) > 0) {
					foreach ($str as $k=>$v) {
						$str[$k] = booklovers_replace_site_url($v, $old_url);
					}
					$str = serialize($str);
					break;
				} else {
					$pos0 = $pos;
					$chg = true;
					while ($pos0 >= 0) {
						if (booklovers_strpos($break, booklovers_substr($str, $pos0, 1))!==false) {
							$chg = false;
							break;
						}
						if (booklovers_substr($str, $pos0, 5)=='http:' || booklovers_substr($str, $pos0, 6)=='https:')
							break;
						$pos0--;
					}
					if ($chg && $pos0>=0) {
						$str = ($pos0 > 0 ? booklovers_substr($str, 0, $pos0) : '') . ($site_url) . booklovers_substr($str, $pos+booklovers_strlen($old_url));
						$pos = $pos0 + $site_len;
					} else 
						$pos++;
				}
			}
		}
		return $str;
	}
}


// Get domain part from URL
if (!function_exists('booklovers_get_domain_from_url')) {
	function booklovers_get_domain_from_url($url) {
		if (($pos=strpos($url, '://'))!==false) $url = substr($url, $pos+3);
		if (($pos=strpos($url, '/'))!==false) $url = substr($url, 0, $pos);
		return $url;
	}
}


// Return file extension from full name/path
if (!function_exists('booklovers_get_file_ext')) {	
	function booklovers_get_file_ext($file) {
		$parts = pathinfo($file);
		return $parts['extension'];
	}
}

/* File system utils
------------------------------------------------------------------------------------- */

// Init WP Filesystem
if (!function_exists('booklovers_init_filesystem')) {
	add_action( 'after_setup_theme', 'booklovers_init_filesystem', 0);
	function booklovers_init_filesystem() {
        if( !function_exists('WP_Filesystem') ) {
            require_once( ABSPATH .'/wp-admin/includes/file.php' );
        }
		if (is_admin()) {
			$url = admin_url();
			$creds = false;
			// First attempt to get credentials.
			if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
				// If we comes here - we don't have credentials
				// so the request for them is displaying no need for further processing
				return false;
			}
	
			// Now we got some credentials - try to use them.
			if ( !WP_Filesystem( $creds ) ) {
				// Incorrect connection data - ask for credentials again, now with error message.
				if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
				return false;
			}
			
			return true; // Filesystem object successfully initiated.
		} else {
            WP_Filesystem();
		}
		return true;
	}
}


// Put text into specified file
if (!function_exists('booklovers_fpc')) {	
	function booklovers_fpc($file, $data, $flag=0) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				// Attention! WP_Filesystem can't append the content to the file!
				// That's why we have to read the contents of the file into a string,
				// add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
				return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND ? $wp_filesystem->get_contents($file) : '') . $data, false);
			} else {
				if (booklovers_param_is_on(booklovers_get_theme_option('debug_mode')))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'booklovers'), $file));
			}
		}
		return false;
	}
}

// Get text from specified file
if (!function_exists('booklovers_fgc')) {	
	function booklovers_fgc($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents($file);
			} else {
				if (booklovers_param_is_on(booklovers_get_theme_option('debug_mode')))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'booklovers'), $file));
			}
		}
		return '';
	}
}

// Get array with rows from specified file
if (!function_exists('booklovers_fga')) {	
	function booklovers_fga($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents_array($file);
			} else {
				if (booklovers_param_is_on(booklovers_get_theme_option('debug_mode')))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'booklovers'), $file));
			}
		}
		return array();
	}
}

// Remove unsafe characters from file/folder path
if (!function_exists('booklovers_esc')) {	
	function booklovers_esc($file) {
        return sanitize_file_name($file);
	}
}

// Create folder
if (!function_exists('booklovers_mkdir')) {	
	function booklovers_mkdir($folder, $addindex = true) {
		if (is_dir($folder) && $addindex == false) return true;
		$created = wp_mkdir_p(trailingslashit($folder));
		@chmod($folder, 0777);
		if ($addindex == false) return $created;
		$index_file = trailingslashit($folder) . 'index.php';
		if (file_exists($index_file)) return $created;
		booklovers_fpc($index_file, "<?php\n// Silence is golden.\n");
		return $created;
	}
}




/* Check if file/folder present in the child theme and return path (url) to it. 
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */

// Detect file location with next algorithm:
// 1) check in the skin folder in the child theme folder (optional, if $from_skin==true)
// 2) check in the child theme folder
// 3) check in the framework folder in the child theme folder
// 4) check in the skin folder in the main theme folder (optional, if $from_skin==true)
// 5) check in the main theme folder
// 6) check in the framework folder in the main theme folder
if (!function_exists('booklovers_get_file_dir')) {	
	function booklovers_get_file_dir($file, $return_url=false, $from_skin=true) {
		static $skin_dir = '';
		if ($file[0]=='/') $file = booklovers_substr($file, 1);
		if ($from_skin && empty($skin_dir) && function_exists('booklovers_get_custom_option')) {
			$skin_dir = booklovers_esc(booklovers_get_custom_option('theme_skin'));
			if ($skin_dir) $skin_dir  = 'skins/' . ($skin_dir);
		}
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
		$child_dir = get_stylesheet_directory();
		$child_url = get_stylesheet_directory_uri();
		$dir = '';
		if ($from_skin && !empty($skin_dir) && file_exists(($child_dir).'/'.($skin_dir).'/'.($file)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($skin_dir).'/'.($file);
		else if (file_exists(($child_dir).'/'.($file)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($file);
		else if (file_exists(($child_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($file)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($file);
		else if ($from_skin && !empty($skin_dir) && file_exists(($theme_dir).'/'.($skin_dir).'/'.($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($skin_dir).'/'.($file);
		else if (file_exists(($theme_dir).'/'.($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($file);
		else if (file_exists(($theme_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($file)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($file);
		return $dir;
	}
}

// Detect file location with next algorithm:
// 1) check in the skin folder in the main theme folder (optional, if $from_skin==true)
// 2) check in the main theme folder
// 3) check in the framework folder in the main theme folder
// and return file slug (relative path to the file without extension)
// to use it in the get_template_part()
if (!function_exists('booklovers_get_file_slug')) {	
	function booklovers_get_file_slug($file, $from_skin=true) {
		static $skin_dir = '';
		if ($file[0]=='/') $file = booklovers_substr($file, 1);
		if ($from_skin && empty($skin_dir) && function_exists('booklovers_get_custom_option')) {
			$skin_dir = booklovers_esc(booklovers_get_custom_option('theme_skin'));
			if ($skin_dir) $skin_dir  = 'skins/' . ($skin_dir);
		}
		$theme_dir = get_template_directory();
		$dir = '';
		if ($from_skin && !empty($skin_dir) && file_exists(($theme_dir).'/'.($skin_dir).'/'.($file)))
			$dir = ($skin_dir).'/'.($file);
		else if (file_exists(($theme_dir).'/'.($file)))
			$dir = $file;
		else if (file_exists(($theme_dir).'/'.BOOKLOVERS_FW_DIR.'/'.($file)))
			$dir = BOOKLOVERS_FW_DIR.'/'.($file);
		if (booklovers_substr($dir, -4)=='.php') $dir = booklovers_substr($dir, 0, booklovers_strlen($dir)-4);
		return $dir;
	}
}

if (!function_exists('booklovers_get_file_url')) {	
	function booklovers_get_file_url($file) {
		return booklovers_get_file_dir($file, true);
	}
}

// Detect file location in the skin/theme/framework folders
if (!function_exists('booklovers_get_skin_file_dir')) {	
	function booklovers_get_skin_file_dir($file) {
		return booklovers_get_file_dir($file, false, true);
	}
}

// Detect file location in the skin/theme/framework folders
if (!function_exists('booklovers_get_skin_file_slug')) {	
	function booklovers_get_skin_file_slug($file) {
		return booklovers_get_file_slug($file, true);
	}
}

if (!function_exists('booklovers_get_skin_file_url')) {	
	function booklovers_get_skin_file_url($file) {
		return booklovers_get_skin_file_dir($file, true, true);
	}
}

// Detect folder location with same algorithm as file (see above)
if (!function_exists('booklovers_get_folder_dir')) {	
	function booklovers_get_folder_dir($folder, $return_url=false, $from_skin=false) {
		static $skin_dir = '';
		if ($folder[0]=='/') $folder = booklovers_substr($folder, 1);
		if ($from_skin && empty($skin_dir) && function_exists('booklovers_get_custom_option')) {
			$skin_dir = booklovers_esc(booklovers_get_custom_option('theme_skin'));
			if ($skin_dir) $skin_dir  = 'skins/'.($skin_dir);
		}
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
		$child_dir = get_stylesheet_directory();
		$child_url = get_stylesheet_directory_uri();
		$dir = '';
		if (!empty($skin_dir) && file_exists(($child_dir).'/'.($skin_dir).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($skin_dir).'/'.($folder);
		else if (is_dir(($child_dir).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($folder);
		else if (is_dir(($child_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($folder);
		else if (!empty($skin_dir) && file_exists(($theme_dir).'/'.($skin_dir).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($skin_dir).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.(BOOKLOVERS_FW_DIR).'/'.($folder);
		return $dir;
	}
}

if (!function_exists('booklovers_get_folder_url')) {	
	function booklovers_get_folder_url($folder) {
		return booklovers_get_folder_dir($folder, true);
	}
}

// Detect skin version of the social icon (if exists), else return it from template images directory
if (!function_exists('booklovers_get_socials_dir')) {	
	function booklovers_get_socials_dir($soc, $return_url=false) {
		return booklovers_get_file_dir('images/socials/' . booklovers_esc($soc) . (booklovers_strpos($soc, '.')===false ? '.png' : ''), $return_url, true);
	}
}

if (!function_exists('booklovers_get_socials_url')) {	
	function booklovers_get_socials_url($soc) {
		return booklovers_get_socials_dir($soc, true);
	}
}

// Detect theme version of the template (if exists), else return it from fw templates directory
if (!function_exists('booklovers_get_template_dir')) {	
	function booklovers_get_template_dir($tpl) {
		return booklovers_get_file_dir('templates/' . booklovers_esc($tpl) . (booklovers_strpos($tpl, '.php')===false ? '.php' : ''));
	}
}
?>