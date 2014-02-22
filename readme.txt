=== Bitbucket Issue Manager ===
Contributors: gabrielbs
Donate link: http://goo.gl/v9CW1R
Tags: bitbucket, widgets, dashboard,
Requires at least: 3
Tested up to: 3.8.1
Stable tag: 0.8.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Check your latest issues from BitBucket directly on your WordPress dashboard.

== Description ==

= What's this? ==

This plugins just aims to be a simple solution to check your project issues or tasks on hold, and completed right inside your WordPress dashboard. However, i pretend to add some extra features soon as shown at the bottom of this section.

At the moment, there are two dashboard widgets available after install:

* Recently opened issues
* Recently closed issues

== Upcoming ==

* Issue listing page.
* Front-end widget
* Issue emmbedding shortcode
* Auto-issue linking on posts.

= ¿Sugestions? =

Do you have any idea that think could be great for this plugin? Miss some feature? Please, [open an issue on GitHub](https://github.com/GabrielGil/bitbucket-issue-manager/issues) repository or add a new [support ticket](https://wordpress.org/support/plugin/bitbucket-issue-manager) on the [plugin WordPress page](https://wordpress.org/plugin/bitbucket-issue-manager) with your idea. I would love to hear you words.

You can also wirte me directly at hello (at) gabrielgil (dot) es

= Translations =

Righ now this plugins is in process to be full compatible with locations, but it's available in `en_US` by default.

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

= 0.8.3 =
* Now the issue date is shown using `human_diff_time()`. (e.g. *5 hours ago* instead *02-18-2013*)
* Shows updated *n* time ago
* Fully localized
* Internal performance issues
* Solves some php strict errors

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

= 0.8.3 =
Now BIM is fully localized. Also some new features about handle errors, or missing config.

= 0.8.2 =
Notices the user on the Dashboard if the username or repository name are not set.
First version which fixes the error on previous versions about one option name. The plugin
will be fixing this error until the release of version 1.

= 0.8 =
First release. You should get it if you use BitBucket. ;)