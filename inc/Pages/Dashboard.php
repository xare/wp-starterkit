<?php

namespace Inc\Starterkit\Pages;

use Inc\Starterkit\Api\SettingsApi;
use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\Callbacks\AdminCallbacks;
use Inc\Starterkit\Api\Callbacks\ManagerCallbacks;

/**
*
*/
class Dashboard extends BaseController
{

	public $settings;
	public $pages = [];
	//public $subpages = [];
	public $callbacks;
	public $callbacks_mngr;


	public function register() {
		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();
		$this->setPages();
		//$this->setSubpages();
		$this->setSettings();
		$this->setSections();
		$this->setFields();
		$this->settings
			->addPages( $this->pages )
			->withSubPage( 'Dashboard' )
			//->addSubPages( $this->subpages )
			->register();
	}

	public function setPages(){
		$this->pages = [
			[
				'page_title' => __('Starter kit','starterkit'),
				'menu_title' =>  __('Starter kit','starterkit'),
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit',
				'callback' => [$this->callbacks, 'adminDashboard'] ,
				'icon_url' => 'dashicons-store',
				'position' => 110
			]
		];
	}

	/* public function setSubpages(){
		$this->subpages = [
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Custom Post Types',
				'menu_title' => 'CPT',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_cpt',
				'callback' => [$this->callbacks, 'adminCPT'] ,
			],
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Custom Taxonomies',
				'menu_title' => 'Taxonomies',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_taxonomies',
				'callback' => [$this->callbacks, 'adminTaxonomy'] ,
			],
			[
				'parent_slug' => 'starterkit',
				'page_title' => 'Custom Widgets',
				'menu_title' => 'Widgets',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_widgets',
				'callback' => [$this->callbacks, 'adminWidgets'] ,
			]
		];
	} */

	public function setSettings()
	{
		$args = [
			[
				'option_group'=> 'starterkit_settings',
				'option_name' => 'starterkit',
				'callback' => [$this->callbacks_mngr, 'checkboxSanitize']
      ]
		];

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = [
			[
				'id'=> 'starterkit_admin_index',
				'title' => 'Settings Manager',
				'callback' => [$this->callbacks_mngr , 'adminSectionManager'],
				'page' => 'starterkit' //From menu_slug
				]
		];
		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = [];
		foreach($this->managers as $key => $value) {
		$args[] = [
						'id'=> $key,
						'title' => $value,
						'callback' => [$this->callbacks_mngr, 'checkboxField'],
						'page' => 'starterkit', //From menu_slug
						'section' => 'starterkit_admin_index',
						'args' => [
								'option_name' => 'starterkit',
								'label_for' => $key,
								'class' => 'ui-toggle'
							]
		];
		}
		$this->settings->setFields( $args );
	}

}