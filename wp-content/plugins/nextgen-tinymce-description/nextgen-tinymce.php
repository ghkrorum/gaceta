<?php
/*
Plugin Name: NextGen TinyMCE Picture Description
Plugin URI: http://marbu.org/wordpress-plugin-tinymce-in-nextgen/
Description: add TinyCME to NextGEN gallery picture description
Author: Marco Buttarini & Giorgio Martello & Andrea Brugnolo
Version: 1.4
Author URI: http://marbu.org
*/

if( !empty($_SERVER['SCRIPT_FILENAME']) && __FILE__ == $_SERVER['SCRIPT_FILENAME']) { die('direct access not alowed '); }

if( is_admin() && isset($_GET['page']) && $_GET['page'] == 'nggallery-manage-gallery' ){

    add_filter('admin_head','load_tiny_mce_editor');
    add_action('admin_footer', 'load_nextgen_tinymce');
    
    function load_nextgen_tinymce(){
    ?>
        <script type="text/javascript">

			jQuery(document).ready(function(){
                var newnextgen = false;
                var elements=[];
                
                jQuery('textarea').filter(function() {
                    
					if(jQuery(this).attr('name').match(/\[[0-9]{1,}\]+\[description\]/))
					{ 	
						newnextgen = true;
						return jQuery(this).attr('name').match(/\[[0-9]{1,}\]+\[description\]/)
					} 
					else 
					{
						newnextgen = false;
						return jQuery(this).attr('name').match(/description\[[0-9]{1,}\]+/)
					}	
					
                }).each(function(k){
				 
					if(newnextgen = false)
					{
						var elem_id = 'description-'+jQuery(this).parent().parent().attr('id');
					} else {
						var elem_id = 'description-'+jQuery(this).parent().parent().find('.column-2').text();						
					}	
			
					jQuery(this).attr('id', elem_id );
                    elements.push(elem_id);
                });
                
				
				
                tinyMCE.init({
                    mode : "exact",
                    elements: elements.join(','),
                    width:"100%",
                    height:"200",
                    theme:"advanced",
                    skin:"default",
                    language: tinyMCE.settings.language, // get setting from WP tinymce
                    plugins : "fullscreen,inlinepopups,spellchecker", 
                    theme_advanced_buttons1 : "bold,italic,underline,blockquote,separator,strikethrough,link,unlink",
                    theme_advanced_buttons2 : "bullist,numlist,justifyleft,justifycenter,justifyright,undo,redo,fullscreen",
                    theme_advanced_buttons3 : "",      
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : true
                    
                });
                

            });
        </script>
    <?php
    }
    
    /**
     * load tinymce javascript files
     * 
     * thanks to http://stackoverflow.com/users/148174/marty
     * http://stackoverflow.com/questions/2855890/add-tinymce-to-wordpress-plugin
     * 
     */
    function load_tiny_mce_editor() {
        wp_enqueue_script( 'common' );
        wp_enqueue_script( 'jquery-color' );
        wp_print_scripts('editor');
        if (function_exists('add_thickbox')) add_thickbox();
        wp_print_scripts('media-upload');
        if (function_exists('wp_tiny_mce')) wp_tiny_mce();
        wp_admin_css();
        wp_enqueue_script('utils');
        do_action("admin_print_styles-post-php");
        do_action('admin_print_styles');
    }
    
    
    
}
