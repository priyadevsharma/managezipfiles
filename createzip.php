<?php

// Enter the name of directory
$pathdir = "./";

// Enter the name to creating zipped directory
$zipcreated = "archived.zip";

// Create new zip class
$zip = new ZipArchive;

if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
	
	// Store the path into the variable
	$dir = opendir($pathdir);
	
	while($file = readdir($dir)) {
		if(is_file($pathdir.$file)) {
			$zip -> addFile($pathdir.$file, $file);
		} elseif (is_dir($pathdir.$file) && ($file != '.') && ($file != '..')) {
			addFolderToZip($pathdir.$file.'/', $zip, $pathdir);
		}
	}
	$zip ->close();
	
	// Download the zip file
	header('Content-Type: application/zip');
	header('Content-disposition: attachment; filename=' . basename($zipcreated));
	header('Content-Length: ' . filesize($zipcreated));
	readfile($zipcreated);
	
	// Delete the zip file from the server
	unlink($zipcreated);
	
}

function addFolderToZip($folder, &$zip, $rootPath) {
	// Add empty directory
	$zip -> addEmptyDir(str_replace($rootPath, '', $folder));

	// Loop through all files and subdirectories in the folder
	$dir = opendir($folder);
	while($file = readdir($dir)) {
		if(($file != '.') && ($file != '..')) {
			if(is_file($folder.$file)) {
				$zip -> addFile($folder.$file, str_replace($rootPath, '', $folder.$file));
			} elseif(is_dir($folder.$file)) {
				addFolderToZip($folder.$file.'/', $zip, $rootPath);
			}
		}
	}
}


?>