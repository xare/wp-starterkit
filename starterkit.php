<?php
    /*
    Plugin Name: Starter Kit for WP plugin
    Description: A simple Starter Kit plugin for WordPress
    Version: 1.0
    Author: xare
    */

defined( 'ABSPATH' ) or die ( 'Acceso prohibido');

// Require once the Composer Autoload
if( file_exists( dirname( __FILE__).'/vendor/autoload.php' ) ){
  require_once dirname( __FILE__).'/vendor/autoload.php';
}

/**
 * The code that runs during plugin Activation
 *
 * @return void
 */
function activate_starterkit(){
  Inc\Starterkit\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_starterkit');

/**
 * The code that runs during plugin Deactivation
 *
 * @return void
 */
function deactivate_starterkit(){
  Inc\Starterkit\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_starterkit');

if(class_exists( 'Inc\\Starterkit\\Init' )) {
  Inc\Starterkit\Init::register_services();
}