            <div class="section-title title-popular gotham-bold">
              Lo + Visto
            </div>
            <div class="popular gotham-book">
              <?php
              foreach ($popularPosts as $post){
                setup_postdata($post);
                $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-90x90', 'img-responsive popular-img');
              ?>
              <div class="popular-item">
                <div class="popular-txt gotham-book">
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