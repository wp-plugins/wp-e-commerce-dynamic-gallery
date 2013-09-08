<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Dynamic Gallery Container Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WPSC_Dynamic_Gallery_Container_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'product_gallery_width'					=> '320',
			'width_type'							=> 'px',
			'product_gallery_height'				=> '215',
			'product_gallery_auto_start'			=> 'true',
			'product_gallery_speed'					=> 4,
			'product_gallery_effect'				=> 'slide-vert',
			'product_gallery_animation_speed'		=> 2,
			'stop_scroll_1image'					=> 'no',
			'bg_image_wrapper'						=> '#FFFFFF',
			'border_image_wrapper_color'			=> '#CCCCCC',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wpsc_dgallery_container_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WPSC_Dynamic_Gallery_Container_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['product_gallery_width']);
		unset($free_default_settings['product_gallery_height']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpsc_dgallery_container_settings;
		$customized_settings = get_option('wpsc_dgallery_container_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WPSC_Dynamic_Gallery_Container_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wpsc_dgallery_container_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function save_settings_action() {
		$option_name = 'wpsc_dgallery_container_settings';
		if ( isset($_REQUEST['wpsc-update-options']) && isset($_REQUEST[$option_name]) ) {
			$customized_settings = $_REQUEST[$option_name];
						
			update_option($option_name, $customized_settings);
			WPSC_Dynamic_Gallery_Container_Settings::set_settings_default();
			
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			WPSC_Dynamic_Gallery_Container_Settings::set_settings_default(true);
		}
	}
	
	public static function panel_page() {
		$option_name = 'wpsc_dgallery_container_settings';
		
		$customized_settings = get_option($option_name);
		$default_settings = WPSC_Dynamic_Gallery_Container_Settings::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		$wpsc_dynamic_gallery = wp_create_nonce("wpsc_dynamic_gallery");
		?>
        <h3><?php _e('Preview', 'wpsc_dgallery'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo WPSC_DYNAMIC_GALLERY_DOCS_URI;?>#section-10" ><?php _e('View Docs', 'wpsc_dgallery'); ?></a></h3>
		<p><a href="<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>?security=<?php echo $wpsc_dynamic_gallery;?>" class="preview_gallery"><?php _e('Click here to preview gallery', 'wpsc_dgallery');?></a></p>
        
        <h3><?php _e('Gallery Dimensions', 'wpsc_dgallery'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo WPSC_DYNAMIC_GALLERY_DOCS_URI;?>#section-5" ><?php _e('View Docs', 'wpsc_dgallery'); ?></a></h3>
		<table class="form-table">
        	<tr valign="top">
				<th scope="row"><label for="product_gallery_width"><?php _e('Gallery width', 'wpsc_dgallery');?></label></th>
				<td>
					<input type="text" value="<?php esc_attr_e( stripslashes( $product_gallery_width ) ); ?>" style="float: left; margin-right: 10px; width: 80px;" id="product_gallery_width" name="<?php echo $option_name; ?>[product_gallery_width]">
                    <select class="chzn-select" name="<?php echo $option_name; ?>[width_type]" id="width_type" style="width:80px;">
                    	<option <?php selected( $width_type, 'px' ); ?> value="px">px</option>
                		<option <?php selected( $width_type, '%' ); ?>  value="%">%</option>
                    </select> <span class="description"><?php _e("Set at 100 and choose % to activate responsive gallery (Pro version feature)", 'wpsc_dgallery'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="product_gallery_height"><?php _e('Gallery height', 'wpsc_dgallery');?></label></th>
				<td>
                	<input type="text" value="<?php esc_attr_e( stripslashes( $product_gallery_height ) ); ?>" style="width:80px" id="product_gallery_height" name="<?php echo $option_name; ?>[product_gallery_height]"> <span class="description">px</span>
				</td>
			</tr>
		</table>
        
        <div class="pro_feature_fields">
        <h3><?php _e('Gallery Special Effects', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="product_gallery_auto_start"><?php _e( 'Auto start', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[product_gallery_auto_start]" id="product_gallery_auto_start" style="width:100px;">
                    	<option <?php selected( $product_gallery_auto_start, 'false' ); ?> value="false"><?php _e('False', 'wpsc_dgallery');?></option>
                		<option <?php selected( $product_gallery_auto_start, 'true' ); ?> value="true"><?php _e('True', 'wpsc_dgallery');?></option>
                    </select>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row"><label for="product_gallery_speed"><?php _e('Time between transitions', 'wpsc_dgallery');?></label></th>
				<td>
                	<input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $product_gallery_speed ) ); ?>" style="width:80px" id="product_gallery_speed" name="<?php echo $option_name; ?>[product_gallery_speed]"> <span class="description"><?php _e('seconds', 'wpsc_dgallery'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="product_gallery_effect"><?php _e( 'Slide transition effect', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[product_gallery_effect]" id="product_gallery_effect" style="width:100px;">
                    	<option <?php selected( $product_gallery_effect, 'none' ); ?> value="none"><?php _e('None', 'wpsc_dgallery');?></option>
              			<option <?php selected( $product_gallery_effect, 'fade' ); ?> value="fade"><?php _e('Fade', 'wpsc_dgallery');?></option>
            			<option <?php selected( $product_gallery_effect, 'slide-hori' ); ?> value="slide-hori"><?php _e('Slide Hori', 'wpsc_dgallery');?></option>
            			<option <?php selected( $product_gallery_effect, 'slide-vert' ); ?> value="slide-vert"><?php _e('Slide vert', 'wpsc_dgallery');?></option>
           				<option <?php selected( $product_gallery_effect, 'resize' ); ?> value="resize"><?php _e('Resize', 'wpsc_dgallery');?></option>
                    </select>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row"><label for="product_gallery_animation_speed"><?php _e('Transition effect speed', 'wpsc_dgallery');?></label></th>
				<td>
                	<select class="chzn-select" name="<?php echo $option_name; ?>[product_gallery_animation_speed]" id="product_gallery_animation_speed" style="width:100px;">
                    <?php for( $i = 1; $i <= 10 ; $i++ ) { ?>
					<option <?php selected( $product_gallery_animation_speed, $i ); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
                    </select>
                    <span class="description"><?php _e('seconds', 'wpsc_dgallery'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="stop_scroll_1image"><?php _e( 'Single Image Transition', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" <?php checked($stop_scroll_1image, 'yes'); ?> value="yes" id="stop_scroll_1image" name="<?php echo $option_name; ?>[stop_scroll_1image]" /> <span class=""><?php _e('Check to auto deactivate image transition effect when only 1 image is loaded to gallery.', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Gallery Style', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="bg_image_wrapper"><?php _e( 'Image background colour', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $bg_image_wrapper ) ); ?>" style="width:80px" id="bg_image_wrapper" name="<?php echo $option_name; ?>[bg_image_wrapper]" default-value="<?php echo $default_settings['bg_image_wrapper']; ?>" /> <span class="description"><?php _e('Gallery image background colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code><?php echo $default_settings['bg_image_wrapper']; ?></code></span>
            		<div id="colorPickerDiv_bg_image_wrapper" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="border_image_wrapper_color"><?php _e( 'Border colour', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $border_image_wrapper_color ) ); ?>" style="width:80px" id="border_image_wrapper_color" name="<?php echo $option_name; ?>[border_image_wrapper_color]" default-value="<?php echo $default_settings['border_image_wrapper_color']; ?>" /> <span class="description"><?php _e('Gallery border colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code><?php echo $default_settings['border_image_wrapper_color']; ?></code></span>
            		<div id="colorPickerDiv_border_image_wrapper_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
		</table>
        </div>
	<?php
	}
}
?>