<?php

// Add Custom Styles with WP wp_add_inline_style Method

function ez_css_styles_method() {

		wp_enqueue_style('ez_custom-css-style', plugins_url().'/ez-portfolio/assets/css/frontend.css', true, '1.0');
		
		// Variables
		
		// General
		$margin = get_option( 'ez_margin_general', '0 0.3% 0.85% 0.3%' );
		$two_col_width = get_option( 'ez_2col_width', '49.4%' );
		$three_col_width = get_option( 'ez_3col_width', '32.73%' );
		$four_col_width = get_option( 'ez_4col_width', '24.4%' );
		$five_col_width = get_option( 'ez_5col_width', '19.4%' );
		$six_col_width = get_option( 'ez_6col_width', '16.06%' );

		// Push
		$push_bg_color = get_option( 'ez_push_bg_color', '#ffffff' );
		$push_border_color = get_option( 'ez_push_border_color', '#1763a4' );
		$push_button_color = get_option( 'ez_push_button_color', '#ffffff' );
		$push_button_hover = get_option( 'ez_push_button_hover', '#1763a4' );
		
		// Door
		$door_classic_border_color = get_option( 'ez_door_classic_border_color', '#1763a4' );
		$door_classic_button_color = get_option( 'ez_door_classic_button_color', '#1763a4' );
		$door_classic_button_hover = get_option( 'ez_door_classic_button_hover', '#ffffff' );		
		
		
		
		// Styles
        $custom_css = "
        	
			.col {
				float:left;
				margin: {$margin};
			}

			/**
			* Grid Column Setup
			*/
	
			.span_1_of_2 {
				max-width: {$two_col_width};
				width: auto;
			}

			.span_1_of_3 {
				max-width: {$three_col_width};
				width: auto;
			}
	
			.span_1_of_4 {
				max-width: {$four_col_width};
				width: auto;
			}

			.span_1_of_5 {
				max-width: {$five_col_width};
				width: auto;
			}
	
			.span_1_of_6 {
				max-width: {$six_col_width};
				width: auto;
			}

			/**
			* Media Querys
			*/

			@media only screen and (max-width: 580px) {
				.col { 
					margin: 1% 0 1% 0%;
				}
				.span_1_of_6, 
				.span_1_of_5, 
				.span_1_of_4, 
				.span_1_of_3, 
				.span_1_of_2 {
					width: auto;
					max-width: 100%; 
				}
			}
 

			/* Plain And Simple */

			.ez_item-first img {
				transition: all 0.2s linear;
			}

			.ez_item-first:hover .mask {
				opacity: 1;
			}
			
			/* Classic */

			.ez_item-second img {
				transition: all 0.2s linear;
			}

			.ez_item-second h2 {
				transform: translateY(-190px);
				opacity: 0;
				transition: all 0.2s ease-in-out;
				background: rgba(0, 0, 0, 0.4);
			}

			.ez_item-second:hover .mask {
				opacity: 1;
			}

			.ez_item-second:hover h2 {
				opacity: 1;
				transform: translateY(0px);
			}
			
			/* Push */
			
			.ez_item-third {
				z-index: 1;
				transition: z-index 0.1s step-end;
			}
			
			.ez_item-third:hover {
				outline: 10px solid {$push_border_color};
				z-index: 2;
				transition: z-index step-start;
			}

			.ez_item_title {
				position: relative;
				display: block;
			}

			.ez_item_title_reveal {
				display: none;
				background: {$push_bg_color};
			}

			.ez_item-third h2 {
				height: auto;
				color: #222;
				position: relative;
				z-index: 2;
			}

			.ez_item-third img {
				transition: all 0.2s linear;
			}

			.ez_item-third_text {
				color: #222;
				font-size: 10px;
				padding: 0 0 10px 0;
			}

			.ez_item-third:hover .mask {
				opacity: 1;
				transition: all 0.5s ease-in-out;
			}
			
			.ez_item a.info_push, .ez_item a.info_push_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				background: {$push_button_color};
				color: {$push_button_hover} !important;
				margin: 5px;
				position: relative;
				border-radius: 100px;
			}

			.ez_item a.info_push:hover, .ez_item a.info_push_zoom:hover {
				background: {$push_button_hover} !important;
				color: {$push_button_color} !important;
			}

			/* Door */

			.ez_item-fourth:hover {
				outline: 10px solid {$door_classic_border_color};
			}

			.ez_item-fourth img {
				transition: all 0.2s linear;
			}

			.ez_item-fourth:hover {
				z-index: 2;
				background: #fff;
				transition-duration: 3s;
				transition-property: z-index;
			}

			.ez_item-fourth .mask {
				opacity: 0;
				background-color: rgba(0,0,0, 0.3);
				transition: all 0.3s ease-in-out;
			}

			.ez_item-fourth:hover .mask {
				opacity: 1;
			}
			
			.ez_item a.info_door, .ez_item a.info_door_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				background: {$door_classic_button_color} !important;
				color: {$door_classic_button_hover} !important;
				margin: 5px;
				position: relative;
				border-radius: 100px;
			}

			.ez_item a.info_door:hover, .ez_item a.info_door_zoom:hover {
				background: {$door_classic_button_hover} !important;
				color: {$door_classic_button_color} !important;
			}

        ";

        // Add inline style
        wp_add_inline_style( 'ez_custom-css-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ez_css_styles_method' );

// Add Custom Stuff

function ez_css_styles_dynamic() {

?>

	<style>
		
		/* Plain And Simple */
		
	
		<?php if ( get_option( 'ez_simple_zoom', 'on' ) == 'on' ) : ?>
			.ez_item-first:hover img {
				transform: scale(1.1);
			}		
		<?php elseif ( get_option( 'ez_simple_zoom', 'on' ) == 'off' ) : ?>
			.ez_item-first:hover img {
				transform: scale(1.0);
			}
		<?php endif; ?>
		
		<?php if ( get_option( 'ez_simple_custom_colors', 'off' ) == 'off' ) : ?>
			.ez_item a.info_simple, .ez_item a.info_simple_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				color: #fff;
				margin: 5px;
				position: relative;
				border-radius: 100px;
			}
			.ez_item-first .mask {
				opacity: 0;
				background: rgba(0,0,0,0.5);
				transition: all 0.4s ease-in-out;
			}
			<?php if ( get_option( 'ez_simple_select_box', 'blue' ) == 'black' ) : ?>
				.ez_item a.info_simple, .ez_item a.info_simple_zoom {
					background: #222;
					color: #fff !important;
				}
				.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
					background: #fff;
					color: #222 !important;
				}
				<?php elseif ( get_option( 'ez_simple_select_box', 'blue' ) == 'blue' ) : ?>
				.ez_item a.info_simple, .ez_item a.info_simple_zoom {
					background: #415eca;
					color: #fff !important;
				}
				.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
					background: #fff;
					color: #415eca !important;
				}
				<?php elseif ( get_option( 'ez_simple_select_box', 'blue' ) == 'green' ) : ?>
				.ez_item a.info_simple, .ez_item a.info_simple_zoom {
					background: #6db408;
					color: #fff !important;
				}
				.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
					background: #fff;
					color: #6db408 !important;
				}
				<?php elseif ( get_option( 'ez_simple_select_box', 'blue' ) == 'red' ) : ?>
				.ez_item a.info_simple, .ez_item a.info_simple_zoom {
					background: #c40c56;
					color: #fff !important;
				}
				.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
					background: #fff;
					color: #c40c56 !important;
				}		
				<?php elseif ( get_option( 'ez_simple_select_box', 'blue' ) == 'orange' ) : ?>
				.ez_item a.info_simple, .ez_item a.info_simple_zoom {
					background: #db8b27;
					color: #fff !important;
				}
				.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
					background: #fff;
					color: #db8b27 !important;
				}
				<?php endif; ?>

		<?php elseif ( get_option( 'ez_simple_custom_colors', 'off' ) == 'on' ) : ?>
			.ez_item a.info_simple, .ez_item a.info_simple_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				color: <?php echo get_option( 'ez_simple_button_hover', '#ffffff' ) ?> !important;
				margin: 5px;
				position: relative;
				border-radius: 100px;
				background: <?php echo get_option( 'ez_simple_button_color', '#222222' ) ?>;
			}
			.ez_item a.info_simple:hover, .ez_item a.info_simple_zoom:hover {
				background: <?php echo get_option( 'ez_simple_button_hover', '#ffffff' ) ?>;
				color: <?php echo get_option( 'ez_simple_button_color', '#222222' ) ?> !important;
			}
			.ez_item-first .mask {
				opacity: 0;
				background: <?php echo get_option ('ez_simple_bg_rgba', 'rgba(0,0,0,0.5)') ?>;
				transition: all 0.4s ease-in-out;
			}
		<?php endif; ?>
		
		/* Classic */
		
		<?php if ( get_option( 'ez_classic_title', 'on' ) == 'on' ) : ?>
			.classic-title {
				display: block;
			}
		<?php elseif ( get_option( 'ez_classic_title', 'on' ) == 'off' ) : ?>
			.classic-title {
				display: none;
			}		
		<?php endif; ?>
		
		<?php if ( get_option( 'ez_classic_custom_colors', 'off' ) == 'off' ) : ?>
			.ez_item a.info_classic, .ez_item a.info_classic_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				color: #fff;
				margin: 5px;
				position: relative;
				border-radius: 100px;
			}
			<?php if ( get_option( 'ez_classic_select_box', 'blue' ) == 'black' ) : ?>
				.ez_item a.info_classic, .ez_item a.info_classic_zoom {
					background: #222;
					color: #fff !important;
				}
				.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
					background: #fff;
					color: #222 !important;
				}
				.ez_item-second .mask {
					opacity: 0;
					background: rgba(0,0,0,0.3);
					transition: all 0.4s ease-in-out;
				}
				<?php elseif ( get_option( 'ez_classic_select_box', 'blue' ) == 'blue' ) : ?>
				.ez_item a.info_classic, .ez_item a.info_classic_zoom {
					background: #415eca;
					color: #fff !important;
				}
				.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
					background: #fff;
					color: #415eca !important;
				}
				.ez_item-second .mask {
					opacity: 0;
					background: rgba(65,94,202,0.2);
					transition: all 0.4s ease-in-out;
				}
				<?php elseif ( get_option( 'ez_classic_select_box', 'blue' ) == 'green' ) : ?>
				.ez_item a.info_classic, .ez_item a.info_classic_zoom {
					background: #6db408;
					color: #fff !important;
				}
				.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
					background: #fff;
					color: #6db408 !important;
				}
				.ez_item-second .mask {
					opacity: 0;
					background: rgba(109,180,8,0.2);
					transition: all 0.4s ease-in-out;
				}
				<?php elseif ( get_option( 'ez_classic_select_box', 'blue' ) == 'red' ) : ?>
				.ez_item a.info_classic, .ez_item a.info_classic_zoom {
					background: #c40c56;
					color: #fff !important;
				}
				.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
					background: #fff;
					color: #c40c56 !important;
				}
				.ez_item-second .mask {
					opacity: 0;
					background: rgba(196,12,186,0.2);
					transition: all 0.4s ease-in-out;
				}				
				<?php elseif ( get_option( 'ez_classic_select_box', 'blue' ) == 'orange' ) : ?>
				.ez_item a.info_classic, .ez_item a.info_classic_zoom {
					background: #db8b27;
					color: #fff !important;
				}
				.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
					background: #fff;
					color: #db8b27 !important;
				}
				.ez_item-second .mask {
					opacity: 0;
					background: rgba(219,139,39,0.2);
					transition: all 0.4s ease-in-out;
				}	
				<?php endif; ?>
		
		<?php elseif ( get_option( 'ez_classic_custom_colors', 'off' ) == 'on' ) : ?>
			.ez_item a.info_classic, .ez_item a.info_classic_zoom {
				display: inline-block;
				text-decoration: none;
				padding: 8px 14px;
				color: <?php echo get_option( 'ez_classic_button_hover', '#ffffff' ) ?>;
				margin: 5px;
				position: relative;
				border-radius: 100px;
				background: <?php echo get_option( 'ez_classic_button_color', '#222222' ) ?>;
			}
			.ez_item a.info_classic:hover, .ez_item a.info_classic_zoom:hover {
				background: <?php echo get_option( 'ez_classic_button_hover', '#ffffff' ) ?>;
				color: <?php echo get_option( 'ez_classic_button_color', '#222222' ) ?> !important;
			}
			.ez_item-second .mask {
				opacity: 0;
				background: <?php echo get_option ('ez_classic_bg_rgba', 'rgba(0,0,0,0.5)') ?>;
				transition: all 0.4s ease-in-out;
			}

		<?php endif; ?>
		
		/* Push */
		
		<?php if ( get_option( 'ez_push_direction', 'up' ) == 'up' ) : ?>
			.push-up {
				display: block;
			}
			.push-down {
				display: none;
			}
		<?php elseif ( get_option( 'ez_push_direction', 'up' ) == 'down' ) : ?>
			.push-up {
				display: none;
			}
			.push-down {
				display: block;
			}
		<?php endif; ?>
		
		/* General */
		
		<?php if ( get_option( 'ez_portfolio_details_disable', 'off' ) == 'on' ) : ?>
		
			.info_simple_zoom, .info_classic_zoom, .info_push_zoom, .info_door_zoom {
				display: none !important;
			}
		
		<?php elseif ( get_option( 'ez_portfolio_details_disable', 'off' ) == 'off' ) : ?>
		
			.info_simple, .info_classic, .info_push, .info_door {
				display: block;
			}
		
		<?php endif; ?>
		
	</style>

<?php }
add_action( 'wp_head', 'ez_css_styles_dynamic', 100 );
?>