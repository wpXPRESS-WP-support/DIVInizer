<?php
/**
 * DIVInize Recent Posts Widget
 * adds a recent posts with thubmnails widget
 *
 * @package  DIVInize/DivinizeRecentPostsWidget
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeRecentPostsWidget extends WP_Widget {

	/**
	 * Sets up the widgets name and description
	 */
	function __construct() {
		$args = array(
			'name' => esc_html__( 'Divinize Recent Posts', 'divinize' ),
			'description' => esc_html__( 'Display recent posts with featured images.', 'divinize' )
		);
		parent::__construct( 'divinize_recent_posts_widget', '', $args );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		! empty( $instance['title'] ) ? $the_title = $instance['title'] : $the_title = esc_html__( 'Recent Posts', 'divinize' );

		$query = new WP_Query(
			$query_args = [
				'post_type'      => $instance['post_type'],
				'posts_per_page' => $instance['number'],
				'post_status' => 'publish',
				'orderby'        => 'ID',
				'order'        => 'DESC'
			]
		);

		echo $args['before_widget'];
			echo $args['before_title'] . $the_title . $args['after_title'];
			if ( $query->have_posts() ) :
				echo '<div class="divinize_recent_posts_wrap">';
				while ( $query->have_posts() ) : $query->the_post();
					echo '<div class="divinize_recent_post">';
						echo '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail() . '</a>';
						echo '<div class="divinize_recent_content"><h5><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5></div>';
					echo '</div>';
				endwhile;
				echo '</div>';
				else:
				echo '<p class="divinize_no_recent_posts">';
				esc_html_e( 'No posts!', 'divinize' );
				echo '</p>';
			endif;
			wp_reset_postdata();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'divinize' );
		$number = ! empty( $instance['number'] ) ? $instance['number'] : 5;
		$post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : 'Post';
		$args = array(
		    'public'              => true,
		    'exclude_from_search' => false,
		    '_builtin'            => false
		);
		$post_types = get_post_types( $args ); 

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'divinize' ); ?></label>
			<input  type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of Posts:', 'divinize' ); ?></label>
			<input  type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $number ); ?>" min="1">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_attr_e( 'Post Type:', 'divinize' ); ?></label>
			<select  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
				<option>Post</option>
				<?php 
				foreach ( $post_types as $the_post_type ) {
					echo "<option value='" . $the_post_type ."' " . selected( $post_type, $the_post_type, false ) . ">";
					echo $the_post_type;
					echo "</option>";
				 } ?>
			</select>
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

	    $instance['title'] = $new_instance['title'];
	    $instance['post_type'] = $new_instance['post_type'];
	    $instance['number'] = $new_instance['number'];

		return $instance;
	}

}

add_action( 'widgets_init', function(){
	register_widget( 'DivinizeRecentPostsWidget' );
});