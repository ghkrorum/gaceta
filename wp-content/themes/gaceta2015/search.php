<?php get_header();?>

    <div class="container-fluid content-listado">
      <div class="container">
        <div class="row section section-list">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <?php
            if ( have_posts() ) {
            ?>
            <?php
            $totalPosts = $wp_query->post_count;
            for ($i=0;(have_posts()) && ($i < 4);$i++){
              the_post();
              $containerClass = '';
              if ($i % 2 == 0){
                echo '<div class="row-one">'; // Open Row
                $containerClass = 'content-categoria-left';
              }else{
                $containerClass = 'content-categoria-right';
              }
              $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-308x308', 'img-responsive');
            ?>
              <div class="<?php echo $containerClass;?>">
                <h1 class="title gotham-bold"><?php echo ($i ==0)?$silverName:'';?></h1>
                <div class="content-image">
                  <?php
                  if ($img){
                  ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php echo $img;?>
                  </a>
                  <?php
                  }
                  ?>
                </div>
                <a href="<?php the_permalink(); ?>">
                  <div class="sub-title gotham-bold"><?php the_title(); ?></div>
                </a>
              </div>
            <?php
              if ( $i % 2 != 0 || $i == $totalPosts-1 ){
                echo '</div>'; // Close Row
              }
            }
            ?>
          <?php
          }else{
          ?>
          <div class="no-results sentinel-book">
            No se encontraron resultados, intenta una nueva búsqueda.
          </div>
          <?php
          }
          ?>
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php echo gaceta2015_get_popular_posts_block(NULL);?>
          </div> 
        </div>
        <?php
        if ( $i < $totalPosts ){
        ?>
        <div id="general-posts">
        <div class="row section-6 listado">
          <?php
          for ( $i; (have_posts()) && $i < $totalPosts ; $i++ ){
            the_post();
            $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-225x225', 'img-responsive');
          ?>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="category-posts-item">
              <a href="<?php the_permalink(); ?>">
                <?php echo $img;?>
                <h2 class="category-posts-item-tit gotham-book"><?php the_title(); ?></h2>
              </a>
            </div>
          </div>  
          <?php
          }
          ?>
        </div>
        </div>
        <div class="row section-7">
          <div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">
            <a href="#" class="more-btn gotham-bold load-more-posts" data-offset="<?php echo $totalPosts;?>" data-s="<?php the_search_query();?>">
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