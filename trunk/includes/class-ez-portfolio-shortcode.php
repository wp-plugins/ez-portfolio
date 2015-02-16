<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Shortcode for the Portfolio
 * @since   1.0.0
 */

 
function ez_portfolio_shortcode( $atts ) {
	ob_start();
	extract(shortcode_atts(array(
		'effect'  => '',
		'columns' => '',
		'items' => ''
	), $atts)); ?>
	
	<div class="portfolio-content">
		<?php
			$terms = get_terms("ez_post_type_categories"); // get all categories, but you can use any taxonomy
			$count = count($terms); //How many are they?
			if ( $count > 0 ){  //If there are more than 0 terms
				echo "<div id='menu-outer'>";
				echo "<ul id='filter'>";
				echo "<li><a class='active' href='#' data-group='all'>All</a></li>";
				foreach ( $terms as $term ) {  //for each term:
					echo "<li><a href='#' data-group='".$term->slug."'>" . $term->name . "</a></li>\n"; //create a list item with the current term slug for sorting, and name for label
				}
				echo "</ul>";
				echo "</div>";
			}
		?>

		<?php $the_query = new WP_Query( array(
			'post_type' => 'ez_portfolio',
			'posts_per_page' => $items,
			'order' => 'ASC',
			'orderby' => 'title',
		) ); ?>

		<?php if ( $the_query->have_posts() ) : ?>
			<div id="grid">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			global $post;
			$termsArray = get_the_terms( $post->ID, 'ez_post_type_categories' );  //Get the terms for this particular item
			if (!empty($termsArray) && !is_wp_error($termsArray)) {
			$termsString = ""; //initialize the string that will contain the terms
				foreach ( $termsArray as $term ) { // for each term
				    if ($term === end($termsArray)) {
						$termsString .= $term->slug.''; // last slug in the line
					} else {
						$termsString = $term->slug.'"'.', '.'"'; // rest of the slugs
					}
					
				}
			}
			global $post;
			$meta = get_post_meta($post->ID,'_url', true);
			?>
			<?php $custom_fields = get_post_custom($post->ID, 'ez_portfolio'); ?>
			
			<?php if ( $columns == '2' ) : ?>
				<div class="item col span_1_of_2 " data-groups='["<?php echo $termsString; ?>"]'>
			<?php elseif ( $columns == '3' ) : ?>
				<div class="item col span_1_of_3 " data-groups='["<?php echo $termsString; ?>"]'>
			<?php elseif ( $columns == '4' ) : ?>
				<div class="item col span_1_of_4 " data-groups='["<?php echo $termsString; ?>"]'>
			<?php elseif ( $columns == '5' ) : ?>
				<div class="item col span_1_of_5 " data-groups='["<?php echo $termsString; ?>"]'>			
			<?php elseif ( $columns == '6' ) : ?>
				<div class="item col span_1_of_6 " data-groups='["<?php echo $termsString; ?>"]'>		
			<?php endif; ?>
			
			<?php if ( $effect == 'simple' ) : ?>
			<div class="ez_item ez_item-first">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
				<div class="mask">
					<div class="centerit">
					<a class="info_simple_zoom" href="<?php the_permalink(); ?>"><?php echo '<i class="fa fa-repeat fa-1x"></i>'; ?></a> 
					<?php if($meta !='') {
							echo '<a class="info_simple lightbox" href="' . $meta . '">';
							echo '<i class="fa fa-play fa-1x"></i>';
							echo '</a>';
					} else { ?>
					<?php if ( has_post_thumbnail()) { $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
							echo '<a class="info_simple lightbox" href="' . $full_image_url[0] . '" title="' . the_title_attribute('echo=0') . '">';
							echo '<i class="fa fa-plus fa-1x"></i>';
							echo '</a>';
							} ?>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php elseif ( $effect == 'classic' ) : ?>
			<div class="ez_item ez_item-second">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
				<div class="mask">
					<h2 class="classic-title"><?php echo ShortenText(get_the_title()); ?></h2>
					<div class="centerit">
					<a class="info_classic_zoom" href="<?php the_permalink(); ?>"><?php echo '<i class="fa fa-repeat fa-1x"></i>'; ?></a> 
					<?php if($meta !='') {
							echo '<a class="info_classic lightbox" href="' . $meta . '">';
							echo '<i class="fa fa-play fa-1x"></i>';
							echo '</a>';
					} else { ?>
					<?php if ( has_post_thumbnail()) { $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
							echo '<a href="' . $full_image_url[0] . '" class="info_classic lightbox" title="' . the_title_attribute('echo=0') . '">';
							echo '<i class="fa fa-plus fa-1x"></i>';
							echo '</a>';
							} ?>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php elseif ( $effect == 'push' ) : ?>
			<div class="ez_item ez_item-third">
				<a class="push-up" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
				<div class="ez_item_title">
					<div class="ez_item_title_reveal">
						<h2><?php echo ShortenText(get_the_title()); ?></h2>
						<div class="ez_item-third_text"><?php echo get_the_date(); ?></div>
						<a class="info_push_zoom" href="<?php the_permalink(); ?>"><?php echo '<i class="fa fa-repeat fa-1x"></i>'; ?></a> 
						<?php if($meta !='') {
							echo '<a class="info_push lightbox" href="' . $meta . '">';
							echo '<i class="fa fa-play fa-1x"></i>';
							echo '</a>';
						} else { ?>
						<?php if ( has_post_thumbnail()) { $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
								echo '<a class="info_push lightbox" href="' . $full_image_url[0] . '" title="' . the_title_attribute('echo=0') . '">';
								echo '<i class="fa fa-plus fa-1x"></i>';
								echo '</a>';
								} ?>
						<?php } ?>
					</div>
				</div>
				<a class="push-down" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
			</div>
			<?php elseif ( $effect == 'door-classic' ) : ?>
			<div class="ez_item ez_item-fourth">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full');?></a>
				<div class="mask">
					<div class="centerit">
					<a class="info_door_zoom" href="<?php the_permalink(); ?>"><?php echo '<i class="fa fa-repeat fa-1x"></i>'; ?></a> 
					<?php if($meta !='') {
							echo '<a class="info_door lightbox" href="' . $meta . '">';
							echo '<i class="fa fa-play fa-1x"></i>';
							echo '</a>';
					} else { ?>
					<?php if ( has_post_thumbnail()) { $full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
							echo '<a class="info_door lightbox" href="' . $full_image_url[0] . '" title="' . the_title_attribute('echo=0') . '">';
							echo '<i class="fa fa-plus fa-1x"></i>';
							echo '</a>';
							} ?>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if ( $columns == '2' ) : ?>
				</div>
			<?php elseif ( $columns == '3' ) : ?>
				</div>
			<?php elseif ( $columns == '4' ) : ?>
				</div>
			<?php elseif ( $columns == '5' ) : ?>
				</div>
			<?php elseif ( $columns == '6' ) : ?>
				</div>
			<?php endif; ?>
			<?php endwhile;  ?>
			</div> <!-- end shuffle-list -->
			<?php endif; ?>
	</div> 
	<?php
	wp_reset_postdata();
	$clean_variable = ob_get_clean();
	return $clean_variable; 
}
add_shortcode( 'ez-portfolio', 'ez_portfolio_shortcode' );

?>