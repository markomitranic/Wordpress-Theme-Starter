<?php 
	// check if the repeater field has rows of data
	$heroes = "";
	$thumbnails = "";
	$i = 0;

	if( have_rows('slider') ):
	    while ( have_rows('slider') ) : the_row();
	        $image = get_sub_field('image')['sizes']['hero'];
	        $thumb = get_sub_field('image')['sizes']['thumbnail'];
	        $alt = get_sub_field('image')['alt'];

	        $heroes .= '<li data-id="'. $i .'" style="background-image: url('. $image .');">';
	        $heroes .= '<img src="'. $image .'" alt="'. $alt .'">';
	        $heroes .= '</li>';
	        
	        $thumbnails .= '<img data-id="'. $i .'" src="'. $thumb .'">';

	        $i++;
	    endwhile;
	endif;
 ?>


	<article id="slider">
		<ul>
			<?php echo $heroes; ?>
		</ul>
		<div id="thumbs">
			<?php echo $thumbnails; ?>
		</div>
	</article>