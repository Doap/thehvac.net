=== Store Locator Plus : Store Pages ===
Plugin Name:  Store Locator Plus : Store Pages
Contributors: charlestonsw
Donate link: http://www.storelocatorplus.com/product/slp4-store-pages/
Tags: google map, locator, finder, stores, SEO
Requires at least: 3.4
Tested up to: 3.9.1
Stable tag: 4.1.02

A premium add-on pack for Store Locator Plus that adds SEO friendly store pages generated from the location data.

== Description ==

You can have a WordPress page for each store location on your map turning your location data into SEO friendly content.  Store Pages are a special page type that is fully integrated with WordPress,  but you manage them through Store Locator Plus.  Store Pages also have their own taxonomy (category system) so you can manage Store Page categories without affecting the rest of your site.

= Features =

Store Pages are built directly from Store Locator Plus data.

Store Pages uses a serialized options table entry in WordPress, significantly reducing database I/O calls and increasing performance.

= Related Links =

* [Store Locator Plus](http://www.storelocatorplus.com/)
* [Other CSA Plugins](http://profiles.wordpress.org/charlestonsw/)

== Installation ==

= Requirements =

* Store Locator Plus: 4.1.08+
* WordPress: 3.4+
* PHP: 5.1+

= Install After SLP =

1. Go fetch and install Store Locator Plus or higher.
2. Purchase this plugin from CSA to get the latest .zip file.
3. Go to plugins/add new.
4. Select upload.
5. Upload the slp-pages.zip file.

== Frequently Asked Questions ==

= What are the terms of the license? =

The license is GPL.  You get the code, feel free to modify it as you
wish. I prefer that customers pay because they like what I do and
want to support the effort that brings useful software to market.  Learn more
on the [License Terms page](http://www.storelocatorplus.com/products/general-eula/).

== Changelog ==

= 4.1.02 =

* Fix: Patch the "not an object" error message when creating a default public post.

= 4.1.01 =

* Fix: If a Store Page is in draft mode the website link does not link to the Store Page.  It will also NOT link to the website URL noted in the location.
* Enhancement: New setting, Prepend URL with Blog Path will auto-prepend store page URLs with your WP install blog path.  Turn it off to just use the permalink setting.
* Enhancement: Phone and Fax label on the Store Page output is now WPML compatible.

= 4.1 =

* Change: Make Pages URL column an Expanded View column.
* Fix: Store Pages was stopping other add-on pack data queries "in their tracks" causing incomplete results.  This has been patched.