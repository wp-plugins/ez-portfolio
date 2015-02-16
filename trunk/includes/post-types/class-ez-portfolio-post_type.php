<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class EZ_Portfolio_Post_Type {

	/**
	 * The single instance of EZ_Portfolio_Post_Type.
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
	 * The name for the custom post type.
	 * @var 	string
	 * @access  public
	 * @since 	1.0.0
	 */
	public $post_type;

	public function __construct ( $parent ) {
		$this->parent = $parent;

		// Modify this to the name of your custom post type
		$this->post_type = 'ez_portfolio';

		// Regsiter post type
		add_action( 'init' , array( $this, 'register_post_type' ) );
		
		// Register taxonomy
		add_action('init', array( $this, 'register_taxonomy' ) );

		if ( is_admin() ) {

			// Handle custom fields for post
			add_action( 'admin_menu', array( $this, 'meta_box_setup' ), 20 );
			add_action( 'save_post', array( $this, 'meta_box_save' ) );

			// Modify text in main title text box
			add_filter( 'enter_title_here', array( $this, 'enter_title_here' ) );

			// Display custom update messages for posts edits
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

		}

	}

	/**
	 * Register new post type
	 * @return void
	 */
	public function register_post_type () {

		$labels = array(
			'name' => _x( 'EZ Portfolio', 'post type general name' , 'ez-portfolio' ),
			'singular_name' => _x( 'EZ Portfolio', 'post type singular name' , 'ez-portfolio' ),
			'add_new' => _x( 'Add New Item', $this->post_type , 'ez-portfolio' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'ez-portfolio' ), __( 'Post' , 'ez-portfolio' ) ),
			'edit_item' => sprintf( __( 'Edit %s' , 'ez-portfolio' ), __( 'Post' , 'ez-portfolio' ) ),
			'new_item' => sprintf( __( 'New %s' , 'ez-portfolio' ), __( 'Post' , 'ez-portfolio' ) ),
			'all_items' => sprintf( __( 'All %s' , 'ez-portfolio' ), __( 'Items' , 'ez-portfolio' ) ),
			'view_item' => sprintf( __( 'View %s' , 'ez-portfolio' ), __( 'Post' , 'ez-portfolio' ) ),
			'search_items' => sprintf( __( 'Search %a' , 'ez-portfolio' ), __( 'Items' , 'ez-portfolio' ) ),
			'not_found' =>  sprintf( __( 'No %s Found' , 'ez-portfolio' ), __( 'Items' , 'ez-portfolio' ) ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'ez-portfolio' ), __( 'Posts' , 'ez-portfolio' ) ),
			'parent_item_colon' => '',
			'menu_name' => __( 'EZ Portfolio' , 'ez-portfolio' )
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array( 'title' , 'editor' , 'thumbnail' ),
			'menu_position' => 5,
			'menu_icon' => 'dashicons-portfolio'
		);

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register new taxonomy
	 * @return void
	 */
	public function register_taxonomy () {

        $labels = array(
            'name' => __( 'Categories' , 'ez-portfolio' ),
            'singular_name' => __( 'Category', 'ez-portfolio' ),
            'search_items' =>  __( 'Search Categories' , 'ez-portfolio' ),
            'all_items' => __( 'All Categories' , 'ez-portfolio' ),
            'parent_item' => __( 'Parent Category' , 'ez-portfolio' ),
            'parent_item_colon' => __( 'Parent Category:' , 'ez-portfolio' ),
            'edit_item' => __( 'Edit Category' , 'ez-portfolio' ),
            'update_item' => __( 'Update Category' , 'ez-portfolio' ),
            'add_new_item' => __( 'Add New Category' , 'ez-portfolio' ),
            'new_item_name' => __( 'New Category Name' , 'ez-portfolio' ),
            'menu_name' => __( 'Categories' , 'ez-portfolio' ),
        );

        $args = array(
            'public' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'labels' => $labels
        );

        register_taxonomy( 'ez_post_type_categories' , $this->post_type , $args );
    }

	/**
	 * Set up admin messages for post type
	 * @param  array $messages Default message
	 * @return array           Modified messages
	 */
	public function updated_messages ( $messages ) {
	  global $post, $post_ID;

	  $messages[$this->post_type] = array(
	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __( 'Post updated. %sView post%s.' , 'ez-portfolio' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    2 => __( 'Custom field updated.' , 'ez-portfolio' ),
	    3 => __( 'Custom field deleted.' , 'ez-portfolio' ),
	    4 => __( 'Post updated.' , 'ez-portfolio' ),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __( 'Post restored to revision from %s.' , 'ez-portfolio' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __( 'Post published. %sView post%s.' , 'ez-portfolio' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    7 => __( 'Post saved.' , 'ez-portfolio' ),
	    8 => sprintf( __( 'Post submitted. %sPreview post%s.' , 'ez-portfolio' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	    9 => sprintf( __( 'Post scheduled for: %1$s. %2$sPreview post%3$s.' , 'ez-portfolio' ), '<strong>' . date_i18n( __( 'M j, Y @ G:i' , 'ez-portfolio' ), strtotime( $post->post_date ) ) . '</strong>', '<a target="_blank" href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    10 => sprintf( __( 'Post draft updated. %sPreview post%s.' , 'ez-portfolio' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	  );

	  return $messages;
	}

	/**
	 * Add meta box to post type
	 * @return void
	 */
	public function meta_box_setup () {
		add_meta_box( 'post-data', __( 'Video or Audio URL' , 'ez-portfolio' ), array( $this, 'meta_box_content' ), $this->post_type, 'normal', 'high' );
	}

	/**
	 * Load meta box content
	 * @return void
	 */
	public function meta_box_content () {
		global $post_id;
		$fields = get_post_custom( $post_id );
		$field_data = $this->get_custom_fields_settings();

		$html = '';

		$html .= '<input type="hidden" name="' . $this->post_type . '_nonce" id="' . $this->post_type . '_nonce" value="' . wp_create_nonce( plugin_basename( $this->parent->dir ) ) . '" />';

		if ( 0 < count( $field_data ) ) {
			$html .= '<table class="form-table">' . "\n";
			$html .= '<tbody>' . "\n";

			foreach ( $field_data as $k => $v ) {
				$data = $v['default'];

				if ( isset( $fields[$k] ) && isset( $fields[$k][0] ) ) {
					$data = $fields[$k][0];
				}

				if( $v['type'] == 'checkbox' ) {
					$html .= '<tr valign="top"><th scope="row">' . $v['name'] . '</th><td><input name="' . esc_attr( $k ) . '" type="checkbox" id="' . esc_attr( $k ) . '" ' . checked( 'on' , $data , false ) . ' /> <label for="' . esc_attr( $k ) . '"><span class="description">' . $v['description'] . '</span></label>' . "\n";
					$html .= '</td></tr>' . "\n";
				} else {
					$html .= '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label></th><td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
					$html .= '<p class="description">' . $v['description'] . '</p>' . "\n";
					$html .= '</td></tr>' . "\n";
				}

			}

			$html .= '</tbody>' . "\n";
			$html .= '</table>' . "\n";
		}

		echo $html;
	}

	/**
	 * Save meta box
	 * @param  integer $post_id Post ID
	 * @return void
	 */
	public function meta_box_save ( $post_id ) {
		global $post, $messages;

		// Verify nonce
		if ( ( get_post_type() != $this->post_type ) || ! wp_verify_nonce( $_POST[ $this->post_type . '_nonce'], plugin_basename( $this->parent->dir ) ) ) {
			return $post_id;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Handle custom fields
		$field_data = $this->get_custom_fields_settings();
		$fields = array_keys( $field_data );

		foreach ( $fields as $f ) {

			if( isset( $_POST[$f] ) ) {
				${$f} = strip_tags( trim( $_POST[$f] ) );
			}

			// Escape the URLs.
			if ( 'url' == $field_data[$f]['type'] ) {
				${$f} = esc_url( ${$f} );
			}

			if ( ${$f} == '' ) {
				delete_post_meta( $post_id , $f , get_post_meta( $post_id , $f , true ) );
			} else {
				update_post_meta( $post_id , $f , ${$f} );
			}
		}

	}

	/**
	 * Load custom title placeholder text
	 * @param  string $title Default title placeholder
	 * @return string        Modified title placeholder
	 */
	public function enter_title_here ( $title ) {
		if ( get_post_type() == $this->post_type ) {
			$title = __( 'Enter the post title here' , 'ez-portfolio' );
		}
		return $title;
	}

	/**
	 * Load custom fields for post type
	 * @return array Custom fields array
	 */
	public function get_custom_fields_settings () {
		$ez_fields = array();

		$ez_fields['_url'] = array(
		    'name' => __( 'URL:' , 'ez-portfolio' ),
		    'description' => __( 'Place Youtube or Vimeo url here.' , 'ez-portfolio' ),
		    'type' => 'text',
		    'default' => '',
		    'section' => 'plugin-data'
		);

		return $ez_fields;
	}

	/**
	 * Main EZ_Portfolio_Post_Type Instance
	 *
	 * Ensures only one instance of EZ_Portfolio_Post_Type is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see EZ_Portfolio()
	 * @return Main EZ_Portfolio_Post_Type instance
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
