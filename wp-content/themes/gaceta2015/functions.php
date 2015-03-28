<?php
define("THEME_URL", get_stylesheet_directory_uri());
define("GACETA_TAXONOMY", 'secciones');
define("MARCAS_TAXONOMY", 'marcas');
define("GACETA_MAIN_CATEGORIES", serialize (array ( 2, 7, 6, 3, 8, 35, 4)));

define("GACETA_ZONA_1", 'zona1');
define("GACETA_ZONA_2", 'zona2');
define("GACETA_ZONA_3", 'zona3');
define("GACETA_ZONA_4", 'zona4');

define("MORE_TEXT", 'Más ');

if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}



//Setting up theme

function gaceta2015_theme_setup() {

	add_theme_support( 'post-formats', array( 'gallery', 'image' ) );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'thumb-slider', 640, 450, false );
	add_image_size( 'thumb-640x500', 640, 500, true );
	add_image_size( 'thumb-308x308', 308, 308, true );
	add_image_size( 'thumb-310x310', 310, 310, true );
	add_image_size( 'thumb-200x116', 200, 116, true );
	add_image_size( 'thumb-274x201', 274, 201, true );
	add_image_size( 'thumb-280x280', 280, 280, true );
	add_image_size( 'thumb-225x225', 225, 225, true );
	add_image_size( 'thumb-309x180', 309, 180, true );
	add_image_size( 'thumb-90x90', 90, 90, true );
	add_image_size( 'thumb-640x450', 640, 450, true );
	add_image_size( 'thumb-70x60', 70, 60, true );
	add_image_size( 'thumb-255x288', 255, 288, true );
}
add_action( 'after_setup_theme', 'gaceta2015_theme_setup' );

function gaceta2015_custom_image_sizes_choose( $sizes ) {
	
	$new_sizes = array();
	
	$added_sizes = get_intermediate_image_sizes();
	
	// $added_sizes is an indexed array, therefore need to convert it
	// to associative array, using $value for $key and $value
	foreach( $added_sizes as $key => $value) {
		$new_sizes[$value] = $value;
	}
	
	// This preserves the labels in $sizes, and merges the two arrays
	$new_sizes = array_merge( $new_sizes, $sizes );

	return array_merge( $sizes, array(
        'thumb-640x500' => __('Slider Thumbnail'),
    ) );
	
	return $new_sizes;
}
add_filter('image_size_names_choose', 'gaceta2015_custom_image_sizes_choose');


add_action( 'init', 'gaceta2015_register_post_type' );
function gaceta2015_register_post_type() {
	register_post_type( 'gaceta_gallery',
		array(
			'labels' => array(
				'name' => __( 'Galleries' ),
				'singular_name' =>  __( 'Gallery' ),
				'add_new' =>  __( 'Add New' ),
				'add_new_item' =>  __( 'Add New Gallery' ),
				'edit' =>  __( 'Edit' ),
				'edit_item' =>  __( 'Edit Gallery' ),
				'new_item' =>  __( 'New Gallery' ),
				'view' =>  __( 'View Gallery' ),
				'view_item' =>  __( 'View Gallery' ),
				'search_items' =>  __( 'Search Gallery' ),
				'not_found' =>  __( 'No gallery found' ),
				'not_found_in_trash' =>  __( 'No gallery found in Trash' ),
				'parent' =>  __( 'Parent Gallery' ),
			),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'show_in_nav_menus' => false,
			'exclude_from_search' => false,
			'hierarchical' => false,
            'rewrite' => array('slug'=>'gallery'),
			'supports' => array('title', 'editor', 'thumbnail'),
		)
	);
flush_rewrite_rules();
}

add_action('init', 'gaceta2015_start_session', 1);
function gaceta2015_start_session() {
    if(!session_id()) {
        session_start();
    }
}


function gaceta2015_register_menu() {
  register_nav_menu( 'gaceta_header_menu', 'Header Menu' );
}
add_action( 'after_setup_theme', 'gaceta2015_register_menu' );


function gaceta2015_mce_before_init($options){
	return $options;
}
add_filter( 'tiny_mce_before_init', 'gaceta2015_mce_before_init' );


/**
 * Enqueue scripts and styles
 */
function gaceta2015_scripts() {

	
	// if (is_single()){
		wp_enqueue_script( 'ios6fix', get_template_directory_uri() . '/js/ios6fix.js', array(), '2.1.6', false );

		wp_enqueue_script( 'jquery.cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array(), '2.1.6', false );

		wp_enqueue_script( 'jquery.cycle2.carousel', get_template_directory_uri() . '/js/jquery.cycle2.carousel.js', array(), '20141007', false );

		wp_enqueue_script( 'jquery.cycle2.center', get_template_directory_uri() . '/js/jquery.cycle2.center.min.js', array(), '20141007', false );
		
		wp_enqueue_script( 'jquery.cycle2.swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js', array(), '2.1.6', false );
	// }
	wp_enqueue_script( 'gaceta-ajax', get_template_directory_uri() . '/js/ajax.js', array(), '1.0.0', false );
	wp_localize_script( 'gaceta-ajax', 'GacetaAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		// 'security' => wp_create_nonce( 'gaceta-valid-string' )
	));
	// wp_enqueue_script( 'gaceta-ajax' );
}
add_action( 'wp_enqueue_scripts', 'gaceta2015_scripts' );


// The function that handles the AJAX request
function gaceta2015_ajax_load_more_posts() {
	// check_ajax_referer( 'gaceta-valid-string', 'security' );
	$showCategoryName = true;
	$offset = (isset($_GET['offset']))?$_GET['offset']:0;
	$category = (isset($_GET['category']))?$_GET['category']:'';
	$taxonomy = (isset($_GET['taxonomy']))?$_GET['taxonomy']:'';
	$s = (isset($_GET['s']))?$_GET['s']:'';
	if (!empty($category)){
		if (!empty($taxonomy)){
			$posts = gaceta2015_get_posts_by_taxonomy($category, $taxonomy, 4, $offset);
		}
		else{
			$posts = gaceta2015_get_cat_posts($category, 4, $offset);
			// $posts = gaceta2015_get_cat_posts_exclude_custom_taxonomy($category, 4, $offset);
		}
	}else{
		if (!empty($s)){
			$showCategoryName = false;
			$posts = gaceta2015_get_posts_by_search_term($s, $numberposts = 4, $offset);
		}else{
			$posts = gaceta2015_get_posts_exclude_custom_taxonomy(4,  $offset);
			// $posts = gaceta2015_get_cat_posts(4, $offset);
			// $posts = gaceta2015_get_cat_posts_exclude_custom_taxonomy(4, $offset);
		}
	}
	$totaPosts = count($posts);
	
	$offset = $offset + $totaPosts;
	$_SESSION['post-offset'] = $offset;
	ob_start();
    include '_more-posts.php';
    $html =  ob_get_clean();
    echo json_encode(array(
    	'content' => $html,
    	'offset' => $offset,
    ));
    // echo $html;
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_load_more_posts', 'gaceta2015_ajax_load_more_posts' );
add_action( 'wp_ajax_nopriv_load_more_posts', 'gaceta2015_ajax_load_more_posts' );


// The function that handles the AJAX request
function gaceta2015_ajax_load_more_category_posts() {
	// check_ajax_referer( 'gaceta-valid-string', 'security' );
	$offset = (isset($_GET['offset']))?$_GET['offset']:0;
	$category = (isset($_GET['category']))?$_GET['category']:'';
	$posts = gaceta2015_get_cat_posts($category, 4, $offset);
	// $posts = gaceta2015_get_cat_posts_exclude_custom_taxonomy($category, 4, $offset);
	$totaPosts = count($posts);
	
	$offset = $offset + $totaPosts;
	
	$_SESSION['post-offset'] = $offset;

	ob_start();
    include '_more-posts.php';
    $html =  ob_get_clean();
    echo json_encode(array(
    	'content' => $html,
    	'offset' => $offset,
    ));
    // echo $html;
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_load_more_category_posts', 'gaceta2015_ajax_load_more_category_posts' );
add_action( 'wp_ajax_nopriv_load_more_category_posts', 'gaceta2015_ajax_load_more_category_posts' );



// The function that handles the AJAX request
function gaceta2015_ajax_load_more_videos(){
	// check_ajax_referer( 'gaceta-valid-string', 'security' );
	$offset = (isset($_GET['offset']))?$_GET['offset']:0;
	$category = (isset($_GET['category']))?$_GET['category']:'';

	if ( !empty($category) ){
		$posts = gaceta2015_get_posts_by_category_and_custom_term( $category, 31, 6, $offset );
	}else{
		$posts = gaceta2015_get_posts_by_category(31, 6, $offset);
	}

	$totaPosts = count($posts);
	
	$offset = $offset + $totaPosts;
	
	ob_start();
    include '_more-videos.php';
    $html =  ob_get_clean();
    echo json_encode(array(
    	'content' => $html,
    	'offset' => $offset,
    ));
    // echo $html;
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_load_more_videos', 'gaceta2015_ajax_load_more_videos' );
add_action( 'wp_ajax_nopriv_load_more_videos', 'gaceta2015_ajax_load_more_videos' );


function gaceta2015_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Instagram', 'instagram-sidebar' ),
        'id' => 'instagram-sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'instagram-sidebar' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );

    register_sidebar( array(
        'name' => __( 'Banner 970x90', 'banner-970x90' ),
        'id' => 'banner-970x90',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'banner-970x90' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );

    register_sidebar( array(
        'name' => __( 'Banner 300x600', 'banner-300x600' ),
        'id' => 'banner-300x600',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'banner-300x600' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );

    register_sidebar( array(
        'name' => __( 'Banner 300x250', 'banner-300x250' ),
        'id' => 'banner-300x250',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'banner-300x250' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'gaceta2015_widgets_init' );

function gaceta2015_acf_image_thumbnail($imageObject, $size = '', $class=''){

	$thumbnail = gaceta2015_get_acf_image_thumbnail($imageObject, $size, $class);

	if (!empty($thumbnail)){
		print($thumbnail);
	}
}

function gaceta2015_get_acf_image_thumbnail($imageObject, $size = '', $class=''){
	if ($imageObject){
		if (!empty($size)){
			// vars
			$url = $imageObject['url'];
			$alt = $imageObject['alt'];

			// thumbnail
			$thumb = $imageObject['sizes'][ $size ];
			$width = $imageObject['sizes'][ $size . '-width' ];
			$height = $imageObject['sizes'][ $size . '-height' ];

			$class = (!empty($class))?"class='".$class."'":'';

			$imageTag = '<img src="'.$thumb.'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'" '.$class.' />';

			return $imageTag;
		}
	}
	return '';
}

function gaceta2015_get_posts_by_search_term($s, $numberposts = 1, $offset = 0){
	$query_args = array( 
		's' => $s,
		'posts_per_page' => $numberposts,
		'offset' => $offset
	);
	$query = new WP_Query( $query_args );
	return $query->posts;
}

function gaceta2015_get_last_post_by_category($termId, $taxonomy = GACETA_TAXONOMY){
	if ($termId){
		$args = array( 
			'numberposts' => 1, 
			'offset'=> 0,
			'tax_query' => array(
		        array(
			        'taxonomy' => $taxonomy,
			        'field' => 'term_id',
			        'terms' => $termId
		        )
		    )
		);
		$myposts = get_posts( $args );

		if ($myposts){
			$post = $myposts[0];
			return $post;
		}
	}
	return null;
}

function gaceta2015_get_last_post_by_term_slug($slug, $taxonomy = GACETA_TAXONOMY){
	$idObj = get_term_by( 'slug', $slug, $taxonomy);
	if ($idObj){
		$termId = $idObj->term_id;
		return gaceta2015_get_last_post_by_category($termId, $taxonomy);
	}
	return NULL;
}

function gaceta2015_get_posts_by_category($termId, $numberposts = 1, $offset = 0){

	if ($termId){
		$args = array( 
			'numberposts' => $numberposts, 
			'offset'=> $offset,
			'tax_query' => array(
		        array(
			        'taxonomy' => GACETA_TAXONOMY,
			        'field' => 'term_id',
			        'terms' => $termId
		        )
		    )
		);
		return get_posts( $args );
	}
	return null;
}

function gaceta2015_get_posts_by_taxonomy($termId, $taxonomy = 'category', $numberposts = 1, $offset = 0){

	if ($termId){
		$args = array( 
			'numberposts' => $numberposts, 
			'offset'=> $offset,
			'tax_query' => array(
		        array(
			        'taxonomy' => $taxonomy,
			        'field' => 'term_id',
			        'terms' => $termId
		        )
		    )
		);
		return get_posts( $args );
	}
	return null;
}

function gaceta2015_get_posts_exclude_custom_taxonomy($numberposts = 1, $offset = 0){
	// $terms = get_terms( GACETA_TAXONOMY );
	$termArray = array();
	foreach ( $terms as $term ){
		$termArray[] = $term->term_id;
	}
	$args = array( 
		'numberposts' => $numberposts, 
		'offset'=> $offset,
		'tax_query' => array(
	        array(
		        'taxonomy' => GACETA_TAXONOMY,
		        'field' => 'term_id',
		        'terms' => array(33,32,31,29),
		        'operator'  => 'NOT IN'
	        )
	    )
	);

	return get_posts( $args );
}

function gaceta2015_get_last_post_by_category_and_custom_term($categoryId, $termId){

	if ( !empty($categoryId) && !empty($termId) ){

		$args = array(
			'post_type' => 'post',
			'numberposts' => 1, 
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categoryId,
				),
				array(
					'taxonomy' => GACETA_TAXONOMY,
					'field'    => 'term_id',
					'terms' => $termId
				),
			),
		);
		
		$myposts = get_posts( $args );

		if ($myposts){
			$post = $myposts[0];
			return $post;
		}
	}
	return null;
}

function gaceta2015_get_posts_by_category_and_custom_term($categoryId, $termId, $numberposts = 1, $offset = 0){

	if ( !empty($categoryId) && !empty($termId) ){

		$args = array(
			'post_type' => 'post',
			'offset'=> $offset,
			'numberposts' => $numberposts,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categoryId,
				),
				array(
					'taxonomy' => GACETA_TAXONOMY,
					'field'    => 'term_id',
					'terms' => $termId
				),
			),
		);
		
		return get_posts( $args );

		// if ($myposts){
		// 	$post = $myposts[0];
		// 	return $post;
		// }
	}
	return null;
}


function gaceta2015_get_cat_posts($categoryId, $numberposts = 1, $offset = 0){
	// $terms = get_terms( GACETA_TAXONOMY );
	$termArray = array();
	foreach ( $terms as $term ){
		$termArray[] = $term->term_id;
	}
	$args = array(
		'numberposts' => $numberposts,
		'offset'=> $offset,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $categoryId,
			),
			array(
		        'taxonomy' => GACETA_TAXONOMY,
		        'field' => 'term_id',
		        'terms' => array(33,32,31,29),
		        'operator'  => 'NOT IN'
	        )
	    )
	);

	return get_posts( $args );
}


function gaceta2015_get_cat_posts_exclude_custom_taxonomy($categoryId, $numberposts = 1, $offset = 0){
	$terms = get_terms( GACETA_TAXONOMY );
	$termArray = array();
	foreach ( $terms as $term ){
		$termArray[] = $term->term_id;
	}
	$args = array(
		'numberposts' => $numberposts,
		'offset'=> $offset,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $categoryId,
			),
	        array(
		        'taxonomy' => GACETA_TAXONOMY,
		        'field' => 'term_id',
		        'terms' => $termArray,
		        'operator'  => 'NOT IN'
	        )
	    )
	);

	return get_posts( $args );
}

function gaceta2015_get_zone_posts( $numberposts = 1, $zoneId = NULL, $terms = array()){
	$args = array(
		'numberposts' => $numberposts,
	);

	$metaQuery = array();

	if ( is_string($zoneId) ){
		$metaQuery = array(
			array(
				'key' => 'zona',
				'value' => $zoneId,
				'compare' => 'LIKE'
			)
		);

	}elseif ( is_array($zoneId) && !empty($zoneId) ){
		
		$metaQuery['relation'] = 'OR';
		foreach ($zoneId as $zone){
			$metaQuery[] = array(
				'key' => 'zona',
				'value' => $zone,
				'compare' => 'LIKE'
			);
		}
		
	}

	$taxQuery = array();

	if (!empty($terms)){
		$taxQuery['relation'] = 'AND';
		foreach ($terms as $term){
			$taxQuery[] = array(
				'taxonomy' => $term['taxonomy'],
				'field'    => 'term_id',
				'terms'    => $term['term_id'],
			);
		}
	}

	$args['meta_query'] = $metaQuery;
	$args['tax_query'] = $taxQuery;

	return get_posts( $args );
	// $results = new WP_Query( $args );
	// echo $results->request;
}

// get results
$the_query = new WP_Query( $args );


function gaceta2015_get_slide_posts($numberposts = 1, $categoryId = null){
	
	$args = array(
		'numberposts' => $numberposts,
		'offset'=> 0,
		'meta_query' => array(
			'relation' => 'AND',
			array(
	            'key' => 'destacado',
	            'value' => '1',
	            'compare' => '='
          	),
        ),
	);
	if (!empty($categoryId)){
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $categoryId,
			),
	    );
	}
	return get_posts( $args );
}

function gaceta2015_get_custom_taxonomy_posts($categoryId, $numberposts = 1){

	if ( !empty($categoryId) ){

		$args = array(
			'post_type' => 'post',
			'numberposts' => $numberposts,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categoryId,
				),
			),
		);
		
		return get_posts( $args );
		
	}
	return null;
}

function gaceta2015_get_custom_taxonomy_posts_by_custom_term($categoryId, $customTermSlug, $numberposts = 1){

	if ( !empty($categoryId) ){

		$args = array(
			'post_type' => 'post',
			'numberposts' => $numberposts,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categoryId,
				),
				array(
			        'taxonomy' => GACETA_TAXONOMY,
			        'field' => 'slug',
			        'terms' => $customTermSlug,
		        )
			),
		);
		
		return get_posts( $args );
		
	}
	return null;
}

function gaceta2015_get_posts_by_term_slug( $terms= array(), $numberposts = 1, $offset = 0 ){

	$args = array(
		'numberposts' => $numberposts,
		'offset' => $offset,
	);

	$taxQuery = array();

	if (!empty($terms)){
		$taxQuery['relation'] = 'OR';
		foreach ($terms as $term){
			$taxQuery[] = array(
				'taxonomy' => $term['taxonomy'],
				'field'    => 'slug',
				'terms'    => $term['slug'],
			);
		}
	}

	$args['tax_query'] = $taxQuery;

	return get_posts( $args );
}

function gaceta2015_get_custom_field_image($field, $size = '', $class = ''){
	global $post;
	if ( has_post_thumbnail() ) {
		return get_the_post_thumbnail($post->ID, $size, array('class' => $class) );
	} 


	$imageObject = get_field($field);
    $image = '';
    if ($imageObject){
      $image = gaceta2015_get_acf_image_thumbnail($imageObject, $size, $class);
    }
    return $image;
}


function gaceta2015_get_custom_video_term( $postId ){
	$seccionesArray = get_the_terms( $postId, GACETA_TAXONOMY );
	if ( !empty($seccionesArray) ){

		if (count($seccionesArray) > 1){
			foreach ($seccionesArray as $seccion){
				if ($seccion->slug != 'videos'){
					return $seccion;
				}
			}
		}else{
			return $seccionesArray[0];
		}
	}
	return '';
}

function gaceta2015_get_terms_array($postId, $taxonomies = array()){
	if (empty($taxonomies)){
		$taxonomies[] = MARCAS_TAXONOMY;
	}
	$termsArray = array();
	foreach ($taxonomies as $taxomony){
		$terms = get_the_terms( $postId, $taxomony );

		if (!empty($terms)){
			foreach ($terms as $term){
			  $termsArray[$term->term_id] = $term->name;
			}
		}
	}

	
	return $termsArray;
}

function gaceta2015_post_get_related_posts($taxTerms, $numberposts = 1, $exceptPostId = NULL){
	if (!empty($taxTerms)){
		
		$args = array( 
			'numberposts' => $numberposts, 
			'offset'=> 0,
		);

		$taxQuery = array();

		if (!empty($taxTerms)){
			$taxQuery['relation'] = 'OR';
			foreach ($taxTerms as $taxonomy => $terms){
				$taxQuery[] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $terms,
				);
			}
		}

		$args['tax_query'] = $taxQuery;

		if (!empty($exceptPostId)){
			if (!is_array($exceptPostId)){
				$exceptPostId = array($exceptPostId);
			}
			$args['post__not_in'] = $exceptPostId;
		}

		return get_posts( $args );
	}
	return NULL;
}

function gaceta2015_get_child_categories($categoryId, $taxonomy = GACETA_TAXONOMY){
	$args = array(
		'child_of'                 => $categoryId,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 0,
		'taxonomy'                 => $taxonomy,
		'pad_counts'               => false 
	); 
	return get_categories( $args );
}

function gaceta2015_get_menu_item($categoryId){
	$menuString = '';
	$category = get_category( $categoryId );
	if ($category){
		$menuString = '<li>';
		$menuString .= '<a href="' . get_category_link( $category->term_id ) .'" class="header-menu-cat-link">' . $category->name . '</a>';
		$categories = gaceta2015_get_child_categories($category->term_id, 'category');
	  	if ($categories){
	  		$menuString .= '<div class="header-submenu gotham-book">';
	    	$menuString .= '<div class="icon-menu"></div>';
			$menuString .= '<div class="content-menu">';
			$count = 0;
			foreach ($categories as $category){
		        if ($count != 0)
		        	$menuString .= '<div class="separador"></div>';
		    	$menuString .= '<a href="' . get_category_link( $category->term_id ) . '" class="item">' . $category->name . '</a>';
		    	$count++;
			}
			$menuString .= '</div>';
	  		$menuString .= '</div>';
		}
		$menuString .= '</li>';
	}
	return $menuString;
}

function gaceta2015_get_menu_item_mobil($categoryId){
	$menuString = '';
	$category = get_category( $categoryId );
	if ($category){
		$menuString = '<li>';
		$menuString .= '<a href="' . get_category_link( $category->term_id ) .'" class="header-menu-cat-link">' . $category->name . '</a>';
		$categories = gaceta2015_get_child_categories($category->term_id, 'category');
	  	if ($categories){
	  		$menuString .= '<ul class="submenu gotham-book">';
			$count = 0;
			foreach ($categories as $category){
		        //if ($count != 0)
		    	$menuString .= '<li><a href="' . get_category_link( $category->term_id ) . '" class="item">' . $category->name . '</a></li>';
		    	//$count++;
			}
			$menuString .= '</ul>';
		}
		$menuString .= '</li>';
	}
	return $menuString;
}

function gaceta2015_get_seccion_term($postId, $taxonomy = GACETA_TAXONOMY){
	$seccionesArray = get_the_terms( $postId,  $taxonomy);
	if ($seccionesArray){
	    foreach ($seccionesArray as $seccion){
	      return $seccion;
	    }
	}
    return NULL;
}

function gaceta2015_get_popular_posts($categories, $limit = 5){
// select p.* from wp_popularpostsdata d
// 	left join wp_posts p on d.postid = p.ID
// 	left join wp_term_relationships r on r.object_id = p.ID
// where
// 	p.post_status = 'publish'
// 	and r.term_taxonomy_id in (3,8,35)
// 	and p.post_modified > '2014-01-01'
// 	and p.ID not in (
// 		select ID 
// 			from wp_posts wp
// 				left join wp_term_relationships wr on wp.ID = wr.object_id
// 			where
// 				wr.term_taxonomy_id = 31
// 	)
// group by p.ID
// order by d.pageviews DESC 
// limit 20;
	global $wpdb;
	$dbPrefix = $wpdb->prefix;

	$queryArray = array();

	$queryArray[] = "
		select distinct(d.postid), p.* from wp_popularpostsdata d
		left join wp_posts p on d.postid = p.ID
		left join wp_term_relationships r on r.object_id = p.ID
		where 
		p.post_status = 'publish'
		and p.post_modified > '2014-01-01'

		";

	$queryArray[] = "
		and p.ID not in (
			select ID 
				from wp_posts wp
					left join wp_term_relationships wr on wp.ID = wr.object_id
				where
					wr.term_taxonomy_id = 31
		)
	";

	if (!empty($categories)){
		$categoryStr = implode(',', $categories);
		$queryArray[] = "and r.term_taxonomy_id in ($categoryStr)";
	}

	$queryArray[] = "order by d.pageviews DESC";

	$queryArray[] = "limit ".$limit;

	$querystr = implode(' ', $queryArray);
	
	return $wpdb->get_results($querystr, OBJECT);
}

function gaceta2015_get_popular_posts_block($categoryId, $limit = 5){
	global $post;
	$localPost = $post;
	$categoryArray = array();
	if ($categoryId){
		$categoryArray[] = $categoryId;

		$childCategories = gaceta2015_get_child_categories($categoryId, 'category');

		if (!empty($childCategories)){
			foreach ($childCategories as $childCategory){
				$categoryArray[] = $childCategory->term_id;
			}
		}
	}

	$popularPosts = gaceta2015_get_popular_posts($categoryArray, $limit);
	ob_start();
    include '_popular-posts.php';
    $post = $localPost;
    return ob_get_clean();
}

function gaceta2015_get_related_posts($termIds, $limit = 5){
	global $wpdb;
	global $post;
	$dbPrefix = $wpdb->prefix;

	$queryArray = array();

	$queryArray[] = "
		select p.* 
		from wp_posts p
		left join wp_term_relationships r on r.object_id = p.ID
		where p.post_status = 'publish'
		";

	if (!empty($post)){
		$queryArray[] = 'and p.ID <> '.$post->ID;
	}
	if (!empty($termIds)){
		$termStr = implode(',', $termIds);
		$queryArray[] = "and r.term_taxonomy_id in ($termStr)";
	}

	$queryArray[] = "limit ".$limit;

	$querystr = implode(' ', $queryArray);
	
	return $wpdb->get_results($querystr, OBJECT);
}

function gaceta2015_get_related_posts_block($termIdArray, $limit = 5){
	if (!empty($termIdArray)){
		global $post;
		$localPost = $post;
		$term = get_term( $termIdArray[0], 'marcas');
		$relatedPosts = gaceta2015_get_related_posts($termIdArray, $limit);
		ob_start();
	    include '_related-posts.php';
	    $post = $localPost;
	    return ob_get_clean();
	}
	return '';
}

function gaceta2015_get_video_link($link, $termSlug, $taxonomy = 'category'){
	// $modaTerm = get_term_by( 'slug', $termSlug, $taxonomy);
	// if ($modaTerm){
  	// return add_query_arg( array('category' => $modaTerm->term_id)  ,$link );
  	// }
  	// return $link;
  	return add_query_arg( array('category' => $termSlug)  ,$link );
}

function gaceta2015_get_post_term($postId){

	$term = NULL
	;
	$term = gaceta2015_get_post_term_by_taxonomy($postId, GACETA_TAXONOMY);

	if ( empty($term) ){
		$term = gaceta2015_get_post_term_by_taxonomy($postId, 'category');
	}

	return $term;
}

function gaceta2015_get_post_term_by_taxonomy($postId, $taxonomy = GACETA_TAXONOMY){
	$obj = new stdClass;

	$terms = get_the_terms($postId, $taxonomy);

	if ( !empty($terms) ){
		foreach ($terms as $term){
		// $term = current ( $terms );

			$parentTerm = gaceta2015_get_category_top_parent($term, $taxonomy);
			if ($parentTerm){
				$term = $parentTerm;
				break;
			}
		}
		$obj->name = $term->name;
		$obj->term_id = $term->term_id;
		$obj->link = get_term_link( $term->term_id, $taxonomy );
		return $obj;
	}
	return null;
}

/**
* Returns ID of top-level parent category, or current category if you are viewing a top-level
*
* @param    string      $catid      Category ID to be checked
* @return   string      $catParent  ID of top-level parent category
*/
function gaceta2015_get_category_top_parent( $term, $taxonomy = GACETA_TAXONOMY ) {
	$parentTerm = NULL;
	if (isset($term)){
		$termId = $term->term_id;
		while ( $termId ) {
	    	if ( !isset($parentTerm) ){
	    		$parentTerm = $term;
	    	}else{
	    		$parentTerm = get_term( $termId, $taxonomy);
	    	}
	        $termId = $parentTerm->parent;
	    }
	}
	
    return $parentTerm;
}

function gaceta2015_get_video_url($url){
	if (!empty($url) && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)){
		$youtubeId = "";
		if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
			$youtubeId = $id[1];
		} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
			$youtubeId = $id[1];
		} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
			$youtubeId = $id[1];
		} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
			$youtubeId = $id[1];
		} else {
			// not an youtube video
		}
		if (!empty($youtubeId)){
			$url = 'http://www.youtube-nocookie.com/embed/'.$youtubeId;
		}
	}
	return $url;
}




/**
 * Create HTML list of nav menu items.
 *
 * @since 3.0.0
 * @uses Walker
 */
class gaceta2015_walker_nav_menu extends Walker_Nav_Menu{
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        //$output .= "\n$indent<ul class=\"sub-menu\">\n"; //this is default output;

        //if( $depth==0 ) //'0'==>1st-sub-level; '1'=2nd-sub-level; ....
        $output .= "\n$indent<div class=\"header-submenu gotham-book\"><div class=\"icon-menu\"></div><div class=\"content-menu\">\n";
    }

    /**
     * @see Walker::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        //$output .= "$indent</ul>\n"; //this is default output;

        //if( $depth==0 ) //'0'==>1st-sub-level; '1'=2nd-sub-level; ....
        $output .= "$indent</div></div>\n";
    }

    // add main/sub classes to li's and links
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
		    ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
		    ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
		    ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
		    'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		if ($depth == 0){
			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
		}else{
			$output .= $indent . '<div class="separador"></div><div id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
		}

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link item ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
		    $args->before,
		    $attributes,
		    $args->link_before,
		    apply_filters( 'the_title', $item->title, $item->ID ),
		    $args->link_after,
		    $args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ($depth == 0){
			$output .= "</li>\n";
		}else{
			$output .= "</div>\n";
		}
	}
}

/**
 * Create HTML list of nav menu items mobil.
 *
 * @since 3.0.0
 * @uses Walker
 */
class gaceta2015_walker_nav_menu_mobil extends Walker_Nav_Menu{
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        //$output .= "\n$indent<ul class=\"sub-menu\">\n"; //this is default output;

        //if( $depth==0 ) //'0'==>1st-sub-level; '1'=2nd-sub-level; ....
        $output .= "\n$indent<ul class=\"submenu gotham-book\">\n";
    }

    /**
     * @see Walker::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        //$output .= "$indent</ul>\n"; //this is default output;

        //if( $depth==0 ) //'0'==>1st-sub-level; '1'=2nd-sub-level; ....
        $output .= "$indent</ul>\n";
    }

    // add main/sub classes to li's and links
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
		    ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
		    ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
		    ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
		    'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		if ($depth == 0){
			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
		}else{
			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
		}

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link item ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
		    $args->before,
		    $attributes,
		    $args->link_before,
		    apply_filters( 'the_title', $item->title, $item->ID ),
		    $args->link_after,
		    $args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ($depth == 0){
			$output .= "</li>\n";
		}else{
			$output .= "</li>\n";
		}
	}
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

if ( ! function_exists( 'the_excerpt_max_charlength' ) ) :
	function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;
	if(strlen($excerpt)>$charlength) {
	   $subex = substr($excerpt,0,$charlength-5);
	   $exwords = explode(" ",$subex);
	   $excut = -(strlen($exwords[count($exwords)-1]));
	   if($excut<0) {
			echo substr($subex,0,$excut);
	   } else {
			echo $subex;
	   }
	   
	} else {
		if (substr($excerpt,strlen($excerpt)-1,1)==".")
			echo substr($excerpt,0,strlen($excerpt)-1);
		else
			echo $excerpt;
	}
	}
endif;

/* Custom shortcodes currently managed by shortcode ultimate plugin  */
// function gaceta2015_shortcode_highlight( $atts, $content = "" ) {
// 	return "<span class='numbers sentinel-book'>$content</span>";
// }
// add_shortcode( 'hl', 'gaceta2015_shortcode_highlight' );



//Debug custom function
if ( ! function_exists( '__pr' ) ) {
function __pr($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
}
?>