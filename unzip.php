<?php

// Get Project path
define('_PATH', dirname(__FILE__));

// Zip file name
$filename = 'trothmatrix.zip';
$zip = new ZipArchive;
$res = $zip->open($filename);
if ($res === TRUE) {

  // Unzip path
  $path = _PATH;

  // Extract file
  $zip->extractTo($path);
  $zip->close();

  echo 'Unzip!';
} else {
  echo 'failed!';
}

?>