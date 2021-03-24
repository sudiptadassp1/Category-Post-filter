<?php
    function get_custom_post_function($newtax){  
      $get_post_id =  $newtax['id'];
      $taxname;
      $get_post_slug;
      $get_temp_val;
      global $wpdb;
      $prefix = $wpdb->prefix."postmeta";
      $results = $wpdb->get_results( "SELECT * FROM $prefix where post_id = $get_post_id" );
      if(count($results) > 0){
        foreach($results as $result){
          if($result->meta_key  == "cpc_post_podt_type"){
            $get_post_slug = $result->meta_value;
          }else if($result->meta_key  == "cpc_taxonomy"){
            $taxname = $result->meta_value;
          }else if($result->meta_key  == "temp"){
            $get_temp_val = $result->meta_value;
          } 
        }
        
        
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
      }else{
        _e("No Filter Found");
      }
      
      
    }
    add_shortcode('get_category', 'get_custom_post_function');


    function get_test_custom_post(){
      $get_cat_name = $_POST["category"];
      $get_tax_name = $_POST["taxonomy"];
      $get_post_type_name = $_POST["post_type"];
      $get_template = $_POST['template_val'];

      $get_post_cat_arr = array();
      //Get the taxomomy
      if(!$get_cat_name)
      {
        $ajax_post_categories = get_terms( array(
          'hide_empty' => false,
          'taxonomy' => $get_tax_name
          ) 
        );

        foreach($ajax_post_categories as $ajax_post_category){
          array_push($get_post_cat_arr, $ajax_post_category->term_taxonomy_id);
        }
        
      }else{
        $get_post_cat_arr = $get_cat_name;
      }


      if(isset($_POST["category"]) && isset($_POST["category"])){
        $i = 1;
        $args = array(
            'post_type' => array( $get_post_type_name ),
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
                  'taxonomy' => $get_tax_name,
                  'field' => 'term_taxonomy_id',
                  'terms' => $get_post_cat_arr
              )
            )
        );
        $query = new WP_Query( $args );
        
        $post_count = 3;
        // echo "<div class=''>";
        if($get_template != ""):
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
              _e("Worng template Selected. Please check again");
            }
              
              $post_count++;
            endwhile;
          else :
              _e( 'Sorry, no posts were found.', 'textdomain' );
          endif;
        else:
          _e("No template Selected. Please select a template.");
        endif;
        die();
      }else{
        _e("jjjjjjjjj");
      }
      // echo "</div>";
    }

    function my_must_login() {
      echo _e("You must log in to vote");
      die();
    }