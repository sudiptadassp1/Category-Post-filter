<?php
   add_action( 'init', 'register_caf_post_type');
   function register_caf_post_type() {
    register_post_type( 'post_filter', array(
        'labels' => array(
            'name' => __( 'Post Filters', 'post_filters' ),
            'singular_name' => __( 'Post Filters', 'post_filter' ),
        ),
        'public'              => false,
            'hierarchical'        => false,
            'exclude_from_search' => true,
            'show_ui'             => current_user_can( 'manage_options' ) ? true : false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 7,
           'menu_icon'           =>'dashicons-palmtree',
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array(
                'title', 
            ),
    ));
}


function wpdocs_register_meta_boxes() {
    add_meta_box( 'meta-box-id', __( 'Select Post Type', 'cpc' ), 'wpdocs_my_display_callback', 'post_filter', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
 
function wpdocs_my_display_callback() {
    wp_nonce_field( plugins_url( '/function.php',__FILE__ ), 'wpse_our_nonce' );
    if(count(get_post_meta(get_the_ID())) > 0){
        $cptposttype = get_post_meta(get_the_ID())["cpc_post_podt_type"][0];
        $cpttaxonomy = get_post_meta(get_the_ID())["cpc_taxonomy"][0];
        $cpttemplatevalue = get_post_meta(get_the_ID())["temp"][0];
        echo "<input type='hidden' id='hidden_post_type_value' value='".$cptposttype."'>";
        echo "<input type='hidden' id='hidden_taxonomy_type_value' value='".$cpttaxonomy."'>";
        echo "<input type='hidden' id='hidden_template_value' value='".$cpttemplatevalue."'>";
    }
    
    ?>
    
    <!-- Taxonomy Dropdown -->
    <div class="row row_template">
        <div class="col-sm-12">
            <div class="post_typeform">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        // Get post type
                        $args = array(
                            'public'   => true
                        );
                        $post_output = 'objects';
                        $all_post_types = get_post_types( $args, $output );
                        
                        ?>
                        <h6>Select Type</h6>
                        <select name="cpc_post_podt_type" id="all_post_type" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'cpc_post_podt_type', true ) ); ?>">
                            <option value="">-- Select One --</option>
                            <?php
                                foreach($all_post_types as $all_post){
                                    _e("<option value='".$all_post->name."'>".$all_post->label."</option>");
                                }
                            ?>
                        </select> 
                    </div>
                    <div class="col-sm-6">
                        <?php                  
                        //Get taxonomy
                        $output = 'objects';
                        $taxonomies = get_taxonomies('', $output);
                        ?>
                        <h6>Select Taxonomy</h6>
                        <select name="cpc_taxonomy" id="root_tagonomy" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'cpc_taxonomy', true ) ); ?>">
                            <option value="">-- Select One --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select template block -->
    <h6>Select template:</h6>
    <from id="radio_button_group">
        <div class="row row_template choose_template_scene">
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="temp_1" name="temp">
                    <h6>Template 1</h6>
                    <img class="template_sample" src="<?php echo plugins_url('img/template1.png', __FILE__); ?>" alt="">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="temp_2" name="temp">
                    <h6>Template 2</h6>
                    <img class="template_sample" src="<?php echo plugins_url('img/template2.png', __FILE__); ?>" alt="">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="temp_3" name="temp">
                    <h6>Template 3</h6>
                    <img class="template_sample" src="<?php echo plugins_url('img/template3.png', __FILE__); ?>" alt="">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="temp_4" name="temp">
                    <h6>Template 4</h6>
                    <img class="template_sample" src="<?php echo plugins_url('img/template4.png', __FILE__); ?>" alt="">
                </div>
            </div>
        </div>
    </from>

    <!-- Generate Shortcode button -->
    <div class="row row_template">
        <div class="col-sm-12">
            <button type="button" class="btn btn-warning shortcode_gernerate_btn">Generate Shortcode</button>
        </div>
    </div>

    <!-- Shortcode placeholder -->
    <div class="row row_template">
        <div class="col-sm-12">
            <div class="">
                <h6>Shortcode</h6>
                <img class="post_ajax_loader" src="<?php echo plugins_url('img/post_type_loader.gif', __FILE__); ?>"/>
                <div class="shortcode_panel text-center">
                    <?php
                    if(count(get_post_meta(get_the_ID())) > 0){
                        // _e("<span class='shotcode_execute'>[get_category post_type='".$cptposttype."' taxonomy='".$cpttaxonomy."' template='".$cpttemplatevalue."']</span>");
                        _e("<span class='shotcode_execute'>[get_category id='".get_the_ID()."']</span>");
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    
}

function set_post_type_func(){
    $ajax_post_slug = $_REQUEST['post_slug'];
    $GLOBALS['postname'] = $ajax_post_slug;
    $variable = $GLOBALS['postname'];

    $taxonomy_objects = get_object_taxonomies( $variable, 'objects' );
    foreach($taxonomy_objects as $taxonomy_object){
        _e("<option value='".$taxonomy_object->name."'>".$taxonomy_object->label."</option>");
    }
    die();
}



function generate_shortcode_function(){
    $ajax_get_post_type = $_REQUEST['posts_slug'];
    $ajax_get_taxonomy = $_REQUEST['tax_slug'];
    $post_id_uri = $_REQUEST['uri_post_id'];
    $template_value = $_REQUEST['template_value'];
    

    _e("<span class='shotcode_execute'>[get_category post_type='".$post_id_uri."']</span>");

    die();
}





