function get_ajax_result_for_post(post_slug){
    jQuery.ajax({
        type : "post",
        url : post_ajax.ajax_url,
        data : {
            action: "set_post_type", 
            post_slug: post_slug
        },
        success: function(response) {
            jQuery('#root_tagonomy').empty();
            jQuery('#root_tagonomy').append(response);
        },
        error : function(error){ console.log(error) }
    }) 
}

function generate_shortcode(posts_slug, tax_slug, uri_post_id, template_val){
    jQuery.ajax({
        type : "post",
        url : post_ajax.ajax_url,
        data : {
            action: "generate_shortcode", 
            posts_slug: posts_slug,
            tax_slug: tax_slug,
            uri_post_id: uri_post_id,
            template_value: template_val
        },
        beforeSend: function(){
            jQuery('img.post_ajax_loader').show();
        },
        complete: function(){
            jQuery('img.post_ajax_loader').hide();
        },
        success: function(response) {
            jQuery('.shortcode_panel').empty();
            jQuery('.shortcode_panel').append(response);
        },
        error : function(error){ console.log(error) }
    }) 
}



jQuery(document).ready(function(){
    // Get Taxonomy by post
    jQuery('#all_post_type').on('change', function(){
        var post_slug = jQuery(this).val();
        get_ajax_result_for_post(post_slug);
    })

    //Get Template value
    var template_value;
    jQuery("#radio_button_group .form-check-input").on('click', function(){
        template_value = jQuery(this).val(); 
     });

    //Generate shortcode
    jQuery('.shortcode_gernerate_btn').on('click', function(){
        var uri_post_id = jQuery('#post_ID').val();
        var posts_slug = jQuery('#all_post_type').val();
        var tax_slug = jQuery('#root_tagonomy').val();
        var template_val = template_value;
        generate_shortcode(posts_slug, tax_slug, uri_post_id, template_val);
    });

    var hidden_post_type = jQuery('#hidden_post_type_value').val();
    var hidden_taxonomy_type = jQuery('#hidden_taxonomy_type_value').val();
    var hidden_template_type = jQuery('#hidden_template_value').val();
    

    // Select post type
    jQuery('#all_post_type option').each(function(i, option){
        if(option.value == hidden_post_type){
            option.selected = "selected";
                jQuery("#all_post_type").change();
        }
    });

    //Select Taxonomy type
    jQuery('#root_tagonomy option').each(function(i, option){
        if(option.value == hidden_taxonomy_type){
            option.selected = "selected";
                jQuery("#root_tagonomy").change();
        }
    });   

    // Select template type
    jQuery('input.form-check-input').each(function(i, input){
        if(input.value == hidden_template_type){
            input.checked = "checked";
        }
    });
});