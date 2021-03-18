<?php
    if($post_count%3 == 0){
        echo "<div class='template4_post_row row '>";
    }
?>
    
    <div class="col-sm-4">
        <div class="template4_post_card card" style="width: 100%;">
            <img class="template4_post_thumb" src="<?php echo the_post_thumbnail_url('post-medium') ?>" alt="">
            <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <p class="card-text"><?php echo get_excerpt(); ?></p>
                <a href="<?php get_permalink ?>" class="btn btn-warning">See More</a>
            </div>
        </div>
    </div>
   
<?php
    if($post_count%3 == 2){
        echo "</div>";
    }
?>