jQuery(window).load(function(){
	// Color picker
	jQuery('.colorpick').each(function(){
		jQuery('.colorpickdiv', jQuery(this).parent()).farbtastic(this);
		jQuery(this).live('click',function() {
			if ( jQuery(this).attr('id') == "bg_image_wrapper" && jQuery(this).val() == "" ) jQuery(this).val('#FFFFFF');
			else if ( jQuery(this).attr('id') == "border_image_wrapper_color" && jQuery(this).val() == "" ) jQuery(this).val('#CCCCCC');
			else if ( jQuery(this).attr('id') == "product_gallery_text_color" && jQuery(this).val() == "" ) jQuery(this).val('#FFFFFF');
			else if ( jQuery(this).attr('id') == "product_gallery_bg_des" && jQuery(this).val() == "" ) jQuery(this).val('#226fd8');
			else if ( jQuery(this).attr('id') == "bg_nav_text_color" && jQuery(this).val() == "" ) jQuery(this).val('#000000');
			else if ( jQuery(this).attr('id') == "transition_scroll_bar" && jQuery(this).val() == "" ) jQuery(this).val('#226fd8');
			else if ( jQuery(this).attr('id') == "bg_nav_color" && jQuery(this).val() == "" ) jQuery(this).val('#226fd8');
			else if ( jQuery(this).val() == "" ) jQuery(this).val('#FFFFFF');
			jQuery('.colorpickdiv', jQuery(this).parent() ).show();
		});	
	});
	jQuery(document).mousedown(function(){
		jQuery('.colorpickdiv').hide();
	});
	jQuery('.preview_allery').live('click',function(){
		var url = jQuery(this).attr("href");
		var data = jQuery('#wpsc-settings-form').serialize();
		tb_show('Dynamic gallery preview', url+'&'+data+'&width=700&action=wpsc_dynamic_gallery&KeepThis=false');
		return false;
	});
});
