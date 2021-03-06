<?php

// Essentials
include_once 'includes/config.php';
include_once 'includes/init.php';

// Register & Functions
include_once 'includes/register.php';
include_once 'includes/func.php';


include_once 'includes/ratings.php';


// Customizer
include_once 'includes/customizer/customizer.php';
include_once 'includes/customizer/css.php';


include_once 'includes/vibe-menu.php';

include_once 'includes/author.php';

if ( function_exists('bp_get_signup_allowed')) {
    include_once 'includes/bp-custom.php';
}

include_once '_inc/ajax.php';

//Widgets
include_once('includes/widgets/custom_widgets.php');
if ( function_exists('bp_get_signup_allowed')) {
include_once('includes/widgets/custom_bp_widgets.php');
}
include_once('includes/widgets/advanced_woocommerce_widgets.php');
include_once('includes/widgets/twitter.php');
include_once('includes/widgets/flickr.php');
include_once('includes/widgets/instagram.php');

//Misc
include_once 'includes/sharing.php';
include_once 'includes/tour.php';

// Options Panel
get_template_part('vibe','options');

/*add bookmark*/
function bookmarks($url = false, $title = false) {
	global $wp;
	
	if($url == false) {
		$current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
		$current_url = explode("?", $current_url);
		$current_url = $current_url[0];
		$title       = get_the_title();
	} else {
		$current_url = $url;
	}
	
	echo '<a class="add-bookmark" href="' . home_url() . '/add-bookmark?page=' . $current_url . '&title=' . $title . '">Add to my favorites</a>';
	
	if(isset($_GET["msg"]) and $_GET["msg"] == "successful-bookmark") {
		echo '<span class="bookmark-successful">Bookmark added successfully</span>';
	}
	return true;
}

/*get bookmarks*/
function getBookmarks() {
	if(function_exists('bp_loggedin_user_link') && is_user_logged_in()) {
		echo '<h3>Bookmarks</h3>';
		
		global $wp;
		global $wpdb;
		
		$user_id = bp_loggedin_user_id();
		$myrows  = $wpdb->get_results("SELECT * FROM wp_bookmarks where user_id=$user_id order by bookmark_id desc");
		
		if($myrows) {
			echo '<ul class="ul-bookmarks">';
				foreach($myrows as $row) {
					echo '<li>';
						echo '<a href="' . $row->url . '" title="' . $row->title . '">' . $row->title . '</a>';
					echo '</li>';
				}
			echo '</ul>';
		} else {
			echo '<h2>Not bookmarks yet</h2>';
		}
	}  else {
		header('Location: '. home_url());
		exit();
	}
}

//Map of roster of practitioners
function getMap() {
	echo "<script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>";
	echo "<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>";
	echo "<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet'/>";
	echo "<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet'/>";
	echo "<link href='/map/css/map-style.css' rel='stylesheet'/>";
	echo "<script src='/map/js/gpsa-rosters.geojson.js' type='text/javascript'></script>";
	
	echo "<a name='roster-of-practitioners'></a><div class='pagetitle'><h2>Roster of practitioners</h2></div>";
	echo "<div id='map'><div id='themes-layers' class='layers'></div><div id='info'></div></div>";
	echo "<script src='/map/js/map-init.js' type='text/javascript'></script>";
}

//custom category type template
function get_custom_cat_template($single_template) {
    global $post;

    if(in_category( 'expert' )) {
        $single_template = dirname( __FILE__ ) . '/single-expert.php';
    }
    
    return $single_template;
}
 
add_filter( "single_template", "get_custom_cat_template" ) ;

//custom post type template
function get_custom_post_type_template($single_template) {
    global $post;
	
    if ($post->post_type == 'ajde_events') {
         $single_template = dirname( __FILE__ ) . '/single-events.php';
    }
    return $single_template;
}
 
add_filter( "single_template", "get_custom_post_type_template" ) ;

//fix for cookie error while login.
function set_wp_test_cookie() {
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
	if ( SITECOOKIEPATH != COOKIEPATH ) {
		setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);
	}
}

add_action( 'after_setup_theme', 'set_wp_test_cookie', 101 );
