<?php
/*
*Plugin Name: Testimonials
*Plugin URI: http://phoenix.sheridanc.on.ca/~ccit2661/
*Description: A plugin to display customer testimonials.
*Author: Elton Fernandes, William Vrbensky, Muhammad Farrukh
*Version: 1.0
*/
 
/*The code below is used to enqueue our css stylesheet and a font taken from Font Awesome.
*The font from Font Awesome is called "comments" which looks like a talking bubble as you can see displayed on the website once testimonials are applied.
*We originally didn't enqueue Font Awesome and it worked. We realized our theme enqueued Font Awesome, which is why it was working on our theme but not other themes. This is when we realized that it needed to be enqueued in the functions file of our plugin in order to work across any theme.
*/
function testimonials_stylesheet() {
	wp_enqueue_style( 'testimonials_css', plugins_url( '/style.css', __FILE__ ) );
	wp_enqueue_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

//The code below adds the action to bring in our two styles enqueued as indicated above.
add_action( 'wp_enqueue_scripts', 'testimonials_stylesheet' );

//The add_action code below displays the testimonials post option on the WordPress dashboard.
add_action( 'init', 'testimonials_post_type' );

//The code below adds the testimonials widget to make it available under the Appearance>Widgets option in WordPress.
include( dirname( __FILE__ ) . '/testimonials_widget.php' );
<<<<<<< HEAD
=======

>>>>>>> origin/master
//The code below adds the submenu under our testimonials page inside of the WordPress dashboard. We took a snippet of the URL since it is a custom post type in order for our options menu to show up under the testimonials page.
function testimonials_add_admin_menu(  ) { 

	add_submenu_page( 'edit.php?post_type=testimonials', 'Options', 'Options', 'manage_options', 'my_awesome_plugin', 'my_awesome_plugin_options_page' );
	
}
<<<<<<< HEAD
=======

>>>>>>> origin/master
//The code below registers the settings to make them show up under our options page.
function hundope_settings_init(  ) { 

	register_setting( 'options_page', 'hundope_settings' );
	
//We indicated the title to be description in the options page.
	add_settings_section(
		'options_page_section', 
		__( 'Description', 'hundope' ), 
		'hundope_settings_section_callback', 
		'options_page'
	);
<<<<<<< HEAD
=======

>>>>>>> origin/master
//The code below adds the settings field to make our dropdown menu show up.
	add_settings_field( 
		'hundope_select_field', 
		__( 'Choose a colour from the dropdown:', 'hundope' ), 
		'hundope_select_field_render', 
		'options_page', 
		'options_page_section' 
	);

}
<<<<<<< HEAD
=======

>>>>>>> origin/master
//The function below should be the content on the options page to show a dropdown menu. Our goal was to let users select which colour to make the testimonial posts.
function hundope_select_field_render() { 
	
}

function hundope_settings_section_callback() { 
	echo __( 'Select a colour that you would like to make the testimonial posts.', 'hundope' );
}

function my_awesome_plugin_options_page() { 

	?>
	<form action="options.php" method="post">
		
		<h2>Options Page</h2>
		<?php
		settings_fields( 'options_page' );
		do_settings_sections( 'options_page' );
		//The code below defines and physically calls  the dropdown menu from the register settings.
		$options = get_option( 'hundope_settings' );
	?>
	<select name="hundope_settings[hundope_select_field]">
	<option value="None" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 1 ); ?>>None</option>		
	<option value="Black" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 2 ); ?>>Black</option>
	<option value="Blue" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 3 );  ?>>Blue</option>
	<option value="Red"  <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 4 ); ?>>Red</option>
	<option value="Green" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 5 ); ?>>Green</option>
	<option value="Yellow" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 6 ); ?>>Yellow</option>
	<option value="Purple" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 7 ); ?>>Purple</option>
	<option value="Brown" <?php if (isset($options['hundope_select_field'])) selected( $options['hundope_select_field'], 8 ); ?>>Brown</option>
	</select>
		
		<?php
		//The code below enables the save changes button to be available and save the indicated colour change.
		submit_button();
		?>
				
	</form>
	<?php
return $options;
}

add_action( 'admin_menu', 'testimonials_add_admin_menu' );
add_action( 'admin_init', 'hundope_settings_init' );
<<<<<<< HEAD
=======


>>>>>>> origin/master
/*
*This function testimonial_post_type creates the custom post type.
*This function is supported by the $labels array which lists the name for each section within the plugin. 
*The array items below will display what we want it to say under the testimonials page. For example, whatever you put next to the add_new array will show in the button at the top of testimonials page.
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

/*
*'dashicons-testimonial' menu icon retrieved from WordPress.org.
*The register_post_type function registers the labels of the plugin as well as other items such as the location of the plugin and editable sections.
*The register_meta_box_cb registers the boxes in which the information/data can be viewed for each testimonial on the back-end of WordPress.
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

//This hooks the function of saving the testimonial posts, and runs the function of saving it. 
add_action( 'save_post', 'testimonials_save_post' );

/*
*The code below enables our posts to be saved.
*This function is attached to the 'save_post' action hook.
*The code below tells the plugin to save each post when you click on save.
*/
function testimonials_save_post( $post_id ) {
	if ( ! empty( $_POST['testimonials'] ) && ! wp_verify_nonce( $_POST['testimonials'], 'testimonials' ) )
		return;
}

//This action hooks the function 'testimonials_edit_columns' and allows you to edit the testimonial based on each column.
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
		'author' => 'Author',
		'date' => 'Date'
	);

	return $columns;
}

/*
*This hooks onto the function 'testiomonial_columns' and runs it.
*The code below manages testimonials column in the WordPress dashboard.
*/
add_action( 'manage_posts_custom_column', 'testimonials_columns', 10, 2 );

/*
*The code below customizes our testimonials' columns in list view.
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
*/
function get_testimonial( $posts_per_page, $orderby ) {
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type' => 'testimonials',
		'orderby' => $orderby
	);
<<<<<<< HEAD
//The options argument pulls the option of grabing each specific colour that's indicated in the select field.
	$options = get_option( 'hundope_settings' );
	
/*
*We decided to do an inline style. If we were to do the style in a css stylesheet, the change for colours would not physically show up on the front end of our site. 
*/
=======

	//The options argument pulls the option of grabing each specific colour that's indicated in the select field.
	$options = get_option( 'hundope_settings' );
	
>>>>>>> origin/master
	$query = new WP_Query( $args  );
	$testimonials = '';
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) : $query->the_post();
		$post_id = get_the_ID();
		$testimonials .= '<aside class="testimonial">';
		//The code below calls the options variable to indicate the colour in the select field and apply it towards our testimonial quote icon.
		$testimonials .= '<span class="quote"><i class="fa fa-comments" style="color:' . $options['hundope_select_field'] . ';"></i></span>';
		$testimonials .= '<div class="entry-content">';
		//The code below calls our options variable to get the colour indicated in the select field and apply it onto the text.
		$testimonials .= '<p class="testimonial-text" style="color:' . $options['hundope_select_field'] . ';" >' . get_the_content() . '</p>';
		$testimonials .= '<p class="testimonial-name"></p>';
		$testimonials .= '</div>';
		$testimonials .= '</aside>';
		endwhile;
		wp_reset_postdata();
		
	}

	return $testimonials;
}

/*
*The code below enables a shortcode to input into different pages in order to display the testimonials posted.
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
