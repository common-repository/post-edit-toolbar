<?php

/*
Plugin Name: Post Edit Toolbar
Plugin URI: http://www.webyourbusiness.com/post-edit-toolbar/
Description: Adds a pair of dropdowns 'Page list' and 'Post List' to the WordPress toolbar of the most recently edited pages, drafts, future schedules pages + posts.
Version: 1.4.12
Author: Web Your Business
Author URI: http://www.webyourbusiness.com/

Release Notes:

1.4.12 - WordPress 4.4 compatibility
1.4.11 - WordPress 4.2.4 compatibility
1.4.10 - WordPress 4.2.3 compatibility
1.4.9 - added apply_filters to the post/page title
1.4.8.4 - updated min. WordPress level required to 3.1 (cmon people - update!)
1.4.8.3 - Added code to prevent php from being called directly
1.4.8.2 - Compatibility tested to WordPress 4.2.2 Powell
1.4.8.2 - Compatibility tested to WordPress 4.2 Powell
1.4.8.1 - Compatibility tested to WordPress 4.1.2.
1.4.8 - Removed Donate link and added link to Support via WordPress.org.
1.4.7.1 - Change rate for review - we need some reviews please people.  If you use and like this - please review / rate it.
1.4.7 - Removed question about Pro version - we're keeping it simple - replaced with link to Rate this plugin
1.4.6 - Added Scheduled Pages + Posts Sections - so that future scheduled pages/posts show in the list
1.4.4.1 - updated docs
1.4.4 - Added bloginfo('wpurl') to fix installations inside subfolders menus - now tested as working
1.4.2 - fixed a couple of typos - and initiated blank classes where needed - tested on multiple sites + php installs
1.4.1 - commented out blank title page code while I debug it (must be a difference between post + page fuctions in codex)
1.4.0 - Added link to site in the settings section + created function to shorten long post/page names (remove repeating code)
1.3.3 - removed home_url() calls - they seem redundant.
1.3.2 - found a problem with this new version if you had page-edit-toolbar installed - changed function names to resolve
1.3.1 - fixed broken page-edit-toolbar functionality where - hierarchical caused less than 5 pages to be returned
1.3.0 - Rolled in page-edit-toolbar functionality.
1.2.2 - added truncation if max len of title is > 40 chars
1.2 - added drafters + separators
1.1.1 - updated image included in the assets folder to be post-edit-tool-bar installed, not the page-edit-toolbar used as initial source
1.1 - bug fix + add new post - added 'Add New Post' to top of list and fixed incorrect variables passed to get_posts() - they differ from get_pages()
1.0 - initial release - based on Page Edit Toolbar by Jeremy Green

==
Known issues: Page list does not shorten length to <40 like it should - investigate later
*/

// Make sure we don't expose any info if called directly
if ( !function_exists('add_action') )
	die('Umm, Hi there!  I\'m a plugin, do not call me directly.');

if (!isset($no_page_drafts_to_show)) { $no_page_drafts_to_show = 5; }
if (!isset($no_page_future_to_show)) { $no_page_future_to_show = 5; }
if (!isset($no_page_edits_to_show)) { $no_page_edits_to_show  = 5; }

if (!isset($no_post_drafts_to_show)) { $no_post_drafts_to_show = 5; }
if (!isset($no_post_future_to_show)) { $no_post_future_to_show = 5; }
if (!isset($no_post_edits_to_show )) { $no_post_edits_to_show  = 5; }

add_action( 'admin_bar_menu', 'pet_page_admin_bar_function', 998 );
add_action( 'admin_bar_menu', 'pet_post_admin_bar_function', 998 );

function pet_page_admin_bar_function( $wp_admin_bar ) {

	// parent page
	$args = array(
		'id' => 'page_list',
		'title' => 'Page List',
		'href' => get_bloginfo('wpurl').'/wp-admin/edit.php?post_type=page'
	);
	$wp_admin_bar->add_node( $args );

	// top item in list is add new page
	$args = array(
		'id' => 'page_item_a',
		'title' => 'Add New Page',
		'parent' => 'page_list',
		'href' => get_bloginfo('wpurl').'/wp-admin/post-new.php?post_type=page'
	);
	$wp_admin_bar->add_node( $args );

	// separator from new to drafts
	$args = array(
		'id' => 'page_item_b',
		'title' => '------------------------',
		'parent' => 'page_list',
		'href' => ''
	);
	$wp_admin_bar->add_node( $args );

	$page_drafts_found = 'N';
	$page_future_found = 'N';
	$page_drafts = pet_recently_edited_page_drafts();
	$page_future = pet_recently_edited_page_future();

//////////////
	// loop through the most recently modified page drafts
	foreach( $page_drafts as $page_draft ) {
		$page_drafts_found = 'Y';

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($page_draft)) {
			$page_draft = new stdClass;
			$page_draft->post_title = new stdClass;
		}

		$page_draft_title = return_short_title($page_draft->post_title,'[EMPTY DRAFT TITLE]');

		// add child nodes (page_draft recently edited)
		$args = array(
			'id' => 'post_item_' . $page_draft->ID,
			'title' => '<strong><u>Draft</u>:</strong> '.$page_draft_title,
			'parent' => 'page_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $page_draft->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}

	if ($page_drafts_found == 'Y') {
		// separator from page_drafts to published
		$args = array(
			'id' => 'page_item_c',
			'title' => '------------------------',
			'parent' => 'page_list',
			'href' => ''
		);
		$wp_admin_bar->add_node( $args );
	}
//////////////
	// loop through the most recently future pages
	foreach( $page_future as $future_page ) {
		$page_future_found = 'Y';

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($future_page)) {
			$future_page = new stdClass;
			$future_page->post_title = new stdClass;
		}

		$future_page_title = return_short_title($future_page->post_title,'[EMPTY DRAFT TITLE]');

		// add child nodes (future_page recently edited)
		$args = array(
			'id' => 'post_item_' . $future_page->ID,
			'title' => '<strong><u>Future</u>:</strong> '.$future_page_title,
			'parent' => 'page_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $future_page->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}

	if ($page_future_found == 'Y') {
		// separator from page_future to published
		$args = array(
			'id' => 'page_item_d',
			'title' => '------------------------',
			'parent' => 'page_list',
			'href' => ''
		);
		$wp_admin_bar->add_node( $args );
	}
//////////////

	// get list of pages
	$pages = pet_recently_edited_pages();

	// loop through the most recently modified pages
	foreach( $pages as $thispage ) {

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($thispage)) {
			$thispage = new stdClass;
			$thispage->post_title = new stdClass;
		}

		$thispage_title = return_short_title($thispage->post_title,'[EMPTY PAGE TITLE]');

		// add child nodes (pages to edit)
		$args = array(
			'id' => 'page_item_' . $thispage->ID,
			'title' => $thispage_title,
			'parent' => 'page_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $thispage->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}
}

///////////////////////// NOW POSTS /////////////////////////////

function pet_post_admin_bar_function( $wp_admin_bar ) {

	// parent post - the 'edit-all-posts' link at the top
	$args = array(
		'id' => 'post_list',
		'title' => 'Post List',
		'href' => get_bloginfo('wpurl').'/wp-admin/edit.php'
	);
	$wp_admin_bar->add_node( $args );

	// top item in list is add new post
	$args = array(
		'id' => 'post_item_a',
		'title' => 'Add New Post',
		'parent' => 'post_list',
		'href' => get_bloginfo('wpurl').'/wp-admin/post-new.php'
	);
	$wp_admin_bar->add_node( $args );

	// separator from new to drafts
	$args = array(
		'id' => 'post_item_b',
		'title' => '------------------------',
		'parent' => 'post_list',
		'href' => ''
	);
	$wp_admin_bar->add_node( $args );


	// get list of drafts
	$drafts_found = 'N';
	$post_future_found = 'N';
	$drafts = pet_recently_edited_drafts();

	// loop through the most recently modified post drafts
	foreach( $drafts as $draft ) {
		$drafts_found = 'Y';

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($draft)) {
			$draft = new stdClass;
			$draft->post_title = new stdClass;
		}

		$draft_post_title = return_short_title($draft->post_title,'[EMPTY DRAFT TITLE]');

		// add child nodes (drafts recently edited)
		$args = array(
			'id' => 'post_item_' . $draft->ID,
			'title' => '<strong><u>Draft</u>:</strong> '.$draft_post_title,
			'parent' => 'post_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $draft->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}

	if ($drafts_found == 'Y') {
		// separator from drafts to published
		$args = array(
			'id' => 'post_item_c',
			'title' => '------------------------',
			'parent' => 'post_list',
			'href' => ''
		);
		$wp_admin_bar->add_node( $args );
	}
//////////////
	// loop through the most recently future posts
	$future_posts = pet_recently_edited_posts_future();
	foreach( $future_posts as $future_post ) {
		$post_future_found = 'Y';

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($future_post)) {
			$future_post = new stdClass;
			$future_post->post_title = new stdClass;
		}

		$future_post_title = return_short_title($future_post->post_title,'[EMPTY DRAFT TITLE]');

		// add child nodes (future_post recently edited)
		$args = array(
			'id' => 'post_item_' . $future_post->ID,
			'title' => '<strong><u>Future</u>:</strong> '.$future_post_title,
			'parent' => 'post_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $future_post->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}

	if ($post_future_found == 'Y') {
		// separator from post_future to published
		$args = array(
			'id' => 'post_item_d',
			'title' => '------------------------',
			'parent' => 'post_list',
			'href' => ''
		);
		$wp_admin_bar->add_node( $args );
	}
//////////////

	// get list of posts
	$posts = pet_recently_edited_posts();

	// loop through the most recently modified posts
	foreach( $posts as $post ) {

		// fixing "Warning: Creating default object from empty value in errors":
		if (!is_object($post)) {
			$post = new stdClass;
			$post->post_title = new stdClass;
		}

		$post_post_title = return_short_title($post->post_title,'[EMPTY POST TITLE]');

		// add child nodes (posts to edit)
		$args = array(
			'id' => 'post_item_' . $post->ID,
			'title' => $post_post_title,
			'parent' => 'post_list',
			'href' => get_bloginfo('wpurl').'/wp-admin/post.php?post=' . $post->ID . '&action=edit'
		);
		$wp_admin_bar->add_node( $args );
	}
}

function pet_recently_edited_drafts() {
	global $no_post_drafts_to_show;
	$args = array(
		'posts_per_page' => $no_post_drafts_to_show,
		'sort_column' => 'post_modified',
		'orderby' => 'post_date',
		'post_status' => 'draft',
		'order' => 'DESC'
	);
	$drafts = get_posts( $args );
	return $drafts;
}
function pet_recently_edited_posts() {
	global $no_post_edits_to_show;
	$args = array(
		'posts_per_page' => $no_post_edits_to_show,
		'sort_column' => 'post_modified',
		'orderby' => 'post_date',
		'order' => 'DESC'
	);
	$posts = get_posts( $args );
	return $posts;
}
function pet_recently_edited_posts_future() {
	global $no_post_future_to_show;
	$args = array(
		'posts_per_page' => $no_post_future_to_show,
		'sort_column' => 'post_modified',
		'orderby' => 'post_date',
		'post_status' => 'future',
		'order' => 'DESC'
	);
	$posts = get_posts( $args );
	return $posts;
}
function pet_recently_edited_pages() {
	global $no_page_edits_to_show;
	$args = array(
		'number' => $no_page_edits_to_show,
		'post_type' => 'page',
		'post_status' => 'publish',
		'sort_column' => 'post_modified',
		'hierarchical' => 0,
		'sort_order' => 'DESC'
	);
	$pages = get_pages( $args );
	return $pages;
}
function pet_recently_edited_page_drafts() {
	global $no_page_drafts_to_show;
	$args = array(
		'number' => $no_page_drafts_to_show,
		'post_type' => 'page',
		'post_status' => 'draft',
		'sort_column' => 'post_modified',
		'hierarchical' => 0,
		'sort_order' => 'DESC'
	);
	$pagedraft = get_pages( $args );
	return $pagedraft;
}
function pet_recently_edited_page_future() {
	global $no_page_future_to_show;
	$args = array(
		'number' => $no_page_future_to_show,
		'post_type' => 'page',
		'post_status' => 'future',
		'sort_column' => 'post_modified',
		'hierarchical' => 0,
		'sort_order' => 'DESC'
	);
	$pagefuture = get_pages( $args );
	return $pagefuture;
}
function return_short_title( $title_to_shorten, $if_empty ) {
	// the variables passed
//	$the_title = $title_to_shorten;
	$the_title = apply_filters('the_title', $title_to_shorten );
	$return_if_empty = $if_empty;
	$return_value = $the_title;
	if (trim($the_title)== FALSE) {
		$the_title='';
		$title_len=0;
	} else {
		$title_len=strlen($the_title);
	}
	if ($title_len < 40){
		if ($title_len == 0) {
			$return_value = $return_if_empty;
		} else {
			$return_value = $the_title;
		}
	} else {
		$return_value = substr($the_title, 0, 36).' [...]';
	}
	return $return_value;
}
// This code adds the links in the settings section of the plugin
if ( ! function_exists( 'post_edit_toolbar_plugin_meta' ) ) :
        function post_edit_toolbar_plugin_meta( $links, $file ) { // add 'Plugin page' and 'Donate' links to plugin meta row
                if ( strpos( $file, 'post-edit-toolbar.php' ) !== false ) {
//                        $links = array_merge( $links, array( '<a href="http://www.webyourbusiness.com/post-edit-toolbar/#donate" title="Support the development">Donate</a>' ) );
                        $links = array_merge( $links, array( '<a href="http://wordpress.org/support/view/plugin-reviews/post-edit-toolbar#postform" title="Review-Post-Edit-Toolbar">Please Review Post-Edit-Toolar</a>' ) );
                        $links = array_merge( $links, array( '<a href="http://wordpress.org/support/plugin/post-edit-toolbar" title="Support-for-Post-Edit-Toolbar">Support</a>' ) );
                }
                return $links;
        }
        add_filter( 'plugin_row_meta', 'post_edit_toolbar_plugin_meta', 10, 2 );
endif; // end of post_edit_toolbar_plugin_meta()
?>
