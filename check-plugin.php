<?php

function get_plugin_version($author) {
  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
  if ($author !== '') { $plugin_author=$author; } 
  else { $plugin_author='*'; }
  $plugins = get_plugins();
  $plugins_allowedtags1 = array(
    'a' => array('href' => array(),'title' => array()),
    'abbr' => array('title' => array()),
    'acronym' => array('title' => array()),
    'code' => array(),'em' => array(),'strong' => array());
  foreach($plugins as $plugin_file => $plugin_data) {
    $plugin_data['Title'] = wp_kses($plugin_data['Title'], $plugins_allowedtags1);
    $plugin_data['Title'] = ($plugin_data['PluginURI']) ? '<a href="' . $plugin_data['PluginURI'] . '">' . $plugin_data['Title'] . '</a>' : $plugin_data['Title'];
    $plugin_data['Version'] = wp_kses($plugin_data['Version'], $plugins_allowedtags1);
    $plugin_data['Author'] = wp_kses($plugin_data['Author'], $plugins_allowedtags1);
    $plugin_data['Author'] = (empty($plugin_data['Author'])) ? '' : ' <cite>' . sprintf(__('%s', 'wp-list-plugins'), ($plugin_data['AuthorURI']) ? '<a href="' . $plugin_data['AuthorURI'] . '">' . $plugin_data['Author'] . '</a>' : $plugin_data['Author']) . '.</cite>';
    $local_version=$plugin_data['Version'];
//  $local_version='0.5';
    if ( 
      (strpos($plugin_data['Author'], $plugin_author) ==true ) || 
      (strpos($plugin_data['Name'],'Rob')== true ) ||
      ($author== '')) {
        $var_sHtml .= "<li>{$plugin_data['Title']} (v. {$plugin_data['Version']} ) By {$plugin_data['Author']}.</li>";
        $p_arr=explode("/", $plugin_file);
        $p_file=$p_arr[0];
        compare_versions($p_file,$plugin_data['Version']);
    }
    $var_iPlugInNumber++;
  }
  if (is_admin()) { echo $var_sHtml; }
  return $var_sHtml;
}

?>
