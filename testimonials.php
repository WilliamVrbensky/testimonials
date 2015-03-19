<?php
/*
*Plugin Name: Testimonials
*Plugin URI: http://phoenix.sheridanc.on.ca/~ccit2661/
*Description: A plugin to display customer testimonials.
*Author: Elton Fernandes, William Vrbensky, Muhammad Farrukh
*Version: 1.0
*/
 
/*The code below is used to enqueue our css stylesheet and a font from Font Awesome.
*The font from Font Awesome is called "comments" which looks like a talking bubble as you can see displayed on the website once testimonials are applied.
*We originally didn't enqueue Font Awesome and it worked. We realized our theme enqueued Font Awesome, which is why it was working on our theme but not other themes. This is when we realized that it needed to be enqueued in the functions file of our plugin in order to work across any theme.
*/
function testimonials_stylesheet() {
	wp_enqueue_style( 'testimonials_css', plugins_url( '/style.css', __FILE__ ) );
	wp_enqueue_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

//This enables our stylesheet to bring in the style as indicated.
add_action( 'wp_enqueue_scripts', 'testimonials_stylesheet' );

//The add_action code below displays the testimonials post option on the WordPress dashboard.
add_action( 'init', 'testimonials_post_type' );

/*
*The code below adds the testimonials widget to make it available under the Appearance>Widgets option in WordPress.
*/
include( dirname( __FILE__ ) . '/testimonials_widget.php' );

/*
*This function testimonial_post_type creates the custom post type.
*This function is supported by the $labels array which lists the name for each section within the plugin. 
*/
function testimonials_post_type() {
	$labels = array(
		'name' => 'Testimonials',
		'singular_name' => 'Testimonial',
		'add_new_item' => 'Add New Testimonial',
		'add_new' => 'Add New Testimonial',
		'edit_item' => 'Edit Testimonial',
		'new_item' => 'New Testimonial',
		'view_item' => 'View Testimonial',
		'search_items' => 'Search Testimonials',
		'not_found' =>  'No Testimonials found',
		'not_found_in_trash' => 'No Testimonials found in the trash',
	);

/*'dashicons-testimonial' menu icon retrieved from WordPress.org.
*The register_post_type function registers the labels of the plugin as well as other items such as the location of the plugin and editable sections.
*The register_meta_box_cb registers the boxes in which the information/data can be viewed for each testimonial on the back-end of wordpress.
*/
	register_post_type( 'testimonials', array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'rewrite' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-testimonial',
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 10,
		'supports' => array( 'editor', 'title' ),
		'register_meta_box_cb' => 'testimonials_meta_boxes',
	) );
}

/*
*This function adds the necessary metabox
*This function is attached to the 'testimonials_post_type()' meta box, and visualizes the testimonial each customer has provided
*/
function testimonials_meta_boxes() {
	add_meta_box( 'testimonials_form', 'testimonials', 'normal', 'high' );
}

/*
*Adding the necessary metabox.
*This functions is attached to the 'add_meta_box()' callback.
*/
function testimonials_form() {
	$post_id = get_the_ID();
	wp_nonce_field( 'testimonials', 'testimonials' );	
}

/* 
*This hooks the function of saving the testimonial posts, and runs the function of saving it. 
*/
add_action( 'save_post', 'testimonials_save_post' );

/*
*Data validation and saving.
*This functions is attached to the 'save_post' action hook.
*/
function testimonials_save_post( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( ! empty( $_POST['testimonials'] ) && ! wp_verify_nonce( $_POST['testimonials'], 'testimonials' ) )
		return;

	if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	}

	if ( ! wp_is_post_revision( $post_id ) && 'testimonials' == get_post_type( $post_id ) ) {
		remove_action( 'save_post', 'testimonials_save_post' );
		add_action( 'save_post', 'testimonials_save_post' );
	}

	if ( ! empty( $_POST['testimonial'] ) ) {
	
		update_post_meta( $post_id, '_testimonial');
	} else {
		delete_post_meta( $post_id, '_testimonial' );
	}
}

/*
*This action hooks the function 'testimonials_edit_columns' and allows you to edit the testimonial based on each column.
*/
add_filter( 'manage_edit-testimonials_columns', 'testimonials_edit_columns' );

/*
*The code below modifies/edits the columns for already existing testimonials.
*This functions is attached to the 'manage_edit-testimonials_columns' filter hook. It is arranged in an array of each specific column.
*The return will enter the changes made to the "$columns." 
*/
function testimonials_edit_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'testimonial' => 'Testimonial',
		'author' => 'Posted by',
		'date' => 'Date'
	);

	return $columns;
}

/*
*This hooks onto the function 'testiomonial_columns' and runs it.
*/
add_action( 'manage_posts_custom_column', 'testimonials_columns', 10, 2 );

/*
*Customizing the list view columns.
*This functions is attached to the 'manage_posts_custom_column' action hook.
*/
function testimonials_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'testimonial':
			the_excerpt();
			break;
	}
}

/*
* The code below displays the testimonials on the front-end of the website.
* The $post_per_page argument function acts as an operator which shows the number of testimonials you want to display.
* The $orderby argument denotes the order in which the testimonials are displayed.
* The $testimonial_id arg gives the ID of the testimonial(s).
* 
*/
function get_testimonial( $posts_per_page, $orderby ) {
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type' => 'testimonials',
		'orderby' => $orderby,
	);

	$query = new WP_Query( $args  );

	$testimonials = '';
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) : $query->the_post();
			$post_id = get_the_ID();
			$testimonials .= '<aside class="testimonial">';
			$testimonials .= '<span class="quote"><i class="fa fa-comments"></i></span>';
			$testimonials .= '<div class="entry-content">';
			$testimonials .= '<p class="testimonial-text">' . get_the_content() . '</p>';
			$testimonials .= '<p class="testimonial-name"></p>';
			$testimonials .= '</div>';
			$testimonials .= '</aside>';

		endwhile;
		wp_reset_postdata();
	}

	return $testimonials;
}

/*
*Shortcode to display testimonials.
*This functions is attached to the 'testimonial' action hook.
*[testimonial posts_per_page="5" orderby="rand"]
*/
add_shortcode( 'testimonial', 'testimonial_shortcode' );

function testimonial_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'posts_per_page' => '5',
		'orderby' => 'rand',
	), $atts ) );

	return get_testimonial( $posts_per_page, $orderby );
}
?>