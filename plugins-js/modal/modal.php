<?php

// If you have a modal, this can be implemented to the top of the page.

if ($_GET['modal'] == true) : ?>
	<div id="modal-header">
		<h2><?php echo get_the_title(); ?></h2>
	</div>
	<div id="modal-body">
		<?php sliceLoop('slices_flex'); ?>
	</div>
	
<?php die(); endif; ?>