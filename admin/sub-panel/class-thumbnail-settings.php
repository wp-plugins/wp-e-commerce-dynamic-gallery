<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Dynamic Gallery Thumbnail Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WPSC_Dynamic_Gallery_Thumbnail_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'enable_gallery_thumb'					=> 'yes',
			'hide_thumb_1image'						=> 'no',
			'thumb_width'							=> 105,
			'thumb_height'							=> 75,
			'thumb_spacing'							=> 2,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wpsc_dgallery_thumbnail_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WPSC_Dynamic_Gallery_Thumbnail_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['thumb_width']);
		unset($free_default_settings['thumb_height']);
		unset($free_default_settings['thumb_spacing']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpsc_dgallery_thumbnail_settings;
		$customized_settings = get_option('wpsc_dgallery_thumbnail_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WPSC_Dynamic_Gallery_Thumbnail_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wpsc_dgallery_thumbnail_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function save_settings_action() {
		$option_name = 'wpsc_dgallery_thumbnail_settings';
		if ( isset($_REQUEST['wpsc-update-options']) && isset($_REQUEST[$option_name]) ) {
			$customized_settings = $_REQUEST[$option_name];		
			
			update_option($option_name, $customized_settings);
			WPSC_Dynamic_Gallery_Thumbnail_Settings::set_settings_default();
			
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			WPSC_Dynamic_Gallery_Thumbnail_Settings::set_settings_default(true);
		}
	}
	
	public static function panel_page() {
		$option_name = 'wpsc_dgallery_thumbnail_settings';
		
		$customized_settings = get_option($option_name);
		$default_settings = WPSC_Dynamic_Gallery_Thumbnail_Settings::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		?>
        <h3><?php _e('Image Thumbnails', 'wpsc_dgallery'); ?></h3>
        <div class="pro_feature_fields">
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="enable_gallery_thumb"><?php _e( 'Show thumbnails', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" checked="checked" value="yes" id="enable_gallery_thumb" name="<?php echo $option_name; ?>[enable_gallery_thumb]" /> <span class=""><?php _e('Enable thumbnail gallery', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="hide_thumb_1image"><?php _e( 'Single Image Thumbnail', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="hide_thumb_1image" name="<?php echo $option_name; ?>[hide_thumb_1image]" /> <span class=""><?php _e('Check to hide thumbnail when only 1 image is loaded to gallery.', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
		</table>
        </div>
        
        <table class="form-table">            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="thumb_width"><?php _e( 'Thumbnail width', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" value="<?php esc_attr_e( stripslashes( $thumb_width ) ); ?>" style="width:80px" id="thumb_width" name="<?php echo $option_name; ?>[thumb_width]"> <span class="description">px. <?php _e( 'Setting 0px will show at default 105px. Hiding thumbnails is a Pro Version feature.', 'wpsc_dgallery' ); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="thumb_height"><?php _e( 'Thumbnail height', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" value="<?php esc_attr_e( stripslashes( $thumb_height ) ); ?>" style="width:80px" id="thumb_height" name="<?php echo $option_name; ?>[thumb_height]"> <span class="description">px. <?php _e( 'Setting 0px will show at default 75px. Hiding thumbnails is a Pro Version feature.', 'wpsc_dgallery' ); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="thumb_spacing"><?php _e( 'Thumbnail width', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" value="<?php esc_attr_e( stripslashes( $thumb_spacing ) ); ?>" style="width:80px" id="thumb_spacing" name="<?php echo $option_name; ?>[thumb_spacing]"> <span class="description">px</span>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>