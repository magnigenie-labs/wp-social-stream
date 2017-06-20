<?php
/*
Plugin Name: WP Social Stream
Plugin URI: http://magnigenie.com/wp-social-stream-show-stream-online-activity/
Description: By using this plugin you can easily get your online activity from lots of different sites and display on your site.
Version: 1.1
Author: Nirmal Ram
Author URI: http://magnigenie.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 *
 * Enable Localization
 *
 */
load_plugin_textdomain('wpss', false, basename( dirname( __FILE__ ) ) . '/lang' );

/**
 *
 * Add admin settings
 *
 */
if( is_admin() ) require dirname(__FILE__).'/admin.php';

/**
 *
 * Add required js/css files for wpss
 *
 */
add_action( 'init','wpss_enqueue_scripts' );
function wpss_enqueue_scripts() {
    wp_enqueue_style( 'lifestream-style', plugins_url('/css/lifestream.css',__FILE__) );
    wp_enqueue_style( 'wpss-style', plugins_url('/css/wpss-style.css',__FILE__) );   
    wp_enqueue_script( 'wpss-script', plugins_url('/js/wpss.js',__FILE__) , array('jquery') );
    
	//Localize lifestream data to be used with js.
	$lifestream_data = get_option( 'lifestream_data' );
	$wpss_style = get_option( 'wpss_styles' );
	$wpss_data = array_merge( $lifestream_data, array( 'num_feeds' => $wpss_style['num_feeds'] ) );
    wp_localize_script( 'wpss-script','users', $wpss_data );
    wp_enqueue_script( 'jquery-timeago-js', plugins_url('/js/jquery.timeago.min.js',__FILE__), array('jquery') );
    wp_enqueue_script( 'jquery-lifestream', plugins_url('/js/jquery.lifestream.min.js',__FILE__), array('jquery') );
}
/**
 *
 * Add shortcode for wpss
 *
 */
 function wpss_shortcode( $atts ) {
     return "<div id='lifestream'></div>";
}
add_shortcode('wp_social_stream', 'wpss_shortcode');
/**
 *
 * Add support for shortcode to work on widgets.
 *
 */
add_filter('widget_text', 'do_shortcode');

/**
 *
 * wpss custom styles.
 *
 */
add_action('wp_head', 'wpss_custom_styles');
function wpss_custom_styles() { 
$wpss_style = get_option( 'wpss_styles' );
?>
<style>
	#lifestream {
	  background: <?php echo $wpss_style['background']; ?>;
	  color: <?php echo $wpss_style['text_color']; ?>;
	}
	#lifestream a {
	  color: <?php echo $wpss_style['link_color']; ?>;
	}
	#lifestream a:hover {
	  color: <?php echo $wpss_style['link_hover']; ?>;
	}
</style>
<?php
}
