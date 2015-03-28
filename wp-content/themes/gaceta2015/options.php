<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {
	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'gaceta_2015'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('PDF File', 'gaceta_2015'),
		'desc' => __('PDF File'),
		'id' => 'gaceta2015_pdf_file',
		'type' => 'upload');
	$options[] = array(
		'name' => __('PDF Image', 'gaceta_2015'),
		'desc' => __('PDF Image (133x179)'),
		'id' => 'gaceta2015_pdf_image',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Ipad Link', 'gaceta_2015'),
		'desc' => __('Ipad Link', 'gaceta_2015'),
		'id' => 'gaceta2015_ipad_link',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Ipad Link Image', 'gaceta_2015'),
		'desc' => __('Ipad Link Image (133x179)'),
		'id' => 'gaceta2015_ipad_image',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Facebook URL', 'gaceta_2015'),
		'desc' => __('Facebook URL', 'gaceta_2015'),
		'id' => 'gaceta2015_facebook_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Twitter URL', 'gaceta_2015'),
		'desc' => __('Twitter URL', 'gaceta_2015'),
		'id' => 'gaceta2015_twitter_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Instagram URL', 'gaceta_2015'),
		'desc' => __('Instagram URL', 'gaceta_2015'),
		'id' => 'gaceta2015_instagram_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Youtube URL', 'gaceta_2015'),
		'desc' => __('Youtube URL', 'gaceta_2015'),
		'id' => 'gaceta2015_youtube_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Foursquare URL', 'gaceta_2015'),
		'desc' => __('Foursquare URL', 'gaceta_2015'),
		'id' => 'gaceta2015_foursquare_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Pinterest URL', 'gaceta_2015'),
		'desc' => __('Pinterest URL', 'gaceta_2015'),
		'id' => 'gaceta2015_pinterest_url',
		'std' => '',
		'type' => 'text');
	return $options;
}