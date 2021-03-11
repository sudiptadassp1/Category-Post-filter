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
    <div class="row row_template choose_template_scene">
        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="template_1">
                <h6>Template 1</h6>
                <img class="template_sample" src="<?php echo plugins_url('img/template1.png', __FILE__); ?>" alt="">
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="template_2">
                <h6>Template 2</h6>
                <img class="template_sample" src="<?php echo plugins_url('img/template2.png', __FILE__); ?>" alt="">
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="template_3">
                <h6>Template 3</h6>
                <img class="template_sample" src="<?php echo plugins_url('img/template3.png', __FILE__); ?>" alt="">
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="template_4">
                <h6>Template 4</h6>
                <img class="template_sample" src="<?php echo plugins_url('img/template4.png', __FILE__); ?>" alt="">
            </div>
        </div>
    </div>

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
                    $get_post_id = get_the_ID();
                        global $wpdb;
                            // echo "<pre>";
                        $result = $wpdb->get_results ( "SELECT * FROM `wp_cpc_shortcode_property` where post_id=$get_post_id" );
                        foreach($result as $results){
                            // print_r($results);
                            _e("<span class='shotcode_execute'>[get_category post_type='".$results->post_slug."' taxonomy='".$results->category_slug."']</span>");
                        }   
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout Template -->
    <div class="row">
    <h6>Select Template:</h6>
        
    </table>
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
    $post_id_url = $_REQUEST['uri_post_id'];
    $post_author_link = $_REQUEST['post author_link'];
    
    // $GLOBALS['ajax_post_slug'] = $ajax_get_post_type;
    // $GLOBALS['ajax_taxonomy'] = $ajax_get_taxonomy;

    global $wpdb;
    $tablename = $wpdb->prefix.'cpc_shortcode_property';

    $data = array(
        'post_id' => $post_id_url,
        'post_slug' => $ajax_get_post_type,
        'category_slug' => $ajax_get_taxonomy,
    );

    $wpdb->insert( $tablename, $data);

    _e("<span class='shotcode_execute'>[get_category post_type='".$ajax_get_post_type."' taxonomy='".$ajax_get_taxonomy."']</span>");

    die();
}





