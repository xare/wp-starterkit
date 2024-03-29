<?php

namespace Inc\Starterkit\Api\Widgets;

use WP_Widget;

class MediaWidget extends WP_Widget
{

  public $widget_id;
  public $widget_name;
  public $widget_options = [];
  public $control_options = [];

  public function __construct( ) {
    $this->widget_id = 'starkerkit_media_widget';
    $this->widget_name = 'Starkerkit media widget';
    $this->widget_options = [
      'classname' => $this->widget_id,
      'description' => $this->widget_name,
      'customize_selective_refresh' => true
    ];
    $this->control_options = [
      'width' => 400,
      'height' => 350
    ];
  }

  public function register() {
     parent::__construct($this->widget_id, $this->widget_name, $this->widget_options, $this->control_options);

     add_action('widgets_init', [$this, 'widgetInit']);
  }

  public function widgetInit() {
    register_widget($this);
  }

  //widget()

  public function widget( $args, $instance) {
    echo $args['before_widget'];
    if ( ! empty($instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title']). $args['after_title'];
    }
    if ( ! empty( $instance['image'] ) ) {
			echo '<img src="'. esc_url( $instance['image'] ) .'" alt="">';
		}
    echo $args['after_widget'];
  }

  //form()

  public function form($instance) {
    $title = ! empty( $instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'starterkit');
    $image = ! empty( $instance['image'] ) ? $instance['image'] : '';
    ?>
    <p>
      <label
      for="<?php esc_attr($this->get_field_id('title')); ?>">
        <?php esc_attr_e( 'Title:', 'starterkit' ); ?>
      </label>
       <input
        class="widefat"
        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
        value="<?php echo esc_attr( $title ); ?>">
    <?php esc_attr($this->get_field_id('title')); ?></p>
    <p>
    <label
      for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
      <?php esc_attr_e( 'Image:', 'starterkit' ); ?>
    </label>
    <input
      class="widefat image-upload"
      id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"
      name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text"
      value="<?php echo esc_url( $image ); ?>">
      <br />
			<button
        type="button"
        class="button button-primary js-image-upload">
        <?php esc_attr_e( 'Select Image', 'starterkit' ); ?>
      </button>
    </p>
    <?php
  }
  //update()

  public function update( $new_instance, $old_instance )
  {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field($new_instance['title']);
    $instance['image'] = !empty( $new_instance['image'] ) ? $new_instance['image'] : '';

    return $instance;
  }
}