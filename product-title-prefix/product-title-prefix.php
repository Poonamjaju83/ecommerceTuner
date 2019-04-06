<?php
/**
 * Plugin Name: Product Title Prefix
 * Plugin URI:  
 * Description: Add prefix to product title.
 * Version: 1 
 * Author: Poonam Jaju
 * Author URI: 
 * License:     GNU General Public License v2.0 or later
 * License URI:  
 */

function custom_plugin_product_title_prefix_register_settings() {
   add_option( 'custom_plugin_option_name', 'Product Page Prefix');
   register_setting( 'custom_plugin_options_group', 'custom_plugin_product_prefix', 'custom_plugin_callback' );
}
add_action( 'admin_init', 'custom_plugin_product_title_prefix_register_settings' );

function custom_plugin_register_options_page() {
  add_options_page('Page Title', 'Plugin Product Prefix', 'manage_options', 'custom_plugin_product_title_prefix', 'custom_plugin_options_page');
}
add_action('admin_menu', 'custom_plugin_register_options_page');

 
function custom_plugin_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'custom_plugin_options_group' ); ?>
  
  <table>
  <tr valign="top">
  <th scope="row"><label for="custom_plugin_product_prefix">Product titles prefix</label></th>
  <td><input type="text" id="custom_plugin_product_prefix" name="custom_plugin_product_prefix" value="<?php echo get_option('custom_plugin_product_prefix'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
} 
  
 

 ?>