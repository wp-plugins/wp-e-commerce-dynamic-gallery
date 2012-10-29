<?php
/**
 * WP e-Commerce Dynamic Gallery Display Class
 *
 * Class Function into WP e-Commerce plugin
 *
 * Table Of Contents
 *
 * html2rgb()
 * rgb2html()
 * wpsc_dynamic_gallery_display()
 * wpsc_dynamic_gallery_preview()
 */
class WPSC_Dynamic_Gallery_Display_Class{
	function html2rgb($color,$text = false){
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
	function rgb2html($r, $g=-1, $b=-1){
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
	function wpsc_dynamic_gallery_display($product_id = 0){
		/**
		 * Single Product Image
		 */
		global $post;
		if($product_id <= 0){
			$product_id = $post->ID;
		}
		//Gallery settings
		$g_width = get_option('product_gallery_width');
        $g_height = get_option('product_gallery_height');
		$g_auto = get_option('product_gallery_auto_start');
        $g_speed = get_option('product_gallery_speed');
        $g_effect = get_option('product_gallery_effect');
        $g_animation_speed = get_option('product_gallery_animation_speed');
		$bg_image_wrapper = get_option('bg_image_wrapper');
		$border_image_wrapper_color = get_option('border_image_wrapper_color');
		$popup_gallery = get_option('popup_gallery');
			
		//Caption text settings
		$caption_font = htmlspecialchars_decode( get_option('caption_font') );
		$caption_font_size = get_option('caption_font_size');
		$caption_font_style = get_option('caption_font_style');
		$product_gallery_text_color = get_option('product_gallery_text_color');
		$product_gallery_bg_des = get_option('product_gallery_bg_des');
		$bg_des = WPSC_Dynamic_Gallery_Display_Class::html2rgb($product_gallery_bg_des,true);
		$des_background =str_replace('#','',$product_gallery_bg_des);
			
		//Nav bar settings
		if(get_option('product_gallery_nav') == 'yes'){
			$product_gallery_nav = get_option('product_gallery_nav');
		}else{
			$product_gallery_nav = 'no';
		}
		$navbar_font = htmlspecialchars_decode (get_option('navbar_font'));
		$navbar_font_size = get_option('navbar_font_size');
		$navbar_font_style = get_option('navbar_font_style');
		$bg_nav_color = get_option('bg_nav_color');
		$bg_nav_text_color = get_option('bg_nav_text_color');
		$navbar_height = get_option('navbar_height');
		if($product_gallery_nav == 'yes'){
			$display_ctrl = 'display:block !important;';
			$mg = $navbar_height;
			$ldm = $navbar_height;		
		}else{
			$display_ctrl = 'display:none !important;';
			$mg = '0';
			$ldm = '0';
		}
			
		//Lazy-load scroll settings
		$transition_scroll_bar = get_option('transition_scroll_bar');
		$lazy_load_scroll = get_option('lazy_load_scroll');
			
		//Image Thumbnails settings
		if(get_option('enable_gallery_thumb') == 'yes'){
			$enable_gallery_thumb = get_option('enable_gallery_thumb');
		}else{
			$enable_gallery_thumb = 'no';
		}
        $g_thumb_width = get_option('thumb_width');
        $g_thumb_height = get_option('thumb_height');
        $g_thumb_spacing = get_option('thumb_spacing');
		
		$html = '';
		
        $html .= '<div class="images">
          <div class="product_gallery">';
                
            $html .=  '<style>
			#TB_window{width:auto !important;}
                .ad-gallery {
                        width: '.$g_width.'px;
						position:relative;
                }
                .ad-gallery .ad-image-wrapper {
					background:'.$bg_image_wrapper.';
                    width: '.($g_width-2).'px;
                    height: '.($g_height-2).'px;
                    margin: 0px;
                    position: relative;
                    overflow: hidden !important;
                    padding:0;
                    border:1px solid #'.$border_image_wrapper_color.';
					z-index:8 !important;
                }
				.ad-gallery .ad-image-wrapper .ad-image{width:100% !important;text-align:center;}
                .ad-image img{
                    max-width:'.$g_width.'px !important;
                }
                .ad-gallery .ad-thumbs li{
                    padding-right: '.$g_thumb_spacing.'px !important;
                }
                .ad-gallery .ad-thumbs li.last_item{
                    padding-right: '.($g_thumb_spacing+13).'px !important;
                }
                .ad-gallery .ad-thumbs li div{
                    height: '.$g_thumb_height.'px !important;
                    width: '.$g_thumb_width.'px !important;
                }
                .ad-gallery .ad-thumbs li a {
                    width: '.$g_thumb_width.'px !important;
                    height: '.$g_thumb_height.'px !important;	
                }
                * html .ad-gallery .ad-forward, .ad-gallery .ad-back{
                    height:	'.($g_thumb_height).'px !important;
                }
				
				/*Gallery*/
				.ad-image-wrapper{
					overflow:inherit !important;
				}
				
				.ad-gallery .ad-controls {
					background: '.$bg_nav_color.' !important;
					border:1px solid '.$bg_nav_color.';
					color: #FFFFFF;
					font-size: 12px;
					height: 22px;
					margin-top: 20px !important;
					padding: 8px 2% !important;
					position: relative;
					width: 95.8%;
					-khtml-border-radius:5px;
					-webkit-border-radius: 5px;
					-moz-border-radius: 5px;
					border-radius: 5px;display:none;
				}
				
				.ad-gallery .ad-info {
					float: right;
					font-size: 14px;
					position: relative;
					right: 8px;
					text-shadow: 1px 1px 1px #000000 !important;
					top: 1px !important;
				}
				.ad-gallery .ad-nav .ad-thumbs{
					margin:7px 4% 0 !important;
				}
				.ad-gallery .ad-nav{
					margin-top:20px !important;
				}
				.ad-gallery .ad-thumbs .ad-thumb-list {
					margin-top: 0px !important;
				}
				.ad-thumb-list{
				}
				.ad-thumb-list li{
					background:none !important;
					padding-bottom:0 !important;
					padding-left:0 !important;
					padding-top:0 !important;
				}
				.ad-gallery .ad-image-wrapper .ad-image-description {
					background: rgba('.$bg_des.',0.5);
					filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr="#88'.$des_background.'", EndColorStr="#88'.$des_background.'");

					margin: 0 0 '.$mg.'px !important;
					color: '.$product_gallery_text_color.' !important;
					font-family:'.$caption_font.' !important;
					font-size: '.$caption_font_size.';';
					
					if($caption_font_style == 'bold'){
						$html .=  'font-weight:bold !important;';
					}elseif($caption_font_style == 'normal'){
						$html .=  'font-weight:normal !important;';
					}elseif($caption_font_style == 'italic'){
						$html .=  'font-style:italic !important;';
					}elseif($caption_font_style == 'bold_italic'){
						$html .=  'font-weight:bold !important;';
						$html .=  'font-style:italic !important;';
					}
					
					$html .=  '
					left: 0;
					line-height: 1.4em;
					padding:2% 2% 2% !important;
					position: absolute;
					text-align: left;
					width: 96.1% !important;
					z-index: 10;
					font-weight:normal;
				}
				.product_gallery .ad-gallery .ad-image-wrapper {
					background: none repeat scroll 0 0 '.$bg_image_wrapper.';
					border: 1px solid '.$border_image_wrapper_color.' !important;
					padding-bottom:'.$mg.'px;
				}
				.product_gallery .slide-ctrl, .product_gallery .icon_zoom {
					'.$display_ctrl.';
					font-family:'.$navbar_font.' !important;
					font-size: '.$navbar_font_size.';
					height: '.($navbar_height-16).'px !important;
					line-height: '.($navbar_height-16).'px !important;';
					if($navbar_font_style == 'bold'){
						$html .=  'font-weight:bold !important;';
					}elseif($navbar_font_style == 'normal'){
						$html .=  'font-weight:normal !important;';
					}elseif($navbar_font_style == 'italic'){
						$html .=  'font-style:italic !important;';
					}elseif($navbar_font_style == 'bold_italic'){
						$html .=  'font-weight:bold !important;';
						$html .=  'font-style:italic !important;';
					}
				$html .=  '
				}';
				if($lazy_load_scroll == 'yes'){
					$html .=  '.ad-gallery .lazy-load{
						background:'.$transition_scroll_bar.' !important;
						top:'.($g_height + 9).'px !important;
						opacity:1 !important;
						margin-top:'.$ldm.'px !important;
					}';
				}else{
					$html .=  '.ad-gallery .lazy-load{display:none!important;}';
				}
				$html .= '
				.product_gallery .icon_zoom {
					background: '.$bg_nav_color.';
					border-right: 1px solid '.$bg_nav_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl {
					background:'.$bg_nav_color.';
					border-left: 1px solid '.$border_image_wrapper_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl .ad-slideshow-stop-slide,.product_gallery .slide-ctrl .ad-slideshow-start-slide,.product_gallery .icon_zoom{
					color:'.$bg_nav_text_color.';
					line-height: '.($navbar_height-16).'px !important;
				}
				.product_gallery .ad-gallery .ad-thumbs li a {
					border:1px solid '.$border_image_wrapper_color.' !important;
				}
				.ad-gallery .ad-thumbs li a.ad-active {
					border: 1px solid '.$transition_scroll_bar.' !important;
				}';
			if($enable_gallery_thumb == 'no'){
				$html .=  '.ad-nav{display:none;}.woocommerce .images { margin-bottom: 15px;}';
			}	
			
			if($product_gallery_nav == 'no'){
				$html .=  '
				.ad-image-wrapper:hover .slide-ctrl{display: block !important;}
				.product_gallery .slide-ctrl {
					background: none repeat scroll 0 0 transparent;
					border: medium none;
					height: 50px !important;
					left: 41.5% !important;
					top: 38% !important;
					width: 50px !important;
				}';
				$html .=  '.product_gallery .slide-ctrl .ad-slideshow-start-slide {background: url('.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/play.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
				$html .=  '.product_gallery .slide-ctrl .ad-slideshow-stop-slide {background: url('.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/pause.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
			}
			
			$html .=  '
            </style>';
            
            $html .=  '<script type="text/javascript">
                jQuery(function() {
                    var settings_defaults_'.$product_id.' = { loader_image: \''.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/loader.gif\',
                        start_at_index: 0,
                        gallery_ID: \''.$product_id.'\',
                        description_wrapper: false,
                        thumb_opacity: 0.5,
                        animate_first_image: false,
                        animation_speed: '.$g_animation_speed.'000,
                        width: false,
                        height: false,
                        display_next_and_prev: true,
                        display_back_and_forward: true,
                        scroll_jump: 0, // If 0, it jumps the width of the container
                        slideshow: {
                            enable: true,
                            autostart: '.$g_auto.',
                            speed: '.$g_speed.'000,
                            start_label: "'.__('START SLIDESHOW', 'wpsc_dgallery').'",
                            stop_label: "'.__('STOP SLIDESHOW', 'wpsc_dgallery').'",
							zoom_label: "'.__('ZOOM +', 'wpsc_dgallery').'",
                            stop_on_scroll: true,
                            countdown_prefix: \'(\',
                            countdown_sufix: \')\',
                            onStart: false,
                            onStop: false
                        },
                        effect: \''.$g_effect.'\', 
                        enable_keyboard_move: true,
                        cycle: true,
                        callbacks: {
                        init: false,
                        afterImageVisible: false,
                        beforeImageVisible: false
                    }
                };
                jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');
            });
            </script>';
            $html .=  '<div id="gallery_'.$product_id.'" class="ad-gallery">
                <div class="ad-image-wrapper"></div>
                <div class="ad-controls"> </div>
                  <div class="ad-nav">
                    <div class="ad-thumbs">
                      <ul class="ad-thumb-list">';
                        // Get all attached images to this product
                        
						$args = array(
							'post_type'      => 'attachment',
							'post_parent'    => $product_id,
							'post_mime_type' => 'image',
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
							'numberposts'    => -1
						); 
						$attached_images = get_posts($args);
						$featured_img = get_post_meta($product_id, '_thumbnail_id');
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
						
                        $script_lightbox = '';
						$script_fancybox = '';
                        if ( count( $attached_thumb ) > 0 ){	
                            $i = 0;
                            $display = '';
							
							if( is_array($attached_thumb) && count($attached_thumb) > 0 ){
                                $script_lightbox .= '<script type="text/javascript">';
								$script_fancybox .= '<script type="text/javascript">';
                                $script_lightbox .= '(function($){';		  
								$script_fancybox .= '(function($){';		  
                                $script_lightbox .= '$(function(){';
								$script_fancybox .= '$(function(){';
                                $script_lightbox .= '$(".ad-gallery .lightbox").live("click",function(ev) { if( $(this).attr("rel") == "gallery_'.$product_id.'") {
									var idx = $("#gallery_'.$product_id.' .ad-image img").attr("idx");';
								$script_fancybox .= '$(".ad-gallery .lightbox").live("click",function(ev) { if( $(this).attr("rel") == "gallery_'.$product_id.'") {
									var idx = $("#gallery_'.$product_id.' .ad-image img").attr("idx");';
                                if(count($attached_thumb) <= 1 ){
                                    $script_lightbox .= '$.lightbox(';
									$script_fancybox .= '$.fancybox(';
                                }else{
                                    $script_lightbox .= '$.lightbox([';
									$script_fancybox .= '$.fancybox([';
                                }
                                $common = '';
                                
								if($attached_thumb){
									$idx = 0;
                                foreach($attached_thumb as $item_thumb){
									if ( get_post_meta( $item_thumb->ID, '_wpsc_exclude_image', true ) == 1 ) continue;
                                    $li_class = '';
                                    if($i == 0){ $li_class = 'first_item';}elseif($i == count($attached_images)-1){$li_class = 'last_item';}
                                    $image_attribute = wp_get_attachment_image_src( $item_thumb->ID, 'full');
                                    $image_lager_default_url = $image_attribute[0];
                                    $thumb_height = $g_thumb_height;
                                    $thumb_width = $g_thumb_width;
                                    $width_old = $image_attribute[1];
                                    $height_old = $image_attribute[2];
                                     if($width_old > $g_thumb_width || $height_old > $g_thumb_height){
                                        if($height_old > $g_thumb_height) {
                                            $factor = ($height_old / $g_thumb_height);
                                            $thumb_height = $g_thumb_height;
                                            $thumb_width = $width_old / $factor;
                                        }
                                        if($thumb_width > $g_thumb_width){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }elseif($thumb_width == $g_thumb_width && $width_old > $g_thumb_width){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }						
                                    }else{
                                         $thumb_height = $height_old;
                                        $thumb_width = $width_old;
                                    }
                                   $alt = get_post_meta($item_thumb->ID, '_wp_attachment_image_alt', true);
								   $img_description = $item_thumb->post_excerpt;
								   if($img_description == ''){
									   $img_description = $alt;
								   }
                                            
                                    $html .=  '<li class="'.$li_class.'"><a alt="'.$alt.'" class="" title="'.$img_description.'" rel="gallery_product_'.$product_id.'" href="'.$image_lager_default_url.'"><div><img idx="'.$idx.'" style="width:'.$thumb_width.'px !important;height:'.$thumb_height.'px !important" src="'.$image_lager_default_url.'" alt="'.$img_description.'" class="image'.$i.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div></a></li>';
                                    $img_description = trim(strip_tags(stripslashes(str_replace("'","", str_replace('"', '', $img_description)))));
                                    if($img_description != ''){
                                        $script_lightbox .= $common.'"'.$image_lager_default_url.'?lightbox[title]='.$img_description.'"';
										$script_fancybox .= $common.'{href:\''.$image_lager_default_url.'\',title:\''.$img_description.'\'}';
                                    }else{
                                        $script_lightbox .= $common.'"'.$image_lager_default_url.'"';
										$script_fancybox .= $common.'{href:\''.$image_lager_default_url.'\',title:\'\'}';
                                    }
                                    $common = ',';
                                    $i++;
									$idx++;
                                 }
								}
								 //$.fancybox([ {href : 'img1.jpg', title : 'Title'}, {href : 'img2.jpg', title : 'Title'} ])
                                if(count($attached_thumb) <= 1 ){
                                    $script_lightbox .= ');';
									$script_fancybox .= ');';
                                }else{
                                    $script_lightbox .= ']);';
									$script_fancybox .= '],{
										 \'index\': idx
      								});';
                                }
                                $script_lightbox .= 'ev.preventDefault();';
                                $script_lightbox .= '} });';
								$script_fancybox .= '} });';
                                $script_lightbox .= '});';
								$script_fancybox .= '});';
                                $script_lightbox .= '})(jQuery);';
								$script_fancybox .= '})(jQuery);';
                                $script_lightbox .= '</script>';
								$script_fancybox .= '</script>';
                            }
                        }else{
                            $html .=  '<li style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;"> <a style="width:'.($g_thumb_width-2).'px !important;height:'.($g_thumb_height - 2).'px !important;overflow:hidden;float:left !important" class="lightbox" rel="gallery_product_'.$product_id.'" href="'.WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/no-image.png"> <div><img style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;" src="'.WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/no-image.png" class="image" alt=""> </div></a> </li>';	
                        }
						if($popup_gallery == 'lb'){
                        	$html .=  $script_lightbox;
						}else{
							$html .=  $script_fancybox;
						}
                        $html .=  '</ul>
                        </div>
                      </div>
                    </div>
          		</div>
        </div>';
		
		return $html;
	}
	
	
	function wpsc_dynamic_gallery_preview($request = ''){
		/**
		 * Single Product Image
		 */
		?>
        <div class="images" style="width:<?php echo $request['product_gallery_width'].'px';?>;margin:30px auto;">
          <div class="product_gallery">
            <?php
			//Gallery settings
            $g_width = $request['product_gallery_width'];
            $g_height = $request['product_gallery_height'];
			
			$g_auto = get_option('product_gallery_auto_start');
			$g_speed = get_option('product_gallery_speed');
			$g_effect = get_option('product_gallery_effect');
			$g_animation_speed = get_option('product_gallery_animation_speed');
			$bg_image_wrapper = get_option('bg_image_wrapper');
			$border_image_wrapper_color = get_option('border_image_wrapper_color');
			$popup_gallery = get_option('popup_gallery');
				
			//Caption text settings
			$caption_font = htmlspecialchars_decode( get_option('caption_font') );
			$caption_font_size = get_option('caption_font_size');
			$caption_font_style = get_option('caption_font_style');
			$product_gallery_text_color = get_option('product_gallery_text_color');
			$product_gallery_bg_des = get_option('product_gallery_bg_des');
			$bg_des = WPSC_Dynamic_Gallery_Display_Class::html2rgb($product_gallery_bg_des,true);
			$des_background =str_replace('#','',$product_gallery_bg_des);
				
			//Nav bar settings
			if(get_option('product_gallery_nav') == 'yes'){
				$product_gallery_nav = get_option('product_gallery_nav');
			}else{
				$product_gallery_nav = 'no';
			}
			$navbar_font = htmlspecialchars_decode (get_option('navbar_font'));
			$navbar_font_size = get_option('navbar_font_size');
			$navbar_font_style = get_option('navbar_font_style');
			$bg_nav_color = get_option('bg_nav_color');
			$bg_nav_text_color = get_option('bg_nav_text_color');
			$navbar_height = get_option('navbar_height');
			if($product_gallery_nav == 'yes'){
				$display_ctrl = 'display:block !important;';
				$mg = $navbar_height;
				$ldm = $navbar_height;		
			}else{
				$display_ctrl = 'display:none !important;';
				$mg = '0';
				$ldm = '0';
			}
				
			//Lazy-load scroll settings
			$transition_scroll_bar = get_option('transition_scroll_bar');
			$lazy_load_scroll = get_option('lazy_load_scroll');
				
			//Image Thumbnails settings
			if(get_option('enable_gallery_thumb') == 'yes'){
				$enable_gallery_thumb = get_option('enable_gallery_thumb');
			}else{
				$enable_gallery_thumb = 'no';
			}
			
            $g_thumb_width = $request['thumb_width'];
            $g_thumb_height = $request['thumb_height'];
            $g_thumb_spacing = $request['thumb_spacing'];
                
            $product_id = rand(10, 10000);
            echo '<style>
			#TB_window{width:auto !important;}
                .ad-gallery {
                        width: '.$g_width.'px;
						position:relative;
                }
                .ad-gallery .ad-image-wrapper {
					background:'.$bg_image_wrapper.';
                    width: '.($g_width-2).'px;
                    height: '.($g_height-2).'px;
                    margin: 0px;
                    position: relative;
                    overflow: hidden !important;
                    padding:0;
                    border:1px solid #'.$border_image_wrapper_color.';
					z-index:1000 !important;
                }
				.ad-gallery .ad-image-wrapper .ad-image{width:100% !important;text-align:center;}
                .ad-image img{
                    max-width:'.$g_width.'px !important;
                }
                .ad-gallery .ad-thumbs li{
                    padding-right: '.$g_thumb_spacing.'px !important;
                }
                .ad-gallery .ad-thumbs li.last_item{
                    padding-right: '.($g_thumb_spacing+13).'px !important;
                }
                .ad-gallery .ad-thumbs li div{
                    height: '.$g_thumb_height.'px !important;
                    width: '.$g_thumb_width.'px !important;
                }
                .ad-gallery .ad-thumbs li a {
                    width: '.$g_thumb_width.'px !important;
                    height: '.$g_thumb_height.'px !important;	
                }
                * html .ad-gallery .ad-forward, .ad-gallery .ad-back{
                    height:	'.($g_thumb_height).'px !important;
                }
				
				/*Gallery*/
				.ad-image-wrapper{
					overflow:inherit !important;
				}
				
				.ad-gallery .ad-controls {
					background: '.$bg_nav_color.' !important;
					border:1px solid '.$bg_nav_color.';
					color: #FFFFFF;
					font-size: 12px;
					height: 22px;
					margin-top: 20px !important;
					padding: 8px 2% !important;
					position: relative;
					width: 95.8%;
					-khtml-border-radius:5px;
					-webkit-border-radius: 5px;
					-moz-border-radius: 5px;
					border-radius: 5px;display:none;
				}
				
				.ad-gallery .ad-info {
					float: right;
					font-size: 14px;
					position: relative;
					right: 8px;
					text-shadow: 1px 1px 1px #000000 !important;
					top: 1px !important;
				}
				.ad-gallery .ad-nav .ad-thumbs{
					margin:7px 4% 0 !important;
				}
				.ad-gallery .ad-nav{
					margin-top:20px !important;
				}
				.ad-gallery .ad-thumbs .ad-thumb-list {
					margin-top: 0px !important;
				}
				.ad-thumb-list{
				}
				.ad-thumb-list li{
					background:none !important;
					padding-bottom:0 !important;
					padding-left:0 !important;
					padding-top:0 !important;
				}
				.ad-gallery .ad-image-wrapper .ad-image-description {
					background: rgba('.$bg_des.',0.5);
					filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr="#88'.$des_background.'", EndColorStr="#88'.$des_background.'");
					bottom: '.($mg-1).'px !important;
					color: '.$product_gallery_text_color.' !important;
					font-family:'.$caption_font.' !important;
					font-size: '.$caption_font_size.';';
					if($caption_font_style == 'bold'){
						echo 'font-weight:bold !important;';
					}elseif($caption_font_style == 'normal'){
						echo 'font-weight:normal !important;';
					}elseif($caption_font_style == 'italic'){
						echo 'font-style:italic !important;';
					}elseif($caption_font_style == 'bold_italic'){
						echo 'font-weight:bold !important;';
						echo 'font-style:italic !important;';
					}
					echo '
					left: 0;
					line-height: 1.4em;
					margin: 0 !important;
					padding:2% 2% 2% !important;
					position: absolute;
					text-align: left;
					width: 96.1% !important;
					z-index: 10;
					font-weight:normal;
				}
				.product_gallery .ad-gallery .ad-image-wrapper {
					background: none repeat scroll 0 0 '.$bg_image_wrapper.';
					border: 1px solid '.$border_image_wrapper_color.' !important;
					padding-bottom:'.$mg.'px;
				}';
				if($lazy_load_scroll == 'yes'){
					echo '.ad-gallery .lazy-load{
						background:'.$transition_scroll_bar.' !important;
						top:'.($g_height + 9).'px !important;
						opacity:1 !important;
						margin-top:'.$ldm.'px !important;
					}';
				}else{
					echo '.ad-gallery .lazy-load{display:none!important;}';
				}
				echo'
				.product_gallery .slide-ctrl, .product_gallery .icon_zoom {
					'.$display_ctrl.';
					font-family:'.$navbar_font.' !important;
					font-size: '.$navbar_font_size.';
					height: '.($navbar_height-16).'px !important;
					line-height: '.($navbar_height-16).'px !important;';
					
					if($navbar_font_style == 'bold'){
						echo 'font-weight:bold !important;';
					}elseif($navbar_font_style == 'normal'){
						echo 'font-weight:normal !important;';
					}elseif($navbar_font_style == 'italic'){
						echo 'font-style:italic !important;';
					}elseif($navbar_font_style == 'bold_italic'){
						echo 'font-weight:bold !important;';
						echo 'font-style:italic !important;';
					}
				echo '
				}
				.ad-gallery .lazy-load{
					background:'.$transition_scroll_bar.' !important;
					top:'.($g_height + 9).'px !important;
					opacity:1 !important;
					margin-top:'.$ldm.'px !important;
				}
				.product_gallery .icon_zoom {
					background: '.$bg_nav_color.';
					border-right: 1px solid '.$bg_nav_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl {
					background:'.$bg_nav_color.';
					border-left: 1px solid '.$border_image_wrapper_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl .ad-slideshow-stop-slide,.product_gallery .slide-ctrl .ad-slideshow-start-slide,.product_gallery .icon_zoom{
					color:'.$bg_nav_text_color.';
					line-height: '.($navbar_height-16).'px !important;
				}
				.product_gallery .ad-gallery .ad-thumbs li a {
					border:1px solid '.$border_image_wrapper_color.' !important;
				}
				.ad-gallery .ad-thumbs li a.ad-active {
					border: 1px solid '.$transition_scroll_bar.' !important;
					/*border: 1px solid '.$bg_nav_color.' !important;*/
				}';
			if($enable_gallery_thumb == 'no'){
				echo '.ad-nav{display:none;}.woocommerce .images { margin-bottom: 15px;}';
			}	
			
			if($product_gallery_nav == 'no'){
				echo '
				.ad-image-wrapper:hover .slide-ctrl{display: block !important;}
				.product_gallery .slide-ctrl {
					background: none repeat scroll 0 0 transparent;
					border: medium none;
					height: 50px !important;
					left: 41.5% !important;
					top: 38% !important;
					width: 50px !important;
				}';
				echo '.product_gallery .slide-ctrl .ad-slideshow-start-slide {background: url('.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/play.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
				echo '.product_gallery .slide-ctrl .ad-slideshow-stop-slide {background: url('.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/pause.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
			}
			
			echo '
            </style>';
            
            echo '<script type="text/javascript">
                jQuery(function() {
                    var settings_defaults_'.$product_id.' = { loader_image: \''.WPSC_DYNAMIC_GALLERY_JS_URL.'/mygallery/loader.gif\',
                        start_at_index: 0,
                        gallery_ID: \''.$product_id.'\',
                        description_wrapper: false,
                        thumb_opacity: 0.5,
                        animate_first_image: false,
                        animation_speed: '.$g_animation_speed.'000,
                        width: false,
                        height: false,
                        display_next_and_prev: true,
                        display_back_and_forward: true,
                        scroll_jump: 0, // If 0, it jumps the width of the container
                        slideshow: {
                            enable: true,
                            autostart: '.$g_auto.',
                            speed: '.$g_speed.'000,
                            start_label: "'.__('START SLIDESHOW', 'wpsc_dgallery').'",
                            stop_label: "'.__('STOP SLIDESHOW', 'wpsc_dgallery').'",
							zoom_label: "'.__('ZOOM +', 'wpsc_dgallery').'",
                            stop_on_scroll: true,
                            countdown_prefix: \'(\',
                            countdown_sufix: \')\',
                            onStart: false,
                            onStop: false
                        },
                        effect: \''.$g_effect.'\', 
                        enable_keyboard_move: true,
                        cycle: true,
                        callbacks: {
                        init: false,
                        afterImageVisible: false,
                        beforeImageVisible: false
                    }
                };
                jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');
            });
            </script>';
            echo '<div id="gallery_'.$product_id.'" class="ad-gallery">
                <div class="ad-image-wrapper"></div>
                <div class="ad-controls"> </div>
                  <div class="ad-nav">
                    <div class="ad-thumbs">
                      <ul class="ad-thumb-list">';
						
						$url_demo_img =  '/assets/js/mygallery/images/';
                        $imgs = array($url_demo_img.'image_1.jpg',$url_demo_img.'image_2.jpg',$url_demo_img.'image_3.jpg',$url_demo_img.'image_4.jpg');
                        
                        $script_lightbox = '';
						$script_fancybox = '';
                        if ( !empty( $imgs ) ){	
                            $i = 0;
                            $display = '';
			
                            if(is_array($imgs) && count($imgs)>0){
                                $script_lightbox .= '<script type="text/javascript">';
								$script_fancybox .= '<script type="text/javascript">';
                                $script_lightbox .= '(function($){';		  
								$script_fancybox .= '(function($){';		  
                                $script_lightbox .= '$(function(){';
								$script_fancybox .= '$(function(){';
                                $script_lightbox .= '$(".ad-gallery .lightbox").live("click",function(ev) { if( $(this).attr("rel") == "gallery_'.$product_id.'") {';
								$script_fancybox .= '$(".ad-gallery .lightbox").live("click",function(ev) { if( $(this).attr("rel") == "gallery_'.$product_id.'") {
								var idx = $(".ad-image img").attr("idx");';
                                if(count($imgs) <= 1 ){
                                    $script_lightbox .= '$.lightbox(';
									$script_fancybox .= '$.fancybox(';
                                }else{
                                    $script_lightbox .= '$.lightbox([';
									$script_fancybox .= '$.fancybox([';
                                }
                                $common = '';
                                $idx = 0;
                                foreach($imgs as $item_thumb){
                                    $li_class = '';
                                    if($i == 0){ $li_class = 'first_item';}elseif($i == count($imgs)-1){$li_class = 'last_item';}
                                    $image_attribute = getimagesize( WPSC_DYNAMIC_GALLERY_DIR . $item_thumb);
                                    $image_lager_default_url = WPSC_DYNAMIC_GALLERY_URL . $item_thumb;
									
									
                                    $thumb_height = $g_thumb_height;
                                    $thumb_width = $g_thumb_width;
                                    $width_old = $image_attribute[0];
                                    $height_old = $image_attribute[1];
                                     if($width_old > $g_thumb_width || $height_old > $g_thumb_height){
                                        if($height_old > $g_thumb_height) {
                                            $factor = ($height_old / $g_thumb_height);
                                            $thumb_height = $g_thumb_height;
                                            $thumb_width = $width_old / $factor;
                                        }
                                        if($thumb_width > $g_thumb_width){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }elseif($thumb_width == $g_thumb_width && $width_old > $g_thumb_width){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }						
                                    }else{
                                         $thumb_height = $height_old;
                                        $thumb_width = $width_old;
                                    }
                                    
                                    
                                        
                                    $img_description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
                                            
                                    echo '<li class="'.$li_class.'"><a class="" title="'.$img_description.'" rel="gallery_product_'.$product_id.'" href="'.$image_lager_default_url.'"><div><img idx="'.$idx.'" style="width:'.$thumb_width.'px !important;height:'.$thumb_height.'px !important" src="'.$image_lager_default_url.'" alt="'.$img_description.'" class="image'.$i.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div></a></li>';
                                    $img_description = trim(strip_tags(stripslashes(str_replace("'","", str_replace('"', '', $img_description)))));
                                    if($img_description != ''){
                                        $script_lightbox .= $common.'"'.$image_lager_default_url.'?lightbox[title]='.$img_description.'"';
										$script_fancybox .= $common.'{href:\''.$image_lager_default_url.'\',title:\''.$img_description.'\'}';
                                    }else{
                                        $script_lightbox .= $common.'"'.$image_lager_default_url.'"';
										$script_fancybox .= $common.'{href:\''.$image_lager_default_url.'\',title:\'\'}';
                                    }
                                    $common = ',';
                                    $i++;
									$idx++;
                                 }
								 //$.fancybox([ {href : 'img1.jpg', title : 'Title'}, {href : 'img2.jpg', title : 'Title'} ])
                                if(count($imgs) <= 1 ){
                                    $script_lightbox .= ');';
									$script_fancybox .= ');';
                                }else{
                                    $script_lightbox .= ']);';
									$script_fancybox .= '],{
        \'index\': idx
      });';
                                }
                                $script_lightbox .= 'ev.preventDefault();';
                                $script_lightbox .= '} });';
								$script_fancybox .= '} });';
                                $script_lightbox .= '});';
								$script_fancybox .= '});';
                                $script_lightbox .= '})(jQuery);';
								$script_fancybox .= '})(jQuery);';
                                $script_lightbox .= '</script>';
								$script_fancybox .= '</script>';
                            }
                        }else{
                            echo '<li> <a class="lightbox" rel="gallery_product_'.$product_id.'" href="'.WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/no-image.png"> <img src="'.WPSC_DYNAMIC_GALLERY_JS_URL . '/mygallery/no-image.png" class="image" alt=""> </a> </li>';
									
                        }
						if($popup_gallery == 'lb'){
                        	echo $script_lightbox;
						}else{
							echo $script_fancybox;
						}
                        echo '</ul>
                        </div>
                      </div>
                    </div>';
                  ?>
          </div>
        </div>
	<?php
	die();
	}
}
?>