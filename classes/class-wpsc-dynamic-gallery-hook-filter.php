<?php
/**
 * WP e-Commerce Dynamic Gallery Hook Filter Class
 *
 * Class Function into WP e-Commerce plugin
 *
 * Table Of Contents
 *
 * add_wpsc_settings_tabs()
 * wpsc_dynamic_gallery_add_script()
 * dynamic_gallery_frontend_script()
 * wp_admin_footer_scripts()
 * wpsc_dynamic_gallery_display()
 * wpsc_dynamic_gallery_preview()
 * wpsc_hide_featured_image_single_product()
 * plugin_extra_links()
 */
class WPSC_Dynamic_Gallery_Hook_Filter {
	function add_wpsc_settings_tabs($tabs) {
		$tabs['gallery_settings'] = __('Dynamic Gallery', 'wpsc_dgallery');
		return $tabs;
	}
	
	function wpsc_dynamic_gallery_add_script() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		wp_register_script( 'wpsc-dynamic-gallery-script', WPSC_DYNAMIC_GALLERY_JS_URL.'/galleries.js' );
		wp_enqueue_script( 'wpsc-dynamic-gallery-script' );
		
		wp_enqueue_style( 'ad-gallery-style', WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.css' );
		wp_enqueue_script( 'ad-gallery-script', WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.js', array(), false, true );
		
		wp_enqueue_style( 'a3_lightbox_style', WPSC_DYNAMIC_GALLERY_JS_URL . '/lightbox/themes/default/jquery.lightbox.css' );
		wp_enqueue_script( 'lightbox2_script', WPSC_DYNAMIC_GALLERY_JS_URL . '/lightbox/jquery.lightbox.min.js', array(), false, true );
			
		wp_enqueue_style( 'woocommerce_fancybox_styles', WPSC_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.css' );
		wp_enqueue_script( 'fancybox', WPSC_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.min.js', array(), false, true );
	}
	
	function dynamic_gallery_frontend_script() {
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'ad-gallery-style', WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.css' );
		wp_enqueue_script( 'ad-gallery-script', WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.js', array(), false, true );
		wp_enqueue_script( 'filter-gallery-script', WPSC_DYNAMIC_GALLERY_JS_URL . '/filter_gallery.js', array(), false, true );
		
		$popup_gallery = get_option('popup_gallery');
		if($popup_gallery == 'lb'){
			wp_enqueue_style( 'a3_lightbox_style', WPSC_DYNAMIC_GALLERY_JS_URL . '/lightbox/themes/default/jquery.lightbox.css' );
			wp_enqueue_script( 'lightbox2_script', WPSC_DYNAMIC_GALLERY_JS_URL . '/lightbox/jquery.lightbox.min.js', array(), false, true );
		}else{
			wp_enqueue_style( 'woocommerce_fancybox_styles', WPSC_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.css' );
			wp_enqueue_script( 'fancybox', WPSC_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.min.js', array(), false, true );
		}
	}
	
	function wp_admin_footer_scripts() {
	?>
    <script type="text/javascript">
		(function($){		
			$(function(){	
				$("a.nav-tab").click(function(){
					if($(this).attr('data-tab-id') == 'gallery_settings'){
						window.location.href=$(this).attr('href');
						return false;
					}
				});
			});		  
		})(jQuery);
	</script>
    <?php
	}
	
	function wpsc_attachment_fields_filter( $form_fields, $post ) {
		if (!$post->post_parent) return $form_fields;
		$parent = get_post( $post->post_parent );
		if ($parent->post_type!=='wpsc-product') return $form_fields;
		
		$edit_post = sanitize_post($post, 'edit');
		if (is_array($form_fields) && count($form_fields) > 0) {
			$number_field = 0;
			$field_post_excerpt = array(
										'label' => 'Caption',
										'input' => 'html',
										'html' => wp_caption_input_textarea($edit_post));
			foreach ($form_fields as $form_key => $form_values) {
				if ($number_field == 1 && is_array($field_post_excerpt)) {
					$new_form_fields['post_excerpt'] = $field_post_excerpt;
					$field_post_excerpt = '';
				}
				$new_form_fields[$form_key] = $form_values;
				
				$number_field++;
			}
			$form_fields = $new_form_fields;
		}
		
		$exclude_image = (int) get_post_meta($post->ID, '_wpsc_exclude_image', true);
		
		$label = __('Exclude image', 'wpsc_dgallery');
		
		$html = '<input type="checkbox" '.checked($exclude_image, 1, false).' name="attachments['.$post->ID.'][wpsc_exclude_image]" id="attachments['.$post->ID.'][wpsc_exclude_image]" />';
		
		$form_fields['wpsc_exclude_image'] = array(
				'label' => $label,
				'input' => 'html',
				'html' =>  $html,
				'value' => '',
				'helps' => __('Enabling this option will hide it from the product page image gallery. If assigned to variations below the image will show when option is selected. (Show Product Variations in Gallery is a', 'wpsc_dgallery').' <a href="http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('Pro Version', 'wpsc_dgallery').'</a> '.__('only feature', 'wpsc_dgallery').')'
		);
		
		return $form_fields;
	}
	
	function wpsc_exclude_image_from_product_page_field_save( $post, $attachment ) {
	
		if (isset($_REQUEST['attachments'][$post['ID']]['wpsc_exclude_image'])) :
			delete_post_meta( (int) $post['ID'], '_wpsc_exclude_image' );
			update_post_meta( (int) $post['ID'], '_wpsc_exclude_image', 1);
		else :
			delete_post_meta( (int) $post['ID'], '_wpsc_exclude_image' );
			update_post_meta( (int) $post['ID'], '_wpsc_exclude_image', 0);
		endif;
			
		return $post;
					
	}
	
	function wpsc_exclude_image_from_product_page_field_add( $post_id ) {
		add_post_meta( $post_id, '_wpsc_exclude_image', 0, true );
	}
	
	function wpsc_dynamic_gallery_preview(){
		global $post;
		check_ajax_referer( 'wpsc_dynamic_gallery', 'security' );
		WPSC_Dynamic_Gallery_Preview_Display::wpsc_dynamic_gallery_preview($_REQUEST);
		die();
	}
	
	function wpsc_dynamic_gallery_frontend(){
		check_ajax_referer( 'wpsc_dynamic_gallery_frontend', 'security' );
		echo WPSC_Dynamic_Gallery_Display_Class::wpsc_dynamic_gallery_display($_REQUEST['product_id']);
		die();
	}
	
	function do_dynamic_gallery(){
		global $post;
		if(is_singular('wpsc-product')){
			$wpsc_dynamic_gallery_frontend = wp_create_nonce("wpsc_dynamic_gallery_frontend");
			$g_width = get_option('product_gallery_width');
			$g_height = get_option('product_gallery_height');
	
			echo "<script type=\"text/javascript\">
			jQuery(window).load(function(){
				var container_image = jQuery('.single_product_display .imagecol');
				container_image.html('<div style=\'display: block; width: 100%; height: 16px; text-align: center; position: absolute; top: 48%;\'><img src=\'".WPSC_DYNAMIC_GALLERY_JS_URL."/mygallery/ajax-loader.gif\' style=\'width:16px !important;height:16px !important;margin:auto !important;padding:0 !important;border:0 !important;\' /></div>').css('position','relative').css('width','".$g_width."px').css('min-height','".$g_height."px');
				jQuery.post('".admin_url('admin-ajax.php')."?security=".$wpsc_dynamic_gallery_frontend."&action=wpsc_dynamic_gallery_frontend&product_id=".$post->ID."', function(data) {
					container_image.html(data);
				});
			});
			</script>";
		}
	}
	
	function wpsc_hide_featured_image_single_product(){
		echo '<style>.single_product_display .imagecol > a { display: none !important;position: absolute;z-index: -1;left:-1000em;}</style>';
	}
	
	function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WPSC_DYNAMIC_GALLERY_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-dynamic-gallery/" target="_blank">'.__('Documentation', 'wpsc_dgallery').'</a>';
		$links[] = '<a href="http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/#help" target="_blank">'.__('Support', 'wpsc_dgallery').'</a>';
		return $links;
	}
}
?>