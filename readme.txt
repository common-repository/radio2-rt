=== Radio2 RT ===
Contributors: shellab
Donate link: http://shll.me/wishlist
Tags: radio2, river2, RT, retweet, open
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.1.0
License: GPLv2 or later

Maps the Radio2 style RT standard onto the Press This URL. 

== Description ==

This plugin checks for any of three query string params (link, title, description)
If they are present it redirects the page to the /wp-admin/press-this.php page
with the params u, t, s and v set appropriately.

The purpose is so static rivers like http://tech.newsriver.org/ will be able
to send a RT request to your blog.

== Installation ==

1. Upload `radio2-rt` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. *(Optional)* Place `<?php radio2rt_rt_link(); ?>` in your templates where you would like to see the RT links

== Frequently Asked Questions ==

= I'm not seeing RT links on my blog posts =

As of right now this is a semi-manual process.  Since I don't know where in 
your templates you want the RT links showing up you will need to edit your
templates and paste in `<?php radio2rt_rt_link(); ?>` where you want the
link to appear.

= What's Radio2 =

Radio2 is a microblogging platform by [Dave Winer](http://scripting.com) 
(the guy that popularized RSS) it supports three parameters (title, link and 
description) to pre-fill out the microblog post form. This plugin allows you
to accept the same parameters and route it to the WordPress "PressThis" page.

= Why would I want to do this? =

This plugin implements a new standard for a decentralized way to cross post
content in a way similar to Twitter's "Retweet" functionality. To learn more
about this new standard please read 
[A standard for RT'ing?](http://scripting.com/stories/2012/02/03/aStandardForRting.html)

== Changelog ==

= 1.1.0 =
* Added the ability to include RT links on your posts

== Upgrade Notice ==

= 1.1.0 =
Allows you to include RT links on your posts