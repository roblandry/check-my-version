<?php

function get_theme_versions($theme_name) {
  for ($i = 0; $i < count($theme_name); $i++) {
    $theme_data = get_theme_data( get_theme_root() . '/' . $theme_name[$i] . '/style.css' );
    $local_version=$theme_data['Version'];
  $local_version='0.5';
    if (($theme_data['Author']==get_option('check_my_version_theme')) || (get_option('check_my_version_theme')== '')) {
      $var_sHtml .= "<li>{$theme_data['Title']} (v. {$theme_data['Version']} ) By {$theme_data['Author']}.</li>";
      compare_versions($theme_name[$i],$local_version);
    }
  }
  if (is_admin()) { echo $var_sHtml; }
  return $var_sHtml;
}

function get_theme_names() {
  $theme_path= get_theme_root();
  if ($handle = opendir($theme_path)) {
    $i=0;
    while (false !== ($entry = readdir($handle))) {
        if (($entry != "." && $entry != "..") && is_dir($theme_path.'/'.$entry)) {
            $theme_name[$i]=$entry;
	$i++;
        }
    }
    closedir($handle);
  }
  return($theme_name);
}
?>
