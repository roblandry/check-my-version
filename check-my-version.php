<?php
/*
Plugin Name: Check My Version
Plugin URI: http://www.landryonline.com/
Description: A plugin to check that my themes/plugins are the latest versions.
Version: 1.0
Author: Rob Landry
Author URI: http://www.landryonline.com
License: GPL
*/

/* Includes */
require_once(dirname(__FILE__).'/inc.php');
require_once(dirname(__FILE__).'/check-theme.php');
require_once(dirname(__FILE__).'/check-plugin.php');

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'check_my_version_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'check_my_version_remove' );

function check_my_version_install() {
  /* Creates new database field */
  add_option("check_my_version_theme", 'Bigrob8181', '', 'yes');
  add_option("check_my_version_plugin", 'Rob Landry', '', 'yes');
}

function check_my_version_remove() {
  /* Deletes the database field */
  delete_option('check_my_version_theme');
  delete_option('check_my_version_plugin');
}

if ( is_admin() ) {
  /* Call the html code */
  add_action('admin_menu', 'check_my_version_admin_menu');

  function check_my_version_admin_menu() {
    add_options_page('Check My Version Options', 'Check My Version', 'administrator',
'check_my_version', 'check_my_version_html_page');
  }
}

/* Make sure file included */
//if (!function_exists('get_themes'))
//	require_once (ABSPATH."wp-admin/includes/theme.php");

function show_on_home() {
get_theme_versions(get_theme_names());
get_plugin_version(get_option('check_my_version_plugin'));
}

/* The Options Page */
function check_my_version_html_page() { ?>
  <div>
    <h2>Check My Version Options</h2>
    <form method="post" action="options.php">
      <?php wp_nonce_field('update-options'); ?>
      <table width="550" border='1'>
        <tr valign="middle">
          <th width="150" scope="row">Theme Author</th>
          <td width="400">
            <input name="check_my_version_theme" type="text" 
            id="check_my_version_theme" value="<?php echo get_option('check_my_version_theme'); ?>" />
          </td>
        </tr>
        <tr><td width="550" colspan='2'>
          <?php get_theme_versions(get_theme_names()); ?>
          </td></tr>
        <tr valign="middle">
          <th width="150" scope="row">Plugin Author</th>
          <td width="400">
            <input name="check_my_version_plugin" type="text" 
            id="check_my_version_plugin" value="<?php echo get_option('check_my_version_plugin'); ?>" />
          </td>
        </tr>
        <tr><td width="550" colspan='2'>
          <?php get_plugin_version(get_option('check_my_version_plugin')); ?>
          </td></tr>
      </table>
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="check_my_version_theme,check_my_version_plugin" />
      <!--input type="hidden" name="page_options" value="check_my_version_plugin" /-->
      <p><input type="submit" value="<?php _e('Save Changes') ?>" /></p>
    </form>
  </div> <?php 
}

if ((current_user_can('administrator')) && (!is_admin())) {
  add_action('init', 'show_on_home');
}
?>
