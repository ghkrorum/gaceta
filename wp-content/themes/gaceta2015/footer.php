    <div class="container-fluid content-footer-extras">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="space-top"></div>
          </div>
        </div>  
        <div class="row footer-extras">
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <?php
            $prontoTerms = array();
            $prontoTerms[] = array(
              'taxonomy' => GACETA_TAXONOMY, 
              'slug' => 'pronto-en-la-gaceta'
            );
            $posts = gaceta2015_get_posts_by_term_slug( $prontoTerms, 3 );
            if (!empty($posts)){
              $count = 0;
            ?>
              <div class="coming-soon-head sentinel-book">
                <span class="italic">Próximamente en</span>
                LA GACETA
              </div>
              <div id="gaceta-pronto" class="cycle-slideshow"
                data-cycle-timeout=2000
                data-cycle-slides="> div"
              >
                <?php
                foreach ( $posts as $post ){
                  setup_postdata($post);
                  $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-255x288', 'img-responsive image-footer');
                  $itemClass = ($count>0)?'none':'';
                  $count++;
                ?>
                <div class="gaceta-pronto-item <?php echo $itemClass;?>">
                  <?php echo $img;?>
                  <h2 class="coming-soon-tit gotham-book">
                    <?php the_title(); ?>
                  </h2>
                </div>
                <?php
                }
                ?>
              </div>
            <?php
            }
            ?>
          </div>  
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <div class="col-social">
              <div class="section-title gotham-bold">
                Social News
              </div>
              <div class="social-news-frame">
                <?php echo do_shortcode( '[custom-facebook-feed]' );?>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 gotham-bold">  
            <?php
              if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('instagram-sidebar')): 
              endif;
            ?>
          </div>  
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="space-top"></div>
          </div>
        </div> 
      </div>  
    </div> 
    <div class="container-fluid content-footer">
      <div class="container"> 
        <div class="row">
          <div class="col-lg-12">
            <div class="space-top"></div>
          </div>
        </div>     
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="footer-newsletter gotham-bold">
              <a class="more-btn gotham-bold"  href="https://www.elpalaciodehierro.com/newsletter/subscriber/new/" target="_blank">
                <span class="more-btn-wrap"> SUSCRÍBETE AL NEWSLETTER </span>
              </a>
              <!--<div class="footer-newsletter-form">
                <form method="post" action="http://gaceta-new.loc/wp-content/plugins/newsletter/do/subscribe.php" onsubmit="return newsletter_check(this)">
                  <input class="newsletter-email footer-newsletter-input" type="email" name="ne" size="30" required>
                  <a href="#" class="footer-newsletter-btn"></a>
                  <input id="newsletter-submit" class="newsletter-submit" type="submit" value="Subscribe"/>
                </form>
              </div>-->
            </div>
            <div class="footer-social">
              <?php
              if ( of_get_option('gaceta2015_facebook_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_facebook_url'); ?>" target="_blank"><div class="icon-facebook"></div></a>
              <?php
              }
              ?>
              <?php
              if ( of_get_option('gaceta2015_twitter_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_twitter_url'); ?>" target="_blank"><div class="icon-twitter"></div></a>
              <?php
              }
              ?>
              <?php
              if ( of_get_option('gaceta2015_instagram_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_instagram_url'); ?>" target="_blank"><div class="icon-instagram"></div></a>
              <?php
              }
              ?>
              <?php
              if ( of_get_option('gaceta2015_youtube_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_youtube_url'); ?>" target="_blank"><div class="icon-youtube"></div></a>
              <?php
              }
              ?>
              <?php
              if ( of_get_option('gaceta2015_foursquare_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_foursquare_url'); ?>" target="_blank"><div class="icon-foursquare"></div></a>
              <?php
              }
              ?>
              <?php
              if ( of_get_option('gaceta2015_pinterest_url') ){
              ?>
              <a href="<?php echo of_get_option('gaceta2015_pinterest_url'); ?>" target="_blank"><div class="icon-pinterest"></div></a>
              <?php
              }
              ?>
            </div>
            <div class="footer-disclaimer gotham-book">
              <a href="http://gaceta.soytotalmentepalacio.com.mx/gaceta2015/terminos-y-condiciones/"><span>Términos y condiciones</span></a>
              <a href="http://gaceta.soytotalmentepalacio.com.mx/gaceta2015/aviso-de-privacidad/"><span>Aviso de privacidad</span></a>
              <a href="http://gaceta.soytotalmentepalacio.com.mx/gaceta2015/directorio/"><span>Directorio</span></a>
              <span class="copyright">&copy; El palacio de hierro 2015</span>
            </div>      
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="other-versions-title sentinel-book italic">
              Consúltala también en:
            </div>
            <?php
            if ( of_get_option('gaceta2015_pdf_file') && of_get_option('gaceta2015_pdf_image') ){
            ?>
            <div class="other-version gotham-bold">
              <a href="<?php echo of_get_option('gaceta2015_pdf_file'); ?>" target="_blank"><img class="img-responsive" src="<?php echo of_get_option('gaceta2015_pdf_image'); ?>"></a>
              <div class="other-versions-desc">
                PDF
              </div>
            </div>
            <?php
            }
            ?>
            <?php
            if ( of_get_option('gaceta2015_ipad_link') && of_get_option('gaceta2015_ipad_image') ){
            ?>
            <div class="other-version gotham-bold">
              <a href="<?php echo of_get_option('gaceta2015_ipad_link'); ?>" target="_blank"><img class="img-responsive" src="<?php echo of_get_option('gaceta2015_ipad_image'); ?>"></a>
              <div class="other-versions-desc">
                IPAD
              </div>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <img src="<?php echo THEME_URL;?>/img/footer-logo.png" class="img-responsive footer-logo">
          </div>
        </div>
        <div class="row">
        <div class="col-lg-12">
          <div class="space-top"></div>
        </div>
        </div> 
      </div>  
    </div>    
    <div class="container-fluid footer-notices">
      <div class="container">  
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-center gotham-book">
            <div class="uparrow"><a href=""><img src="<?php echo THEME_URL;?>/img/img_uparrow.png"/></a></div>
            <!--<a href=""><span class="gotham-bold">AVISOS IRRESISTIBLES:</span> OFERTAS Y PROMOCIONES VIGENTES</a>-->
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
