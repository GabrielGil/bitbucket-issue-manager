# Wordpress BitBucket Issue Manager

With this plugin you can easily check your latest issues on BitBucket right on your Dashboard.
The recently created and the solved ones.

At the moment, there are two widgets available after install:

* Recently opened issues
* Recently closed issues

[Get it on WordPress.org](http://goo.gl/VCglW7 "Bitbucket Issue Manager on WordPress.org") official repo.


## Upcoming features

* Issue listing page.
* Front-end widget
* Issue emmbedding shortcode
* Auto-issue linking on posts.

## ¿Sugestions?

Do you have any idea that think could be great for this plugin? Miss some feature? Please, [open an issue on GitHub](https://github.com/GabrielGil/bitbucket-issue-manager/issues) repository or add a new [support ticket](https://wordpress.org/support/plugin/bitbucket-issue-manager) on the [plugin WordPress page](https://wordpress.org/plugin/bitbucket-issue-manager) with your idea. I would love to hear you words.

You can also wirte me directly at hellogabrielgil (dot) es


## Translations

Righ now this plugins is in process to be full compatible with locations, but it's available in `en_US` by default.


## Frequently Asked Questions

### Why do i don't see my issues?

Check your username and respository under Settings -> General page on your WP installation.

### Why i'm getting an 403 Forbidden error?

Please, make sure your repository issues are public.


## Changelog

### 0.8.3
* Now the issue date is shown using `human_diff_time()`. (e.g. *5 hours ago* instead *02-18-2013*)
* Shows updated *n* time ago
* Fully localized
* Internal performance issues
* Solves some php strict errors

### 0.8.2
* Fixes a misspelled opdtion name and properly deletes it (Will stop deleting the wrong name
on version 1, and the value will be stored on your db for ever if you don't update before
that version).
* Added admin notice when the user or repo are not set in General Settings page.

### 0.8.1
* Added hability to delete self data on uninstall. 

### 0.8
* Initial release on Wordpress.org

### 0.7
* First stable version with Settings API