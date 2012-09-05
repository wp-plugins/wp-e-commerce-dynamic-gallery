<?php
/**
 * WP e-Commerce Dynamic Gallery Metaboxes Class
 *
 * Class Function into WP e-Commerce plugin
 *
 * Table Of Contents
 *
 *
 * remove_wpsc_metaboxes()
 * wpsc_meta_boxes_image()
 * wpsc_product_image_box()
 */
class WPSC_Dynamic_Gallery_Metaboxes_Class{
	function remove_wpsc_metaboxes(){
		global $post;
		if (is_admin()) :
			remove_meta_box('wpsc_product_image_forms', 'wpsc-product', 'normal');
			remove_meta_box('wpsc_product_download_forms', 'wpsc-product', 'normal');
			remove_meta_box('wpsc_product_shipping_forms', 'wpsc-product', 'normal');
		endif;
	}
	
	
	function wpsc_meta_boxes_image() {
		global $post;
		add_meta_box( 'wpsc_product_image_forms', __('Gallery Images', 'wpsc_dgallery'), array('WPSC_Dynamic_Gallery_Metaboxes_Class','wpsc_product_image_box'), 'wpsc-product', 'normal', 'high' );
		add_meta_box( 'wpsc_product_download_forms', __('Product Download', 'wpsc'), 'wpsc_product_download_forms', 'wpsc-product', 'normal', 'high' );
		add_meta_box( 'wpsc_product_shipping_forms', __('Shipping', 'wpsc'), 'wpsc_product_shipping_forms', 'wpsc-product', 'normal', 'high' );
	}
	
	function wpsc_product_image_box() {
		global $post, $thepostid;
		echo '<script type="text/javascript">
		
		jQuery(\'.upload_image_button\').live(\'click\', function(){
			var post_id = '.$post->ID.';
			//window.send_to_editor = window.send_to_termmeta;
			tb_show(\'\', \'media-upload.php?parent_page=wpsc-edit-products&post_id=\' + post_id + \'&type=image&tab=gallery&TB_iframe=true\');
			return false;
		});
		
		</script>';
		echo '<div class="wpsc_options_panel">';
	
		
		$args = array(
					'post_type'      => 'attachment',
					'post_parent'    => $post->ID,
					'post_mime_type' => 'image',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'numberposts'    => -1
				); 
		$attached_images = get_posts($args);
		$featured_img = get_post_meta($post->ID, '_thumbnail_id');
		$attached_thumb = array();
		if( count($attached_images) > 0 ){
			$i = 0;
			foreach($attached_images as $key=>$object){
				$i++;
				if ( in_array( $object->ID, $featured_img ) ){
					$attached_thumb[0] = $object;
				}else{
					$attached_thumb[$i] = $object;
				}
			}			
		}
		ksort($attached_thumb);
		
		if(is_array($attached_thumb) && count($attached_thumb)>0){
	
			echo '<a href="#" onclick="tb_show(\'\', \'media-upload.php?parent_page=wpsc-edit-products&post_id='.$post->ID.'&type=image&TB_iframe=true\');return false;" style="margin-right:10px;margin-bottom:10px;" class="upload_image_button1" rel="'.$post->ID.'"><img src="'.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/no-image.jpg" style="width:69px;height:69px;border:2px solid #CCC" /><input type="hidden" name="upload_image_id[1]" class="upload_image_id" value="0" /></a>';
			
			$i = 0 ;
			foreach($attached_thumb as $item_thumb){
				$i++;
				if ( get_post_meta( $item_thumb->ID, '_wpsc_exclude_image', true ) == 1 ) continue;
				$image_attribute = wp_get_attachment_image_src( $item_thumb->ID, array(70,70) );
				echo '<a href="#" style="margin-right:10px;margin-bottom:10px;" class="upload_image_button" rel="'.$post->ID.'"><img src="'.$image_attribute[0].'" style="width:69px;height:69px;border:2px solid #CCC" /><input type="hidden" name="upload_image_id['.$i.']" class="upload_image_id" value="'.$item_thumb->ID.'" /></a>';
			}
		}else{
			echo '<a href="#" class="upload_image_button" rel="'.$post->ID.'"><img src="'.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/no-image.jpg" style="width:69px;height:69px;border:2px solid #CCC" /><input type="hidden" name="upload_image_id[1]" class="upload_image_id" value="0" /></a>';
		}
		
		echo '</div>';			
	}
}

add_action( 'admin_head', array('WPSC_Dynamic_Gallery_Metaboxes_Class','remove_wpsc_metaboxes') );
add_action( 'admin_head', array('WPSC_Dynamic_Gallery_Metaboxes_Class','wpsc_meta_boxes_image'), 10);
?>
