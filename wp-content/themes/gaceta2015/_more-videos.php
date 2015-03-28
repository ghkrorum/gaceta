        <?php
        global $post;
        $totalPosts = count($posts);
        for ( $i = 0 ; $i < $totalPosts ; $i++ ){
          $post = $posts[$i];
          setup_postdata($post);
          $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-309x180', 'img-responsive');
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
          if ( $i % 3 == 0 ){
            echo '<div class="row section-6 video-post">'; // Open Row
          }
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 video-items-loaded">
            <div class="category-posts-item none">
              <a href="<?php echo $videoUrl; ?>"><?php echo $img;?></a>
              <iframe src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen></iframe>
              <h2 class="category-posts-item-tit gotham-book"><a href="#"><?php the_title(); ?></a></h2>
            </div>
          </div>
        <?php
          if ( ($i + 1) % 3 == 0 || $i == ( $totalPosts - 1 ) ){
            echo '</div>'; // Close Row
          }
        }
        ?>
