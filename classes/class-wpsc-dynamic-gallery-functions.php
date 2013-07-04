<?php
/**
 * WPEC Dynamic Gallery Functions
 *
 * Table Of Contents
 *
 * plugins_loaded()
 * reset_products_galleries_activate()
 * html2rgb()
 * rgb2html()
 * get_font()
 * get_font_sizes()
 * plugin_pro_notice()
 * upgrade_1_1_4()
 */
class WPSC_Dynamic_Gallery_Functions 
{	
	/** 
	 * Set global variable when plugin loaded
	 */
	public static function plugins_loaded() {
		
		WPSC_Dynamic_Gallery_Container_Settings::get_settings();
		WPSC_Dynamic_Gallery_Global_Settings::get_settings();
		WPSC_Dynamic_Gallery_Caption_Settings::get_settings();
		WPSC_Dynamic_Gallery_Navbar_Settings::get_settings();
		WPSC_Dynamic_Gallery_LazyLoad_Settings::get_settings();
		WPSC_Dynamic_Gallery_Thumbnail_Settings::get_settings();
		
	}
	
	public static function reset_products_galleries_activate() {
		global $wpdb;
		$wpdb->query( "DELETE FROM ".$wpdb->postmeta." WHERE meta_key='_actived_d_gallery' " );
	}
	
	public static function html2rgb($color,$text = false){
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		if($text){
			return $r.','.$g.','.$b;
		}else{
			return array($r, $g, $b);
		}
	}
	
	public static function rgb2html($r, $g=-1, $b=-1){
		if (is_array($r) && sizeof($r) == 3)
			list($r, $g, $b) = $r;
	
		$r = intval($r); $g = intval($g);
		$b = intval($b);
	
		$r = dechex($r<0?0:($r>255?255:$r));
		$g = dechex($g<0?0:($g>255?255:$g));
		$b = dechex($b<0?0:($b>255?255:$b));
	
		$color = (strlen($r) < 2?'0':'').$r;
		$color .= (strlen($g) < 2?'0':'').$g;
		$color .= (strlen($b) < 2?'0':'').$b;
		return '#'.$color;
	}
	
	public static function get_font() {
		$fonts = array( 
			'Arial, sans-serif'													=> __( 'Arial', 'wpsc_dgallery' ),
			'Verdana, Geneva, sans-serif'										=> __( 'Verdana', 'wpsc_dgallery' ),
			'Trebuchet MS, Tahoma, sans-serif'								=> __( 'Trebuchet', 'wpsc_dgallery' ),
			'Georgia, serif'													=> __( 'Georgia', 'wpsc_dgallery' ),
			'Times New Roman, serif'											=> __( 'Times New Roman', 'wpsc_dgallery' ),
			'Tahoma, Geneva, Verdana, sans-serif'								=> __( 'Tahoma', 'wpsc_dgallery' ),
			'Palatino, Palatino Linotype, serif'								=> __( 'Palatino', 'wpsc_dgallery' ),
			'Helvetica Neue, Helvetica, sans-serif'							=> __( 'Helvetica*', 'wpsc_dgallery' ),
			'Calibri, Candara, Segoe, Optima, sans-serif'						=> __( 'Calibri*', 'wpsc_dgallery' ),
			'Myriad Pro, Myriad, sans-serif'									=> __( 'Myriad Pro*', 'wpsc_dgallery' ),
			'Lucida Grande, Lucida Sans Unicode, Lucida Sans, sans-serif'	=> __( 'Lucida', 'wpsc_dgallery' ),
			'Arial Black, sans-serif'											=> __( 'Arial Black', 'wpsc_dgallery' ),
			'Gill Sans, Gill Sans MT, Calibri, sans-serif'					=> __( 'Gill Sans*', 'wpsc_dgallery' ),
			'Geneva, Tahoma, Verdana, sans-serif'								=> __( 'Geneva*', 'wpsc_dgallery' ),
			'Impact, Charcoal, sans-serif'										=> __( 'Impact', 'wpsc_dgallery' ),
			'Courier, Courier New, monospace'									=> __( 'Courier', 'wpsc_dgallery' ),
			'Century Gothic, sans-serif'										=> __( 'Century Gothic', 'wpsc_dgallery' ),
		);
		
		return apply_filters('wpsc_dynamic_gallery_fonts_support', $fonts );
	}
	
	public static function get_font_sizes($start = 9, $end = 30, $unit = 'px') {
		$font_sizes = array();
		for ($start; $start <= $end; $start ++) {
			$font_sizes[$start.''.$unit] = $start.''.$unit;
		}
		
		return $font_sizes;
	}
	
	public static function plugin_pro_notice() {
		$html = '';
		$html .= '<div id="a3_plugin_panel_extensions">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.WPSC_DYNAMIC_GALLERY_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade available for WPEC Dynamic Gallery Pro', 'wpsc_dgallery').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> All the functions inside the Yellow border on the plugins admin panel are extra functionality that is activated by upgrading to the Pro version", 'wpsc_dgallery').':</p>';
		$html .= '<h3>* <a href="http://a3rev.com/shop/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('WPEC Dynamic Gallery Pro', 'wpsc_dgallery').'</a> '.__('Features', 'wpsc_dgallery').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__('Show Multiple Product Variation images in Gallery. As users selects options from the drop down menu that options product image auto shows in the Dynamic Gallery complete with caption text.', 'wpsc_dgallery').'</li>';
		$html .= '<li>2. '.__('Fully Responsive Gallery option. Set gallery wide to % and it becomes fully responsive image product gallery including the image zoom pop up.', 'wpsc_dgallery').'</li>';
		$html .= '<li>3. '.__('Activate all of the Gallery customization settings you see here on this page to style and fine tune your product presentation.', 'wpsc_dgallery').'</li>';
		$html .= '<li>4. '.__('Option to Deactivate the Gallery on any Single product page - default WP e-Commerce product image will show.', 'wpsc_dgallery').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('View this plugins', 'wpsc_dgallery').' <a href="http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-dynamic-gallery/" target="_blank">'.__('documentation', 'wpsc_dgallery').'</a></h3>';
		$html .= '<h3>'.__('Visit this plugins', 'wpsc_dgallery').' <a href="http://wordpress.org/support/plugin/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('support forum', 'wpsc_dgallery').'</a></h3>';
		$html .= '<h3>'.__('More FREE a3rev WP e-Commerce Plugins', 'wpsc_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('WP e-Commerce Dynamic Gallery', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-predictive-search/" target="_blank">'.__('WP e-Commerce Predictive Search', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('WP e-Commerce Compare Products', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-catalog-visibility-and-email-inquiry/" target="_blank">'.__('WP e-Commerce Catalog Visibility & Email Inquiry', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-grid-view/" target="_blank">'.__('WP e-Commerce Grid View', 'wpsc_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		
		$html .= '<h3>'.__('FREE a3rev WordPress plugins', 'wpsc_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/contact-us-page-contact-people/" target="_blank">'.__('Contact Us Page - Contact People', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wpsc_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		
		$html .= '<h3>'.__('Help spread the Word about this plugin', 'wpsc_dgallery').'</h3>';
		$html .= '<p>'.__("Things you can do to help others find this plugin", 'wpsc_dgallery');
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('Rate this plugin 5', 'wpsc_dgallery').' <img src="'.WPSC_DYNAMIC_GALLERY_IMAGES_URL.'/stars.png" align="top" /> '.__('on WordPress.org', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('Mark the plugin as a fourite', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://www.facebook.com/a3revolution/" target="_blank">'.__('Follow a3rev on facebook', 'wpsc_dgallery').'</a></li>';
		$html .= '<li>* <a href="https://twitter.com/a3rev/" target="_blank">'.__('Follow a3rev on Twitter', 'wpsc_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '</div>';
		return $html;
	}
	
	public static function upgrade_1_1_4() {
		$default_settings = array(
			'product_gallery_width'					=> get_option('product_gallery_width', 100),
			'width_type'							=> get_option('width_type', '%'),
			'product_gallery_height'				=> get_option('product_gallery_height', 75),
			'product_gallery_auto_start'			=> get_option('product_gallery_auto_start', 'true'),
			'product_gallery_speed'					=> get_option('product_gallery_speed', 5),
			'product_gallery_effect'				=> get_option('product_gallery_effect', 'slide-vert'),
			'product_gallery_animation_speed'		=> get_option('product_gallery_animation_speed', 2),
			'stop_scroll_1image'					=> get_option('dynamic_gallery_stop_scroll_1image', 'no'),
			'bg_image_wrapper'						=> get_option('bg_image_wrapper', '#FFFFFF'),
			'border_image_wrapper_color'			=> get_option('border_image_wrapper_color', '#CCCCCC'),
		);
		update_option( 'wpsc_dgallery_container_settings', $default_settings );
		
		$default_settings = array(
			'popup_gallery'							=> get_option('popup_gallery', 'fb'),
			'dgallery_activate'						=> 'yes',
			'dgallery_show_variation'				=> get_option('dynamic_gallery_show_variation', 'yes'),
		);
		update_option( 'wpsc_dgallery_global_settings', $default_settings );
		
		$default_settings = array(
			'caption_font'							=> get_option('caption_font', 'Arial, sans-serif'),
			'caption_font_size'						=> get_option('caption_font_size', '12px'),
			'caption_font_style'					=> get_option('caption_font_style', 'normal'),
			'product_gallery_text_color'			=> get_option('product_gallery_text_color', '#FFFFFF'),
			'product_gallery_bg_des'				=> get_option('product_gallery_bg_des', '#000000'),
		);
		update_option( 'wpsc_dgallery_caption_settings', $default_settings );
		
		$default_settings = array(
			'product_gallery_nav'					=> get_option('product_gallery_nav', 'yes'),
			'navbar_font'							=> get_option('navbar_font', 'Arial, sans-serif'),
			'navbar_font_size'						=> get_option('navbar_font_size', '12px'),
			'navbar_font_style'						=> get_option('navbar_font_style', 'bold'),
			'bg_nav_text_color'						=> get_option('bg_nav_text_color', '#000000'),
			'bg_nav_color'							=> get_option('bg_nav_color', '#FFFFFF'),
			'navbar_height'							=> get_option('navbar_height', 25),
		);
		update_option( 'wpsc_dgallery_navbar_settings', $default_settings );
		
		$default_settings = array(
			'lazy_load_scroll'						=> get_option('lazy_load_scroll', 'yes'),
			'transition_scroll_bar'					=> get_option('transition_scroll_bar', '#000000'),
		);
		update_option( 'wpsc_dgallery_lazyload_settings', $default_settings );
		
		$default_settings = array(
			'enable_gallery_thumb'					=> get_option('enable_gallery_thumb', 'yes'),
			'hide_thumb_1image'						=> get_option('dynamic_gallery_hide_thumb_1image', 'no'),
			'thumb_width'							=> get_option('thumb_width', 105),
			'thumb_height'							=> get_option('thumb_height', 75),
			'thumb_spacing'							=> get_option('thumb_spacing', 2),
		);
		update_option( 'wpsc_dgallery_thumbnail_settings', $default_settings );
		
		
		global $wpdb;
		$wpdb->query( "UPDATE ".$wpdb->postmeta." SET meta_key='_wpsc_dgallery_show_variation' WHERE meta_key='_show_variation' " );
		$wpdb->query( "UPDATE ".$wpdb->postmeta." SET meta_key='_wpsc_dgallery_in_variations' WHERE meta_key='_in_variations' " );
	}
}
?>