<?php
    function get_custom_post_function($newtax){     
      $taxname = $newtax['taxonomy'];
      $get_post_slug = $newtax['post_type'];
      
      $categories = get_terms( array(
          'hide_empty' => false,
          'taxonomy' => $taxname
        ) 
      );
       
      ?>
        <select name="cat" id="c_cat">
          <option value="">All</option>
        <?php
          foreach($categories as $cartegoty){
            _e("<option value='".$cartegoty->term_taxonomy_id."'>".$cartegoty->name."</option>");
          }
        ?>
        </select>

        <input id="hidden_taxonomy_slug" type="hidden" value='<?php _e($taxname); ?>'>    
        <input id="hidden_post_slug" type="hidden" value='<?php _e($get_post_slug); ?>'>    
        <hr/>
        <div id="after_ajax_req"></div>
      <?php
    }
    add_shortcode('get_category', 'get_custom_post_function');


    function get_test_custom_post(){
      $get_cat_name = $_POST["category"];
      $get_tax_name = $_POST["taxonomy"];
      $get_post_type_name = $_POST["post_type"];
      if(isset($_POST["category"]) && isset($_POST["category"])){
        $i = 1;
        $args = array(
            'post_type' => array( $get_post_type_name ),
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
                  'taxonomy' => $get_tax_name,
                  'field' => 'term_taxonomy_id',
                  'terms' => $get_cat_name
              )
            )
        );
        $query = new WP_Query( $args );
      
        $post_count = 3;
        echo "<div class='container'>";
        if ( $query->have_posts() ) :
          while ( $query->have_posts() ) : $query->the_post();
            include('template/template1.php');
            $post_count++;
          endwhile;
        else :
            _e( 'Sorry, no posts were found.', 'textdomain' );
        endif;
        die();
      }else{
        _e("jjjjjjjjj");
      }
      echo "</div>";
    }

    function my_must_login() {
      echo _e("You must log in to vote");
      die();
    }