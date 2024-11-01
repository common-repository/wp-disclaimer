=== WP Disclaimer ===
Contributors: Horttcore
Donate link: http://horttcore.de/plugins/wp-disclaimer/
Tags: user, registration, sign up, disclaimer, agreement 
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: 2.0

WP Disclaimer

== Description ==

Users have to accept a disclaimer when they register.

!!!WARNING!!!
Template Tags updated, may break you page!

== Installation ==

Copy the wp-disclaimer folder into your plugin directory and activate the plugin.

== Usage ==

Add/Edit the Disclaimer via WP-Backend>Management>Disclaimer menu

== Frequently Asked Questions ==

= Are there any template functions? =
Yes, there is a function WP_Disclaimer::the_disclaimer(), that will display the disclaimer.

You might want to use the WP_Disclaimer::get_disclaimer() function, this will return the disclaimer and not echo it.

= Is there any Shortcode? =
Yes, there is the shortcode [DISCLAIMER] to display the disclaimer in your posts/pages

= Are there any hooks? =
You can use this filter ´apply_filters('wp-disclaimer')´

== Changelog ==

= 2.0 =
*    Added Shortcode
*    WYSIWYG Editor
*    Completely rewritten

… 