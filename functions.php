<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );

// Allow subscribers to see Private posts and pages
$subRole = get_role( 'subscriber' );
$subRole->add_cap( 'read_private_posts' );
$subRole->add_cap( 'read_private_pages' );

// Redirect to home page on login
function loginRedirect( $redirect_to, $request_redirect_to, $user ) {
    if ( is_a( $user, 'WP_User' ) && $user->has_cap( 'edit_posts' ) === false ) {
        return get_bloginfo( 'siteurl' );
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'loginRedirect', 10, 3 );

//Remove dashboard view for subscribers
function remove_dashboard_meta() {
remove_meta_box( ‘dashboard_incoming_links’, ‘dashboard’, ‘normal’ );
remove_meta_box( ‘dashboard_plugins’, ‘dashboard’, ‘normal’ );
remove_meta_box( ‘dashboard_primary’, ‘dashboard’, ‘side’ );
remove_meta_box( ‘dashboard_secondary’, ‘dashboard’, ‘normal’ );
remove_meta_box( ‘dashboard_quick_press’, ‘dashboard’, ‘side’ );
remove_meta_box( ‘dashboard_recent_drafts’, ‘dashboard’, ‘side’ );
remove_meta_box( ‘dashboard_recent_comments’, ‘dashboard’, ‘normal’ );
remove_meta_box( ‘dashboard_right_now’, ‘dashboard’, ‘normal’ );
remove_meta_box( ‘dashboard_activity’, ‘dashboard’, ‘normal’);//since 3.8
}
if (!current_user_can('edit_posts')) {
add_action(‘admin_init’, ‘remove_dashboard_meta’ );
}
