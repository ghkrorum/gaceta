<?php
/*
Plugin Name: Gallery in post
Plugin URI: 
Description: Improved image attachment in post
Version: 1.0
Author: Julio Mart&iacute;nez
Author URI: 
License: GPL2


*/

define("GALLERY_IN_POST_URL",plugins_url('',__FILE__).'/');

add_filter('query_vars', 'gip_queryvars' );
add_action('parse_request', 'gip_check_request');
// add_action('admin_init','gallery_in_post');


function gallery_in_post() {
	if ( $_GET['post'] ) {
		foreach ( get_post_types() as $post_type ) {
			add_meta_box('gallery-in-post', "Images", 'show_images_in_post', $post_type, 'normal', 'high');
			add_meta_box('gallery-in-post-new', "Agregar im&aacute;genes", 'gallery_in_post_new', $post_type, 'normal', 'high');
		}
	}
	//add_action( 'admin_head', 'gallery_in_post_style' );
	wp_enqueue_style( 'gallery-in-post-css', GALLERY_IN_POST_URL.'gallery-in-post.css'); 
	wp_enqueue_style( 'jqModal-css', GALLERY_IN_POST_URL.'jqModal/jqModal.css'); 
	add_action('save_post', 'update_gallery_in_post');
	wp_enqueue_script( 'gallery-in-post',GALLERY_IN_POST_URL.'gallery-in-post.js');
	wp_enqueue_style( 'upladify-css', GALLERY_IN_POST_URL.'uploadify/uploadify.css'); 
	wp_enqueue_script( 'upladify', GALLERY_IN_POST_URL.'uploadify/jquery.uploadify.v2.1.4.min.js');
	wp_enqueue_script( 'swfobject', GALLERY_IN_POST_URL.'uploadify/swfobject.js');
	wp_enqueue_script( 'jqModal-js', GALLERY_IN_POST_URL.'jqModal/jqModal.js');
	wp_localize_script( 'gallery-in-post', 'gip_ajax', array('path'		=> GALLERY_IN_POST_URL,
															'callback'  => home_url() . '/' . 'index.php?gip-callback=gip-ajax',
					) );
	
	add_action( 'admin_head', 'gip_wysiwyg_instance' );
	add_action( 'admin_head', 'gip_show_uploadify_script' );
}

function gip_show_uploadify_script(){?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
		  jQuery('#gip_upload').uploadify({
			'uploader'  : '<?php echo GALLERY_IN_POST_URL;?>uploadify/uploadify.swf',
			'script'    : gip_ajax.callback,
			'cancelImg' : '<?php echo GALLERY_IN_POST_URL;?>uploadify/cancel.png',
			'folder'    : '/wp-content/uploads',
			'auto'      : false,
			'fileExt'   : '*.jpg;*.jpeg;*.png',
			'onError'   : function (event,ID,fileObj,errorObj) {
							  alert(errorObj.type + ' Error: ' + errorObj.info);
							},
			'onComplete'  : function(event, ID, fileObj, response, data) {
							  window.location.reload();
							},
			'fileDesc'    : 'Web Image Files (.JPG, .JPEG , .PNG)',
			<?php if (isset($_GET['post'])){?>
				'scriptData'  : {'post_id':<?php echo $_GET['post'];?>},
			<?php }?>
			
			'multi'       : true,
			'auto'        : true
			
		  });
			var myLoad = function(){
				jQuery('#ex2').find('.gip_wysiwyg').each(function(){
					jQuery(this).make_gip_wysiwyg();	
				});
			};
			
		  jQuery('#ex2').jqm({ajax: '@href' , trigger: 'div.gallery-in-post-img a',onLoad:myLoad});
		});
	</script>
	
<?php
}

function gip_wysiwyg_instance(){
	$post_type = get_post_type($_GET['post']);
	if(!post_type_supports($post_type, 'editor'))
	{
		wp_tiny_mce();
	}
}

function gip_check_request( $wp ){
 	if ( !array_key_exists('gip-callback', $wp->query_vars) )
		{
			return;
		}
	if ( $wp->query_vars['gip-callback'] == 'gip-ajax') {
			require_once (dirname (__FILE__) . '/ajax.php');
            exit();
        }
}
function gip_queryvars( $qvars )
{
  $qvars[] = 'gip-callback';
  return $qvars;
}

// Callback function to show fields in meta box
function show_images_in_post() {
	global $wpdb;
	$callbackkUrl = home_url() . '/' . 'index.php?gip-callback=gip-ajax&show_gip_form=1&gip_postId=';
	$pid = $_GET['post'];
	$thumb = get_post_thumbnail_id($pid);
	// mysql_query($q);
	$images =& get_children("post_type=attachment&post_mime_type=image&post_parent=$pid" );
	echo '<div class="jqmWindow" id="ex2">
			Please wait... <img src="inc/busy.gif" alt="loading" />
		</div>';
    echo '<div class="gallery-in-post-main-cont"><ul class="gallery-in-post-list">';
	foreach ($images as $image) {
		$custom2Value = get_post_meta($image->ID, "_exclude-from-gallery", true);
		$gip_url = get_post_meta($image->ID, "_gip_url", true);
		$checked = ($custom2Value=='1')?'checked':'';
		$tdi++;
		if ( $image->ID == $thumb ) $is_thumb = ' checked="checked"';
		else $is_thumb = '';
		
		echo "<li class='gallery-in-post-image-cont' >"
				."<div class='gallery-in-post-img' id='gallery-in-post-image-{$image->ID}'>"
				."<a href='".$callbackkUrl.$image->ID."'>".wp_get_attachment_image($image->ID, $size='thumb-90x90', $icon = false).'</a>'
				."<input type='hidden' name='image_ID[]' value='{$image->ID}'>"
				.'</div>'
			."</li>";
		
		/*
		echo "<li class='gallery-in-post-image-cont' id='gallery-in-post-image-{$image->ID}'>"
			 .'<div class="gallery-in-post-img">'
				.wp_get_attachment_image($image->ID, $size='list-thumb', $icon = false)
			 .'</div>'
			 ."<p><label>Title:</label><input type='text' value='{$image->post_title}' name='image_title[]' size='40'/></p>"
			 ."<p><label>Url:</label><input type='text' name='gip_url[]' value='{$gip_url}'/></p>"
			 ."<p class='short'>"
			 ."<input type='hidden' value='{$image->ID}' name='image_ID[]' />"
			 ."<div class='gip_wysiwyg'><label>Caption:</label><textarea class='caption' name='image_excerpt[]' size='10'/>".wp_richedit_pre($image->post_excerpt)."</textarea></div></p>"
		     ."<p class='description'><div class='gip_wysiwyg'><label>Description:</label><textarea name='image_content[]' rows='5' cols='10'/>".wp_richedit_pre($image->post_content)."</textarea></div></p>";
			 
			//."<p>Order:<input type='text' value='{$image->menu_order}' name='image_order[]' size='2'/></p>"
		echo "<p>Thumb:<input type='radio' name='image_thumb'$is_thumb/ value='{$image->ID}'></p>"
			."<p>Exclude from gallery:<input type='checkbox' value='1' class='gip-check' name='gip-check-{$image->ID}' {$checked}/><input type='hidden' id='gip-hidden-{$image->ID}' value='{$custom2Value}' name='exclude-from-fallery[]'/></p>"			
			."<p class='buttons'><button onclick='detachImage({$image->ID});return false;'>Detach</button>"
			."<button onclick='deleteImage({$image->ID});return false;'>Delete</button></p>"			
			."</li>";
		*/
		
		if ($tdi == 3) {
			echo "</tr><tr>";
			$tdi = 0;
		}
	}
	echo '</ul></div>';
}
function gallery_in_post_new(){
	echo "<p><label>Imagen:</label><input id='gip_upload' class='gip_upload' name='file_upload' type='file' /></p>";
}
function update_gallery_in_post( $post_id ) {
	/* Update changes to attadchments */
	foreach ( (array)$_POST['image_ID'] as $i=>$ID ) {
		/*
		$my_post = array(
			'ID' => $ID,
			'post_title' => $_POST['image_title'][$i],
			'post_excerpt' => $_POST['image_excerpt'][$i],
			'post_content' => $_POST['image_content'][$i],
			//'menu_order' => $_POST['image_order'][$i]
		);
		wp_update_post( $my_post );
		*/
		$excludeFromGallery = get_post_meta($ID, "_exclude-from-gallery", true);
		$gip_url = get_post_meta($ID, "_gip_url", true);
		if (empty($excludeFromGallery))
			gip_save_post_custom($ID,'_exclude-from-gallery','');
		if (empty($gip_url))
			gip_save_post_custom($ID,'_gip_url','');
	}
	return $post_id;
}

function gip_save_post_custom($postID,$field,$value){
	if ( !update_post_meta($postID, $field, $value))  
				add_post_meta($postID, $field, $value); 
	
}

function gip_galNav($images){
	$code = "";
	if ($images){
		$total_images = count($images);
		$code = '<div class="fotoNav fs-11">';
		
							
			$i = 0;
			foreach ($images as $image)
			{
				$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				$image_src = wp_get_attachment_image_src( $image->ID, 'gal-large' );
				if ($image_src){
					$code .= '<div class="fotoPinCont_'.$i.' fotoPinCont">'
							.'<a href="//pinterest.com/pin/create/button/'
							.'?url='.get_permalink()
							.'&media='.$image_src[0]
							.'&description='.$image->post_excerpt.'"'
							.' data-pin-do="buttonPin"'
							.' data-pin-config="beside">'
							.'<img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />'
							.'</a>'
							.'</div>';
				}
				$i++;
			}
			$code .= '<a href="#" class="fotoNavPrev prevImg">< anterior</a><span class="fotoNavInd">1 / '.$total_images.'</span><a href="#" class="fotoNavNext nextImg">siguiente ></a>';
			
		
		$code .= '</div>';
	}
	return $code;
}

function gip_jsCode($images = array()){
$jsImageArray = "var imageArray = null;";
if ($images){
	$jsImageArray .= "imageArray = ".json_encode($images).";";
	
}

$jsCode = <<<JS
<script>
{$jsImageArray}
function GalNav(){
	var This = this;
	this.prevSelector = ".fotoNavPrev";
	this.nextSelector = ".fotoNavNext";
	this.indicatorSelector = ".fotoNavInd";
	this.current = 0;
	this.totalItems = 0;
	this.init = function(){
		this.totalItems = jQuery('#totalPics').val();
		jQuery(this.prevSelector).click(function(event){
			event.preventDefault();
			This.prev();
		});
		jQuery(this.nextSelector).click(function(event){
			event.preventDefault();
			This.next();
		});
		this.updateIndicator();
		this.showPin();
	};
	this.next = function(){
		if (this.current < this.totalItems-1)
		{
			this.showGal(++this.current);
		}
	};
	this.prev = function(){
		if (this.current > 0)
		{
			this.showGal(--this.current);
		}
	};
	this.updateIndicator = function(){
		var txt = this.current+1+' / '+this.totalItems;
		jQuery(this.indicatorSelector).text(txt);
	};
	this.showGal = function(idVal){
		if (idVal >=0 && idVal < this.totalItems)
		{
			jQuery('#fotoCont ul li').css('display', 'none');
			jQuery('#fotoCont_'+idVal).css('display', 'block');
			this.current = idVal;
			this.updateIndicator();
			this.showPin();
		}
	};
	this.showPin = function(){
		jQuery('.fotoPinCont').css('display', 'none');
		jQuery('.fotoPinCont_'+this.current).css('display', 'block');
	};
	this.init();
}

var galNav;
jQuery(document).ready(function(){
	if (imageArray != null){
		for (var i=0;i<imageArray.length;i++)
		{
			var image = imageArray[i];
			var img = new Image();
			img.onload = function(){
				var imgWidth = this.width;
				if (imgWidth < 620)
				{
					var imgCont = jQuery(this).parent('.fotoImgCont');
					jQuery(imgCont).width(this.width);
					jQuery(imgCont).parent('.liFotoCont').children('.contGalRight').width(620-15-this.width);
				}
				
			};
			img.src=image;
			jQuery('.gip-img-cont-'+i).prepend(img);
		}
	}
	
	
	var slideItems = jQuery("#slide li");
	if (slideItems.length > 7 )
	{
		var carouselNavigation = jQuery('.carousel-navigation').jcarousel({
				initCallback: mycarousel_initCallback,
				buttonNextHTML: null,
				buttonPrevHTML: null,
				buttonNextCallback:   mycarousel_buttonNextCallback,
				buttonPrevCallback:   mycarousel_buttonPrevCallback,
				center:true
		});
	}
	else
	{
		var itmLength  = parseInt((slideItems.length * 70)/2);
		var xpos = 280 - itmLength;
		
		jQuery('#slide').css('left',xpos+'px');
	}
	galNav = new GalNav;
});
</script>
JS;
return $jsCode;
}

function gip_shortcode(){
	global $post,$wpdb;
	$jsImages = array();
	$gip_code = '';
	$querystr = "
		SELECT p.*
		FROM $wpdb->posts as p  LEFT JOIN $wpdb->postmeta as m
		ON p.ID = m.post_id
		WHERE p.post_type = 'attachment'
		AND p.post_mime_type like 'image%'
		AND m.meta_key = '_exclude-from-gallery' 
		AND m.meta_value <> '1' 
		AND p.post_parent = $post->ID 
		GROUP BY p.ID ORDER BY p.menu_order ASC, p.ID DESC
	";
	//$gip_code .= "<div style='display:none'>".$querystr."</div>";
	$images = $wpdb->get_results($querystr, OBJECT);	
	//$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
	if ( $images ) {
		
		$total_images = count( $images );
		$i = 0;
		
		$navCode = gip_galNav($images);
		

		
		
		$gip_code .= '<input type="hidden" value="'.$total_images.'" id="totalPics">';
		$gip_code .= '<div class="fotoContC">'.$navCode.'<div id="fotoCont">'
					.'<ul>';
		foreach ($images as $image)
		{
			$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
			$image_src = wp_get_attachment_image_src( $image->ID, 'gal-large' );
			$urlCompra = get_post_meta($image->ID, "_gip_url", true);
			$display = ($i)?'style="display:none;"':'';
			$gip_code .= '<li id="fotoCont_'.$i.'" '.$display.' class="liFotoCont">';
			
			if ($image_src)
			{
				$jsImages[] = $image_src[0];
				$gip_code .= '<div class="fotoImgCont gip-img-cont-'.$i.'">'
							//.'<img src="'.$image_src[0].'" class="floatLeft gip-img" id="gip-img-'.$i.'">'
							.'<div class="fotoImgPie">'
							.$image->post_excerpt
							.'</div>'
							.'</div>';
			}
			$gip_code .= '<div class="body fs-13 lh-18 gray contGalRight">'.wpautop($image->post_content);
			
			if (!empty($urlCompra))
			{
				$gip_code .= '<a href="'.$urlCompra.'" class="buyBtn" target="_blank">COMPRAR</a>';
			}
			$gip_code .= '</div></li>';
			$i++;
		}
		$gip_code .= '</ul></div>';
		
		$hideNavBtnClass = ($total_images<8)?'gip-hideNavBtn':'';
		
		$gip_code .= '<div class="galSlider floatLeft carousel-navigation">'
						.'<div id="prevSlide" class="slideBtn floatLeft prevSlide'.$hideNavBtnClass.'">'
						.'</div>'
						.'<div class="slideView floatLeft carousel-navigation">'
							.'<ul id="slide" class="jcarousel-skin-tango">';
								reset ($images);
								$i=0;
								foreach ($images as $image)
								{
									$image_img_tag = wp_get_attachment_image( $image->ID, 'gal-thumb' );
									$gip_code .= '<li onclick="galNav.showGal('.$i.');">'.$image_img_tag
												.'</li>';
									$i++;
								}
				$gip_code .= '</ul>'
					.'</div>'
					.'<div id="nextSlide" class="slideBtn floatLeft nextSlide'.$hideNavBtnClass.'">'
					.'</div>'
				.'</div></div>';
	}
	
	$jsCode = gip_jsCode($jsImages);
	return $gip_code.$jsCode;
}



function gip_shortcode_full(){
	global $post,$wpdb;
	$gip_code = '';
	$querystr = "
		SELECT p.*
		FROM $wpdb->posts as p  LEFT JOIN $wpdb->postmeta as m
		ON p.ID = m.post_id
		WHERE p.post_type = 'attachment'
		AND p.post_mime_type like 'image%'
		AND m.meta_key = '_exclude-from-gallery' 
		AND m.meta_value <> '1' 
		AND p.post_parent = $post->ID 
		GROUP BY p.ID ORDER BY p.menu_order ASC, p.ID DESC
	";
	$gip_code .= "<div style='display:none'>".$querystr."</div>";
	$images = $wpdb->get_results($querystr, OBJECT);	
	//$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
	if ( $images ) {
		$total_images = count( $images );
		$i = 0;
		$navCode = gip_galNav($images);
		$gip_code .= '<input type="hidden" value="'.$total_images.'" id="totalPics">';
		$gip_code .= '<div class="fotoContC">'.$navCode.'<div id="fotoCont" class="fullGal">'
					.'<ul>';
		foreach ($images as $image)
		{
			//$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
			$image_src = wp_get_attachment_image_src( $image->ID, 'full-gal-large' );
			$urlCompra = get_post_meta($image->ID, "_gip_url", true);
			$display = ($i)?'style="display:none;"':'';
			$gip_code .= '<li id="fotoCont_'.$i.'" '.$display.'>';
			if ($image_src)
				$gip_code .= '<img src="'.$image_src[0].'" class="floatLeft">';
			$gip_code .= '<div class="body fs-13 lh-18 gray block gip-full-caption">'.wpautop($image->post_excerpt).'</div>';
			$gip_code .= '<div class="body fs-13 lh-18 gray block gip-full-text">'.wpautop($image->post_content).'</div>';
			
			
			$gip_code .= '</li>';
			$i++;
		}
		$gip_code .= '</ul></div>';
		$hideNavBtnClass = ($total_images<8)?'gip-hideNavBtn':'';
		$gip_code .= '<div class="galSlider floatLeft ">'
						.'<div id="prevSlide" class="slideBtn floatLeft '.$hideNavBtnClass.'">'
						.'</div>'
						.'<div class="slideView floatLeft">'
							.'<ul id="slide" class="jcarousel-skin-tango">';
								reset ($images);
								$i=0;
								foreach ($images as $image)
								{
									$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
									$gip_code .= '<li onclick="galNav.showGal('.$i.');">'.$image_img_tag
												.'</li>';
									$i++;
								}
				$gip_code .= '</ul>'
					.'</div>'
					.'<div id="nextSlide" class="slideBtn floatLeft'.$hideNavBtnClass.'">'
					.'</div>'
				.'</div></div>';
	}
	$jsCode = gip_jsCode();
	return $gip_code.$jsCode;
}

add_shortcode( 'gip_gallery', 'gip_shortcode' );
add_shortcode( 'gip_gallery_full', 'gip_shortcode_full' );
/*
function my_image_attachment_fields_to_edit($form_fields, $post) {  
    // $form_fields is a special array of fields to include in the attachment form  
    // $post is the attachment record in the database  
    //     $post->post_type == 'attachment'  
    // (attachments are treated as posts in WordPress)  
  
    // add our custom field to the $form_fields array  
    // input type="text" name/id="attachments[$attachment->ID][custom1]"  
    $form_fields["custom1"] = array(  
        "label" => __("Custom Text Field"),  
        "input" => "text", // this is default if "input" is omitted  
        "value" => get_post_meta($post->ID, "_custom1", true)  
    );  
	
	$checked = (get_post_meta($post->ID, "_custom2", true)=='1')?'checked':'';
	//$checked = get_post_meta($post->ID, "_custom2", true)=='1';
	
	
	
	$form_fields["custom2"]["label"] = __("Custom Checkbox");  
	$form_fields["custom2"]["input"] = "html";  
	$form_fields["custom2"]["html"] = "the html output goes here, like a checkbox: 
	<input type='checkbox' value='1' 
		name='attachments[{$post->ID}][custom2]' 
		id='attachments[{$post->ID}][custom2]' {$checked}/>";  
    // if you will be adding error messages for your field,  
    // then in order to not overwrite them, as they are pre-attached  
    // to this array, you would need to set the field up like this:  
    $form_fields["custom1"]["label"] = __("Custom Text Field");  
    $form_fields["custom1"]["input"] = "text";  
    $form_fields["custom1"]["value"] = get_post_meta($post->ID, "_custom1", true);
	
	$form_fields["custom2"]["label"] = __("Custom Text Field");  
    $form_fields["custom2"]["input"] = "html";  
    $form_fields["custom2"]["value"] = get_post_meta($post->ID, "_custom2", true);
    return $form_fields;  
}  
// attach our function to the correct hook  
add_filter("attachment_fields_to_edit", "my_image_attachment_fields_to_edit", null, 2); 

function my_image_attachment_fields_to_save($post, $attachment) {  
    // $attachment part of the form $_POST ($_POST[attachments][postID])  
    // $post attachments wp post array - will be saved after returned  
    //     $post['post_type'] == 'attachment'  
    if( isset($attachment['custom1']) ){  
        // update_post_meta(postID, meta_key, meta_value);  
        update_post_meta($post['ID'], '_custom1', $attachment['custom1']);  
    }
	if( isset($attachment['custom2']) ){  
        // update_post_meta(postID, meta_key, meta_value);  
        update_post_meta($post['ID'], '_custom2', $attachment['custom2']);  
    }
	else
		update_post_meta($post['ID'], '_custom2', '');  
    return $post;  
}  
add_filter("attachment_fields_to_save", "my_image_attachment_fields_to_save", null, 2);
*/
?>
