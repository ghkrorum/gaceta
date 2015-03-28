<?php get_header();?>
<?php
the_post();
$postUrl = get_permalink();
$galleryUrl = add_query_arg( array('gallery' => 1)  ,$postUrl );
$term = gaceta2015_get_post_term_by_taxonomy( $post->ID, 'category' );
$brands = get_the_terms( $post->ID, 'marcas' );
?>
    <div class="container-fluid content-post">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <div class="post-col1">
              <div class="post-category gotham-bold">
                <?php echo $term->name;?>
              </div>
              <h1 class="post-title gotham-bold">
                <?php the_title(); ?>
              </h1>
              <div class="post-description gotham-book">
                <?php echo get_the_excerpt();?>
              </div>
              <div class="post-author gotham-bold">
                <?php echo the_field('g_autor');?>
              </div>
              <div class="post-date gotham-book">
                <?php echo the_date( 'j F, Y' );?>
              </div>
              <?php
              $imageCount = 0;
              $theImage = gaceta2015_get_custom_field_image('imagen_destacada','thumb-640x450', 'img-responsive');
              if ( have_rows('galeria') ){
                $carouselImages = array();
                  while ( have_rows('galeria') ){
                    the_row();
                    $image = get_sub_field('imagen');
                    $imgClass = 'img-responsive';
                    $containerClass = '';
                    if ($i > 0){
                      $containerClass = 'none';
                    }elseif(empty($image)){
                      $theImage = $image;
                    }
                    $image = gaceta2015_get_acf_image_thumbnail($image, 'thumb-640x450', $imgClass);
                    $imageCount++;
                  }
              }
              if ($theImage){
              ?>
              <div class="post-slider">
                <div class="post-slider-cont">
                  <div id="post-slideshow">
                    <div class="post-slideshow-item <?php echo $containerClass;?>">
                      <?php echo $theImage;?>
                    </div>
                  </div>
                  <a href="<?php echo $galleryUrl;?>" class="gallery-cover-btn">
                    <span class="gallery-cover-btn-txt gotham-bold"><?php echo $imageCount;?></span>
                  </a>
                </div>
              </div>
              <?php
              }
              ?>
              <div class="row-post sentinel-book">
                <div class="parrafo-one">
                  <?php the_content();?>
                </div>
                <div class="post-pages">
                  <?php 
                  $args = array(
                          'before'           => '<p>' . __('P&aacute;ginas:')
                        );
                  wp_link_pages($args); ?>
                </div>
              </div>
              <div class="row-post">
                <div class="col-left">&nbsp;</div>
                <div class="description-txt gotham-book autor">
                  <?php
                  $marcas = gaceta2015_get_terms_array($post->ID, array(MARCAS_TAXONOMY, 'post_tag'));
                  if (!empty($marcas)){
                  ?>
                  <span class="sentinel-book italic title">En este artículo:</span> 
                  <?php
                    echo implode(', ', $marcas);
                  }
                  ?>
                </div>
              </div>
              <div class="row-post sentinel-book facebook">
                <?php comments_template( '', true ); ?>
              </div>
            </div>  
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?php
            if(!empty($term)){
              echo gaceta2015_get_popular_posts_block($term->term_id);
            }else{
              echo gaceta2015_get_popular_posts_block(NULL);
            }
            ?>
            <div class="aside-right">
              <!-- Banner -->
              <?php
              if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('banner-300x600')): 
              endif;
              ?>
              <!-- End Banner -->
            </div>
            
            <!-- Más Marcas -->
            <?php
            $marcas = gaceta2015_get_terms_array($post->ID, array(MARCAS_TAXONOMY));
            $marcaIdArray = array();
            if (!empty($marcas)){
              foreach ($marcas as $key => $marca){
                $marcaIdArray[] = $key;
              }
              echo gaceta2015_get_related_posts_block($marcaIdArray);
            }
            ?>

            <!-- End Más Marcas -->

          </div> 
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="line-section"></div>
          </div>
        </div>
        <?php
        $tagIdArray = array();
        if (!empty($tags)){
          foreach ($tags as $key => $tag){
            $tagIdArray[] = $key;
          }
        }

        $taxTerms = array(
          'MARCAS_TAXONOMY' => $marcaIdArray,
          'post_tag' => $tagIdArray
        );

        $relatedPosts = gaceta2015_post_get_related_posts($taxTerms, 4, $post->ID);

        if (!empty($relatedPosts)){
        ?>
        <div class="row notas">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="section-title gotham-bold">
                NOTAS RELACIONADAS
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          </div>  
        </div>
        <div class="row section-6 posts">
          <?php
          foreach ( $relatedPosts as $post ){
            setup_postdata($post);
            $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-225x225', 'img-responsive');
          ?>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="category-posts-item">
              <a href="<?php the_permalink();?>">
                <?php echo $img;?>
                <h2 class="category-posts-item-tit gotham-book"><?php the_title();?></h2>
              </a>
            </div>
          </div>  
          <?php
          }
          ?>
        </div>
        <?php
        }
        ?>
      </div>  
    </div>
<?php get_footer(); ?>