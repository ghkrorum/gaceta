<?php get_header();?>
<?php
the_post();
$postUrl = get_permalink();
$galleryUrl = add_query_arg( array('gallery' => 1)  ,$postUrl );
$term = gaceta2015_get_post_term( $post->ID );
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
              if( have_rows('galeria') ):
              ?>
              <div class="post-slider" id="post-slider">
                <div class="post-slider-cont">
                  <div id="post-slideshow" class="cycle-slideshow-" 
                    
                  >
                    <?php
                    $i = 0;
                    $carouselImages = array();
                    while ( have_rows('galeria') ) : the_row();
                      $image = get_sub_field('imagen');
                      $imgClass = 'gal-img';
                      $containerClass = '';
                      if ($i > 0){
                        $containerClass = 'none';
                      }
                      $img = gaceta2015_get_acf_image_thumbnail($image, 'thumb-slider', $imgClass);
                      $carouselImages[] = gaceta2015_get_acf_image_thumbnail($image, 'thumb-70x60', '');
                      if ($img){
                         $caption = get_field('custom_caption', $image['id']);
                         $description = get_field('custom_description', $image['id']);
                         if ( $i==0 ){
                          $firstDescription = $description;
                          $firstCaption = $caption;
                         }
                      ?>
                        <div class="post-slideshow-item <?php echo $containerClass;?>">
                          <?php echo $img;?>
                          <div class="post-slideshow-item-caption hidden">
                            <?php echo $caption;?>
                          </div>
                          <div class="post-slideshow-item-description hidden">
                            <?php echo $description;?>
                          </div>
                        </div>
                      <?php
                      }
                      $i++;
                    endwhile;
                    ?>
                  </div>
                  <?php
                  if ($i > 1)
                  {
                  ?>
                  <a href="#" id="post-slide-prev"><img src="<?php echo THEME_URL;?>/img/post/post-slide-prev.png" class="post-slide-prev img-responsive"/></a>
                  <a href="#" id="post-slide-next"><img src="<?php echo THEME_URL;?>/img/post/post-slide-next.png" class="post-slide-next img-responsive"/></a>
                  <?php
                  }
                  ?>
                </div>
                <?php if ($i > 1){ ?>
                <div class="post-slider-carousel-cont" id="post-slider-carousel-cont">
                  <div class="post-slider-carousel-cont-wrap">
                    <div id="post-slider-carousel" class="post-slider-carousel cycle-slideshow" style="float: left; width: 100%;"
                      data-cycle-fx=carousel
                      data-cycle-timeout="0"
                      data-cycle-next="#post-carousel-next"
                      data-cycle-prev="#post-carousel-prev"
                      data-cycle-carousel-visible="<?php echo ($i < 6)?$i:6;?>"
                      data-allow-wrap="false"
                      data-cycle-carousel-fluid=true
                    >
                      <?php 
                      foreach ($carouselImages as $carouselImage){
                      ?>
                        <?php echo $carouselImage;?>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <a href="#" id="post-carousel-prev"><img src="<?php echo THEME_URL;?>/img/flecha_izq_thumbs.png" class=""/></a>
                  <a href="#" id="post-carousel-next"><img src="<?php echo THEME_URL;?>/img/flecha_der_thumbs.png" class=""/></a>
                </div>
                <?php
                }
                ?>
                
                <div class="post-carousel-nav" id="carousel-nav">
                </div>
                <script>
                var sliderImages = new Array();
                var slideCount = 0;
                var images = jQuery('#post-slider .post-slideshow-item img');
                jQuery(images).each(function(){
                  var ThisImg = this;
                  jQuery("<img/>")
                    .attr("src", jQuery(this).attr("src"))
                    .load(function() {
                        sliderImages[slideCount++] = new Array(ThisImg, this.width, this.height);
                        
                          resizeSliderImages();
                        
                    });
                  
                });
                </script>
      
                <div class="post-slider-bottom">
                  <div class="post-slider-caption gotham-book" >
                    <div class="post-slider-caption-txt" id="post-slider-caption">
                      <?php echo $firstCaption;?>
                    </div>
                    <div class="post-slider-description sentinel-book" id="post-slider-description">
                      <?php echo $firstDescription;?>
                    </div>
                  </div>
                  <div class="control-pagination">
                    <a href="<?php echo $galleryUrl;?>"><img class="allpage" src="<?php echo THEME_URL;?>/img/post/img_allpages.jpg"/></a>
                    <div class="content-img">
                      <?php 
                      if ($i > 1)
                      {
                      ?>
                      <div id="cycle-caption">
                      </div>
                      
                      <a href="#" id="show-slider-carousel">
                        <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                        <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                        <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                      </a>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              endif;
              ?>
              <div class="row-post sentinel-book">
                
                <!-- <ul class="aside-redes">
                  <li><img src="<?php echo THEME_URL;?>/img/post/btnside_facebook.jpg"/></li>
                  <li><img src="<?php echo THEME_URL;?>/img/post/btnside_twitter.jpg"/></li>
                  <li><img src="<?php echo THEME_URL;?>/img/post/btnside_pinterest.jpg"/></li>
                  <li><img src="<?php echo THEME_URL;?>/img/post/btnside_mail.jpg"/></li>
                </ul> -->
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
                <div class="description-txt gotham-book autor">
                  <?php
                  $marcas = gaceta2015_get_terms_array($post->ID, array(MARCAS_TAXONOMY, 'post_tag'));
                  $tags = gaceta2015_get_terms_array($post->ID, array(MARCAS_TAXONOMY, 'post_tag'));
                  $terms = $marcas + $tags;
                  if (!empty($terms)){
                  ?>
                  <span class="sentinel-book italic title">En este artículo:</span> 
                  <?php
                    echo implode(', ', $terms);
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
            $mainTerm = gaceta2015_get_post_term_by_taxonomy($post->ID, 'category');
            if(!empty($mainTerm)){
              echo gaceta2015_get_popular_posts_block($mainTerm->term_id);
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
