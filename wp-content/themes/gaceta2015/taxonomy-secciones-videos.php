<?php get_header();?>
<?php
$seccion = get_query_var(GACETA_TAXONOMY);
$category = (isset($_GET['category']))?$_GET['category']:'';
$idObj = get_term_by( 'slug', $seccion, GACETA_TAXONOMY);
$categoryId = '';
if (!empty($idObj)){
  $seccionId = $idObj->term_id;
  $videosLink = get_term_link( $seccionId, GACETA_TAXONOMY );  
  if ( !empty($category) ){
    $categoryObj = get_term_by( 'slug', $category, 'category');
    $categoryId = $categoryObj->term_id;
    $posts = gaceta2015_get_posts_by_category_and_custom_term( $categoryId, $seccionId, 6, 0 );
  }else{
    $posts = gaceta2015_get_posts_by_category($idObj->term_id, 6);
  }
?>
    <div class="container-fluid content-video">
      <div class="container">
        <?php
        if (!empty($posts)){
          $post = $posts[0];
          setup_postdata($post);
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
          $term = gaceta2015_get_custom_video_term($post->ID);
        ?>
        <div class="row main-video">
          <div class="col-lg-12">
            <div class="content-image-video">
              <iframe width="971" height="580" src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen></iframe>  
            </div>
          </div>
        </div>
        <div class="row section section-video">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="content-txt">
              <h1 class="title gotham-bold"><?php echo $term->name;?></h1>
              <div class="sub-title gotham-bold"><?php the_title(); ?></div>
              <div class="redes-sociales gotham-book">
               <?php // echo do_shortcode( '[shareaholic app="share_buttons" id="15706066"]' );?>
              </div>
            </div>
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
          </div> 
        </div>
        <?php
        }
        ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="line-section"></div>
          </div>
        </div>
        <div class="row menu-2">
          <div class="col-lg-3 col-md-3 col-sm-2">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
            <div class="content-nav">
              <ul class="header-menu gotham-bold" id="videos-menu">
                <?php
                $menuItems = array(
                  '',
                  'moda',
                  'belleza',
                  'estilo-de-vida',
                  'mundo-palacio',
                );

                foreach ($menuItems as $menuItem){
                  $termId = '';
                  if ($menuItem > ''){
                    $itemClass = ($menuItem == $category)?'active':'';
                    $menuLink = gaceta2015_get_video_link( $videosLink, $menuItem );
                    $idObj = get_term_by( 'slug', $menuItem, 'category');
                    if ($idObj){
                      $menuTitle = $idObj->name;
                      $termId = $idObj->term_id;
                    }
                  }else{
                    $itemClass = (empty($category))?'active':'';
                    $menuLink = $videosLink;
                    $menuTitle = 'Todos';

                  }
                ?>
                <li>
                  <a href="<?php echo $menuLink;?>" class="<?php echo $itemClass;?>" data-category="<?php echo $termId;?>"><?php echo $menuTitle;?></a>
                </li>
                <?php
                }
                ?>
              </ul>
            </div> 
          </div>
          <div class="col-lg-3 col-md-3 col-sm-2">
          </div>
        </div>

        <div id="videos-list-cont">
        <?php
        $totalPosts = count($posts);
        $rowCount = 0;
        for ( $i = 0 ; $i < $totalPosts ; $i++ ){
          $post = $posts[$i];
          setup_postdata($post);
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
          $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-309x180', 'img-responsive');
          if ( $i % 3 == 0 ){
            $rowClass = ($rowCount>0)?'video-items-loaded':'';
            echo '<div class="row section-6 video-post '.$rowClass.'">'; // Open Row
          }
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <a href="<?php echo $videoUrl; ?>"><?php echo $img;?></a>
              <iframe src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen></iframe>
              <a href="<?php echo $videoUrl; ?>"><h2 class="category-posts-item-tit gotham-book"><?php the_title(); ?></h2></a>
            </div>
          </div>
        <?php
          if ( ($i + 1) % 3 == 0 || $i == ( $totalPosts - 1 ) ){
            $rowCount++;
            echo '</div>'; // Close Row
          }
        }
        ?>
        </div>
        <div class="row section-7">
          <div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">
            <a href="" class="more-btn gotham-bold" id="load-more-videos" data-offset="<?php echo $totalPosts;?>" data-category="<?php echo $categoryId;?>">
              <span class="more-btn-wrap">
               Cargar Más
              </span>
            </a>
          </div>
        </div>
        <?php
        }
        ?>
      </div>  
    </div>
<?php get_footer(); ?>
