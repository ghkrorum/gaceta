<?php 
    $termArray = array();
    $termArray[] = array('term_id' => $categoryId, 'taxonomy' => 'category');
    $mainTerm = get_term($categoryId, 'category');
    $posts = gaceta2015_get_zone_posts( 4, GACETA_ZONA_1, $termArray);
    $slidePostCount = count($posts);
    if ($posts){
    ?>
    <div class="container-fluid slide-home">
      <?php
      $slidePostCount = count($posts);
      ?>
      <?php if( !empty($posts) ): ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div id="top-main-slider" class="main-slider-cont" data-slides="<?php echo ($slidePostCount<3)?$slidePostCount:3;?>">
            <?php 
            foreach ($posts as $post){
              setup_postdata($post);
              $image = gaceta2015_get_custom_field_image('imagen_destacada','thumb-640x500', 'img-responsive');
              if ($image){
            ?>
            <div class="slide gotham-bold">
              <div class="slide-wrap">
                <?php 
                echo $image;

                // $termObj = gaceta2015_get_post_term($post->ID);
                ?>
                <div class="slide-txt">
                  <div class="slide-txt-wrap">
                    <?php
                    if ($mainTerm){
                      $termName = $mainTerm->name;
                      $termLink = get_term_link( $mainTerm->term_id, 'category' );
                    ?>
                    <div class="slide-txt-section"><a href="<?php echo $termLink;?>"><?php echo $termName;?></a></div>
                    <?php
                    }
                    ?>
                    <h2 class="slide-txt-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  </div>
                </div>
              </div>
            </div>
            <?php 
              }
            }
            ?>
          </div>
          <a href="#" class="slider-prev"><img src="<?php echo THEME_URL;?>/img/post/post-slide-prev.png" class="post-slide-prev img-responsive"/></a>
            <a href="#" class="slider-next"><img src="<?php echo THEME_URL;?>/img/post/post-slide-next.png" class="post-slide-next img-responsive"/></a>
        </div>
      </div>
      <?php endif; ?>
      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="carousel-nav">
          </div>
      </div>
    </div>
    <?php
    }
    ?>
    <div class="container-fluid content-home">
      <div class="container">
        <div class="row banner">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
              if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('banner-970x90')): 
              endif;
            ?>
          </div>
        </div>
        <div class="row section">
          <?php
          $posts = gaceta2015_get_zone_posts( 3, GACETA_ZONA_2, $termArray);
          if ($posts){
            foreach ($posts as $post){
              setup_postdata($post);
              $term = gaceta2015_get_post_term($post->ID);
              $termName = '&nbsp;';
              $termLink = '';
              if ( !empty($term) ){
                $termName = $term->name;
                $termLink = $term->link;
              }
              $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-308x308', 'img-responsive');
          ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h1 class="title gotham-bold"><?php echo $termName;?></h1>
            <?php
            if (!empty($img)){
            ?>
            <a href="<?php the_permalink(); ?>">
              <?php echo $img;?>
            </a>
            <?php
            
            }
            ?>
            <a href="<?php the_permalink(); ?>">
              <div class="sub-title gotham-bold"><?php the_title(); ?></div>
            </a>
            <?php
            if ( !empty($termLink) )
            {
            ?>
            <div class="post-more">
              <a href="<?php echo $termLink;?>" class="more-btn gotham-bold">
                <span class="more-btn-wrap">
                  <?php echo MORE_TEXT.$termName;?>
                </span>
              </a>
            </div>
            <?php
            }
            ?>
          </div>
          <?php
            }
          }
          ?>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="line-section"></div>
          </div>
        </div>
        <div class="row section-2">
          <?php
          $posts = gaceta2015_get_zone_posts( 1, GACETA_ZONA_3, $termArray);
          if ($posts){
            $post = current($posts);
            setup_postdata($post);
            $term = gaceta2015_get_post_term($post->ID);
            $termName = '';
            $termLink = '';
            if ( !empty($term) ){
              $termName = $term->name;
              $termLink = $term->link;
            }
            $image = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-310x310', 'img-responsive');
          ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="content-image">
              <?php
              if (!empty($image)){
              ?>
              <a href="<?php the_permalink(); ?>"><?php echo $image;?></a>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="post-c-cat gotham-bold">
              <a href=""><?php echo $termName;?></a>
            </div>
            <h2 class="post-c-title gotham-bold">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="post-c-summary sentinel-book">
              <?php the_excerpt_max_charlength(160);?>
            </div>
            <?php 
            if ( !empty($termLink) ){
            ?>
            <a href="<?php echo $termLink;?>" class="more-btn gotham-bold">
              <span class="more-btn-wrap">
                <?php echo MORE_TEXT.$termName;?>
              </span>
            </a>
            <?php
            }
            ?>
          </div>
          <?php
          }
          ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div id="home-banner-300x250">
            <?php
              if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('banner-300x250')): 
              endif;
            ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="line-section"></div>
          </div>
        </div>
        <?php
        $posts = gaceta2015_get_custom_taxonomy_posts_by_custom_term( $categoryId, 'cita', 1 );
        
        if (!empty($posts)){
          $post = current($posts);
          setup_postdata($post);
          $cita = get_field('cita');
          $autor = get_field('cita_autor');
        ?>
        <div class="row section-3">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quote">
            <div class="quote-txt sentinel-book italic">
              <?php echo $cita;?>
            </div>
            <div class="quote-author sentinel-book">
              <?php echo $autor;?>
            </div>
            <div class="quote-social">
              <a href="#"><img src="<?php echo THEME_URL;?>/img/quote-ico-face.png"></a>
              <a href="#"><img src="<?php echo THEME_URL;?>/img/twitter-section-3.png"></a>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
        <div class="row section-4">
          <?php
          $idObj = get_term_by( 'slug', 'videos', GACETA_TAXONOMY);
          $termId = $idObj->term_id;
          $videos = gaceta2015_get_posts_by_category_and_custom_term($categoryId, $termId, 3);
          ?>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-6">
            <?php
            if ( !empty( $videos ) ){
            ?>
            <div class="section-title gotham-bold">
                VIDEOS
            </div>
            <?php
            foreach ($videos as $post){
              setup_postdata($post);
              $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
            ?>
            <div class="video">
              <iframe width="638" height="358" src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen></iframe>  
            </div>
            <?php
              break;
            }
            
            ?>
            <div class="video-list">
              <?php
              $videoCount = 0;
              foreach ($videos as $post){
                setup_postdata($post);
                $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
                $image = gaceta2015_get_custom_field_image('imagen_destacada','thumb-200x116', 'img-responsive');
                
                if ($image){
                  $itemClass = '';
                  if ($videoCount == 1){
                    $itemClass = 'video-center';
                  }
              ?>
              <div class="video-list-item <?php echo $itemClass;?>">
                <a href="<?php echo $videoUrl;?>">
                  <?php echo $image;?>
                  <h3 class="video-title gotham-book">
                    <?php the_title(); ?>
                  </h3>
                </a>
              </div>
              <?php
                  $videoCount++;
                }
              }
              ?>
            </div>
            <div class="content-button-video">
              <a href="<?php echo get_term_link( $termId, GACETA_TAXONOMY );?>" class="more-btn gotham-bold">
                <span class="more-btn-wrap">
                  Más videos
                </span>
              </a>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
            <?php 
            echo gaceta2015_get_popular_posts_block($categoryId);
            ?>
          </div> 
        </div>
        <div class="row section-5 home-3-5">
          <?php
          $posts = gaceta2015_get_zone_posts( 1, GACETA_ZONA_4, $termArray );
          if ($posts){
              $post = current($posts);
              setup_postdata($post);
              $term = gaceta2015_get_post_term($post->ID);
              $termName = '&nbsp;';
              $termLink = '#';
              if ( !empty($term) ){
                $termName = $term->name;
                $termLink = $term->link;
              }
              $image = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-310x310', 'img-responsive');
          ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="content-image">
              <?php 
              if (!empty($image)){
              ?>
                <a href="<?php the_permalink(); ?>"><?php echo $image;?></a>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="post-c-cat gotham-bold">
              <a href="<?php echo $termLink;?>"><?php echo $termName;?></a>
            </div>
            <h2 class="post-c-title gotham-bold">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="post-c-summary sentinel-book">
              <?php the_excerpt_max_charlength(160);?>
            </div>
            <?php
            if ( !empty($termLink) ){
            ?>
            <a href="<?php echo $termLink;?>" class="more-btn gotham-bold">
              <span class="more-btn-wrap">
                <?php echo MORE_TEXT.$termName;?>
              </span>
            </a>
            <?php
            }
            ?>
          </div>
          <?php
          }
          ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?php
            $idObj = get_term_by( 'slug', 'pocos-saben', GACETA_TAXONOMY);
            $termId = $idObj->term_id;
            $post = gaceta2015_get_last_post_by_category_and_custom_term($categoryId, $termId);
            if ($post){
              setup_postdata($post);
              $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-310x310', 'img-responsive');
            ?>
            <div class="linea-b-col">
              <div class="content-image">
                <?php
                if (!empty($img)){
                ?>
                  <?php echo $img;?>
                <?php
                }
                ?>
              </div>
              <h2 class="post-c-title gotham-bold">
                <?php echo $idObj->name;?>
              </h2>
              <div class="post-c-summary gotham-book">
                <?php echo get_the_excerpt();?>
              </div>
            </div>
            <div class="break"></div>
            <?php
            }
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="line-section"></div>
          </div>
        </div>
        <div id="general-posts">
          <?php
          $numOfPosts = (isset($_SESSION['post-offset']))?$_SESSION['post-offset']:4;
          unset($_SESSION['post-offset']);
          $posts = gaceta2015_get_cat_posts($categoryId, $numOfPosts);
          // $posts = gaceta2015_get_cat_posts_exclude_custom_taxonomy($categoryId, $numOfPosts);
          if ($posts){
            $postCount = 0;
          ?>
            <?php
            $totalPosts = count($posts);
            foreach ( $posts as $post ){
              setup_postdata( $post );
              $term = gaceta2015_get_post_term($post->ID);
              $catName = (!empty($term))?$term->name:'';
              $image = gaceta2015_get_custom_field_image('imagen_destacada','thumb-310x310', 'img-responsive');
              if ( $postCount % 4 == 0 ){
                $extraClass = ($postCount>0)?'row-more-posts':'';
                echo '<div class="row section-6 '.$extraClass.'">';
              }
            ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
              <div class="category-posts-item">
                <div class="section-title gotham-bold">
                  <?php echo $catName;?>
                </div>
                <a href="<?php the_permalink(); ?>">
                  <?php if (!empty($image)){ 
                    echo $image;
                  }
                  ?>
                  <h2 class="category-posts-item-tit gotham-book"><?php the_title(); ?></h2>
                </a>
              </div>
            </div>
            <?php
              $postCount++;
              if ( $postCount % 4 == 0 || $postCount == $totalPosts){
                echo '</div>';
              }
            }
            ?>
        </div>
        <div class="row section-7">
          <div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">
            <a href="" class="more-btn gotham-bold load-more-posts" data-offset="<?php echo $totalPosts;?>" data-category="<?php echo $categoryId;?>">
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