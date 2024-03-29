<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\Widgets\MediaWidget;

class WidgetController extends BaseController
{
  public $callbacks;
  public $subpages = [];

  public function register()
  {
    if( !$this->activated('media_widget')) return;

    $media_widget = new MediaWidget();
    $media_widget->register();

  }
}