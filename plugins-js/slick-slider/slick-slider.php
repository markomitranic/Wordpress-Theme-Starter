<?php 
$images = get_sub_field('gallery');
$type = get_sub_field('gallery_type');
?>
<?php if ($type == 'slider') : ?>
  
      <?php if( $images ): ?>
            <div class="wp-slider">
                  <?php foreach( $images as $image ): ?>
                              <figure class="unclickable">
                                    <img src="<?php echo $image['sizes']['Hero size']; ?>" alt="<?php echo $image['alt']; ?>">
                              </figure>
                  <?php endforeach; ?>
          </div>
      <?php endif; ?>
      <script>
      	$(document).ready(function(){
      		$('.wp-slider').slick({
                  dots: true,
                  infinite: true,
                  centerMode: true,
                  variableWidth: true,
                  adaptiveHeight: true,
                  accessibility: true,
                  autoplay: true,
                  autoplaySpeed: 3000
      		}).slick('slickNext');
      	});
      </script>
<?php elseif ($type == 'grid') : ?>
      <?php if( $images ): ?>
            <div class="wp-slider grid">
                  <?php foreach( $images as $image ): ?>
                              <figure style="background-image: url(<?php echo $image['sizes']['Hero size']; ?>)">
                                    <img src="<?php echo $image['sizes']['Hero size']; ?>" alt="<?php echo $image['alt']; ?>">
                              </figure>
                  <?php endforeach; ?>
          </div>
      <?php endif; ?>
<?php endif; ?>