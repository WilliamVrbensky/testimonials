<?php
/*
*Testimonials widget.
*/
class testimonials_widget extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'testimonials_widget', 'description' => 'A widget to display client testimonials.' );
		parent::__construct( 'testimonials_widget', 'Testimonials', $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$posts_per_page = (int) $instance['posts_per_page'];
		$orderby = strip_tags( $instance['orderby'] );

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		echo get_testimonial( $posts_per_page, $orderby );

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'posts_per_page' => '1', 'orderby' => 'none', 'testimonial_id' => null ) );
		$title = strip_tags( $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];
		$orderby = strip_tags( $instance['orderby'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of Testimonials: </label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Order By</label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
			<option value="none" <?php selected( $orderby, 'none' ); ?>>None</option>
			<option value="date" <?php selected( $orderby, 'date' ); ?>>Date</option>
			<option value="rand" <?php selected( $orderby, 'rand' ); ?>>Random</option>
		</select></p>

		<?php
	}
}

add_action( 'widgets_init', 'register_testimonials_widget' );

/*
*The code below registers our widget.
*This functions is attached to the 'widgets_init' action hook.
*/
function register_testimonials_widget() {
	register_widget( 'testimonials_widget' );
}