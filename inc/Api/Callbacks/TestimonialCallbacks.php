<?php

/**
 * @package Starterkit
 */

 namespace Inc\Starterkit\Api\Callbacks;

 use Inc\Starterkit\Base\BaseController;

 class TestimonialCallbacks extends BaseController
 {
  public function shortcodePage() {
    return require_once( "$this->plugin_path/templates/adminTestimonial.php" );
  }
 }