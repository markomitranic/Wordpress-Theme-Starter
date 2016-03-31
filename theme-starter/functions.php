<?php 


// This is the propper way to enqueue both scripts and additional CSS.
// Usage: https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
// Generator: https://generatewp.com/register_style/

function custom_styles() {
	wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css', false ); 
}
function custom_js() {
	wp_enqueue_script( 'my-js', get_template_directory_uri() . '/scripts/helloworld.js', false );
}
add_action( 'wp_enqueue_scripts', 'custom_styles' );
add_action( 'wp_enqueue_scripts', 'custom_js' );




// This function is used to register navigation positions within the theme.
// Usage: https://codex.wordpress.org/Function_Reference/register_nav_menus

function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );




// We can add post thumbnails option. This allows the 'Featured Image' field when editing posts.
// Usage: https://codex.wordpress.org/Post_Thumbnails

add_theme_support( 'post-thumbnails' ); 



// We can add predefined image sizes that wordpress will automatically create while uploading.
// Usage: https://developer.wordpress.org/reference/functions/add_image_size/

add_image_size( 'Big', 500, 500, false ); // $name, $min-width, $min-height, $crop
add_image_size( 'footer', 64, 64, true ); 


// There are a few unneeded tags within our <head>. It looks messy. We can disable/unmount them here/

remove_action('wp_head', 'rsd_link'); // Weblog client legacy support (editing via custom-made Apps)
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer Manifest
remove_action('wp_head', 'wp_generator'); // Built-in Meta generator (if we want to use custom meta tags)



?>