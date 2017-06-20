<?php
/**
 *
 * Default plugin settings
 *
 */
$wpss_setup = array(
    'atom' => '',
    'bitbucket' => '',
    'bitly' => '',
    'blogger' => '',
    'citeulike' => '',
    'dailymotion' => '',
    'delicious' => '',
    'deviantart' => '',
    'disqus' => '',
    'dribbble' => '',
    'facebook_page' => '',
    'fancy' => '',
    'flickr' => '',
    'foomark' => '',
    'formspring' => '',
    'forrst' => '',
    'foursquare' => '',
    'gimmebar' => '',
    'github' => '',
    'googleplus' => '',
	'google_api_key' => '',
    'hypem' => '',
    'instapaper' => '',
    'iusethis' => '',
    'lastfm' => '',
    'librarything' => '',
    'linkedin' => '',
    'mendeley' => '',
    'miso' => '',
    'mlkshk' => '',
    'pinboard' => '',
    'pocket' => '',
    'posterous' => '',
    'quora' => '',
    'reddit' => '',
    'rss' => '',
    'slideshare' => '',
    'snipplr' => '',
    'stackoverflow' => '',
    'tumblr' => '',
    'twitter' => '',
    'vimeo' => '',
    'wikipedia' => '',
    'wordpress' => '',
    'youtube' => '',
    'zotero' => ''
);

$wpss_styles = array(
	'num_feeds' => '20',
    'background' => '#333',
    'text_color' => '#fff',
    'link_color' => '#f6dd97',
    'link_hover' => '#fff5d8',
);
/**
 *
 * Save the default settings
 *
 */
if(!get_option('lifestream_data')) {
    add_option('lifestream_data', $wpss_setup);
}

if(!get_option('wpss_styles')) {
    add_option('wpss_styles', $wpss_styles);
}

/**
 *
 * Add required js files.
 *
 */
add_action( 'admin_enqueue_scripts', 'wpss_admin_scripts' );
function wpss_admin_scripts() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wpss-admin-js', plugins_url('js/wpss-admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
}

/**
 *
 * Add settings page menu item
 *
 */
if ( is_admin() ){
    /**
     * action name
     * function that will create the menu page link / options page
     */
    add_action( 'admin_menu', 'wpolstream_admin_menu' );
}

/**
 *
 * Add plugin settings page
 *
 */
function wpolstream_admin_menu(){
    /**
     * menu title
     * page title
     * who can acces the settings  - user that can ...
     * the settings page identifier for the url
     * function that will generate the form with th esettings
     */
    add_options_page( __('WP Social Stream','wpss'), __('WP Social Stream','wpss'), 'manage_options', 'wp-social-stream', 'wpss_settings' );
}

function wpss_settings() {
//save lifestream data to database.
if( !empty( $_POST['submit'] ) ) {
    unset( $_POST['submit'] );
    update_option( 'lifestream_data', $_POST );
}
//Save appearance data to database.
if( !empty( $_POST['save_appearance'] ) ) {
    unset( $_POST['save_appearance'] );
    update_option( 'wpss_styles', $_POST );
}
$lifestream_data = array();
$lifestream_data = get_option( 'lifestream_data' );
$wpss_style = get_option( 'wpss_styles' );
?>
<div class="wrap">
<?php if( isset( $_POST['atom'] ) ) 
	echo '<div class="updated"><p>Successfully saved !</p></div>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab <?php if($_GET['tab'] == '') echo 'nav-tab-active'; ?>" href="?page=wp-social-stream">Profile Settings</a>
<a class="nav-tab <?php if($_GET['tab'] == 'appearance') echo 'nav-tab-active'; ?>" href="?page=wp-social-stream&amp;tab=appearance">Appearance</a></h2>

<?php echo "<h2>" . __( 'WP Social Stream', 'menu-test' ) . "</h2>"; ?>

	<form method="post" action="">
	<?php if($_GET['tab'] == '') { ?>	
	<div style="float:left; width: 70%;">
		<table class="widefat" cellspacing="4" cellpadding="4">
		<?php
		foreach( $lifestream_data as $service => $uid ) { ?>
			<tr>
				<td>
					<label for="<?php echo $service; ?>" class="lifestream-<?php echo $service; ?>">
						<?php echo str_replace( '_', ' ', $service ); ?>
					</label>
				</td>
				<td>
				  <input type="text" name="<?php echo $service; ?>" id="<?php echo $service; ?>" value="<?php echo $uid; ?>">
				  <?php echo wpss_help_text( $service ); ?>
				</td>
			</tr>
		   <?php } ?>
		   <tr>
				<td>
					<input type="submit" class="button button-primary" name="submit" value="Submit">
				</td>
		   </tr>
		</table>
	</div>
	<?php } else { ?>
	<div style="float:left; width: 70%;">
		<table class="widefat" cellspacing="4" cellpadding="4">
			<tr>
				<td><label for="num_feeds"># of Feeds</label></td>
				<td><input type="number" name="num_feeds" id="num_feeds" value="<?php echo $wpss_style['num_feeds']; ?>"> </td>
			</tr>
			<tr>
				<td><label for="background">Background</label></td>
				<td><input type="text" name="background" id="background" value="<?php echo $wpss_style['background']; ?>"> </td>
			</tr>
			<tr>
				<td><label for="text_color">Text Color</label></td>
				<td><input type="text" name="text_color" id="text_color" value="<?php echo $wpss_style['text_color']; ?>"> </td>
			</tr>
			<tr>
				<td><label for="link_color">Link Color</label></td>
				<td><input type="text" name="link_color" id="link_color" value="<?php echo $wpss_style['link_color']; ?>"> </td>
			</tr>
			<tr>
				<td><label for="link_hover">Link Hover Color</label></td>
				<td><input type="text" name="link_hover" id="link_hover" value="<?php echo $wpss_style['link_hover']; ?>"> </td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="button button-primary" name="save_appearance" value="Save Changes">
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
	<div style="float:left; width:28%; margin-left: 2%;">
		<table class="widefat" cellspacing="4" cellpadding="4">
			<tr>
				<td><b>Put this shortcode on any page/post/widget etc to show the social stream on your site.</b></td>
			</tr>
			<tr>
				<td><b>[wp_social_stream]</b></td>
			</tr>
		</table>
	</div>
	</form>
</div>
<?php
}
/**
 *
 * wpss service help text
 *
 */
 function wpss_help_text( $service ) {
	switch( $service ) {
		case 'flickr' :
			return '<a href="http://idgettr.com/" title="Find your flickr id or username" target="_blank" class="help">Click here to find your flickr id or username.</a>';
			break;
		case 'foursquare' :
			return '<a href="http://www.cl.ly/7TEJ" title="Find your foursquare id or username" target="_blank" class="help">Click here to find your foursquare id or username.</a>';
			break;
		case 'flickr' :
			return '<a href="http://f.cl.ly/items/0a3K2Z42442l3d030g0E/stackoverflow.png" title="Find your stackoverflow id or username" target="_blank" class="help">Click here to find your stackoverflow id or username.</a>';
			break;
		case 'rss' :
			return 'Enter RSS feed url.';
			break;
		case 'facebook_page' :
			return '<a href="http://findmyfacebookid.com/" title="Find your facebook page id" target="_blank" class="help">Click here to find your facebook page id.</a>';
			break;
		case 'google_api_key' :
			return '<a href="https://code.google.com/apis/console" target="_blank">Click here to create your key.</a>';
			break;
		default:
			return '<span class="description">Enter your '.$service.' username or user id.</span>';
	}
 }