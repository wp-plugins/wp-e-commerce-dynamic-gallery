jQuery(window).load(function(){
	// Color picker
	jQuery('.colorpick').each(function(){
		jQuery('.colorpickdiv', jQuery(this).parent()).farbtastic(this);
		jQuery(this).live('click',function() {
			if ( jQuery(this).val() == "" ) jQuery(this).val('#');
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
	jQuery("a.nav-tab").click(function(){
		if(jQuery(this).attr('data-tab-id') == 'gallery_settings'){
			window.location.href=jQuery(this).attr('href');
			return false;
		}
	});
});