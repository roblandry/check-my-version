<?php

function get_remote_version($name) {
  $checkfile = 'http://trac.landryonline.com/trac.fcgi/export/head/'. $name .'/trunk/check.chk';
  $status = array();
  $vcheck = wp_remote_fopen($checkfile);
  if ($vcheck) {
    $status = explode('@', $vcheck);
    return $status;
  }
}
  
function compare_versions($name,$local_version) {
  $status = get_remote_version($name);
  $theVersion = $status[1];
  $theMessage = $status[3];
  if ((version_compare(strval($theVersion), strval($local_version), '>') == 1)) {
    $msg = 'Update available for: '. $name .' <strong>' . $theVersion . '</strong>. ' . $theMessage;
    echo '<div class="plugin-update" style="text-align:center; background-color: #fff; background-color: rgba(255,255,255,0.8); color:red;">' . $msg . '</div>';
  } else {
    return;
  }
}
?>
