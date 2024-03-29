<div class="wrap">
<?php settings_errors(); ?>
<h1>Taxonomy Manager</h1>

<ul class="nav nav-tabs">
    <li class="<?php echo !isset( $_POST['edit_taxonomy']) ? 'active' : '' ?>">
      <a href="#tab-1">Your Taxonomies</a>
    </li>
    <li class="<?php echo isset( $_POST['edit_taxonomy']) ? 'active' : '' ?>">
      <a href="#tab-2"><?php isset( $_POST['edit_taxonomy']) ? 'Edit' : 'Add' ?>
        Custom Taxonomy
      </a>
    </li>
    <li><a href="#tab-3">Export</a></li>
  </ul>
  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>">
    <h3>Manage Custom Taxonomies</h3>
    <table class="cpt-table">
      <tr>
        <th>ID</th>
        <th>Singular Name</th>
        <th>Hierarchical</th>
        <th>Actions</th>
      </tr>
    <?php

    $options = get_option('starterkit_taxonomy') ?: [];

    foreach( $options as $option ){
      $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";

      echo "<tr><td>{$option['taxonomy']}</td>
      <td>{$option['singular_name']}</td>
      <td>{$hierarchical}</td>
      <td class=\"text-center\">";
      echo '<form method="post" action="" class="inline-block">';
      echo '<input type="hidden" name="edit_taxonomy" value="' . $option['taxonomy'] . '">';
      submit_button( 'Edit', 'primary small', 'submit', false );
      echo "</form>";

      echo '<form method="post" action="options.php" class="inline-block">';
      settings_fields('starterkit_taxonomy_settings');
      echo '<input type="hidden" name="remove" value="' . $option['taxonomy'] . '">';
      submit_button( 'Delete', 'delete small', 'submit', false, [
        'onclick'=> 'return confirm("Are you sure you want to delete this Custom Taxonomy? The data associated with it will not be deleted.")'
        ] );
      echo "</form></td></tr>";
    }
    ?>
    </table>
    </div>
   <div id="tab-2" class="tab-pane<?php echo isset( $_POST['edit_taxonomy']) ? ' active' : '' ?>">
    <h3>Create a new Taxonomy </h3>
    <form method="post" action="options.php">
        <?php
          settings_fields('starterkit_taxonomy_settings');
          do_settings_sections( 'starterkit_taxonomy');
          submit_button();
        ?>
      </form>
   </div>
   <div id="tab-3" class="tab-pane">
    <h3>Export your taxonomies </h3>

   </div>
  </div>

</div>