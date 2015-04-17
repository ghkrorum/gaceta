        <?php
        global $post;
        $totalPosts = count($posts);
        $rowCount = 0;
        for ( $i = 0 ; $i < $totalPosts ; $i++ ){
          $item = $offset + $i;
          $post = $posts[$i];
          setup_postdata($post);
          $videoUrl = gaceta2015_get_video_url(get_field('video_url'));
        ?>
          <div class='shareaholic-canvas none share-<?php echo $item;?>' data-app-id='15706070' data-app='share_buttons' data-title='<?php the_title();?>' data-link='<?php echo $videoUrl;?>'></div>
        <?php
        }
        ?>
