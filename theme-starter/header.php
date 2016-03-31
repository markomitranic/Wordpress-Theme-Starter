<!--
Header Template
This is just a suggestion of what woudl be used within the header when making Wordpress templates.

Header menu can be created simply with calling a function. It will generate a simple ul>li>a list of menu items from that particular menu.
Creating header menus: https://developer.wordpress.org/reference/functions/wp_nav_menu/

If you are not into that kind of stuff and need special elements, classes and stuff, you can create a custom loop menu. This is what the second example is for.
-->


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head(); ?>
    </head>
    <body>
    	<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>



		<?php
			$menu_name = 'header-menu';
			 
			if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			    $menu_items = wp_get_nav_menu_items($menu->term_id);

			    $menu_list = '<ul>'; 
			    foreach ( (array) $menu_items as $key => $menu_item ) {
			        $title = $menu_item->title;
			        $url = $menu_item->url;
			        $menu_list .= '<li><a id="'.$menu_item->classes[0].'" href="' . $url . '">'. $title . '</a></li>';
			    }
			    $menu_list .= '</ul>';

			} else {
			    $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
			}
			echo $menu_list;
		?>