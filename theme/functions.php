<?php

/******************** SET UP ********************/

// Localisation 
load_theme_textdomain( 'estete', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

add_action( 'after_setup_theme', 'estete' );
if ( ! function_exists( 'estete' ) ):
function estete() {
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 60, 60, true ); // Main theme thumbnails
	add_image_size( 'thumbnail-lead', 550, 220, true ); // Large thumbnails
	add_image_size( 'thumbnail-random', 300, 200, true ); // Large thumbnails
	add_image_size( 'thumbnail-related', 120, 120, true ); // related posts image
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary-menu' => __( 'Primary menu' ),
	) );	
}
endif;

/******************** REGISTER SIDEBARS & WIDGET CLASSES ********************/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Основной сайдбар',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Сайдбар страниц',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Сайдбар постов',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

// Add option for custom avatar
function e_custom_avatar( $avatar_defaults ) {
    $e_avatar = get_bloginfo('template_directory') . '/images/avatar.png';
    $avatar_defaults[$e_avatar] = 'Estete';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'e_custom_avatar' );

/******************** POST EXCERPT ********************/

// Remove more jump link
function e_remove_more_jump_link($link) { 
$offset = strpos($link, '#more-');
if ($offset) {
$end = strpos($link, '"',$offset);
}
if ($end) {
$link = substr_replace($link, '', $offset, $end-$offset);
}
return $link;
}
add_filter('the_content_more_link', 'e_remove_more_jump_link');

function improved_trim_excerpt($text) {
	global $post;
		if ( '' == $text ) {
			$text = get_the_content('');
			$text = apply_filters('the_content', $text);
			$text = str_replace('\]\]\>', ']]&gt;', $text);
			$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
			$text = strip_tags($text, '<p> <a>');
			$excerpt_length = 35;
			$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words)> $excerpt_length) {
			array_pop($words);
				array_push($words, '...');
				$text = implode(' ', $words);
			}
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');

/******************** DESCRIPTION META ********************/

function e_meta_desc() {
	/* >> user-configurable variables */
	$default_blog_desc = 'Estete - блог, посвященный визуальной красоте'; // default description (setting overrides blog tagline)
	$post_desc_length  = 30; // description length in # words for post/Page
	$post_use_excerpt  = 1; // 0 (zero) to force content as description for post/Page
	$custom_desc_key   = 'description'; // custom field key; if used, overrides excerpt/content
	/* << user-configurable variables */

	global $cat, $cache_categories, $wp_query, $wp_version;
	if(is_single() || is_page()) {
		$post = $wp_query->post;
		$post_custom = get_post_custom($post->ID);
		$custom_desc_value = $post_custom["$custom_desc_key"][0];

		if($custom_desc_value) {
			$text = $custom_desc_value;
		} elseif($post_use_excerpt && !empty($post->post_excerpt)) {
			$text = $post->post_excerpt;
		} else {
			$text = $post->post_content;
		}
		$text = str_replace(array("\r\n", "\r", "\n", "  "), " ", $text);
		$text = str_replace(array("\""), "", $text);
		$text = trim(strip_tags($text));
		$text = explode(' ', $text);
		if(count($text) > $post_desc_length) {
			$l = $post_desc_length;
			$ellipsis = '...';
		} else {
			$l = count($text);
			$ellipsis = '';
		}
		$description = '';
		for ($i=0; $i<$l; $i++)
			$description .= $text[$i] . ' ';

		$description .= $ellipsis;
	} elseif(is_category()) {
		$category = $wp_query->get_queried_object();
		$description = trim(strip_tags($category->category_description));
	} else {
		$description = (empty($default_blog_desc)) ? trim(strip_tags(get_bloginfo('description'))) : $default_blog_desc;
	}

	if($description) {
		echo "<meta name=\"description\" content=\"$description\"/>\n";
	}
}

/******************** WP ADMIN ********************/

// Remove WP logo from toolbar
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Edit admin footer link and remove version number
function e_change_footer_admin () {
return '<a href="' . get_home_url() . '">© ' . get_bloginfo('name') . '</a>';
}
add_filter('admin_footer_text', 'e_change_footer_admin', 9999);
function e_remove_footer_version() {
return '';
}
add_filter( 'update_footer', 'e_remove_footer_version', 9999);

// Admin Area Favicon
function e_wp_favicon() {
	echo '<link rel="shortcut icon" href="' . get_bloginfo('template_directory') . '/favicon.ico" />';
}
add_action('admin_head', 'e_wp_favicon');
add_action('login_head', 'e_wp_favicon' );

// Remove current theme from “Right Now” dashboard widget
function e_remove_theme_name($text) {
     $text = str_ireplace('Тема <span class="b">%1$s</span>,', '',  $text);
     return $text;
}
add_filter('ngettext', 'e_remove_theme_name' );

// Profile fields
add_filter('user_contactmethods','hide_profile_fields',10,1);
function hide_profile_fields( $contactmethods ) {
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['yim']);
    return $contactmethods;
}

// Remove submenus
function e_admin_menus() {  
    remove_submenu_page('options-general.php','wplogin_redirect.php'); 
	remove_submenu_page('options-general.php','adminimize/adminimize.php'); 
	remove_submenu_page('options-general.php','google-analyticator.php'); 
	remove_submenu_page('options-general.php','faster-image-insert/faster-image-insert.php'); 
	remove_submenu_page('options-general.php','mail-from.php'); 
	remove_submenu_page('options-general.php','reveal-ids-for-wp-admin-25/reveal-ids-for-wp-admin-25.php'); 	
	remove_submenu_page('options-general.php','simple-google-sitemap.php'); 	
	remove_submenu_page('options-general.php','simplemodal-login.php'); 
	remove_submenu_page('options-general.php','postviews-options.php');
	remove_submenu_page('options-general.php','pagenavi.php');
}  
add_action( 'admin_menu', 'e_admin_menus' );  

// Disable widgets
function e_unregister_widget() {
    unregister_widget('WP_Widget_Pages'); 
    unregister_widget('WP_Widget_Calendar'); 
    unregister_widget('WP_Widget_Archives'); 
    unregister_widget('WP_Widget_Links'); 
    unregister_widget('WP_Widget_Meta');  
    unregister_widget('WP_Widget_Categories'); 
    unregister_widget('WP_Widget_Recent_Posts'); 
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud'); 
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_PostViews'); 
    unregister_widget('Akismet_Widget'); 	
	unregister_widget('GoogleStatsWidget');
	unregister_widget('SU_Widget_Search');
}
add_action('widgets_init', 'e_unregister_widget');

// Disable dashboard widgets
function e_disable_default_dashboard_widgets() { 
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  
	remove_meta_box('dashboard_primary', 'dashboard', 'core');  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');  
}  
add_action('admin_menu', 'e_disable_default_dashboard_widgets');  

// Highligt posts statuses
function e_posts_status_color(){
	echo '<style>
	.status-draft{ background: #FCE3F2!important; }
	.status-pending{ background: #87C5D6!important; }
	.status-future{ background: #C6EBF5!important; }
	.status-private{ background:#F2D46F!important; }
</style>'."\n";
}
add_action('admin_footer','e_posts_status_color');

// Remove Captions
add_filter('the_content', 'e_remove_img_titles');
function e_remove_img_titles($text) {
    // Get all title="..." tags from the html.
    $result = array();
    preg_match_all('|title="[^"]*"|U', $text, $result);
    // Replace all occurances with an empty string.
    foreach($result[0] as $img_tag) {
        $text = str_replace($img_tag, '', $text);
    }
    return $text;
}

// Remove admin color scheme options
function e_remove_admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'e_remove_admin_color_scheme');

// Display post id column
function e_posts_columns_id($defaults){
    $defaults['e_post_id'] = 'ID';
    return $defaults;
}
function e_posts_custom_id_columns($column_name, $id){
    if($column_name === 'e_post_id'){
        echo $id;
    }
}
function e_posts_columns_attachment_id($defaults){
    $defaults['e_attachments_id'] = 'ID';
	return $defaults;
}
function e_posts_custom_columns_attachment_id($column_name, $id){
    if($column_name === 'e_attachments_id'){
        echo $id;
    }
}
add_filter('manage_posts_columns', 'e_posts_columns_id', 5);
add_action('manage_posts_custom_column', 'e_posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'e_posts_columns_id', 5);
add_action('manage_pages_custom_column', 'e_posts_custom_id_columns', 5, 2);
add_filter('manage_media_columns', 'e_posts_columns_attachment_id', 1);
add_action('manage_media_custom_column', 'e_posts_custom_columns_attachment_id', 1, 2);

// Display post attachment count column
function e_posts_columns_attachment_count($defaults) {
    $defaults['e_post_attachments'] = __('Прикреплены', 'e');
    return $defaults;
}
function e_posts_custom_columns_attachment_count($column_name, $id){
    if($column_name === 'e_post_attachments') {
		$attachments = get_children(array('post_parent'=>$id));
		$count = count($attachments);
		if($count !=0){
			echo $count;
		}
    }
}
add_filter('manage_posts_columns', 'e_posts_columns_attachment_count', 5);
add_action('manage_posts_custom_column', 'e_posts_custom_columns_attachment_count', 5, 2);

// Display media library URL column
function e_muc_column( $cols ) {
        $cols["media_url"] = "URL";
        return $cols;
}
function e_muc_value( $column_name, $id ) {
        if ( $column_name == "media_url" ) echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="'.wp_get_attachment_url( $id ).'"/>';
}
add_filter( 'manage_media_columns', 'e_muc_column' );
add_action( 'manage_media_custom_column', 'e_muc_value', 10, 2);

// Add styles for columns
function e_columns_styles() {
	echo "\n".'<style type="text/css">
    .column-e_post_id, .column-e_attachments_id { width: 50px; }
    .column-e_post_attachments { width: 100px; }
    .column-author { width: 130px!important; }
</style>'."\n";
}
add_action('admin_head', 'e_columns_styles');

/******************** WP LOGIN ********************/

// Custom styles and script for login page
function e_custom_login() { 
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/css/login.css" type="text/css" media="screen" />'; 
	echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/js/respond.min.js"></script>';
}
add_action('login_head', 'e_custom_login');

// Make a custom login logo and link
function e_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
    </style>';
}
add_action('login_head', 'e_custom_login_logo');

// Make a custom login logo and link
function e_wp_login_url() {
	echo bloginfo('url');
}
function e_wp_login_title() {}
add_filter('login_headerurl', 'e_wp_login_url');
add_filter('login_headertitle', 'e_wp_login_title');

// Allow login with email address
function e_login_with_email_address($username) {
    $user = get_user_by('email',$username);
    if(!empty($user->user_login))
        $username = $user->user_login;
    return $username;
}
add_action('wp_authenticate','e_login_with_email_address');
function e_username_text($text){
    if(in_array($GLOBALS['pagenow'], array('wp-login.php'))) {
        if ($text == 'Username') { $text = 'Username / Email'; }
		elseif ($text == 'Имя пользователя') { $text = 'Имя пользователя / Email'; }
    }
    return $text;
}
add_filter( 'gettext', 'e_username_text' );

// Redirect after login & logout
function default_login_redirect( $redirect, $request_redirect )
{
    if ( $request_redirect === '' )
        $redirect = home_url();
    return $redirect; 
}
add_filter( 'login_redirect', 'default_login_redirect', 10, 2 );

// Redirect wp-login to login
function wplogin_filter( $url, $path, $orig_scheme )
{
	$old  = array( "/(wp-login\.php)/");
	$new  = array( "login");
	return preg_replace( $old, $new, $url, 1);
}
add_filter('site_url',  'wplogin_filter', 10, 3);

/******************** DISABLE ATTACHMENT PAGES ********************/

// Disable attachment posts
function e_attachment_fields_edit($form_fields,$post){ 
    $form_fields['url']['html'] = preg_replace('/<button(.*)<\/button>/', '', $form_fields['url']['html']);
    $form_fields['url']['helps'] ='';
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'e_attachment_fields_edit', 10, 2);

// Redirect attachment pages
function sar_attachment_redirect() {  
	global $post;
	if( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) {
		wp_redirect(get_permalink($post->post_parent), 301); // permanent redirect to post/page where image or document was uploaded
		exit;
	} elseif( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent < 1) ) {   // for some reason it doesnt work checking for 0, so checking lower than 1 instead...
		wp_redirect(get_bloginfo('wpurl'), 302); // temp redirect to home for image or document not associated to any post/page
		exit;       
    }
}
add_action('template_redirect', 'sar_attachment_redirect',1);

/************************************************************************************
MISC.
*************************************************************************************/

// Output the styling for the seperated Pings
function e_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

// Block Bad Queries
global $user_ID;
if($user_ID) {
  if(!current_user_can('level_10')) {
    if (strlen($_SERVER['REQUEST_URI']) > 255 ||
      strpos($_SERVER['REQUEST_URI'], "eval(") ||
      strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
      strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
      strpos($_SERVER['REQUEST_URI'], "base64")) {
        @header("HTTP/1.1 414 Request-URI Too Long");
    @header("Status: 414 Request-URI Too Long");
    @header("Connection: Close");
    @exit;
    }
  }
}

// Thumbsup
include 'thumbsup/init.php';

// Remove useless stuff from wp_head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

// Russian dates
function the_russian_time($tdate = '') {
	if ( substr_count($tdate , '---') > 0 ) return str_replace('---', '', $tdate);

	$treplace = array (
	"Январь" => "января",
	"Февраль" => "февраля",
	"Март" => "марта",
	"Апрель" => "апреля",
	"Май" => "мая",
	"Июнь" => "июня",
	"Июль" => "июля",
	"Август" => "августа",
	"Сентябрь" => "сентября",
	"Октябрь" => "октября",
	"Ноябрь" => "ноября",
	"Декабрь" => "декабря",

	);
   	return strtr($tdate, $treplace);
}

add_filter('the_time', 'the_russian_time');
add_filter('get_comment_date', 'the_russian_time');
add_filter('the_modified_time', 'the_russian_time');

// Convert Cyrillic characters in URL
function ctl_sanitize_title($title) {
	global $wpdb;

	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
		'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
		'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'Y',
		'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
		'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
		'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
		'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '``',
		'Ы' => 'YI', 'Ь' => '`', 'Э' => 'E`', 'Ю' => 'YU', 'Я' => 'YA',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
		'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'y',
		'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
		'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
		'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ь' => '',
		'ы' => 'yi', 'ъ' => "'", 'э' => 'e`', 'ю' => 'yu', 'я' => 'ya'
	);	

	$term = $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'");
	if ( empty($term) ) {
		$title = strtr($title, apply_filters('ctl_table', $iso9_table));
		$title = preg_replace("/[^A-Za-z0-9`'_\-\.]/", '-', $title);
	} else {
		$title = $term;
	}

	return $title;
}
if ( !empty($_POST) || !empty($_GET['action']) && $_GET['action'] == 'edit' || defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ) {
	add_filter('sanitize_title', 'ctl_sanitize_title', 9);
	add_filter('sanitize_file_name', 'ctl_sanitize_title');
}

function ctl_convert_existing_slugs() {
	global $wpdb;

	$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status = 'publish'");
	foreach ( (array) $posts as $post ) {
		$sanitized_name = ctl_sanitize_title(urldecode($post->post_name));
		if ( $post->post_name != $sanitized_name ) {
			add_post_meta($post->ID, '_wp_old_slug', $post->post_name);
			$wpdb->update($wpdb->posts, array( 'post_name' => $sanitized_name ), array( 'ID' => $post->ID ));
		}
	}

	$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+') ");
	foreach ( (array) $terms as $term ) {
		$sanitized_slug = ctl_sanitize_title(urldecode($term->slug));
		if ( $term->slug != $sanitized_slug ) {
			$wpdb->update($wpdb->terms, array( 'slug' => $sanitized_slug ), array( 'term_id' => $term->term_id ));
		}
	}
}

function ctl_schedule_conversion() {
	add_action('shutdown', 'ctl_convert_existing_slugs');
}
register_activation_hook(__FILE__, 'ctl_schedule_conversion');

//  Youtube Shortcode
function youtube_video($atts, $content=null) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '550',  
        'height' => '309'  
    ), $atts));  
    return '<p><iframe width="' . $width . '" height="' . $height .'" src="http://www.youtube.com/embed/' . $id . '?rel=0" frameborder="0" allowfullscreen></iframe></p>';  
}  
add_shortcode('youtube', 'youtube_video');  

//  Vimeo Shortcode
function vimeo_video($atts, $content=null) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '550',  
        'height' => '309',  
        'color' => 'ffffff'  
    ), $atts));  
    return '<p><iframe src="http://player.vimeo.com/video/' . $id . '?color=' . $color . '" width="' . $width .'" height="' . $height . '" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe></p>';  
}  
add_shortcode('vimeo', 'vimeo_video');  

// Clean nav menu
class Cleaner_Walker_Nav_Menu extends Walker {
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array();
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', '', $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $value . $class_names .'>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el(&$output, $item, $depth) {
        $output .= "</li>\n  ";
    }
}

// Plural Form for comments
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

?>