<?php
/**
 * WPSC_Settings_Tab_Gallery_Settings Class
 *
 * Class Function into WP e-Commerce plugin
 *
 * Table Of Contents
 *
 * fonts
 * wpsc_dynamic_gallery_set_setting()
 * is_submit_button_displayed()
 * is_update_message_displayed()
 * display()
 * update_settings()
 */
class WPSC_Settings_Tab_Gallery_Settings {
	
	private $fonts = array( 
					'Arial, sans-serif' => 'Arial',
					'Verdana, Geneva, sans-serif'		=> 'Verdana',
					'&quot;Trebuchet MS&quot;, Tahoma, sans-serif'		=> 'Trebuchet',
					'Georgia, serif'		=> 'Georgia',
					'&quot;Times New Roman&quot;, serif'		=> 'Times New Roman',
					'Tahoma, Geneva, Verdana, sans-serif'		=> 'Tahoma',
					'Palatino, &quot;Palatino Linotype&quot;, serif'		=> 'Palatino',
					'&quot;Helvetica Neue&quot;, Helvetica, sans-serif'		=> 'Helvetica*',
					'Calibri, Candara, Segoe, Optima, sans-serif'		=> 'Calibri*',
					'&quot;Myriad Pro&quot;, Myriad, sans-serif'		=> 'Myriad Pro*',
					'&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, sans-serif'		=> 'Lucida',
					'&quot;Arial Black&quot;, sans-serif'		=> 'Arial Black',
					'&quot;Gill Sans&quot;, &quot;Gill Sans MT&quot;, Calibri, sans-serif'		=> 'Gill Sans*',
					'Geneva, Tahoma, Verdana, sans-serif'		=> 'Geneva*',
					'Impact, Charcoal, sans-serif'		=> 'Impact',
					'Courier, &quot;Courier New&quot;, monospace'		=> 'Courier',
					'&quot;Century Gothic&quot;, sans-serif'		=> 'Century Gothic'
					);
					
	public function wpsc_dynamic_gallery_set_setting($reset=false, $free_version=false){
		global $wpdb;
		if( ( trim(get_option('product_gallery_width')) == '' || $reset) && !$free_version){
			update_option('product_gallery_width','320');
		}
		if( (trim(get_option('product_gallery_height')) == '' || $reset) && !$free_version ){
			update_option('product_gallery_height',215);
		}
		if( (trim(get_option('thumb_width')) == '' || $reset) && !$free_version){
			update_option('thumb_width',105);
		}
		if( (trim(get_option('thumb_height')) == '' || $reset) && !$free_version){
			update_option('thumb_height',75);
		}
		if( (trim(get_option('thumb_spacing')) == '' || $reset) && !$free_version){
			update_option('thumb_spacing',2);
		}

		if( trim(get_option('product_gallery_speed')) == '' || $reset ){
			update_option('product_gallery_speed',5);
		}
		if( trim(get_option('product_gallery_effect')) == '' || $reset ){
			update_option('product_gallery_effect','slide-vert');
		}
		if( trim(get_option('product_gallery_auto_start')) == '' || $reset ){
			update_option('product_gallery_auto_start','true');
		}
		if( trim(get_option('product_gallery_animation_speed')) == '' || $reset ){
			update_option('product_gallery_animation_speed',2);
		}
		if( trim(get_option('bg_image_wrapper')) == '' || $reset ){
			update_option('bg_image_wrapper','#FFFFFF');
		}
		if( trim(get_option('border_image_wrapper_color')) == '' || $reset ){
			update_option('border_image_wrapper_color','#CCCCCC');
		}
		if( trim(get_option('product_gallery_text_color')) == '' || $reset ){
			update_option('product_gallery_text_color','#FFFFFF');
		}
		if( trim(get_option('product_gallery_bg_des')) == '' || $reset ){
			update_option('product_gallery_bg_des','#226fd8');
		}
		if( trim(get_option('product_gallery_nav')) == '' || $reset ){
			update_option('product_gallery_nav','yes');
		}
		if( trim(get_option('bg_nav_color')) == '' || $reset ){
			update_option('bg_nav_color','#226fd8');
		}
		if( trim(get_option('bg_nav_text_color')) == '' || $reset ){
			update_option('bg_nav_text_color','#FFFFFF');
		}
		if( trim(get_option('popup_gallery')) == '' || $reset ){
			update_option('popup_gallery','fb');
		}
		if( trim(get_option('enable_gallery_thumb')) == '' || $reset ){
			update_option('enable_gallery_thumb','yes');
		}
		if( trim(get_option('transition_scroll_bar')) == '' || $reset ){
			update_option('transition_scroll_bar','#226fd8');
		}
		if( trim(get_option('lazy_load_scroll')) == '' || $reset ){
			update_option('lazy_load_scroll','yes');
		}
		
		if( trim(get_option('caption_font')) == '' || $reset ){
			update_option('caption_font','Arial, sans-serif');
		}
		if( trim(get_option('caption_font_size')) == '' || $reset ){
			update_option('caption_font_size','12px');
		}
		if( trim(get_option('caption_font_style')) == '' || $reset ){
			update_option('caption_font_style','normal');
		}
		
		if( trim(get_option('navbar_font')) == '' || $reset ){
			update_option('navbar_font','Arial, sans-serif');
		}
		if( trim(get_option('navbar_font_size')) == '' || $reset ){
			update_option('navbar_font_size','12px');
		}
		if( trim(get_option('navbar_font_style')) == '' || $reset ){
			update_option('navbar_font_style','bold');
		}
		if( trim(get_option('navbar_height')) == '' || $reset ){
			update_option('navbar_height','25');
		}
		
	}
	
	public function is_submit_button_displayed() {
		return true;
	}
	public function is_update_message_displayed() {
		if(isset($_REQUEST['updateoption'])){
			$this->update_settings($_POST);
			$this->wpsc_dynamic_gallery_set_setting(true, true);
		}
		return true;
	}
	function update_settings($request){
		
		if( is_array($request) && count($request) > 0 ){
			unset($request['wpsc_admin_action']);
			unset($request['wpsc-update-options']);
			unset($request['_wp_http_referer']);
			unset($request['updateoption']);
			if(!isset($request['product_gallery_nav'])){
				update_option('product_gallery_nav','no');
			}
			if(!isset($request['lazy_load_scroll'])){
				update_option('lazy_load_scroll','no');
			}
			if(!isset($request['enable_gallery_thumb'])){
				update_option('enable_gallery_thumb','no');
			}
			foreach($request as $key=>$value){
				update_option($key,$value);
			}
			
		}
	}
	public function display() {
		global $wpdb;
		$wpsc_dynamic_gallery = wp_create_nonce("wpsc_dynamic_gallery");
		?>
        <style type="text/css">
			.description{font-family: sans-serif;font-size: 12px;font-style: italic;color:#666666;}
			input.colorpick{text-transform:uppercase;}
			#wpsc_dgallery_upgrade_area { border:2px solid #FF0;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:0; position:relative}
	  	 	#wpsc_dgallery_upgrade_area h3{ margin-left:10px;}
	   		#wpsc_dynamic_gallery_extensions { background: url("<?php echo WPSC_DYNAMIC_GALLERY_URL; ?>/assets/images/logo_a3blue.png") no-repeat scroll 4px 6px #FFFBCC; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 0px; padding: 4px 8px 4px 38px; position: absolute; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 300px; left:400px; top:10px; border:1px solid #E6DB55}
       	</style>
        
		<h3><?php _e('Gallery', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row"><?php _e('Gallery width', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('product_gallery_width');?>" style="width:7em;" id="product_gallery_width" name="product_gallery_width">
              <span class="description">px</span>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Gallery height', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('product_gallery_height');?>" style="width:7em;" id="product_gallery_height" name="product_gallery_height"> <span class="description">px</span>
            </td>
		  </tr>
		</table>
        <table class="form-table"><tr valign="top"><td style="padding:0;"><div id="wpsc_dgallery_upgrade_area"><?php echo WPSC_Settings_Tab_Gallery_Settings::wpsc_dynamic_gallery_extension(); ?>
        <table class="form-table">
          <tr>
		    <th scope="row"><?php _e('Auto start', 'wpsc_dgallery');?>	</th>
		    <td>
              <select class="" style="width:7em;" id="product_gallery_auto_start" name="product_gallery_auto_start" disabled="disabled">
                <option <?php if(get_option('product_gallery_auto_start') == 'false'){ echo 'selected="selected" ';} ?>value="false"><?php _e('False', 'wpsc_dgallery');?></option>
                <option <?php if(get_option('product_gallery_auto_start') == 'true'){ echo 'selected="selected" ';} ?>value="true"><?php _e('True', 'wpsc_dgallery');?></option>
              </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Time between transitions', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('product_gallery_speed');?>" style="width:7em;" id="product_gallery_speed" name="product_gallery_speed"  disabled="disabled" />  
              <span class="description"><?php _e('seconds', 'wpsc_dgallery');?></span>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Slide transition effect', 'wpsc_dgallery');?>	</th>
		    <td>
              <select class="" style="width:7em;" id="product_gallery_effect" name="product_gallery_effect" disabled="disabled">
              	<option <?php if(get_option('product_gallery_effect') == 'none'){ echo 'selected="selected" ';} ?>value="none"><?php _e('None', 'wpsc_dgallery');?></option>
              	<option <?php if(get_option('product_gallery_effect') == 'fade'){ echo 'selected="selected" ';} ?>value="fade"><?php _e('Fade', 'wpsc_dgallery');?></option>
            	<option <?php if(get_option('product_gallery_effect') == 'slide-hori'){ echo 'selected="selected" ';} ?>value="slide-hori"><?php _e('Slide Hori', 'wpsc_dgallery');?></option>
            	<option <?php if(get_option('product_gallery_effect') == 'slide-vert'){ echo 'selected="selected" ';} ?>value="slide-vert"><?php _e('Slide vert', 'wpsc_dgallery');?></option>
           		<option <?php if(get_option('product_gallery_effect') == 'resize'){ echo 'selected="selected" ';} ?>value="resize"><?php _e('Resize', 'wpsc_dgallery');?></option>
              </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Transition effect speed', 'wpsc_dgallery');?>	</th>
		    <td>
              <select class="" style="width:7em;" id="product_gallery_animation_speed" name="product_gallery_animation_speed" disabled="disabled">
              <?php
              for( $i = 1; $i <= 10 ; $i++ ){
				  if( get_option('product_gallery_animation_speed') == $i ){
					  echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				  }else{
					  echo '<option value="'.$i.'">'.$i.'</option>';
				  }
				  
			  }
			  ?>
              </select> 
              <span class="description"><?php _e('seconds', 'wpsc_dgallery');?></span>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Image background colour', 'wpsc_dgallery');?>	</th>
		    <td><input type="text" class="colorpick" value="<?php echo get_option('bg_image_wrapper');?>" style="width: 7em;" id="bg_image_wrapper" name="bg_image_wrapper" disabled="disabled" /> <span class="description"><?php _e('Gallery image background colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#FFFFFF</code>.</span>
            <div id="colorPickerDiv_bg_image_wrapper" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Border colour', 'wpsc_dgallery');?>	</th>
		    <td><input type="text" class="colorpick" value="<?php echo get_option('border_image_wrapper_color');?>" style="width: 7em;" id="border_image_wrapper_color" name="border_image_wrapper_color" disabled="disabled" /> <span class="description"><?php _e('Gallery border colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#CCCCCC</code>.</span>
            <div id="colorPickerDiv_border_image_wrapper_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Gallery popup', 'wpsc_dgallery');?>	</th>
		    <td>
              <select class="" style="width:7em;" id="popup_gallery" name="popup_gallery" disabled="disabled">
                <option <?php if(get_option('popup_gallery') == 'fb'){ echo 'selected="selected" ';} ?>value="fb"><?php _e('Fancybox', 'wpsc_dgallery');?></option>
                <option <?php if(get_option('popup_gallery') == 'lb'){ echo 'selected="selected" ';} ?>value="lb"><?php _e('Lightbox', 'wpsc_dgallery');?></option>
              </select>
            </td>
		  </tr>
		</table>
        
        <h3><?php _e('Caption text', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row"><?php _e('Font', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="caption_font" name="caption_font" disabled="disabled">
            <?php
            foreach($this->fonts as $key=>$value){
				if( htmlspecialchars( get_option('caption_font') ) ==  htmlspecialchars($key) ){
					
					?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
				}else{
					?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
				}
			}
			?>                                  
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Font size', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="caption_font_size" name="caption_font_size" disabled="disabled">
            <?php
            for( $i = 9 ; $i <= 29 ; $i++ ){
				if( get_option('caption_font_size')  ==  $i.'px' ){
					
					?><option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option><?php
				}else{
					?><option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option><?php
				}
			}
			?>                                  
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Font style', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="caption_font_style" name="caption_font_style" disabled="disabled">
              <option <?php if(get_option('caption_font_style') == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('caption_font_style') == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('caption_font_style') == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('caption_font_style') == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpsc_dgallery');?></option>
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Colour', 'wpsc_dgallery');?>	</th>
		    <td>
            <input type="text" class="colorpick" value="<?php echo get_option('product_gallery_text_color');?>" style="width:7em;" id="product_gallery_text_color" name="product_gallery_text_color" disabled="disabled" /> <span class="description"><?php _e('Caption text color.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#FFFFFF</code>.</span> 
            <div id="colorPickerDiv_product_gallery_text_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Background', 'wpsc_dgallery');?>	</th>
		    <td>
            <input type="text" class="colorpick" value="<?php echo get_option('product_gallery_bg_des');?>" style="width: 7em;" id="product_gallery_bg_des" name="product_gallery_bg_des" disabled="disabled" /> <span class="description"><?php _e('Caption text background colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#226fd8</code>.</span> <div style="z-index: 100; background: #eee; border: 1px solid #ccc; position: absolute; display: none;" class="colorpickdiv" id="colorPickerDiv_product_gallery_bg_des"></div></td>
		  </tr>
          
          
          
		</table>
        
        <h3><?php _e('Nav bar', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row"><?php _e('Control', 'wpsc_dgallery');?>	</th>
		    <td><input type="checkbox" <?php if( get_option('product_gallery_nav') == 'yes' ){echo 'checked="checked" ';}?>value="yes" id="product_gallery_nav" name="product_gallery_nav" disabled="disabled" /> <span class="description"><?php _e('Enable Nav bar Control', 'wpsc_dgallery');?></span></td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Font', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="navbar_font" name="navbar_font" disabled="disabled">
            <?php
            foreach($this->fonts as $key=>$value){
				if( htmlspecialchars( get_option('navbar_font') ) ==  htmlspecialchars($key) ){
					
					?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
				}else{
					?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
				}
			}
			?>                                  
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Font size', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="navbar_font_size" name="navbar_font_size" disabled="disabled">
            <?php
            for( $i = 9 ; $i <= 29 ; $i++ ){
				if( get_option('navbar_font_size')  ==  $i.'px' ){
					
					?><option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option><?php
				}else{
					?><option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option><?php
				}
			}
			?>                                  
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Font style', 'wpsc_dgallery');?>	</th>
		    <td>
            <select class="" style="width:7em;" id="navbar_font_style" name="navbar_font_style" disabled="disabled">
              <option <?php if(get_option('navbar_font_style') == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('navbar_font_style') == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('navbar_font_style') == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'wpsc_dgallery');?></option>
              <option <?php if(get_option('navbar_font_style') == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'wpsc_dgallery');?></option>
            </select>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Colour', 'wpsc_dgallery');?>	</th>
		    <td>
            <input type="text" class="colorpick" value="<?php echo get_option('bg_nav_color');?>" style="width:7em;" id="bg_nav_color" name="bg_nav_color" disabled="disabled" /> <span class="description"><?php _e('Nav bar background colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#226fd8</code>.</span> 
            <div id="colorPickerDiv_bg_nav_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Text', 'wpsc_dgallery');?>	</th>
		    <td>
            <input type="text" class="colorpick" value="<?php echo get_option('bg_nav_text_color');?>" style="width:7em;" id="bg_nav_text_color" name="bg_nav_text_color" disabled="disabled" /> <span class="description"><?php _e('Nav bar text color.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#FFFFFF</code>.</span>
            <div id="colorPickerDiv_bg_nav_text_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Container height', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('navbar_height');?>" style="width:7em;" id="navbar_height" name="navbar_height" disabled="disabled" />
              <span class="description">px</span>
            </td>
		  </tr>
		</table>
        
        <h3><?php _e('Lazy-load scroll', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row"><?php _e('Control', 'wpsc_dgallery');?>	</th>
		    <td><input type="checkbox" <?php if( get_option('lazy_load_scroll') == 'yes' ){echo 'checked="checked" ';}?>value="yes" id="lazy_load_scroll" name="lazy_load_scroll" disabled="disabled" /> <span class="description"><?php _e('Enable lazy-load scroll', 'wpsc_dgallery');?></span></td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Colour', 'wpsc_dgallery');?>	</th>
		    <td>
            <input type="text" class="colorpick" value="<?php echo get_option('transition_scroll_bar');?>" style="width:7em;" id="transition_scroll_bar" name="transition_scroll_bar" disabled="disabled" /> <span class="description"><?php _e('Scroll bar colour.', 'wpsc_dgallery');?> <?php _e('Default', 'wpsc_dgallery');?> <code>#226fd8</code>.</span>
            <div id="colorPickerDiv_transition_scroll_bar" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
            </td>
		  </tr>
		</table>
        
        <h3><?php _e('Image Thumbnails', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row"><?php _e('Show thumbnails', 'wpsc_dgallery');?>	</th>
		    <td><input type="checkbox" <?php if( get_option('enable_gallery_thumb') == 'yes' ){echo 'checked="checked" ';}?>value="yes" id="enable_gallery_thumb" name="enable_gallery_thumb" disabled="disabled" /> <span class="description"><?php _e('Enable thumbnail gallery', 'wpsc_dgallery');?></span></td>
		  </tr>
        </table>
        </div></td></tr></table>
        <table class="form-table">
          <tr>
		    <th scope="row"><?php _e('Thumbnail width', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('thumb_width');?>" style="width:7em;" id="thumb_width" name="thumb_width">
              <span class="description">px</span>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Thumbnail height', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('thumb_height');?>" style="width:7em;" id="thumb_height" name="thumb_height">
              <span class="description">px</span>
            </td>
		  </tr>
          <tr>
		    <th scope="row"><?php _e('Thumbnail spacing', 'wpsc_dgallery');?>	</th>
		    <td>
              <input type="text" value="<?php echo get_option('thumb_spacing');?>" style="width:7em;" id="thumb_spacing" name="thumb_spacing">
              <span class="description">px</span>
            </td>
		  </tr>
		</table>
        
        <h3><?php _e('Preview', 'wpsc_dgallery'); ?></h3>
		<table class="form-table">
		  <tr>
		    <th scope="row" style="margin:0;padding:0"><a href="<?php echo admin_url("admin-ajax.php")?>?security=<?php echo $wpsc_dynamic_gallery;?>" class="preview_allery"><?php _e('Click here to preview gallery', 'wpsc_dgallery');?></a></th>
		  </tr>
          
		</table>
		<?php
	}
	
	function wpsc_dynamic_gallery_extension() {
		$html = '';
		$html .= '<div id="wpsc_dynamic_gallery_extensions">'.__('Features that you see inside this yellow frame are this plugins Pro Version Features. Upgrade to the', 'wpsc_dgallery').' <a target="_blank" href="http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/">'.__('Pro Version', 'wpsc_dgallery').'</a> '.__('for a small once only fee to activate all 22 gallery features and unleash to full glory of the WP e-Commerce dynamic products gallery on your site. Note: Thumbnail size settings are activated in this Lite version and are at the bottom of this page.', 'wpsc_dgallery').'</div>';
		return $html;	
	}
}
?>
