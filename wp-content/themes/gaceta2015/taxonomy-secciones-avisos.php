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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Avisos</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/libraries/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/style.css">

    <script type="text/javascript" src="<?php echo THEME_URL;?>/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URL;?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URL;?>/js/main.js"></script>
  </head>
  <body>
    <div class="container-fluid header-notices">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-center gotham-book">
            <div class="bar">
              <div class="txt">
              <a href=""><span class="gotham-bold">AVISOS IRRESISTIBLES:</span> OFERTAS Y PROMOCIONES VIGENTES</a>
              </div>
              <div class="icon">
              <a href="" class="downarrow"><img src="<?php echo THEME_URL;?>/img/img_downarrow.png"/></a>
              </div>
            </div>
          </div>
        </div>  
    </div>
    <div class="container-fluid content-aviso">
      <div class="container">
        <div class="row menu-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="content-nav">
              <ul class="header-menu gotham-bold">
                <?php
                $querystr = "
                  SELECT t.term_id, t.name, t.slug, count(*) total
                  FROM  
                    (
                      SELECT object_id
                      FROM wp_term_relationships
                      WHERE term_taxonomy_id = ".GACETA_CATEGORY_AVISOS."
                    ) p
                    LEFT JOIN wp_term_relationships tr on tr.object_id = p.object_id
                    LEFT JOIN  wp_term_taxonomy tt on tr.term_taxonomy_id = tt.term_taxonomy_id
                    LEFT JOIN  wp_terms t on t.term_id = tt.term_id
                    WHERE t.term_id != 1
                  GROUP BY t.term_id
                  ORDER BY count(*) DESC;
                ";
                $menuItems = $wpdb->get_results($querystr, OBJECT);

                foreach ($menuItems as $menuItem){
                  $termId = '';
                  $itemClass = ( $menuItem == $category )?'active':'';
                  $menuLink = gaceta2015_get_video_link( $videosLink, $menuItem->slug );
                  $idObj = get_term_by( 'slug', $menuItem->slug, 'category' );
                  if ( $idObj ){
                    $menuTitle = $idObj->name;
                    $termId = $idObj->term_id;
                  }
                ?>
                <li>
                  <a href="<?php echo $menuLink;?>" class="<?php echo $itemClass;?>" data-category="<?php echo $termId;?>"><?php echo $menuItem->name;?> (<?php echo $menuItem->total;?>)</a>
                </li>
                <?php
                }
                ?>
              </ul>
            </div> 
          </div>
        </div>
        <?php
        $totalPosts = count($posts);
        $rowCount = 0;
        for ( $i = 0 ; $i < $totalPosts ; $i++ ){
          $post = $posts[$i];
          setup_postdata($post);
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
          $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-309x180', 'img-responsive');
          if ( $i % 3 == 0 ){
            echo '<div class="row section-avisos">'; // Open Row
          }

        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>
        <?php
          if ( ($i + 1) % 3 == 0 || $i == ( $totalPosts - 1 ) ){
            $rowCount++;
            echo '</div>'; // Close Row
          }
        }
        ?>
        <div class="row section-avisos">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>  
        </div>
        <div class="row section-avisos">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item">
              <div class="content-image">
                <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
                <div class="more-btn-content">
                  <a href="#modal1" class="more-btn gotham-bold">
                    <span class="more-btn-wrap">
                      Más detalles
                    </span>
                  </a>
                </div>
              </div>
              <a href="">
                <div class="sub-title gotham-bold">descuentos y meses sin intereses en joyería y moda</div>
              </a>  
              <h4 class="date-aviso gotham-book">DEL 4 AL 15 DE FEBRERO</h4>
            </div>
          </div>  
        </div>
        <div class="row pagination-aviso">
          <div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">
            <a href="" class="more-btn gotham-bold">
              <span class="more-btn-wrap active">
               1
              </span>  
            </a>
            <a href="" class="more-btn gotham-bold">
              <span class="more-btn-wrap">
               2
              </span>  
            </a>
          </div>
        </div>
        <div id="modal1" class="modalmask">
          <div class="modalbox movedown">
            <div class="content-image">
              <img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
            </div>      
            <div class="descripcion-modal gotham-book">
              <p><span class="numbers sentinel-book">20%</span> de descuento en cupones ó <span class="numbers sentinel-book">15</span> mensualidades sin intereses con Tarjeta Palacio ó <span class="numbers sentinel-book">12</span> mensualidades sin intereses con tarjetas bancarias en Joyería de fantasía y Relojes de moda.</p>

              <p>Hasta <span class="numbers sentinel-book">15</span> mensualidades sin intereses con Tarjeta Palacio y <span class="numbers sentinel-book">12</span> mensualidades sin intereses con tarjetas bancarias en Joyería y Relojes finos.</p>
            </div>
            <div class="date-modal gotham-book">
              DEL 4 AL 15 DE FEBRERO.
              <ul class="logos-modal">
                <li><a href=""><img src="<?php echo THEME_URL;?>/img/facebook-modal.png"></a></li>
                <li><a href=""><img src="<?php echo THEME_URL;?>/img/twitter-modal.png"></a></li>
                <li><a href=""><img src="<?php echo THEME_URL;?>/img/pinperest-modal.png"></a></li>
                <li><a href=""><img src="<?php echo THEME_URL;?>/img/mail-modal.png"></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>  
    </div>         
    <script src="<?php echo THEME_URL;?>/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
}
?>