<?php
/**
 * WPSC_Settings_Tab_Gallery_Settings Class
 *
 * Class Function into WP e-Commerce plugin
 *
 * Table Of Contents
 *
 * is_submit_button_displayed()
 * is_update_message_displayed()
 * display()
 * update_settings()
 */
class WPSC_Settings_Tab_Gallery_Settings {
	
	public function is_submit_button_displayed() {
		return true;
	}
	public function is_update_message_displayed() {
		if(isset($_REQUEST['wpsc-update-options'])){
			WPSC_Dynamic_Gallery_Container_Settings::save_settings_action();
			WPSC_Dynamic_Gallery_Global_Settings::save_settings_action();
			WPSC_Dynamic_Gallery_Caption_Settings::save_settings_action();
			WPSC_Dynamic_Gallery_Navbar_Settings::save_settings_action();
			WPSC_Dynamic_Gallery_LazyLoad_Settings::save_settings_action();
			WPSC_Dynamic_Gallery_Thumbnail_Settings::save_settings_action();
			if ( isset($_REQUEST['subtab']) )
				update_option('wpsc_dgallery_current_subtab', $_REQUEST['subtab']);
		}
		
		return true;
	}
	
	public function display() {
		global $wpdb;
		
		$current_subtab = get_option('wpsc_dgallery_current_subtab', '');
		delete_option('wpsc_dgallery_current_subtab');
		
		// Include script for dashboard
		add_action('admin_footer', array('WPSC_Dynamic_Gallery_Hook_Filter', 'wpsc_dynamic_gallery_add_script') );
		
		?>
        <style type="text/css">
		.code, code{font-family:inherit;font-size:inherit;}
		.form-table{margin:0px; border-collapse:separate;}
		.description{font-family: sans-serif;font-size: 12px;font-style: italic;color:#666666;}
		.subsubsub { white-space:normal;}
		.subsubsub li { white-space:nowrap;}
		input.colorpick{text-transform:uppercase;}
		img.help_tip{float: right; margin: 0 -10px 0 0;}
		#a3_plugin_panel_container { position:relative; margin-top:10px;}
		#a3_plugin_panel_fields {width:65%; float:left;}
		#a3_plugin_panel_upgrade_area { position:relative; margin-left: 65%; padding-left:10px;}
		#a3_plugin_panel_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3 { margin:8px 5px; }
		.pro_feature_fields p { margin-left:5px; }
		.pro_feature_fields  .form-table td, .pro_feature_fields .form-table th { padding:8px 10px; }
        </style>
        <div id="a3_plugin_panel_container">
    	<div id="a3_plugin_panel_fields" class="a3_subsubsub_section">
            <ul class="subsubsub">
            	<li><a href="#gallery-settings" class="current"><?php _e('Gallery', 'wpsc_dgallery'); ?></a> | </li>
            	<li><a href="#global-settings"><?php _e('Global Settings', 'wpsc_dgallery'); ?></a> | </li>
                <li><a href="#caption-text"><?php _e('Caption text', 'wpsc_dgallery'); ?></a> | </li>
                <li><a href="#nav-bar"><?php _e('Nav Bar', 'wpsc_dgallery'); ?></a> | </li>
                <li><a href="#lazy-load-scroll"><?php _e('Lazy-load scroll', 'wpsc_dgallery'); ?></a> | </li>
                <li><a href="#image-thumbnails"><?php _e('Image Thumbnails', 'wpsc_dgallery'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="gallery-settings">
            	<?php echo WPSC_Dynamic_Gallery_Container_Settings::panel_page(); ?>
            </div>
            <div class="section" id="global-settings">
            	<?php echo WPSC_Dynamic_Gallery_Global_Settings::panel_page(); ?>
            </div>
            <div class="section" id="caption-text">
            	<div class="pro_feature_fields">
            	<?php echo WPSC_Dynamic_Gallery_Caption_Settings::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="nav-bar">
            	<div class="pro_feature_fields">
            	<?php echo WPSC_Dynamic_Gallery_Navbar_Settings::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="lazy-load-scroll">
            	<div class="pro_feature_fields">
            	<?php echo WPSC_Dynamic_Gallery_LazyLoad_Settings::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="image-thumbnails">
            	<?php echo WPSC_Dynamic_Gallery_Thumbnail_Settings::panel_page(); ?>
            </div>
            <input type="hidden" id="last_tab" name="subtab" />
		</div>
        <div id="a3_plugin_panel_upgrade_area"><?php echo WPSC_Dynamic_Gallery_Functions::plugin_pro_notice(); ?></div>
    	</div>
    	<div style="clear:both;"></div>
<script type="text/javascript">
	jQuery(window).load(function(){
		// Subsubsub tabs
		jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
		jQuery('div.a3_subsubsub_section .section:gt(0)').hide();

		jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
			var $clicked = jQuery(this);
			var $section = $clicked.closest('.a3_subsubsub_section');
			var $target  = $clicked.attr('href');

			$section.find('a').removeClass('current');

			if ( $section.find('.section:visible').size() > 0 ) {
				$section.find('.section:visible').fadeOut( 100, function() {
					$section.find( $target ).fadeIn('fast');
				});
			} else {
				$section.find( $target ).fadeIn('fast');
			}

			$clicked.addClass('current');
			jQuery('#last_tab').val( $target );
	
			return false;
		});

	<?php if ( $current_subtab != '') echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href='.$current_subtab.']").click();'; ?>
	});
	
	(function($){
		$(function(){
			// Color picker
			$('.colorpick').each(function(){
				$('.colorpickdiv', $(this).parent()).farbtastic(this);
				$(this).click(function() {
					var default_value = $(this).attr('default-value');
					if ( $(this).val() == "" ) $(this).val( default_value );
					$('.colorpickdiv', $(this).parent() ).show();
				});	
			});
			$(document).mousedown(function(){
				$('.colorpickdiv').hide();
			});
		});
	})(jQuery);
</script>		
		<?php
	}
}
?>