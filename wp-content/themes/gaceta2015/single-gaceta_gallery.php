<?php get_header(); ?>
	<!-- Begin Content -->
	<div class="single-container page" >
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="single-block">
			<div class="page-line-title grid_12"><h1 class="inner-title"><?php the_title(); ?></h1></div>
			<div class="clear"></div>
			<div class="single-content">
				<div class="grid_12"><?php the_content(); ?></div>
						<?php
   							//fetch all images which are in current post
   							$attachments = attachments_get_attachments();
    						$total_attachments = count($attachments);
							if( $total_attachments > 0 )
							{
		  						for ($i=0; $i < $total_attachments; $i++)
		  						{	
		  							$exten = substr(strrchr($attachments[$i]["location"],'.'),1);
		  							$filename = substr($attachments[$i]["location"], 0, -4);
			  						$good_size = $filename.'-140x140.'.$exten;
			  						echo '<div class="grid_2 gallery-image"><a href="'.$attachments[$i]["location"].'" title="'.$attachments[$i]["title"].'" rel="prettyPhoto[gallery]" class="preview-icon"><img src="'.$good_size.'" width="140" height="140" class="fadeover" alt="'.$attachments[$i]["caption"].'" /></a></div>';
		 						 }
							}
   						?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	</div>
	<!-- End Content -->
<?php get_footer(); ?>