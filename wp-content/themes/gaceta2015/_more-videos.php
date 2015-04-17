        <?php
        global $post;
        $totalPosts = count($posts);
        $rowCount = 0;
        for ( $i = 0 ; $i < $totalPosts ; $i++ ){
          $item = $offset + $i;
          $post = $posts[$i];
          setup_postdata($post);
          $img = gaceta2015_get_custom_field_image('imagen_destacada', 'thumb-309x180', 'img-responsive');
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
          if ( $i % 3 == 0 ){
            $rowClass = ($rowCount>0 || $offset > 0)?'video-items-loaded':'';
            echo '<div class="row section-6 video-post '.$rowClass.'">'; 
          }
        ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="category-posts-item none">
              <a href="<?php echo $videoUrl; ?>" data-title="<?php echo get_the_title();?>" data-item="<?php echo $item;?>"><?php echo $img;?></a>
              <h2 class="category-posts-item-tit gotham-book"><a href="<?php echo $videoUrl; ?>" data-title="<?php echo get_the_title();?>" data-item="<?php echo $item;?>"><?php the_title(); ?></a></h2>
            </div>
          </div>
        <?php
          if ( ($i + 1) % 3 == 0 || $i == ( $totalPosts - 1 ) ){
            $rowCount++;
            echo '</div>'; // Close Row
          }
        }
        ?>
