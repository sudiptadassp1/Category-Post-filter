<?php
/* 
    Plugin Name: Category Post filter
    Description: Get custom post carousol by category
    Version: 2.0.0
    Author: Sudipta Das
*/
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$GLOBALS['postname'] = '';

register_activation_hook( __FILE__, 'get_category_name' );
require_once('admin/function.php');
require_once('admin/create_post.php');
require_once('public/function.php');


function register_common_scripts_style(){
  wp_register_script('jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', null, false);
  wp_enqueue_script('jquery-script');

  wp_register_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js', null, true);
  wp_enqueue_script('bootstrap-script');

  wp_register_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css');
  wp_enqueue_style('bootstrap-css');

  wp_register_style('custom-public-css', plugins_url('public/css/custom.css', __FILE__));
  wp_enqueue_style('custom-public-css');
  
}
add_action('init', 'register_common_scripts_style');

function register_admin_scripts_style(){
  wp_register_script('custom-admin-script', plugins_url('admin/js/admin.js', __FILE__));
  wp_enqueue_script('custom-admin-script');
  wp_localize_script( 'custom-admin-script', 'post_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  wp_register_style('custom-admin-css', plugins_url('admin/css/admin.css', __FILE__));
  wp_enqueue_style('custom-admin-css');

  
}
add_action('admin_enqueue_scripts', 'register_admin_scripts_style');

add_action( 'wp_enqueue_scripts', 'register_public_scripts' );
function register_public_scripts() {
    wp_enqueue_script('custom-javascript-public', plugins_url('public/js/custom.js', __FILE__), array('jquery'), null, true);
    wp_localize_script( 'custom-javascript-public', 'my_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}



// add_action( 'admin_menu', 'register_my_custom_menu_page' );
add_action("wp_ajax_get_test_custom_post", "get_test_custom_post");
add_action("wp_ajax_nopriv_get_test_custom_post", "get_test_custom_post");

add_action("wp_ajax_set_post_type", "set_post_type_func");
add_action("wp_ajax_nopriv_set_post_type", "set_post_type_func");

add_action("wp_ajax_generate_shortcode", "generate_shortcode_function");
add_action("wp_ajax_nopriv_generate_shortcode", "generate_shortcode_function");

//Limit post excerpt
function get_excerpt(){
  $excerpt = get_the_content();
  $excerpt = preg_replace(" ([.*?])",'',$excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, 70);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
  
  return $excerpt;
  }


