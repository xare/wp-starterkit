<?php
/**
 * @package starterkit
 */

 namespace Inc\Starterkit\Base;

 class BaseController
 {
  public $plugin_path;
  public $plugin_url;
  public $plugin;
  public $plugin_templates_path;
  public array $managers;

  public function __construct() {
    $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2));
    $this->plugin_templates_path = plugin_dir_path( dirname( __FILE__, 2)).'/templates';
    $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2));
    $this->plugin = plugin_basename( dirname( __FILE__, 3) ) . '/starterkit.php';
    $this->managers = [
      'cpt_manager' => 'Activate CPT Manager',
      'taxonomy_manager' => 'Activate Taxonomy Manager',
      'media_widget' => 'Activate Media widget',
      'gallery_manager' => 'Activate Gallery Manager',
      'testimonial_manager' => 'Activate Testimonial Manager',
      'proyecto_manager' => 'Activate Proyecto Manager',
      'template_manager' => 'Activate Template Manager',
      'auth_manager' => 'Activate Login Manager',
      'chat_manager' => 'Activate Chat Manager'
    ];
  }

  public function activated(string $key)
  {
    $option = get_option('starterkit');
    return isset($option[$key]) ? $option[$key] : false;
  }


 }