<?php
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Starterkit\Api\Callbacks;

class TaxonomyCallbacks
{
  public function taxonomySectionManager(){
    echo "Create as many Custom taxonomies as you want";
  }

  public function taxonomySanitize( $input ){

      $output = get_option('starterkit_taxonomy');

      if ( isset($_POST["remove"]) ) {
        unset($output[$_POST["remove"]]);

        return $output;
      }

      if ( count($output) == 0 ){
        $output[$input['taxonomy']] = $input;
        return $output;
      }
      foreach ($output as $key => $value) {
        if ($input['taxonomy'] === $key) {
          $output[$key] = $input;
        } else {
          $output[$input['taxonomy']] = $input;
        }
      }

      return $output;

  }

  public function textField( $args ){
    //return the input
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $value = '';
    if ( isset($_POST['edit_taxonomy'])) {
      $input = get_option( $option_name );
      $value = $input[$_POST['edit_taxonomy']][$name];
    }
    //$value = $input[$name];
    echo '<input
            type="text"
            class="regular-text"
            id="' . $name . '"
            name="' . $option_name . '[' . $name . ']"
            value="'.$value.'"
            placeholder="' . $args['placeholder'] .'"
            required>
            ';
  }
  public function checkboxField($args){
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $checked = false;
    if ( isset($_POST['edit_taxonomy'])) {
      $checkbox = get_option( $option_name );
      $checked = isset($checkbox[$_POST['edit_taxonomy']][$name]) ?: false ;
    }
    echo "<div class='".$classes."'>
          <input
            class=''
            type='checkbox'
            id='" . $name . "'
            name='" . $option_name . "[" . $name . "]'
            value='1'
            ". ($checked ? 'checked' : '').">
              <label for='".$name."'><div></div></label>
          </div>";
  }

  function checkboxPostTypesField( $args ) {
    $name = $args['label_for'];
    $classes = $args['class'];
    $option_name = $args['option_name'];
    $checked = false;
    $output = '';

    if ( isset($_POST['edit_taxonomy'])) {
      $checkbox = get_option( $option_name );
    }

    $post_types = get_post_types(['show_ui' => true]);

    foreach ($post_types as $post) {
      if ( isset($_POST["edit_taxonomy"]) ) {
        $checked = isset($checkbox[$_POST["edit_taxonomy"]][$name][$post]) ?: false;
      }
      $output .= '
        <div class="' . $classes . ' mb-10">
          <input
            type="checkbox"
            id="' . $post . '"
            name="' . $option_name . '[' . $name . '][' . $post . ']"
            value="1"
            class="" '
            . ( $checked ? 'checked' : '') . '>
              <label for="' . $post . '">
                <div></div>
              </label>
            <strong>' . $post . '</strong>
          </div>';
    }
    echo $output;
  }

}