<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Base\BaseController;

class AuthController extends BaseController
{

  public function register()
  {
    if( !$this->activated('auth_manager')) return;
    add_action( 'wp_enqueue_scripts',  [ $this, 'enqueue' ] );
		add_action( 'wp_head', [ $this, 'add_auth_template' ] );
		add_action( 'wp_ajax_nopriv_starterkit_login', [ $this, 'login' ] );
  }

  public function enqueue()
	{
		wp_enqueue_style( 'auth-style', $this->plugin_url . 'dist/css/auth.min.css' );
		wp_enqueue_script( 'auth-script', $this->plugin_url . 'dist/js/auth.min.js' );
	}

  public function add_auth_template()
	{
		if ( is_user_logged_in() ) return;

		$file = $this->plugin_templates_path . '/auth.php';

		if ( file_exists( $file ) ) {
			load_template( $file, true );
		}
	}
	public function login()
	{
		check_ajax_referer( 'ajax-login-nonce', 'starterkit_auth');

		$info = [
			'user_login' => $_POST['username'],
			'user_password' => $_POST['password'],
			'remember' => true
		];

		$user_signon = wp_signon( $info, true );

		if ( is_wp_error( $user_signon ) ) {
			echo json_encode(
				[
					'status' => false,
					'message' => 'Wrong username or password'
				]
			);

			die();
		}

		echo json_encode(
			[
				'status' => true,
				'message' => 'Login successful, redirecting...'
			]
		);

		die();
	}
}