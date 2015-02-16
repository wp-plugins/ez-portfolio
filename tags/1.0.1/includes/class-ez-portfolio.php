<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Admin CSS
 */
add_action( 'admin_enqueue_scripts', 'ez_enqueue_styles_admin' );
 
function ez_enqueue_styles_admin () {
	wp_enqueue_style('admin-css', plugins_url().'/ez-portfolio/assets/css/admin.css', true, '1.0');
}

/**
 * Load frontend Javascript.
 */
add_action( 'wp_enqueue_scripts', 'ez_enqueue_scripts_frontend_js' );

function ez_enqueue_scripts_frontend_js () {
	wp_enqueue_script('frontend-js', plugins_url().'/ez-portfolio/assets/js/frontend.js', array('jquery'), '2.1.5');
}

/**
 * Load Font Awesome
 */
add_action( 'wp_enqueue_scripts', 'ez_enqueue_styles_font_awesome_css' );

function ez_enqueue_styles_font_awesome_css () {
	wp_enqueue_style('font-awesome.min', plugins_url().'/ez-portfolio/assets/css/font-awesome.min.css', true, '1.5');
}

/**
 * Load Lightbox CSS
 */
add_action( 'wp_enqueue_scripts', 'ez_enqueue_styles_lightbox_css' );

function ez_enqueue_styles_lightbox_css () {
	wp_enqueue_style('jquery.lightbox', plugins_url().'/ez-portfolio/assets/css/nivo-lightbox.css', true, '1.0');
	wp_enqueue_style('jquery.lightbox.theme', plugins_url().'/ez-portfolio/assets/js/themes/default/default.css', true, '1.0');
}

/**
 * Load Lightbox Javascript.
 */
add_action( 'wp_enqueue_scripts', 'ez_enqueue_scripts_lightbox' );

function ez_enqueue_scripts_lightbox () {
    wp_enqueue_script('jquery.lightbox', plugins_url().'/ez-portfolio/assets/js/nivo-lightbox.js', array('jquery'), '1.0');
}

/**
 * Load Shuffle
 */
add_action( 'wp_enqueue_scripts', 'ez_enqueue_scripts_shuffle' );
	
function ez_enqueue_scripts_shuffle () {
	wp_enqueue_script('shuffle', plugins_url().'/ez-portfolio/assets/js/jquery.shuffle.min.js', array('jquery'));
	wp_enqueue_script('custom', plugins_url().'/ez-portfolio/assets/js/jquery.custom.js', array('jquery'));
	wp_enqueue_script('modernizer', plugins_url().'/ez-portfolio/assets/js/jquery.shuffle.modernizr.min.js', array('jquery'));
}
 
/**
 * Limit Characters Length on Titles
 */
function ShortenText($text) { // Function name ShortenText
	$chars_limit = 35; // Character length
	$chars_text = strlen($text);
	$text = $text." ";
	$text = substr($text,0,$chars_limit);
	$text = substr($text,0,strrpos($text,' '));
 
	if ($chars_text > $chars_limit)
		{ $text = $text."..."; } // Ellipsis
	return $text;
}
	
/**
* Create Shortcode TinyMCE Button
* @since   1.0.0
*/
	
function ez_portfolio_add_button() {
	global $typenow;
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
	return;
	}
	if( ! in_array( $typenow, array( 'post', 'page' ) ) )
		return;
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "ez_portfolio_add_tinymce_plugin");
		add_filter('mce_buttons', 'ez_portfolio_register_button');
	}
}

function ez_portfolio_add_tinymce_plugin($plugin_array) {
	$plugin_array['ez_portfolio_button'] = plugins_url().'/ez-portfolio/assets/js/shortcode.js';
	return $plugin_array;
}

function ez_portfolio_register_button($buttons) {
	array_push($buttons, "ez_portfolio_button");
return $buttons;
}
	
add_action('admin_head', 'ez_portfolio_add_button');
	
class EZ_Portfolio {

	/**
	 * The single instance of EZ_Portfolio.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'ez_portfolio';

		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

	// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
	} // Edn __construct ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'ez-portfolio', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'ez-portfolio';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main EZ_Portfolio Instance
	 *
	 * Ensures only one instance of EZ_Portfolio is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see EZ_Portfolio()
	 * @return Main EZ_Portfolio instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()
	
	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

}