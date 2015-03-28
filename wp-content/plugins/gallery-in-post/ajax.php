<?php
function show_gallery_in_post_form($thePostId){
	$image = get_post($thePostId);
	$custom2Value = get_post_meta($image->ID, "_exclude-from-gallery", true);
	$gip_url = get_post_meta($image->ID, "_gip_url", true);
	$checked = ($custom2Value=='1')?'checked':'';
	$tdi++;
	if ( $image->ID == $thumb ) $is_thumb = ' checked="checked"';
	else $is_thumb = '';
	$htmlOut = 	"<div>"
				."<p><label>Title:</label><input type='text' value='{$image->post_title}' name='image_title' size='40' id='gip_image_title'/></p>"
				."<p><label>Url:</label><input type='text' name='gip_url[]' value='{$gip_url}' id='gip_url'/></p>"
				."<p class='short'>"
				."<input type='hidden' value='{$image->ID}' name='image_ID[]' />"
				."<div class='gip_wysiwyg'><label>Caption:</label><textarea class='caption' name='image_excerpt' size='10' id='gip_image_excerpt'>".wp_richedit_pre($image->post_excerpt)."</textarea></div></p>"
				."<p class='description'><div class='gip_wysiwyg'><label>Description:</label><textarea name='image_content' id='gip_image_desc' rows='5' cols='10'>".wp_richedit_pre($image->post_content)."</textarea></div></p>"
				//."<p>Thumb:<input type='radio' name='image_thumb'$is_thumb value='{$image->ID}' id='gip_is_thumb'/></p>"
				."<p>Exclude from gallery:<input type='checkbox' value='1' class='gip-check' name='gip-check-{$image->ID}' {$checked} id='gip_exclude_from_gallery'/><input type='hidden'  value='{$custom2Value}' name='exclude-from-fallery'/></p>"			
				."<p class='buttons'><button onclick='detachImage({$image->ID});return false;'>Detach</button>"
				."<button onclick='deleteImage({$image->ID});return false;'>Delete</button><button onclick='gip_saveImage({$image->ID});return false;'>Save</button></p>"	
				."</div>";
	echo $htmlOut;
}


function ajax_update_gallery_in_post( $post_id ) {
	/* Update changes to attadchments */
	
		$my_post = array(
			'ID' => $post_id,
			'post_title' => $_REQUEST['image_title'],
			'post_excerpt' => $_REQUEST['image_excerpt'],
			'post_content' => $_REQUEST['image_content'],
			//'menu_order' => $_POST['image_order'][$i]
		);
		wp_update_post( $my_post );
		
		if( isset($_REQUEST['exclude']) ){
			gip_save_post_custom($post_id,'_exclude-from-gallery',$_REQUEST['exclude']);
		}
		else
			gip_save_post_custom($post_id,'_exclude-from-gallery','');
		
		if( isset($_REQUEST['gip_url']) )
			gip_save_post_custom($post_id,'_gip_url',$_REQUEST['gip_url']);
	
	echo 1;
	exit();
}

function save_gallery_in_post(){
	if (!empty($_FILES)) {
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		
		$post_id = $_REQUEST['post_id'];
		
		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
		
		$fileData = $_FILES['Filedata'];
		
		/*
		$attach_id = media_handle_upload( $fileData, $post_id );

		update_post_meta($post_id,'_thumbnail_id',$attach_id);
		*/
		
		$overrides = array( 'test_form' => false);
		
		$uploaded_file = wp_handle_upload($fileData, $overrides);

		$ext = pathinfo($uploaded_file['file'], PATHINFO_EXTENSION);

		$attachment = array(
		'post_title' => $_FILES['Filedata']['name'],
		'post_content' => '',
		'post_type' => 'attachment',
		'post_parent' => $post_id,
		'post_mime_type' => 'image/'.$ext,
		'guid' => $uploaded_file['url']
		);
		// Save the data
		$id = wp_insert_attachment( $attachment,$_FILES['Filedata'][ 'file' ], $post_id );
		$attach_meta = wp_generate_attachment_metadata( $id, $uploaded_file['file'] );
		wp_update_attachment_metadata( $id, $attach_meta );
		
		
		if ($_REQUEST['update_only']=="1")
			update_post_meta($post_id,'_thumbnail_id',$id);	
		else
			add_post_meta($post_id, '_thumbnail_id',$id);	
		
		echo "pid => $post_id , attachId => $id";
		//echo $uploaded_file['url'];
		//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	}
}
if ( isset($_REQUEST['post_id'])&& $_REQUEST['post_id']>"")
{
	save_gallery_in_post();
}
if ( $_GET['detachImage'] ) {
	if ( current_user_can( 'edit_post', $_GET['detachImage']  ) ) {
		$my_post = array( 
			'ID' => $_GET['detachImage'],
			'post_parent' => 0
		);
		if ( wp_update_post( $my_post ) ) echo '1';
	}
}
if ( $_GET['deleteImage'] ) {
	if ( current_user_can( 'delete_post', $_GET['deleteImage'] ) ) {
		if ( wp_delete_attachment( $_GET['deleteImage'] ) ) echo '1';
	}
}
if ( isset($_REQUEST['show_gip_form'])&& $_REQUEST['show_gip_form']>"")
{
	show_gallery_in_post_form($_REQUEST['gip_postId']);
}
if ( isset($_REQUEST['updateImage'])&& $_REQUEST['updateImage']>"")
{
	ajax_update_gallery_in_post($_REQUEST['updateImage']);
}
?>
