<?php 

// This is the propper way to enqueue both scripts and additional CSS.

// For a full list of scripts included with WP visit:
// https://developer.wordpress.org/reference/functions/wp_enqueue_script/#Default_scripts_included_with_WordPress

// If you would like to learn why, how and mechanics - you can visit:
// Usage: http://code.tutsplus.com/articles/how-to-include-javascript-and-css-in-your-wordpress-themes-and-plugins--wp-24321


// =========================================================================



// ADD CSS STYLES
    add_action( 'wp_enqueue_scripts', 'custom_styles' );
    function custom_styles() {
        // Register the style first so that WP knows what we are working with:
        wp_register_style( 'core-css', get_template_directory_uri() . '/css/style.css' );
     
        // Then we need to enqueue them one by one to the theme:
        wp_enqueue_style( 'core-css' );
    }


// Sometimes it is mandatory to have a special version of jQuery. This should be avoided. And allowed only outside admin panel.
    if (!is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', ( get_template_directory_uri() . "/js/jquery-1.9.1.min.js"), false, '1.9.1');
            wp_enqueue_script('jquery');
    }


// NOW LETS GET AL THE JAVASCRIPT
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


// If we use ACF plugin, we can add a special theme options page like this.
    // EXAMPLE:> the_field('footer_disclaimer', 'option');
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


// Need to use permanent redirection? Easy peasy.
    function Redirect($url, $permanent = 302) {
        header('Location: ' . $url, true, $permanent);
        exit();
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


// Create a favicon for yout website.
    // add_action('wp_head', 'create_favicon');
    function create_favicon() {
        $output = '';
        $icon = get_field('favicon', 'option');

        if ($icon['width'] == 32) {
            $output .= '<link rel="icon" type="image/png" sizes="32x32" href="'. $icon['url'] .'">';   
        } else {
            $output .= '<link rel="icon" type="image/png" sizes="16x16" href="'. $icon['url'] .'">';   
        }
        echo $output;
    }
    







