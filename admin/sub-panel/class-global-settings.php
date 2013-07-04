<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WPEC Dynamic Gallery Global Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WPSC_Dynamic_Gallery_Global_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'popup_gallery'							=> 'fb',
			'dgallery_activate'						=> 'yes',
			'dgallery_show_variation'				=> 'yes',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wpsc_dgallery_global_settings';
		
		$default_settings = WPSC_Dynamic_Gallery_Global_Settings::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
			update_option('wpsc_dgallery_clean_on_deletion', 'no');
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[WPSC_DYNAMIC_GALLERY_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		} else {
			update_option($option_name, $default_settings);
			if ( get_option('wpsc_dgallery_clean_on_deletion', '') == '') {
				update_option('wpsc_dgallery_clean_on_deletion', 'no');
			}
		}
				
	}
	
	public static function get_settings() {
		global $wpsc_dgallery_global_settings;
		$wpsc_dgallery_global_settings = WPSC_Dynamic_Gallery_Global_Settings::get_settings_default();
		
		return $wpsc_dgallery_global_settings;
	}
	
	public static function save_settings_action() {
		$option_name = 'wpsc_dgallery_global_settings';
		if (isset($_REQUEST['wpsc-update-options'])) {
			WPSC_Dynamic_Gallery_Global_Settings::set_settings_default(true);
			
			if ( isset($_REQUEST['wpsc_dgallery_clean_on_deletion']) ) {
				update_option('wpsc_dgallery_clean_on_deletion', $_REQUEST['wpsc_dgallery_clean_on_deletion']);
			} else { 
				update_option('wpsc_dgallery_clean_on_deletion', 'no');
				$uninstallable_plugins = (array) get_option('uninstall_plugins');
				unset($uninstallable_plugins[WPSC_DYNAMIC_GALLERY_NAME]);
				update_option('uninstall_plugins', $uninstallable_plugins);
			}
				
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			WPSC_Dynamic_Gallery_Global_Settings::set_settings_default(true);
		}
	}
	
	public static function panel_page() {
		$option_name = 'wpsc_dgallery_global_settings';
		
		$customized_settings = $default_settings = WPSC_Dynamic_Gallery_Global_Settings::get_settings_default();
		
		extract($customized_settings);
		
		?>
        <div class="pro_feature_fields">
        <h3><?php _e('Image Zoom Function', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="popup_gallery"><?php _e( 'Gallery popup', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[popup_gallery]" id="popup_gallery" style="width:120px;">
                    	<option <?php selected( $popup_gallery, 'fb' ); ?> value="fb"><?php _e('Fancybox', 'wpsc_dgallery');?></option>
                		<option <?php selected( $popup_gallery, 'lb' ); ?>  value="lb"><?php _e('Lightbox', 'wpsc_dgallery');?></option>
                		<option <?php selected( $popup_gallery, 'deactivate' ); ?>  value="deactivate"><?php _e('Deactivate', 'wpsc_dgallery');?></option>
                    </select>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Gallery On / Off', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="dgallery_activate"><?php _e( 'Gallery Activation Default', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" checked="checked" value="yes" id="dgallery_activate" name="<?php echo $option_name; ?>[dgallery_activate]" /> <span class=""><?php _e('Checked = Gallery Activated on Product Pages. Unchecked = Deactivated. Note: Changing this setting will not over-ride any custom Gallery activation settings made on single product pages.', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wpsc_dgallery_reset_galleries_activate"><?php _e( 'Reset Activation to default', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wpsc_dgallery_reset_galleries_activate" name="wpsc_dgallery_reset_galleries_activate" /> <span class=""><?php _e("Checked this box and 'Save Changes' to reset ALL products to the default 'Gallery Activation' status you set above including ALL individual custom Product Page Gallery activation settings.", 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Image Variation Feature', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="dgallery_show_variation"><?php _e( 'Variations Activation Default', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="dgallery_show_variation" name="<?php echo $option_name; ?>[dgallery_show_variation]" /> <span class=""><?php _e('Checked = Variation Images Activated on Product Pages. Unchecked = Deactivated. Note: Changing this setting will not over-ride any custom Variation Images activation settings made on single product pages.', 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wpsc_dgallery_reset_variation_activate"><?php _e( 'Reset Activation to default', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wpsc_dgallery_reset_variation_activate" name="wpsc_dgallery_reset_variation_activate" /> <span class=""><?php _e("Checked this box and 'Save Changes' to reset ALL products to the default 'Variations Activation' status you set above. NOTE: ALL individual custom Product Page Variation Images Activation settings will be changed to the default.", 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
		</table>
        </div>
        
        <h3><?php _e('House Keeping', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wpsc_dgallery_clean_on_deletion"><?php _e( 'Clean up on Deletion', 'wpsc_dgallery' );?></label></th>
		    	<td class="forminp">
                	<label><input type="checkbox" <?php checked( get_option('wpsc_dgallery_clean_on_deletion'), 'yes'); ?> value="yes" id="wpsc_dgallery_clean_on_deletion" name="wpsc_dgallery_clean_on_deletion" /> <span class=""><?php _e("Check this box and if you ever delete this plugin it will completely remove all of its code and tables it has created, leaving no trace it was ever here. It will not delete your product images! <strong>WARNING</strong> All of the gallery settings you have made will be deleted forever. If you ever reinstall the gallery you will have to reset them all.", 'wpsc_dgallery');?></span></label>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>