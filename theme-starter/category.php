<?php

// This is a simple var dumped category page.
// We have two different loop options. Query and Get.
// If we use query, we are meddling with the WP Query loop.
// Get posts is somewhat better, but it has less options. This returns an array of posts.

// Wordpress Tags Usage: https://codex.wordpress.org/Template_Tags


get_header();


$args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'portfolio',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
$posts_array = get_posts( $args );
var_dump($posts_array);






query_posts(['post_type'=> 'post', 'order' => 'DESC', 'posts_per_page'=> 6]);
while ( have_posts() ) : the_post();
	echo the_title();
endwhile;





get_footer();


?>