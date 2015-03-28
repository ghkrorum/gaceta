<?php 
if ((isset($_GET['gallery']))){
	get_template_part( 'content','gallery' );
}else{
	get_template_part( 'content',get_post_format() );
}
?>
