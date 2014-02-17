=== Bitbucket issue manager ===
Contributors: gabrielbs
Donate link: http://goo.gl/v9CW1R
Tags: bitbucket, widgets, dashboard,
Requires at least: 3
Tested up to: 3.8.1
Stable tag: 0.8.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Check your latest issues from BitBucket directly on your WordPress dashboard.

== Description ==

With this plugin you can easily check your latest issues on BitBucket right on your Dashboard.
The recently created and the solved ones.

There are two widgets available after install:

* Recently opened issues
* Recently closed issues

= Upcoming features =

* Issue listing page.
* Front-end widget
* Issue emmbedding shortcode
* Auto-issue linking on posts.

== Installation ==

This section describes how to install the plugin and get it working.

1. Uncompress `bitbucket-issue-manager.zip`
2. Upload `bitbucket-issue-manager` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings -> General and set up your username and repository you want watch.

== Frequently Asked Questions ==

= Why do i don't see my issues? =

Check your username and respository under Settings -> General page on your WP installation.

= Why i'm getting an 403 Forbidden error? =

Please, make sure your repository issues are public.

== Screenshots ==

1. Example General Settings page showing the BitBucket issue manager fields.

== Changelog ==

= 0.8.2 =
* Fixes a misspelled opdtion name and properly deletes it (Will stop deleting the wrong name
on version 1, and the value will be stored on your db for ever if you don't update before
that version).
* Added admin notice when the user or repo are not set in General Settings page.

= 0.8.1 =
* Added hability to delete self data on uninstall. 

= 0.8 =
* Initial release on Wordpress.org

= 0.7 =
* First stable version with Settings API

== Upgrade Notice ==

= 0.8.2 =
Notices the user on the Dashboard if the username or repository name are not set.
First version which fixes the error on previous versions about one option name. The plugin
will be fixing this error until the release of version 1.

= 0.8 =
First release. You should get it if you use BitBucket. ;)