<?php
the_post();
$postUrl = $_SERVER['HTTP_REFERER'];
$galleryUrl = get_permalink();
$galleryUrl = add_query_arg( array('gallery' => 1)  ,$galleryUrl );
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/libraries/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/style.css">
    <script type="text/javascript">
       window.shareaholic_settings = { apps: { floated_share_buttons: { enabled: false } } };
    </script>
    <?php 
    wp_head();
    ?>
    

    <script type="text/javascript" src="<?php echo THEME_URL;?>/libraries/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URL;?>/js/main.js"></script>
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-40739494-1', 'soytotalmentepalacio.com.mx');
    ga('send', 'pageview');

    </script>
  </head>
  <body>
    <div class="container-fluid top-belt">
      <div class="row">
        <div class="col-lg-12"></div>
      </div>
    </div>
    <div class="container-fluid content-post galeria">
      <div class="row">
        <div class="col-lg-10 col-md-7 col-sm-8 col-xs-7 width-slider">
          <div class="post-col1">
            <div class="content-logo">
               <a href="<?php echo site_url(); ?>"><img src="<?php echo THEME_URL;?>/img/header-logo.jpg" class="img-responsive"></a>
            </div>
            <?php
              if( have_rows('galeria') ):
              ?>
            <div class="gallery-slider-cont">
            <div id="gallery-slider" class="post-slider">
              <?php
              $i = 0;
              $carouselImages = array();
              while ( have_rows('galeria') ) : the_row();
                $image = get_sub_field('imagen');
                // $imgClass = 'img-responsive';
                $imgClass = 'gal-img';
                $contentClass = '';
                if ($i > 0){
                  $contentClass = ' none';
                }
                $img = gaceta2015_get_acf_image_thumbnail($image, 'large', $imgClass);
                $carouselImages[] = $img;
                if ($img){
                   $caption = get_field('custom_caption', $image['id']);
                   $description = get_field('custom_description', $image['id']);
                   if ( $i==0 ){
                    $firstCaption = $caption;
                    $firstDescription = $description;
                   }
                ?>
                  <div class="slide post-slider-wrap <?php echo $contentClass;?>">
                    <?php echo $img;?>
                    <div class="gallery-item-title none"><?php echo $image['title'];?></div>
                    <div class="gallery-item-caption none">
                      <?php echo $caption;?>
                    </div>
                    <div class="gallery-item-description none">
                      <?php echo $description;?>
                    </div>
                  </div>
                <?php
                }
                $i++;
              endwhile;
              ?>
              <a href="#" id="gallery-prev"><img src="<?php echo THEME_URL;?>/img/post/post-slide-prev.png" class="post-slide-prev img-responsive"/></a>
              <a href="#" id="gallery-next"><img src="<?php echo THEME_URL;?>/img/post/post-slide-next.png" class="post-slide-next img-responsive"/></a>
            </div>
            <script>
            var galleryImages = new Array();
            var slideCount = 0;
            var images = jQuery('#gallery-slider .post-slider-wrap img');
            jQuery(images).each(function(){
              var ThisImg = this;
              jQuery("<img/>")
                .attr("src", jQuery(this).attr("src"))
                .load(function() {
                    galleryImages[slideCount++] = new Array(ThisImg, this.width, this.height);
                      resizeFullGalleryImages();
                });
              
            });
            </script>
            <div class="post-carousel-nav" id="carousel-nav"></div>
            </div>
            <?php
            endif;
            ?>
            <ul style="display:none"  class="thumbnail-galery">

              <?php 
              $count = 0;
              foreach ($carouselImages as $carouselImage)
              {
              ?>
                <li data-index="<?php echo $count;?>"><?php echo $carouselImage;?></li>

              <?php
                $count++;
              }
              ?>
            </ul>
            
          </div>  
        </div>
        <div class="col-lg-2 col-md-5 col-sm-4 col-xs-5 width-sidebar">
          <div class="content-sidebar">
            <div class="post-slider-bottom">
              <div class="control-pagination">
                <a href="<?php echo $postUrl;?>">
                  <img class="close-galery" src="<?php echo THEME_URL;?>/img/galeria/btn_closefullgallery.png"/>
                </a>
                <div class="content-img">
                  <div id="gallery-caption">
                    
                  </div>
                  <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                  <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                  <img src="<?php echo THEME_URL;?>/img/post/img_pagination.jpg"/>
                </div>
              </div>
              <h1 class="title-galery gotham-bold"><?php the_title();?></h1>
              <?php if (get_post_format() == 'gallery'){ ?>
              <div class="gallery-excerpt gotham-book">
                <?php the_excerpt();?>
              </div>
              <?php }?>
              <div class="description-galery sentinel-book">
                <?php echo $firstDescription;?>
              </div>
              <div class="footer-galery gotham-book">
                <?php echo $firstCaption;?>
              </div>

              <?php
              for ($count = 0 ; $count < $i ; $count++){
                $item =  $count+1;

              ?>
                <div class='shareaholic-canvas none share-<?php echo $item;?>' data-app-id='15706070' data-app='share_buttons' data-title='<?php the_title();?>' data-link='<?php echo $galleryUrl.'#'.$item;?>' data-summary=''></div>
              <?php
              }
              ?>
              <div class="aside-galery">
                <div class="aside-gallery-banner">
                <?php
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('banner-300x250')): 
                    endif;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div> 
    </div>       
    <script src="<?php echo THEME_URL;?>/js/bootstrap.min.js"></script>
    <?php wp_footer();?>
    <script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 966745603;
    var google_conversion_label = "uwFICK201QMQg7z9zAM";
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/966745603/?value=0&amp;label=uwFICK201QMQg7z9zAM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>  
  </body>
</html>