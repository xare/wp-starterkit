<?php
/**
 * @package starterkit
 */

 namespace Inc\Starterkit\Api\Callbacks;

use Inc\Starterkit\Base\BaseController;

 class AdminCallbacks extends BaseController {

  public function adminDashboard() {
    return require_once("$this->plugin_templates_path/adminDashboard.php");
  }
  public function adminCustomPostType() {
    return require_once("$this->plugin_templates_path/adminCustomPostType.php");
  }
  public function adminWidgets(){
    return require_once("$this->plugin_templates_path/adminWidget.php");
  }
  public function adminTaxonomy(){
    return require_once("$this->plugin_templates_path/adminTaxonomy.php");
  }
  public function adminGallery(){
    return require_once("$this->plugin_templates_path/adminGallery.php");
  }
  public function adminTestimonial(){
    return require_once("$this->plugin_templates_path/adminTestimonial.php");
  }
  public function adminTemplates(){
    return require_once("$this->plugin_templates_path/adminTemplates.php");
  }
  public function adminAuth(){
    return require_once("$this->plugin_templates_path/adminAuth.php");
  }
  public function adminMembership(){
    return require_once("$this->plugin_templates_path/adminMembership.php");
  }
  public function adminChat(){
    return require_once("$this->plugin_templates_path/adminChat.php");
  }

  public function starterkitOptionsGroup($input) {
    return $input;
  }

  public function starkerkitAdminSection() {
    echo "visit this section";
  }
  public function starkerkitTextExample() {
    $value = esc_attr(get_option( 'text_example' ));
    echo '<input
      type="text"
      class="regular-text"
      name="text-example"
      value="'.$value.'"
      placeholder="Text Example">';
  }
  public function starkerkitFirstName() {
    $value = esc_attr(get_option( 'first_name' ));
    echo '<input
            type="text"
            class="regular-text"
            name="first-name"
            value="'.$value.'"
            placeholder="First Name">';
  }
 }