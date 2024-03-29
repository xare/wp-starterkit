<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\SettingsApi;
use Inc\Starterkit\Api\Callbacks\AdminCallbacks;

class GalleryController extends BaseController
{

  public $subpages = [];
  public $AdminCallbacks;
  public $settings;

  public function register()
  {
    if( !$this->activated('gallery_manager')) return;

    $this->settings = new SettingsApi();
    $this->AdminCallbacks = new AdminCallbacks();
    $this->setSubpages();
    
    $this->settings->addSubPages($this->subpages)->register();
  }

  public function setSubpages(){
		$this->subpages = [
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Gallery',
				'menu_title' => 'Gallery',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_gallery',
				'callback' => [$this->AdminCallbacks, 'adminGallery'] ,
			]
		];
	}
}