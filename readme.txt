=== WP e-Commerce Dynamic Gallery  ===
Contributors: a3rev, A3 Revolution Software Development team
Tags: WP e-Commerce image gallery, WP e-Commerce, WP e-Commerce Product images, e-commerce,  wordpress ecommerce
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Bring your product pages and presentation alive with WP e-Commerce Dynamic Gallery. Simply and Beautifully.
 
== Description ==

As soon as you install WP e-Commerce Dynamic Gallery it <strong>brings your store to life</strong> with a beautifully stylish sliding image gallery on every product page.  
 
= Key Features =

* Instantly adds a scrolling gallery to every product page and adds all product images to each gallery
* On-page Gallery easy manager greatly simplifies product image editing and gallery management.
* Gallery scales images to fit inside the container no matter what the size or shape.
* <strong>Search Engine friendly images</strong>. Image Alt tags if set are visible to search engines

Having an image with your products creates more sales. WP e-Commerce Dynamic Gallery allows you to show an unlimited number of images - it shows one image or lots of images in a beautiful and dynamic presentation.  

= More Features =

* Add caption text to images.
* Caption text fades in after image transition effect and out before the next transaction effect begins.
* Manual image click to scroll next or previous.
* ZOOM - shows full size image with caption text and manual scroll through entire gallery.
* START SLIDE SHOW | STOP SLIDESHOW manual control
* Gallery thumbnails scroll left and right on hover.

= Premium Upgrade =

A small once only Premium upgrade activates a total of 22 different settings that allows you to tweak and style the WP e-Commerce Dynamic Gallery to match your theme and your preferences to perfection. You will see all of the available upgrade features on the plugins admin panel.  

= Gold Cart Compatability =

WP e-Commerce Dynamic Gallery PRO is tested 100% compatible with the getshopped.org Premium 'Gold Cart' plugin. This Free lite available here on Wordpress will not work for you if you have the 'Gold Cart' installed and activated. 

= 100% Grid View Compatabile =

WP e-Commerce Dynamic Gallery is 100% compatabile with [WP e-Commerce Grid View](http://wordpress.org/extend/plugins/wp-e-commerce-grid-view/)

= Localization =

English (default) - always include.
.po file (wpsc_dgallery.po) in languages folder for translations.
If you do a translation of this plugin for your site [please send it to us](http://a3rev.com/contact/) for inclusion in the plugins language folder. We'll acknowledge your work and link to your site. 

= Plugins Resources =

[Pro Upgrade](http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/) |
[Plugin Documentation](http://docs.a3rev.com/user-guides/wp-e-commerce/wpec-dynamic-gallery/) |
[Support](http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/#help)

== Installation ==

= Minimum Requirements =

* WordPress 3.3 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
 
= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install of WP e-Commerce Dynamic Gallery, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New. 

In the search field type "WP e-Commerce Dynamic Gallery" and click Search Plugins. Once you have found our plugin you can install it by simply clicking Install Now. After clicking that link you will be asked if you are sure you want to install the plugin. Click yes and WordPress will automatically complete the installation. 

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favorite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installations wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.

== Screenshots ==

1. WP e-Commerce Dynamic Gallery
2. WP e-Commerce Dynamic Gallery activated admin settings (cut down view)
3. WP e-Commerce Dynamic Gallery on-page Gallery Image easy manager
4. WP e-Commerce Dynamic Gallery image editor - Add Caption text and exclude images from gallery feature.

== Usage ==

1. WP admin > Settings > Store > Dynamic Gallery

2. Set the wide and tall in px of the image gallery to match your theme.

3. Set the Wide and Tall in px of your gallery Thumbnails and the padding to show between them (at botton of admin page).

4. Use the Click here to preview gallery link to see a pop up preview of your work..

5. Save your changes.

6. Have fun.

== Frequently Asked Questions ==

= When can I use this plugin? =

You can use this plugin only when you have installed the WP e-Commerce plugin.
 
== Support ==

Support and access to this plugin documents are available from the [HELP tab](http://a3rev.com/products-page/wp-e-commerce/wp-e-commerce-dynamic-gallery/#help) on the Pro Versions Home page.

== Changelog ==

= 1.0.2 - 2012/09/05 =
* Fixed : Fixed: Gallery preview not working on sites that do not have wp_enqueue_script( 'thickbox' ) by default. Added call to wp_enqueue_script( 'thickbox' ) if it does not exist so that preview window can open.
* Fixed : Updated depreciated php function ereg() with stristr() so that Pro version auto plugin auto upgrade feature work without error for WordPress 3.4.0 and later
* Feature: Add fancybox script to plugin so that if the theme does not support fancybox or it is disabled in the admin panel then the gallery image zoom can still work.
* Feature: Enqueue plugin script into footer use wp_enqueue_script so that now it is only loaded when needed rather than site-wide and has zero impact on page load speeds.
* Feature: Enqueue plugin style into header use wp_enqueue_style so that now it is only loaded when needed rather than site-wide and has zero impact on page load speeds.
* Feature: Add plugin Documentation and Support links to the wp plugins dashboard description.
* Tweak: Plugins admin dashboard message and added links to other A3 WordPress WP e-Commerce plugins
* Tweak: Updated readme.
* Tweak: Add plugin description to wp plugins dashboard.
* Tweak: Change localization file path from actual to base path

= 1.0.1 - 2012/07/23 =
* Fix: Thumbnails show after editing thumbnail settings in the Store > Dynamic Gallery tab.

= 1.0 - 2012/07/18 =
* Initial release. 
