            <div class="section-title title-popular medium gotham-bold">
              más de <?php echo $term->name;?>
            </div>
            <div class="popular gotham-book">
              <?php
              foreach ($relatedPosts as $post){
                setup_postdata($post);
                $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-90x90', 'img-responsive popular-img');
              ?>
              <div class="popular-item">
                <div class="popular-txt">
                  <a href="<?php the_permalink();?>">
                    <?php the_title();?>
                  </a>
                </div>
                <a href="<?php the_permalink();?>">
                  <?php echo $img;?>
                </a>
              </div>
              <?php
              }
              ?>
            </div>