<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class EZ_Portfolio_Settings {

	/**
	 * The single instance of EZ_Portfolio_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'ez_';

		// Initialise settings
		add_action( 'admin_init', array( $this, 'init_settings' ) );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'EZ Portfolio', 'ez-portfolio' ) , __( 'EZ Portfolio Settings', 'ez-portfolio' ) , 'manage_options' , 'ez_portfolio_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    	wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=ez_portfolio_settings">' . __( 'Settings', 'ez-portfolio' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		$settings['simple'] = array(
			'title'					=> __( '<u>Settings for Plain and Simple Effect</u>', 'ez-portfolio' ),
			'description'			=> __( 'Use these settings to adjust your "Plain and Simple" hover effect', 'ez-portfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'simple_zoom',
					'label'			=> __( 'Zoom On/Off', 'ez-portfolio' ),
					'description'	=> __( 'Choose Zoom Effect On/Off', 'ez-portfolio' ),
					'type'			=> 'radio',
					'options'		=> array( 'on' => 'On', 'off' => 'Off'),
					'default'		=> 'on'
				),
				array(
					'id' 			=> 'simple_select_box',
					'label'			=> __( 'Color Theme', 'ez-portfolio' ),
					'description'	=> __( 'Choose color theme', 'ez-portfolio' ),
					'type'			=> 'select',
					'options'		=> array( 'black' => 'Black', 'blue' => 'Blue', 'green' => 'Green', 'red' => 'Red', 'orange' => 'Orange' ),
					'default'		=> 'blue'
				),
				array(
					'id' 			=> 'simple_custom_colors',
					'label'			=> __( 'Use Custom Colors On/Off', 'ez-portfolio' ),
					'description'	=> __( 'Turn this on, if you want to use your own custom colors:', 'ez-portfolio' ),
					'type'			=> 'radio',
					'options'		=> array( 'on' => 'On', 'off' => 'Off'),
					'default'		=> 'off'
				),
				array(
					'id' 			=> 'simple_bg_rgba',
					'label'			=> __( 'Custom Background color' , 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Enter your custom background color in RGBA value (You can use <a href="http://html-generator.weebly.com/css-rgba-color-generator.html" target="_blank">this generator</a> as referance).', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> 'rgba(0,0,0,0.5)',
					'placeholder'	=> __( 'rgba(0,0,0,0.5)', 'ez-portfolio' )
				),
				array(
					'id' 			=> 'simple_button_color',
					'label'			=> __( 'Custom Button Primary Color', 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Choose primary color for your button.', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#222222'
				),
				array(
					'id' 			=> 'simple_button_hover',
					'label'			=> __( 'Custom Button Hover Color', 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Choose hover color for your button.', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				),
			)
		);
			
		$settings['classic'] = array(
			'title'					=> __( '<u>Settings for Classic Effect</u>', 'ez-portfolio' ),
			'description'			=> __( 'Use these settings to adjust your "Classic" hover effect', 'ez-portfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'classic_title',
					'label'			=> __( 'Title On/Off', 'ez-portfolio' ),
					'description'	=> __( 'Show Title on hover On/Off', 'ez-portfolio' ),
					'type'			=> 'radio',
					'options'		=> array( 'on' => 'On', 'off' => 'Off'),
					'default'		=> 'on'
				),
				array(
					'id' 			=> 'classic_select_box',
					'label'			=> __( 'Color Theme', 'ez-portfolio' ),
					'description'	=> __( 'Choose color theme', 'ez-portfolio' ),
					'type'			=> 'select',
					'options'		=> array( 'black' => 'Black', 'blue' => 'Blue', 'green' => 'Green', 'red' => 'Red', 'orange' => 'Orange' ),
					'default'		=> 'blue'
				),
				array(
					'id' 			=> 'classic_custom_colors',
					'label'			=> __( 'Use Custom Colors On / Off', 'ez-portfolio' ),
					'description'	=> __( 'Turn this on, if you want to use your own custom colors:', 'ez-portfolio' ),
					'type'			=> 'radio',
					'options'		=> array( 'on' => 'On', 'off' => 'Off'),
					'default'		=> 'off'
				),
				array(
					'id' 			=> 'classic_bg_rgba',
					'label'			=> __( 'Custom Background color' , 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Enter your custom background color in RGBA value (You can use <a href="http://html-generator.weebly.com/css-rgba-color-generator.html" target="_blank">this generator</a> as referance).', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> 'rgba(0,0,0,0.5)',
					'placeholder'	=> __( 'rgba(0,0,0,0.5)', 'ez-portfolio' )
				),
				array(
					'id' 			=> 'classic_button_color',
					'label'			=> __( 'Custom Button Primary Color', 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Choose primary color for your button.', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#222222'
				),
				array(
					'id' 			=> 'classic_button_hover',
					'label'			=> __( 'Custom Button Hover Color', 'ez-portfolio' ),
					'description'	=> __( '<b>*** This setting will only work if "Use Custom Colors" is enabled!</b> *** Choose hover color for your button.', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				)

			)
		);
		
		$settings['push'] = array(
			'title'					=> __( '<u>Settings for Push Effect</u>', 'ez-portfolio' ),
			'description'			=> __( 'Use these settings to adjust your "Push" hover effect', 'ez-portfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'push_direction',
					'label'			=> __( 'Push  Up / Down', 'ez-portfolio' ),
					'description'	=> __( 'Choose direction for the push effect', 'ez-portfolio' ),
					'type'			=> 'select',
					'options'		=> array( 'up' => 'Up', 'down' => 'Down'),
					'default'		=> 'up'
				),
				array(
					'id' 			=> 'push_bg_color',
					'label'			=> __( 'Title background Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose background color for the hover effect', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				),
				array(
					'id' 			=> 'push_border_color',
					'label'			=> __( 'Border Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose border color for the hover effect', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#1763a4'
				),
				array(
					'id' 			=> 'push_button_color',
					'label'			=> __( 'Button Primary Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose primary color for your button', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				),
				array(
					'id' 			=> 'push_button_hover',
					'label'			=> __( 'Button Hover Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose hover color for your button', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#1763a4'
				)

			)
		);
			
		$settings['door_classic'] = array(
			'title'					=> __( '<u>Settings for Door Classic Effect</u>', 'ez-portfolio' ),
			'description'			=> __( 'Use these settings to adjust your "Door Classic" hover effect', 'ez-portfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'door_classic_border_color',
					'label'			=> __( 'Border Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose border color for the hover effect', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#1763a4'
				),
				array(
					'id' 			=> 'door_classic_button_color',
					'label'			=> __( 'Button Primary Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose primary color for your button', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#1763a4'
				),
				array(
					'id' 			=> 'door_classic_button_hover',
					'label'			=> __( 'Button Hover Color', 'ez-portfolio' ),
					'description'	=> __( 'Choose hover color for your button', 'ez-portfolio' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				)

			)
		);
		
		$settings['General'] = array(
			'title'					=> __( '<u>General Settings</u>', 'ez-portfolio' ),
			'description'			=> __( 'These settings affects to all portfolios', 'ez-portfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'portfolio_details_disable',
					'label'			=> __( 'Disable Portfolio details On/Off', 'ez-portfolio' ),
					'description'	=> __( 'Use this function, if you only want to make image gallery, instead of portfolio. This will disable "portfolio details" button!', 'ez-portfolio' ),
					'type'			=> 'radio',
					'options'		=> array( 'on' => 'On', 'off' => 'Off'),
					'default'		=> 'off'
				),
				array(
					'id' 			=> 'margin_general',
					'label'			=> __( 'Marginal' , 'ez-portfolio' ),
					'description'	=> __( 'Input marginal between the portfolio items. Default 0 0.3% 0.6% 0.3%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '0 0.3% 0.6% 0.3%',
					'placeholder'	=> __( '0 0.3% 0.6% 0.3%', 'ez-portfolio' )
				),
				array(
					'id' 			=> '2col_width',
					'label'			=> __( '2 Columns Width' , 'ez-portfolio' ),
					'description'	=> __( 'Width for 2 columns layout. Default 49.4%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '49.4%',
					'placeholder'	=> __( '49.4%', 'ez-portfolio' )
				),
				array(
					'id' 			=> '3col_width',
					'label'			=> __( '3 Columns Width' , 'ez-portfolio' ),
					'description'	=> __( 'Width for 3 columns layout. Default 32.73%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '32.73%',
					'placeholder'	=> __( '32.73%', 'ez-portfolio' )
				),
				array(
					'id' 			=> '4col_width',
					'label'			=> __( '4 Columns Width' , 'ez-portfolio' ),
					'description'	=> __( 'Width for 4 columns layout. Default 24.4%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '24.4%',
					'placeholder'	=> __( '24.4%', 'ez-portfolio' )
				),
				array(
					'id' 			=> '5col_width',
					'label'			=> __( '5 Columns Width' , 'ez-portfolio' ),
					'description'	=> __( 'Width for 5 columns layout. Default 19.4%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '19.4%',
					'placeholder'	=> __( '19.4%', 'ez-portfolio' )
				),
				array(
					'id' 			=> '6col_width',
					'label'			=> __( '6 Columns Width' , 'ez-portfolio' ),
					'description'	=> __( 'Width for 6 columns layout. Default 16.06%', 'ez-portfolio' ),
					'type'			=> 'text',
					'default'		=> '16.06%',
					'placeholder'	=> __( '16.06%', 'ez-portfolio' )
				)
			)
		);

		$settings = apply_filters( 'ez_portfolio_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if( is_array( $this->settings ) ) {
			foreach( $this->settings as $section => $data ) {

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'ez_portfolio_settings' );

				foreach( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( 'ez_portfolio_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'ez_portfolio_settings', $section, array( 'field' => $field ) );
				}
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Generate HTML for displaying fields
	 * @param  array $args Field data
	 * @return void
	 */
	public function display_field ( $args ) {

		$field = $args['field'];

		$html = '';

		$option_name = $this->base . $field['id'];
		$option = get_option( $option_name );

		$data = '';
		if( isset( $field['default'] ) ) {
			$data = $field['default'];
			if( $option ) {
				$data = $option;
			}
		}

		switch( $field['type'] ) {

			case 'text':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
			break;

			case 'checkbox':
				$checked = '';
				if( $option && 'on' == $option ){
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
			break;

			case 'radio':
				foreach( $field['options'] as $k => $v ) {
					$checked = false;
					if( $k == $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;

			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
			break;

			case 'color':
				?><div class="color-picker" style="position:relative;">
			        <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
			        <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
			    </div>
			    <?php
			break;

		}

		switch( $field['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $field['description'] . '</span>';
			break;

			default:
				$html .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
			break;
		}

		echo $html;
	}

	/**
	 * Validate individual settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function validate_field ( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="ez_portfolio_settings">' . "\n";
			$html .= '<h2>' . __( 'Plugin Settings' , 'ez-portfolio' ) . '</h2>' . "\n";
			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Setup navigation
				$html .= '<ul id="settings-sections" class="subsubsub hide-if-no-js">' . "\n";
					$html .= '<li><a class="tab all current" href="#all">' . __( 'All' , 'ez-portfolio' ) . '</a></li>' . "\n";

					foreach( $this->settings as $section => $data ) {
						$html .= '<li>| <a class="tab" href="#' . $section . '">' . $data['title'] . '</a></li>' . "\n";
					}

				$html .= '</ul>' . "\n";

				$html .= '<div class="clear"></div>' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( 'ez_portfolio_settings' );
				do_settings_sections( 'ez_portfolio_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'ez-portfolio' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main EZ_Portfolio_Settings Instance
	 *
	 * Ensures only one instance of EZ_Portfolio_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see EZ_Portfolio()
	 * @return Main EZ_Portfolio_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}