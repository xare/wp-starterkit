<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\SettingsApi;
use Inc\Starterkit\Api\Callbacks\AdminCallbacks;

class ChatController extends BaseController
{
  public $settings;
  public $subpages = [];
  public $callbacks;
  public function register()
  {
    if( !$this->activated('chat_manager')) return;

    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->setSubpages();
    $this->settings->addSubPages($this->subpages)->register();

  }

  public function setSubpages(){
		$this->subpages = [
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Chat Manager',
				'menu_title' => 'Chat Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_chat',
				'callback' => [$this->callbacks, 'adminChat'] ,
			]
		];
	}
}