=== Post Edit Toolbar ===
Contributors: WebYourBusiness,greghl
Donate link: http://webyourbusiness.com/post-edit-toolbar
Tags: Post, posts, admin, edit post, toolbar, admin bar, list posts, list drafts, edit page, edit page list, edit post list, page edit toolbar, post edit toolbar, sidebar, helper
Requires at least: 3.1
Tested up to: 4.4
Stable tag: 1.4.12
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a pair of dropdowns 'Page list' and 'Post List' to the WordPress toolbar of the most recently edited pages, drafts, future schedules pages + posts.

== Description ==

Adds a pair of dropdowns 'Page list' and 'Post List' to the WordPress toolbar of the most recently edited pages, drafts, future schedules pages + posts. This provides you quick access to a work in progress, or a page/post that was recently published.

The new menus work as 'post quick edit' and 'page quick edit' shortcut menus - not forgetting 'drafts quick edit'.  The quick edit menus will allow you to access your recently used pages, posts, drafts and even your scheduled posts + pages in less clicks than first visting the posts page or pages page.

This plugin is designed for publishers who get interrupted while composing those posts (if you're anything like me - almost every post/page is interrupted, or composed and then saved as a draft before final publishing!

Currently this plugin displays a separate menu for page drafts, scheduled page + published pages, plus a second menu for your most recent draft posts, scheduled posts and 5 most recent published posts.

If you use WordPress admin (not the app) on your laptop or tablet (such as iPad) - you will probably find this plugin very useful.

== Installation ===

1. Upload `post-edit-toolbar.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. A pair of dropdown menus will appear in the WordPress toolbar titled 'Page List' and 'Post List'.

== Screenshots ==

1. The dropdown shows the add new Page, Drafts, Scheduled Pages + the 2 most recently edited pages.
2. This dropdown shows the add new post, a future scheduled post and the most recently published post - which in this case is the 'Hello World!' post.

== Frequently Asked Questions ==

For FAQs - see the post-edit-toolbar page at: http://webyourbusiness.com/post-edit-toolbar

== Upgrade Notice ==

= 1.4.12 =
WordPress 4.4 compatibility
= 1.4.11 =
WordPress 4.2.4 compatibility
= 1.4.10 =
WordPress 4.2.3 compatibility
= 1.4.9 =
added apply_filters to the post title
= 1.4.8.4 =
update release version of WordPress required to 3.1
= 1.4.8.3 =
Added code to prevent direct call
= 1.4.8.2 =
Compatibility tested to WordPress 4.2 Powell
= 1.4.8.1 =
Compatibility tested to WordPress 4.1.2.
= 1.4.8 =
Removed Donate link and added link to Support via WordPress.org.
= 1.4.7.1 =
Change rate for review - we need some reviews please people.  If you use and like this - please review / rate it.
= 1.4.7 =
Removed question about Pro version - we're keeping it simple - replaced with link to rate this plugin
= 1.4.6 =
Added Scheduled Pages + Posts Sections - so that future scheduled pages/posts show in the list
= 1.4.4.1 =
updated docs
= 1.4.4 =
fixed bug where /wp-admin didn't work - replaced with get_bloginfo('wpurl').'/wp-admin/' - installations in folders other than root are now working
= 1.4.2 =
fixed a couple of typos - and initiated blank classes where needed - tested on multiple sites + php installs
= 1.4.1 =
commented out blank page title substitution while I investigate a reported bug.
= 1.4.0 =
Added link to site in the settings section + created function to shorten long post/page names (remove repeating code)
= 1.3.2 =
rushed out 1.3.2 because installation onto a system with page-edit-toolbar caused a duplicate function name which could break your site - changed our function names to fix
= 1.3.1 =
fixed broken page-edit-toolbar functionality where hierarchical caused less than 5 pages to be returned if there were not 5 top-level pages, but there were sub-pages
= 1.3.0 =
Rolled in the functionality of Page-Edit-Toolbar - so I could add and "Add Page" link at the top of that menu, as per Post-Edit-Toolbar (and drafts)
= 1.2 =
Added an 'Add drafts' - if you get interrupted while composing a post, you'll love access to drafts that I added in 1.2

== Changelog ==

= 1.4.11 =
WordPress 4.2.4 compatibility
= 1.4.10 =
WordPress 4.2.3 compatibility
= 1.4.9 =
added apply_filters to the post title
= 1.4.8.4 =
update release version of WordPress required to 3.1
= 1.4.8.3 =
Added code to prevent direct call
= 1.4.8.2 =
Compatibility tested to WordPress 4.2 Powell
= 1.4.8.1 =
Compatibility tested to WordPress 4.1.2.
= 1.4.8 =
Removed Donate link and added link to Support via WordPress.org.
= 1.4.7.1 =
Change rate for review - we need some reviews please people.  If you use and like this - please review / rate it.
= 1.4.7 =
Removed question about Pro version - we're keeping it simple - replaced with link to rate this plugin
= 1.4.6 =
Added Scheduled Pages + Posts Sections - so that future scheduled pages/posts show in the list
= 1.4.4.1 =
updated docs
= 1.4.4 =
fixed bug where /wp-admin didn't work - replaced with get_bloginfo('wpurl').'/wp-admin/'
= 1.4.2 =
* fixed a couple of typos - and initiated blank classes where needed - tested on multiple sites + php installs
= 1.4.1 =
* commented out blank page title substitution while I investigate a reported bug.
= 1.4.0 =
* Added link to site in the settings section + created function to shorten long post/page names (remove repeating code)
= 1.3.3 =
* removed home_url() calls - they seem redundant.
= 1.3.2 =
1.3.2 - found a problem with this new version if you had page-edit-toolbar installed - changed function names to resolve
= 1.3.1 =
fixed broken page-edit-toolbar functionality where - hierarchical caused less than 5 pages to be returned
= 1.3.0 =
Rolled in page-edit-toolbar functionality.
= 1.2.2 =
* added truncation of long post + draft titles so menu does not get too long
= 1.2 = 
* added drafts + separators
= 1.1.1 =
* updated image included in the assets folder to be post-edit-tool-bar installed, not the page-edit-toolbar used as initial source
= 1.1 =
* bug fix + add new post - added 'Add New Post' to top of list and fixed incorrect variables passed to get_posts() - they differ from get_pages()
= 1.0 =
* initial release - based on Page Edit Toolbar by Jeremy Green
= 0.1 =
* Initial plugin submission
