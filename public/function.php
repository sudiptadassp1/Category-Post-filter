<?php
    function get_custom_post_function($newtax){     
      $taxname = $newtax['taxonomy'];
      $get_post_slug = $newtax['post_type'];
      $get_temp_val = $newtax['template'];
      
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
        <input id="hidden_template_value" type="hidden" value='<?php _e($get_temp_val); ?>'>    
        <hr/>
        <div id="after_ajax_req"></div>
      <?php
    }
    add_shortcode('get_category', 'get_custom_post_function');


    function get_test_custom_post(){
      $get_cat_name = $_POST["category"];
      $get_tax_name = $_POST["taxonomy"];
      $get_post_type_name = $_POST["post_type"];
      $get_template = $_POST['template_val'];
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
          if($get_template == "temp_1")
          {
            include('template/template1.php');
          }else if($get_template == "temp_2")
          {
            include('template/template2.php');
          }else if($get_template == "temp_3")
          {
            include('template/template3.php');
          }else if($get_template == "temp_4")
          {
            include('template/template4.php');
          }else{
            _e("No template Selected. Please select a template.");
          }
            
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