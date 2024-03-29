<?php

/**
 * @package StarterKit
 */

namespace Inc\Starterkit\Base;

 class Activate {
  public static function activate() {
    flush_rewrite_rules();

    $default = [];

    if ( !get_option('starterkit')) {
      update_option('starterkit', $default);
    }

    if ( !get_option('starterkit_cpt')) {
      update_option('starterkit_cpt', $default);
    }

    if ( !get_option('starterkit_taxonomy')) {
      update_option('starterkit_taxonomy', $default);
    }


  }
 }