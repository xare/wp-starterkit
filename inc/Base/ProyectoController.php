<?php
namespace Inc\Starterkit\Base;

use Inc\Starterkit\Base\BaseController;
use Inc\Starterkit\Api\SettingsApi;
use Inc\Starterkit\Api\Callbacks\TestimonialCallbacks;

class ProyectoController extends BaseController
{

	public $settings;
	public $callbacks;

  public function register()
  {
    if( !$this->activated('testimonial_manager')) return;

		$this->settings = new SettingsApi();
		$this->callbacks = new TestimonialCallbacks();

    add_action( 'init', [ $this, 'proyecto_cpt' ]);
    add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
    add_action( 'save_post', array( $this, 'save_meta_box' ) );

		add_action( 'manage_proyecto_posts_columns', [$this, 'set_custom_columns'] );
		add_action( 'manage_proyecto_posts_custom_column', [$this, 'set_custom_columns_data'], 10, 2 );

		add_filter( 'manage_edit-proyecto_sortable_columns', [ $this, 'set_custom_columns_sortable']);

		$this->setShortcodePage();

		add_shortcode( 'proyecto-form', [$this, 'proyecto_form'] );
		add_shortcode( 'proyecto-slideshow', [$this, 'proyecto_slideshow'] );
		add_action( 'wp_ajax_submit_proyecto', [ $this, 'submit_proyecto'] );
		add_action( 'wp_ajax_nopriv_submit_proyecto', [ $this, 'submit_proyecto'] );
  }

	
	public function submit_proyecto(){
		if(! DOING_AJAX || ! check_ajax_referer('testimonial-nonce', 'nonce')) {
			return $this->return_json('error');
		}

		//sanitize the data
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

		//store the data into testimonial cpt
		$data = [
			'name' => $name,
			'email' => $email,
			'approved' => 0,
			'featured' => 0
		];

		$args = [
			'post_title' => 'Proyecto from'. $name,
			'post_content' => $message,
			'post_author' => 1,
			'post_status' => 'publish',
			'post_type' => 'proyecto',
			'meta_input' =>[
				'_starterkit_proyecto_key' => $data
			]
		];

		$postID = wp_insert_post($args);
		
		if ($postID) {
			return $this->return_json('success');
		}
		return $this->return_json('error');
	}

	public function return_json($status) {
		wp_send_json(['status'=> $status]);
		wp_die();
	}

	public function proyecto_form()
	{
		ob_start();
		echo '<link 
						type="text/css" 
						href="'.$this->plugin_url.'dist/css/form.min.css" 
						media="all" 
						rel="stylesheet" />';
		require_once($this->plugin_path."templates/contact-form.php");
		echo '<script src="'.$this->plugin_url.'dist/js/form.min.js"></script>';
		return ob_get_clean();
	}
	public function proyecto_slideshow()
	{
		ob_start();
		echo '<link 
						type="text/css" 
						href="'.$this->plugin_url.'dist/css/slider.min.css" 
						media="all" 
						rel="stylesheet" />';
		require_once($this->plugin_templates_path."/slider.php");
		echo '<script src="'.$this->plugin_url.'dist/js/slider.min.js"></script>';
		return ob_get_clean();
	}
	public function setShortcodePage()
	{
		$subpage = [
			[
				'parent_slug' => 'edit.php?post_type=proyectos',
				'page_title' => 'Shortcodes',
				'menu_title' => 'Shortcodes',
				'capability' => 'manage_options',
				'menu_slug' => 'starterkit_proyecto_shortcode',
				'callback' => [$this->callbacks, 'shortcodePage']
			]
		];
		$this->settings->addSubPages( $subpage )->register();
	}

  public function proyecto_cpt(){
    $labels = [
			'name' => 'Proyectos',
			'singular_name' => 'Proyecto'
    ];

    $args = [
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-welcome-widgets-menus',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' =>  [ 'title', 'editor' ],
			'show_in_rest' => true
    ];

		register_post_type ( 'proyecto', $args );
  }

  public function add_meta_boxes(){
    add_meta_box(
      'proyecto_propiedades',
			'Propiedades Proyecto',
			[ $this, 'render_features_box' ],
			'proyecto',
			'normal',
			'high'
    );
    // author email
    // approved
    //featured

  }

  public function render_features_box($post)
	{
		wp_nonce_field( 'starterkit_proyecto', 'starterkit_proyecto_nonce' );

    $data = get_post_meta( $post->ID, '_starterkit_proyecto_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
		$url = isset($data['url']) ? $data['url'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<table>
			<tr>
				<td>
					<label for="starterkit_proyecto_name">Proyecto Nombre</label>
				</td>
				<td>
					<input
					type="text"
					id="starterkit_proyecto_name"
					name="starterkit_proyecto_name"
					value="<?php echo esc_attr( $name ); ?>">
				</td>
				<td>
					<label for="starterkit_proyecto_email">Email</label>
				</td>
				<td>
					<input
					type="text"
					id="starterkit_proyecto_email"
					name="starterkit_proyecto_email"
					value="<?php echo esc_attr( $email ); ?>">
				</td>
			</tr>
			<tr>
			<td>
					<label for="starterkit_proyecto_url">Sitio web</label>
				</td>
				<td>
					<input
					type="text"
					id="starterkit_proyecto_url"
					name="starterkit_proyecto_url"
					value="<?php echo esc_attr( $url ); ?>">
				</td>
			</tr>

		</table>
    <div class="meta-container">
			<label class="meta-label w-50 text-left" for="starterkit_proyecto_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div
          class="ui-toggle inline">
            <input
              type="checkbox"
              id="starterkit_proyecto_approved"
							name="starterkit_proyecto_approved"
              value="1"
              <?php echo $approved ? 'checked' : ''; ?>>
					<label for="starterkit_proyecto_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="starterkit_proyecto_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline">
          <input
            type="checkbox"
            id="starterkit_proyecto_featured"
						name="starterkit_proyecto_featured"
            value="1"
            <?php echo $featured ? 'checked' : ''; ?>>
					<label for="starterkit_proyecto_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php
	}

  public function render_author_email_box($post){
    wp_nonce_field( 'starterkit_proyecto_author_email', 'starterkit_proyecto_author_email_nonce' );

		$value = get_post_meta( $post->ID, '_starterkit_proyecto_author_email_key', true );
		?>
		<label for="starterkit_proyecto_email_author">Proyecto Author</label>
		<input
      type="text"
      id="starterkit_proyecto_email_author"
      name="starterkit_proyecto_email_author"
      value="<?php echo esc_attr( $value ); ?>">
		<?php
  }

  public function save_meta_box($post_id) {
    if (! isset($_POST['starterkit_proyecto_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['starterkit_proyecto_nonce'];
		if (! wp_verify_nonce( $nonce, 'starterkit_proyecto' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = [
			'name' => sanitize_text_field( $_POST['starterkit_proyecto_author'] ),
			'email' => sanitize_text_field( $_POST['starterkit_proyecto_email'] ),
			'url' => sanitize_text_field( $_POST['starterkit_proyecto_url'] ),
			'approved' => isset($_POST['starterkit_proyecto_approved']) ? 1 : 0,
			'featured' => isset($_POST['starterkit_proyecto_featured']) ? 1 : 0,
    ];
		update_post_meta( $post_id, '_starterkit_proyecto_key', $data );
  }

	public function set_custom_columns( $columns )
	{
		$title = $columns['title'];
		$date = $columns['date'];

		unset ( $columns['title'], $columns['date'] );

		$columns['name'] = 'Nombre del proyecto';
		$columns['title'] = $title;
		$columms['approved'] = 'Approved';
		$columms['featured'] = 'Featured';
		$columns['date'] = $date;

		return $columns;
	}

	public function set_custom_columns_data( $column, $post_id )
	{
		$data = get_post_meta( $post_id, '_starterkit_proyecto_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
		$url = isset($data['url']) ? $data['url'] : '';
		$approved = isset($data['approved']) && $data['approved'] === 1 ? '<strong>YES</strong>' : 'NO';
		$featured = isset($data['featured']) && $data['featured'] === 1 ? '<strong>YES</strong>' : 'NO';

		switch ($column) {
			case 'name':
				echo '<a href="'. $url .'><strong>' . $name . '</strong></a><br /><a href="mailto:'. $email .'>' . $email . '</a>';
			break;
			case 'approved':
				echo $approved;
			break;
			case 'featured':
				echo $featured;
			break;
		}



	}

	public function set_custom_columns_sortable( $columns ) {
		$columns['name'] = 'name';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';
		return $columns;
	}

}