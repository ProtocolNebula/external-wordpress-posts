=== WP API Shortcodes ===
Contributors: hideokamoto
Donate link: https://note.mu/hideokamoto/n/nd0cecce0e758
Tags: wp-api
Requires at least: 4.1.0
Tested up to: 4.3.1
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Shortcode Plugin to get WordPress data from WP REST API(Version2)

== Description ==

You can use Simple Shortcode [wpapi-posts].
This shortcode can get many data from WP REST API(Version2).

##Shortcode Example
###Get 10 post from own Site
```
[wpapi-posts]
```

###Get 5 Posts from http://example.com/ writing about 'WP-API'
```
[wpapi-posts s="WP-API" url="http://example.com/" posts_per_page="5"]
```

###Get 10 Pages from own Site
```
[wpapi-posts type="pages"]
```

###Get 10 Thumbnail Images from http://example.com/
```
[wpapi-posts type="media" size="thumbnail"]
```

== Installation ==


1. Upload `wpapi-shortcodes-and-widgets` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What type can get WP-API ?  =

shortcodes can get 'posts','pages','media'.

= Can I use WP REST API(Version1)? =

Sorry, this plugin does not supported.

== Screenshots ==

1. No Images

== Changelog ==

= 2.0 =
2016/01/05 Support WP REST API(Version2)

= 1.0 =
2015/03/18 released

== Upgrade Notice ==
= 2.0 =
* Support WP REST API(Version2)
* Unsupport Widgets
