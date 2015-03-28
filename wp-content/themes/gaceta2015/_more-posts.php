        <?php
        if ($posts){
          global $post;
        ?>
        <div class="row section-6 row-more-posts">
          <?php
          foreach ( $posts as $post ){
            setup_postdata( $post );
            $term = gaceta2015_get_post_term($post->ID);
            $catName = (!empty($term))?$term->name:'';
            $image = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-310x310', 'img-responsive');
          ?>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="category-posts-item">
              <?php if ($showCategoryName){?>
              <div class="section-title gotham-bold">
                <?php echo $catName;?>
              </div>
              <?php
              }
              ?>
              <a href="<?php the_permalink(); ?>">
                <?php if (!empty($image)){ 
                  echo $image;
                }
                ?>
              <h2 class="category-posts-item-tit gotham-book"><?php the_title(); ?></h2></a>
            </div>
          </div>  
          <?php
          }
          ?>
        </div>
        <?php
        }
        ?>