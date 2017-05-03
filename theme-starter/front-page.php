<?php

// Front Page
// This is a special type of template. If present, it will automatically be set as the front page for your website.
// Wordpress Tags Usage: https://codex.wordpress.org/Template_Tags


get_header();

// We can use this instead of php import method
get_template_part('menus');

// We can get the blog description like this
echo get_bloginfo('description');


echo 'WELCOME TO FRONT PAGE!!!!';


get_footer();


?>