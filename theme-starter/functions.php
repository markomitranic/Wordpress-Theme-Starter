<?php 

// This is the propper way to enqueue both scripts and additional CSS.

// For a full list of scripts included with WP visit:
// https://developer.wordpress.org/reference/functions/wp_enqueue_script/#Default_scripts_included_with_WordPress

// If you would like to learn why, how and mechanics - you can visit:
// Usage: http://code.tutsplus.com/articles/how-to-include-javascript-and-css-in-your-wordpress-themes-and-plugins--wp-24321


// =========================================================================


// Wordpress disables sessions. But IF we need a way to enable use of session globally...
    // add_action('init', 'myStartSession', 1);
    function myStartSession() {
        if(!session_id()) {
            session_start();
        }
    }



// ADD CSS STYLES
    add_action( 'wp_enqueue_scripts', 'custom_styles' );
    function custom_styles() {
        // Register the style first so that WP knows what we are working with:
        wp_register_style( 'core-css', get_template_directory_uri() . '/css/style.css' );
     
        // Then we need to enqueue them one by one to the theme:
        wp_enqueue_style( 'core-css' );
    }


// Sometimes it is mandatory to have a special version of jQuery. This should be avoided. And allowed only outside admin panel.
    function deregisterJQuery() {
        wp_deregister_script('jquery');
        wp_register_script('jquery', ( get_template_directory_uri() . "/js/jquery-3.1.0.min.js"), false, '3.1.0');
        wp_enqueue_script('jquery');
    }
    if (!is_admin()) {
        add_action('wp_enqueue_scripts', 'deregisterJQuery');
    }


// NOW LETS GET ALL THE JAVASCRIPT
    add_action( 'wp_enqueue_scripts', 'custom_scripts' );
    function custom_scripts() {
        // Register the scripts first so that WP knows what we are working with:
        // Parameters: Slug, url, dependencies, version, in_footer
        wp_register_script( 'my-js', get_template_directory_uri() . '/ms.js', ['jquery', 'jcrop'], 1.2, true );
     
        // Then we need to enqueue them one by one to the theme:
        wp_enqueue_script( 'my-js' );

        if (is_front_page()) {
            wp_enqueue_script( 'homepage' ); 
        }
    }





// This function is used to register navigation positions within the theme.
// Usage: https://codex.wordpress.org/Function_Reference/register_nav_menus
    add_action( 'init', 'register_my_menus' );
    function register_my_menus() {
      register_nav_menus( array(
        'header-menu' => 'Header Menu',
        'categories-menu' => 'Categories Menu',
      ) );
    }




// We can add post thumbnails option. This allows the 'Featured Image' field when editing posts.
// Usage: https://codex.wordpress.org/Post_Thumbnails
    add_theme_support( 'post-thumbnails' ); 


// We can add predefined image sizes that wordpress will automatically create while uploading.
// Usage: https://developer.wordpress.org/reference/functions/add_image_size/
// $name, $min-width, $min-height, $crop
    add_image_size( 'Big', 500, 500, false );
    add_image_size( 'footer', 64, 64, true ); 


// There are a few unneeded tags within our <head>. It looks messy. We can disable/unmount them here/
    remove_action('wp_head', 'rsd_link'); // Weblog client legacy support
    remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer Manifest
    remove_action('wp_head', 'wp_generator'); // Built-in Meta generator



// Lets set up ACF PRO silently.
    // 1. customize ACF paths
    add_filter('acf/settings/path', 'my_acf_settings_path');
    function my_acf_settings_path( $path ) {
        $path = get_stylesheet_directory() . '/acf-plugin/';
        return $path;
    }
    add_filter('acf/settings/dir', 'my_acf_settings_dir');
    function my_acf_settings_dir( $dir ) {
        $dir = get_stylesheet_directory_uri() . '/acf-plugin/';
        return $dir;
    }
    include_once( get_stylesheet_directory() . '/acf-plugin/acf.php' );

    // 2. Hide ACF field group menu item on administration pages
    // add_filter('acf/settings/show_admin', '__return_false');

    // 3. Set up Theme Options page.
    // USAGE EXAMPLE:> the_field('footer_disclaimer', 'option');
    if( function_exists('acf_add_options_page') ) {
      acf_add_options_page(array(
        'page_title'  =>  'Template Options',
        'menu_title'  =>  'Template Options',
        'menu_slug'   =>  'template-options',
        'capability'  =>  'edit_posts',
        'parent_slug' =>  'themes.php',
        'position'    =>  false,
        'icon_url'    =>  false
        ));
    }


// A Slices loop for creating Marko's custom page builder
    function sliceLoop($name) {
        if( have_rows($name) ):
            while ( have_rows($name) ) : the_row();

                if( get_row_layout() == 'video_slice' ):
                    get_template_part('slices/video-full');

                elseif( get_row_layout() == 'wysiwyg_slice' ): 
                    get_template_part('slices/wysiwyg');

                elseif( get_row_layout() == 'wysiwyg_slice2' ): 
                    get_template_part('slices/wysiwyg2');

                endif;
            endwhile;
        endif;
    }

// We all need a debug method. The second parameter is optional and decides if php is set to die after printing the var.
  function debug($input, $die = false) {
    echo '<pre>';
    print_r($input);
    echo '</pre>';
    if ($die) {
      die();
    }
  }


// Need to use permanent redirection? Easy peasy.
    function Redirect($url, $permanent = 302) {
        header('Location: ' . $url, true, $permanent);
        exit();
    }


// A propper way to implement WP Titles.
add_filter('wp_title', 'change_the_title');
function change_the_title($title) {
    return $title . ' ~ ' . get_bloginfo('name');
}




// Create complete metadata tags for Google, Facebook OG and Twitter Cards
    // add_action('wp_head', 'create_meta');
    function create_meta() {
        global $post;
        $output = "";

        $image = get_field('meta_image')['sizes'];
        $title = get_the_title() . ' ~ ' . get_bloginfo('name');
        $description = get_field('meta_excerpt');
        if (!$description) { $description = get_field('global_meta_description', 'option'); }
        $description = strip_tags($description);
        $description = str_replace("\"", "'", $description);

        // Google metadata
        $output .= '
        <meta name="Description" CONTENT="' . $description . '">';
        // Facebook OpenGraph metadata
        $output .= '
        <meta property="og:title" content="' . $title . '" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="' . $image['Hero size'] . '" />
        <meta property="og:image:width" content="' . $image['Hero size-width'] . '" />
        <meta property="og:image:height" content="' . $image['Hero size-height'] . '" />
        <meta property="og:url" content="' . get_the_permalink() . '" />
        <meta property="og:description" content="' . $description . '" />
        <meta property="og:site_name" content="' . get_bloginfo('name') . '" />';
        // Twitter Cards metadata
        $output .= '
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@DigitalMindLLC">
        <meta name="twitter:creator" content="@DigitalMindLLC">
        <meta name="twitter:title" content="' . $title . '">
        <meta name="twitter:description" content="' . $description . '">';
        $image = (isset($image)) ? $image : get_field('gizmo_bg', 'option')['sizes'];
        $output .= '<meta name="twitter:image" content="' . $image['medium_large'] . '">';
        echo $output;
    }


// Create a favicon for your website.
  // add_action('wp_head', 'create_favicon');
  function create_favicon() {
      $output = '';
      $favicon16 = get_field('favicon_16', 'option');
      $favicon32 = get_field('favicon_32', 'option');
      $appleicon = get_field('apple_ios_icon', 'option');
      $applefullscreen = get_field('apple_full_screen', 'option');
      $androidicon = get_field('android_app_icon', 'option');
      $androidsplash = get_field('android_app_splash', 'option');
      $androidname = (get_field('android_app_name', 'option')) ? get_field('android_app_name', 'option') : get_bloginfo('name');
      $androidcolor = get_field('android_app_color', 'option');


      if ($applefullscreen) {
        $output .= '
          <meta name="apple-mobile-web-app-capable" content="yes">
          <meta name="apple-mobile-web-app-status-bar-style" content="black">';        
      }
      if ($appleicon) {
        $output .= '<link rel="apple-touch-icon" sizes="180x180" href="' . $appleicon . '">';        
      }
      if ($favicon32) {
        $output .= '<link rel="icon" type="image/png" href="' . $favicon32 . '" sizes="32x32">';        
      }
      if ($favicon16) {
        $output .= '<link rel="icon" type="image/png" href="' . $favicon16 . '" sizes="16x16">';        
      }
      if ($androidicon) {
        $output .= '
          <link rel="icon" type="image/png" href="' . $androidicon . '" sizes="192x192">
          <link rel="manifest" href="' . get_template_directory_uri() . '/manifest.json">
          <meta name="theme-color" content="' . $androidcolor . '">';
          // createManifest($androidname, $androidicon, $androidsplash, $androidcolor);
      }

      function createManifest($name, $icon, $splash, $color) {
        $manifest = [
          'name' => $name,
          'icons' => [
            [
              'src' => $icon,
              'sizes' => '192x192',
              'type' => 'image\/png'
            ],
            [
              'src' => $splash,
              'sizes' => '512x512',
              'type' => 'image\/png'
            ]
          ],
          'theme_color' => $color,
          'display' => 'standalone',
          'orientation' => 'portrait'
        ];        
      }

      echo $output;
  }

    


// An example of adding a cusotm shortcode. for your WordPress WYSIWYG editor.
    // add_shortcode( 'fusnota', 'fusnotaHandler' );
    function fusnotaHandler( $atts, $content = null ) {
        return '<span class="footnote jailed"><span class="footnote-number">*</span><span class="footnote-body">'.$content.'</span></span>';
    }


// Disable galleries support
    // add_action( 'admin_head_media_upload_gallery_form', 'mfields_remove_gallery_setting_div' );
    if( !function_exists( 'mfields_remove_gallery_setting_div' ) ) {
       function mfields_remove_gallery_setting_div() {
            print '
            <style type="text/css">
         #gallery-settings *{
               display:none;
           }
        </style>';
        }
    }


// WP_Fill website advises us to disable <p> tags on images.
    // add_filter('the_content', 'filter_ptags_on_images');
    function filter_ptags_on_images($content){
     return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }






