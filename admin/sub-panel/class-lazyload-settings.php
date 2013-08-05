<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Dynamic Gallery Lazy Load Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WPSC_Dynamic_Gallery_LazyLoad_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'lazy_load_scroll'						=> 'yes',
			'transition_scroll_bar'					=> '#000000',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wpsc_dgallery_lazyload_settings';
		
		$default_settings = WPSC_Dynamic_Gallery_LazyLoad_Settings::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wpsc_dgallery_lazyload_settings;
		$wpsc_dgallery_lazyload_settings = WPSC_Dynamic_Gallery_LazyLoad_Settings::get_settings_default();
		
		return $wpsc_dgallery_lazyload_settings;
	}
	
	public static function save_settings_action() {
		$option_name = 'wpsc_dgallery_lazyload_settings';
		if ( isset($_REQUEST['wpsc-update-options']) && isset($_REQUEST[$option_name]) ) {
			WPSC_Dynamic_Gallery_LazyLoad_Settings::set_settings_default(true);
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			WPSC_Dynamic_Gallery_LazyLoad_Settings::set_settings_default(true);
		}
	}
	
	public static function panel_page() {
		$option_name = 'wpsc_dgallery_lazyload_settings';
		
		$customized_settings = $default_settings = WPSC_Dynamic_Gallery_LazyLoad_Settings::get_settings_default();
		
		extract($customized_settings);
		
		?>
        <h3><?php _e('Lazy-load scroll', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="lazy_load_scroll"><?php _e( 'Control', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" checked="checked" value="yes" id="lazy_load_scroll" name="<?php echo $option_name; ?>[lazy_load_scroll]" /> <span class=""><?php _e('Enable lazy-load scroll', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="transition_scroll_bar"><?php _e( 'Colour', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $transition_scroll_bar ) ); ?>" style="width:80px" id="transition_scroll_bar" name="<?php echo $option_name; ?>[transition_scroll_bar]" default-value="<?php echo $default_settings['transition_scroll_bar']; ?>" /> <span class="description"><?php _e('Scroll bar colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code><?php echo $default_settings['transition_scroll_bar']; ?></code></span>
            		<div id="colorPickerDiv_transition_scroll_bar" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>