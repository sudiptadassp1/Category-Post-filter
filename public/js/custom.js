function get_ajax_result(cat_slug, tax_slug, post_type_slug, template_value){
    jQuery.ajax({
        type : "post",
        url : my_ajax.ajax_url,
        data : {
            action: "get_test_custom_post", 
            category: cat_slug,
            taxonomy: tax_slug,
            post_type: post_type_slug,
            template_val: template_value
        },
        success: function(response) {
            jQuery('#after_ajax_req').empty();
            jQuery('#after_ajax_req').append(response);
        },
        error : function(error){ console.log(error) }
    }) 
}

jQuery(document).ready(function(){
    var cat_slug = jQuery('#c_cat').val();
    var taxonomy_slug = jQuery('#hidden_taxonomy_slug').val();
    var post_type_slug = jQuery('#hidden_post_slug').val();
    var template_value = jQuery('#hidden_template_value').val();
    console.log("template_value");
    get_ajax_result(cat_slug, taxonomy_slug, post_type_slug, template_value);
    jQuery('#c_cat').on('change', function(){
        var cat_slug = jQuery(this).val();
        // console.log(my_ajax.ajax_url);
        get_ajax_result(cat_slug, taxonomy_slug, post_type_slug, template_value);
    })
});


