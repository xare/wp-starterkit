<div class="wrap">
<?php settings_errors(); ?>
<h1>Starter kit for WP plugin development CPT</h1>

<ul class="nav nav-tabs">
    <li class="<?php echo !isset( $_POST['edit_post']) ? 'active' : '' ?>">
      <a href="#tab-1">Your Custom Post Types</a>
    </li>
    <li class="<?php echo isset( $_POST['edit_post']) ? 'active' : '' ?>">
      <a href="#tab-2"><?php isset( $_POST['edit_post']) ? 'Edit' : 'Add' ?> Custom Post Type</a>
    </li>
    <li><a href="#tab-3">Export</a></li>
  </ul>
  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">
    <h3>Manage Custom Post Types</h3>
    <table class="cpt-table">
      <tr>
        <th>ID</th>
        <th>Singular Name</th>
        <th>Plural Name</th>
        <th>Public</th>
        <th>Archive</th>
        <th>Actions</th>
      </tr>
    <?php


    $options = get_option('starterkit_cpt') ?: [];

    foreach( $options as $option ){
      $public = isset($option['public']) ? "TRUE" : "FALSE";
      $has_archive = isset($option['has_archive']) ? "TRUE" : "FALSE";

      echo "<tr><td>{$option['post_type']}</td>
      <td>{$option['singular_name']}</td>
      <td>{$option['plural_name']}</td>
      <td>{$public}</td>
      <td>{$has_archive}</td>
      <td class=\"text-center\">";
      echo '<form method="post" action="" class="inline-block">';
      echo '<input type="hidden" name="edit_post" value="' . $option['post_type'] . '">';
      submit_button( 'Edit', 'primary small', 'submit', false );
      echo "</form>";

      echo '<form method="post" action="options.php" class="inline-block">';
      settings_fields('starterkit_cpt_settings');
      echo '<input type="hidden" name="remove" value="' . $option['post_type'] . '">';
      submit_button( 'Delete', 'delete small', 'submit', false, [
        'onclick'=> 'return confirm("Achtung you are about to delete a custom post type!")'
        ] );
      echo "</form></td></tr>";
    }
    ?>
    </table>
    </div>
   <div id="tab-2" class="tab-pane<?php echo isset( $_POST['edit_post']) ? ' active' : '' ?>">
    <h3>Create a new Custom Post Type </h3>
    <form method="post" action="options.php">
        <?php
          settings_fields('starterkit_cpt_settings');
          do_settings_sections( 'starterkit_cpt');
          submit_button();
        ?>
      </form>
   </div>
   <div id="tab-3" class="tab-pane">
    <h3>Export a new Custom Post Type </h3>
    <?php foreach( $options as $option ){ ?>
      <h3><?php echo $option['singular_name']; ?></h3>
    <pre class="prettyprint">

    <?php } ?>
    // Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( '<?php echo $option['singular_name']; ?>', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '<?php echo $option['singular_name']; ?>', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '<?php echo $option['plural_name']; ?>', 'text_domain' ),
		'name_admin_bar'        => __( '<?php echo $option['singular_name']; ?>', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Post Type', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => <?php isset($option['public']) ? "TRUE" : "FALSE"; ?>,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => <?php isset($option['has_archive']) ? "TRUE" : "FALSE"; ?>,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'post_type', $args );

}
add_action( 'init', 'custom_post_type', 0 );</pre>
   </div>
  </div>

</div>