<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Dynamic Gallery Navbar Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WPSC_Dynamic_Gallery_Navbar_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'product_gallery_nav'					=> 'yes',
			'navbar_font'							=> 'Arial, sans-serif',
			'navbar_font_size'						=> '12px',
			'navbar_font_style'						=> 'bold',
			'bg_nav_text_color'						=> '#000000',
			'bg_nav_color'							=> '#FFFFFF',
			'navbar_height'							=>  25,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wpsc_dgallery_navbar_settings';
		
		$default_settings = WPSC_Dynamic_Gallery_Navbar_Settings::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpsc_dgallery_navbar_settings;
		$wpsc_dgallery_navbar_settings = WPSC_Dynamic_Gallery_Navbar_Settings::get_settings_default();
		
		return $wpsc_dgallery_navbar_settings;
	}
	
	public static function save_settings_action() {
		$option_name = 'wpsc_dgallery_navbar_settings';
		if ( isset($_REQUEST['wpsc-update-options']) && isset($_REQUEST[$option_name]) ) {
			WPSC_Dynamic_Gallery_Navbar_Settings::set_settings_default(true);
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			WPSC_Dynamic_Gallery_Navbar_Settings::set_settings_default(true);
		}
	}
	
	public static function panel_page() {
		$option_name = 'wpsc_dgallery_navbar_settings';
		
		$customized_settings = $default_settings = WPSC_Dynamic_Gallery_Navbar_Settings::get_settings_default();
		
		extract($customized_settings);
		
		$fonts = WPSC_Dynamic_Gallery_Functions::get_font();
		$font_sizes = WPSC_Dynamic_Gallery_Functions::get_font_sizes();
		?>
        <h3><?php _e('Nav Bar', 'wpsc_dgallery'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo WPSC_DYNAMIC_GALLERY_DOCS_URI;?>#section-7" ><?php _e('View Docs', 'wpsc_dgallery'); ?></a></h3>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="product_gallery_nav"><?php _e( 'Control', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" checked="checked" value="yes" id="product_gallery_nav" name="<?php echo $option_name; ?>[product_gallery_nav]" /> <span class=""><?php _e('Enable Nav bar Control', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="navbar_font"><?php _e( 'Font', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[navbar_font]" id="navbar_font" style="width:160px;">
                    	<?php foreach ( $fonts as $key => $value ) { ?>
                        <option <?php selected( htmlspecialchars( $navbar_font ), htmlspecialchars($key) ); ?> value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option>
						<?php } ?>
                    </select>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row"><label for="navbar_font_size"><?php _e('Font size', 'wpsc_dgallery');?></label></th>
				<td>
                	<select class="chzn-select" name="<?php echo $option_name; ?>[navbar_font_size]" id="navbar_font_size" style="width:100px;">
                    	<?php foreach ( $font_sizes as $key => $value ) { ?>
                        <option <?php selected( $navbar_font_size, $value ); ?> value='<?php echo $value; ?>'><?php echo $value; ?></option>
						<?php } ?>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="navbar_font_style"><?php _e( 'Font style', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[navbar_font_style]" id="navbar_font_style" style="width:100px;">
                    	<option <?php selected( $navbar_font_style, 'normal' ); ?> value="normal"><?php _e('Normal', 'wpsc_dgallery');?></option>
						<option <?php selected( $navbar_font_style, 'italic' ); ?> value="italic"><?php _e('Italic', 'wpsc_dgallery');?></option>
              			<option <?php selected( $navbar_font_style, 'bold' ); ?> value="bold"><?php _e('Bold', 'wpsc_dgallery');?></option>
              			<option <?php selected( $navbar_font_style, 'bold_italic' ); ?> value="bold_italic"><?php _e('Bold/Italic', 'wpsc_dgallery');?></option>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="bg_nav_text_color"><?php _e( 'Font colour', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $bg_nav_text_color ) ); ?>" style="width:80px" id="bg_nav_text_color" name="<?php echo $option_name; ?>[bg_nav_text_color]" default-value="<?php echo $default_settings['bg_nav_text_color']; ?>" /> <span class="description"><?php _e('Nav bar text color.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code><?php echo $default_settings['bg_nav_text_color']; ?></code></span>
            		<div id="colorPickerDiv_bg_nav_text_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="bg_nav_color"><?php _e( 'Background', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $bg_nav_color ) ); ?>" style="width:80px" id="bg_nav_color" name="<?php echo $option_name; ?>[bg_nav_color]" default-value="<?php echo $default_settings['bg_nav_color']; ?>" /> <span class="description"><?php _e('Nav bar background colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code><?php echo $default_settings['bg_nav_color']; ?></code></span>
            		<div id="colorPickerDiv_bg_nav_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="navbar_height"><?php _e( 'Container height', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $navbar_height ) ); ?>" style="width:80px" id="navbar_height" name="<?php echo $option_name; ?>[navbar_height]"> <span class="description">px</span>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>