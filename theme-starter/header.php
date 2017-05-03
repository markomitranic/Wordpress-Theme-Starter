<!--
Header Template
This is just a suggestion of what woudl be used within the header when making Wordpress templates.

Header menu can be created simply with calling a function. It will generate a simple ul>li>a list of menu items from that particular menu.
Creating header menus: https://developer.wordpress.org/reference/functions/wp_nav_menu/

If you are not into that kind of stuff and need special elements, classes and stuff, you can create a custom loop menu. This is what the second example is for.
-->


<!-- echo site_url(); -->
<!-- $is_home = (is_front_page()) ? true : false; -->
<!-- echo ($is_home) ? 'class="hidden"' : ''; -->


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title('');?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head(); ?>
        <?php get_template_part('headers'); ?>
    </head>
    <body>


		<a href="<?php echo home_url(); ?>">
			<img id="logo" src="<?php echo get_field('header_logo', 'option')['sizes']['medium']; ?>" alt="<?php echo get_field('header_logo', 'option')['alt']; ?>">
		</a>


    	<?php wp_nav_menu( array(
    		'theme_location'	=>	'header-menu',
    		'menu_class'		=>	'header-menu-wrapper'
    	) ); ?>


		<?php
			$menu_name = 'header-menu';
			 
			if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) :
			    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			    $menu_items = wp_get_nav_menu_items($menu->term_id);

			    $menu_list = '<ul>'; 
			    foreach ( (array) $menu_items as $key => $menu_item ) :
			        $title = $menu_item->title;
			        $alt = $menu_item->attr_title;
			        $url = $menu_item->url;
			        $icon = $menu_item->description;
			        $menu_list .= '
			        <li>
				        <a id="'.$menu_item->classes[0].'" href="' . $url . '"  title="'.$alt.'">
				        	'. $title . '
				        </a>
			        </li>';
			    endforeach;
			    $menu_list .= '</ul>';

			: else :
			    $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
			endif;
			echo $menu_list;
		?>