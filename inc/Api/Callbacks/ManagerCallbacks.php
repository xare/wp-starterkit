<?php
/**
 * @package starterkit
 */

 namespace Inc\Starterkit\Api\Callbacks;

use Inc\Starterkit\Base\BaseController;

 class ManagerCallbacks extends BaseController
 {

  public function checkboxSanitize( $input ) {

    $output = [];
    foreach ( $this->managers as $key => $value ){
      $output[$key] = isset( $input[$key] ) ? true : false;
    }
    return $output;
  }

  public function adminSectionManager() {
    echo 'manage the Sections and Features of this plugin by activating the checkboxes in the list below';
  }

  public function checkboxField( $args )
  {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $checkbox = get_option( $option_name );
    $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false ) : false;
    echo "<div class='".$classes."'>
          <input
            class=''
            type='checkbox'
            id='" . $name . "'
            name='" . $option_name . "[" . $name . "]'
            value='1'".
            ($checked ? " checked" : "") . ">
              <label for='".$name."'><div></div></label>
          </div>";
  }
}