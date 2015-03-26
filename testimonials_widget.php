<?php
/*
*Testimonials widget.
*This the public function __construct code calls the new widget testimonial under the class name 'testimonial_widget'
*The code below sets up the widget name and its description.
*$widget_ops argument is the css class of the widget, displaying it
*/
class testimonials_widget extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'testimonials_widget', 'description' => 'A widget to display client testimonials.' );
		parent::__construct( 'testimonials_widget', 'Testimonials', $widget_ops );
	}

/*
*The code below displays the testimonial widget on the sidebar on the front-end of the site
*The code 'echoes' out or displays the data and information within in the widget before and after other widgets on the sidebar
*The $posts_per_page arg contols how many testimonials can be seen at once on within the widget
*The $order_by arg gives users the ability to order the testimonials by random, date, or default none
*/
		public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$posts_per_page = (integer) $instance['posts_per_page'];
		$orderby = strip_tags( $instance['orderby'] );

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		echo get_testimonial( $posts_per_page, $orderby );

		echo $after_widget;
	}

//The update function code below updates the changes made to the widget (title, number of posts per page, and the order-by argument)
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( $new_instance['title'] );
		$instance['posts_per_page'] = $new_instance['posts_per_page'];
		$instance['orderby'] = ( $new_instance['orderby'] );

		return $instance;
	}
	
/*
*The form function below constructs the form in which you can select how you want to display the testimonials 
*Title, the number of testimonials seen per page, along with the order in which they are displayed are all instances in this case
*/
	public function form( $instance ) {
		$orderby = ( $instance['orderby'] );
		$posts_per_page = $instance['posts_per_page'];
		$title = ( $instance['title'] );
?>

<?php
/*
*The code below labels each form function such as Title for $title, Number of Testimonials for $posts_per_page and Order By for $orderby
*Under the orderby label, this code labels each selection for ordering the testimonials by None, Date, and Random
*/
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of Testimonials: </label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Order:</label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
			<option value="recent" <?php selected( $orderby, 'recent' ); ?>>Recent</option>
			<option value="rand" <?php selected( $orderby, 'rand' ); ?>>Random</option>
		</select></p>

		<?php
	}
}

/*
*The code below registers our testimonial widget.
*This functions is attached to the 'widgets_init' action hook.
*The add_action code adds the widget onto both the back end and front end of the site.
*/
add_action( 'widgets_init', function(){
     register_widget( 'testimonials_widget' );
});
?>