<?php

namespace Inc\Starterkit;

final class Init
{
  /**
   * Store all the classes inside an array
   *
   * @return array Full list of classes
   */
  public static function get_services():Array {
    return [
      Pages\Dashboard::class,
      Base\Enqueue::class,
      Base\SettingsLinks::class,
      Base\CustomPostTypeController::class,
      Base\CustomTaxonomyController::class,
      Base\WidgetController::class,
			Base\GalleryController::class,
			Base\TestimonialController::class,
      Base\ProyectoController::class,
			Base\TemplateController::class,
			Base\AuthController::class,
			Base\MembershipController::class,
			Base\ChatController::class,
    ];
  }

  /**
   * Loop through the classes, initialize them
   * and call the register() method if it exists
   *
   * @return void
   */
  public static function register_services() {
    foreach(self::get_services() as $class){
      $service = self::instantiate( $class );
      if(method_exists($service,'register')) {
          $service->register();
      }
    }
  }
  /**
   * Initialize the class
   *
   * @param [type] $class class from the services array
   * @return class instance new instance of the class
   */
  private static function instantiate( $class ) {
    return new $class();
  }
}
