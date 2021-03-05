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

function generate_shortcode(posts_slug, tax_slug, uri_post_id){
    jQuery.ajax({
        type : "post",
        url : post_ajax.ajax_url,
        data : {
            action: "generate_shortcode", 
            posts_slug: posts_slug,
            tax_slug: tax_slug,
            uri_post_id: uri_post_id
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

    //Generate shortcode
    jQuery('.shortcode_gernerate_btn').on('click', function(){
        var uri_post_id = jQuery('#post_ID').val();
        var posts_slug = jQuery('#all_post_type').val();
        var tax_slug = jQuery('#root_tagonomy').val();
        generate_shortcode(posts_slug, tax_slug, uri_post_id);
    });
});