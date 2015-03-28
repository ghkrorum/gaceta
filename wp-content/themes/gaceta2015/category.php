<?php get_header();?>
<?php
$categoryId = get_query_var('cat');

$mainCategories = unserialize(GACETA_MAIN_CATEGORIES);

if ( in_array( $categoryId , $mainCategories ) ){
  include('_main-category.php');
}else{
  include('_sub-category.php');
}
?>
<?php get_footer(); ?>