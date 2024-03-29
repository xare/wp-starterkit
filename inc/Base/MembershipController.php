<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Api\SettingsApi;
use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\Callbacks\AdminCallbacks;

class MembershipController extends BaseController
{
  public $callbacks;
  public $subpages = [];

  public function register()
  {
    if( !$this->activated('membership_manager')) return;

    $this->settings = new SettingsApi();

    $this->setSubpages();
    $this->callbacks = new AdminCallbacks();
    $this->settings->addSubPages($this->subpages)->register();
  }

  public function setSubpages(){
		$this->subpages = [
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Membership',
				'menu_title' => 'Membership',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_membership',
				'callback' => [$this->callbacks, 'adminMembership'] ,
			]
		];
	}
}