 (function($){
	var gip_wysiwyg_count = 0;
	$.fn.make_gip_wysiwyg = function()
	{	
		gip_wysiwyg_count++;
		var id = 'gip_wysiwyg_'+gip_wysiwyg_count;
		//alert(id);
		$(this).find('textarea').attr('id',id);
		tinyMCE.execCommand('mceAddControl', false, id);
	};
 })(jQuery);
 
 jQuery(document).ready(function() {
	jQuery("input.gip-check").each(function(i) {
			jQuery(this).click(function (e){
				setCheckboxValue(e.target);
			});
	});
	
	if(typeof(tinyMCE) != "undefined")
	{
		/*
		if(tinyMCE.settings.theme_advanced_buttons1)
		{
			tinyMCE.settings.theme_advanced_buttons1 += ",|,add_image,add_video,add_audio,add_media";
		}
		
		if(tinyMCE.settings.theme_advanced_buttons2)
		{
			tinyMCE.settings.theme_advanced_buttons2 += ",code";
		}
		*/
	}
	jQuery('#gallery-in-post').find('.gip_wysiwyg').each(function(){
			jQuery(this).make_gip_wysiwyg();	
		});
	
});
 function setCheckboxValue(obj)
{
	var theId = jQuery(obj).attr('name');
	var theValue = 0;
	theId = theId.substring(10);
	if (jQuery(obj).attr('checked')){
		theValue = 1;
	}
	jQuery('#gip-hidden-'+theId).val(theValue);
}
function detachImage(id,reload) {
	if ( confirm("Are you sure you want to detach this image?") ) {
		jQuery.get( gip_ajax.callback , {detachImage: id}  , function(data) {
			if (data=='1') {
				jQuery('#ex2').jqmHide();
				jQuery('#gallery-in-post-image-'+id).remove();
			}
		} );
	}
}

function deleteImage(id) {
	if ( confirm("Are you sure you want to delete this image?") ) {
		jQuery.get( gip_ajax.callback , {deleteImage: id} , function(data) {
			if (data=='1') {
				jQuery('#ex2').jqmHide();
				jQuery('#gallery-in-post-image-'+id).remove();
			}
		} );
	}
}

function gip_saveImage(id) {
	if ( confirm("Save changes?") ) {
		tinyMCE.triggerSave();
		var exclude = 0;
		if (jQuery("#gip_exclude_from_gallery").is(':checked'))
			exclude = 1;
		
		var textObj = jQuery('#ex2  textarea')
		var idcaption = jQuery(textObj[0]).attr('id');
		var iddesc = jQuery(textObj[1]).attr('id');
		//tinyMCE.get('gip_wysiwyg_1').getContent()
		var info = {
			updateImage : id,
			image_title : jQuery('#gip_image_title').val(),
			gip_url : jQuery('#gip_url').val(),
			image_excerpt : tinyMCE.get(idcaption).getContent(),
			image_content : tinyMCE.get(iddesc).getContent(),
			exclude : exclude
		};

		jQuery.post( gip_ajax.callback , info , function(data) {
			if (data=='1') {
				jQuery('#ex2').jqmHide();
			}
		} );
	}
}