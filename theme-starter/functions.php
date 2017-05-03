<?php 

// For a full list of scripts included with WP visit:
// https://developer.wordpress.org/reference/functions/wp_enqueue_script/#Default_scripts_included_with_WordPress

// If you would like to learn why, how and mechanics - you can visit:
// Usage: http://code.tutsplus.com/articles/how-to-include-javascript-and-css-in-your-wordpress-themes-and-plugins--wp-24321

// =========================================================================


// Wordpress disables sessions. But IF we need a way to enable use of session globally for some reason...
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


// WP uses an ancient version of jQuery 1.4. This should be avoided and removed. Unfortunately, Admin panel uses 1.4 and we should keep it if admin.
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
        wp_register_script( 'my-js', get_template_directory_uri() . '/ms.js', ['jquery'], 1.2, true );
     
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
        'main-menu' => 'Main Menu',
        'copyright-menu' => 'Copyright Menu',
        'contact-header-menu' => 'Contact Header Menu',
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


// A Slices loop for creating Marko's custom page builder. Essentially, if you create an ACF Repeater with an ACF flex field, which has repeater children, you got yourself a page builder...
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


// A propper way to implement WP Titles. The output of this will replace the title tag of the page automatically. Additionally, the function is formatted in ausch a way that it can me statically used anywhere.
  add_filter('wp_title', 'change_the_title');
  function change_the_title($title) {
    $output = $title;
    $output .= ($title == '') ? '' : ' ~ ';
    $output .= get_bloginfo('name');

    return $output;
  }

    


// An example of adding a custom editor shortcode. for your WordPress WYSIWYG editor.
  // add_shortcode( 'fusnota', 'fusnotaHandler' );
  function fusnotaHandler( $atts, $content = null ) {
      return '<span class="footnote jailed"><span class="footnote-number">*</span><span class="footnote-body">'.$content.'</span></span>';
  }


// Disable galleries support. I don't think this is used in WP 4, but WPfill recommends disabling them...
  add_action( 'admin_head_media_upload_gallery_form', 'mfields_remove_gallery_setting_div' );
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


// P tags on images can cause weird side effects, if not planned in the design. I avoid this, since it is not 100% clear.
    // add_filter('the_content', 'filter_ptags_on_images');
    function filter_ptags_on_images($content){
     return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }



//Get hero image for a post. If no Hero Image is provided, use a site-wide fallback
    function get_hero_image($postId) {
        $featuredImage = get_field('hero_image', $postId);
        if (!isset($featuredImage['sizes'])) {
            $featuredImage = get_field('hero_fallback', 'option');
        }
        return $featuredImage['sizes']['Hero'];
    }


// Get size of attachment in MB
  function attachment_size($id) {
      $size = filesize(get_attached_file($id));
      $size /= 1024;
      $size = round($size, 2);
      return $size;
  }



// Clean up HTML from string to get an excerpt
  function excerpt($text, $length = 256) {
      $text = wp_strip_all_tags($text);
      $text = trim(preg_replace('/\s+/', ' ', $text)); // Remove new lines
      $text = substr($text, 0, $length);
      return $text;
  }

