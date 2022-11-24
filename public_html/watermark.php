<?php
	$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('uploads'));
	$files = array();
	
	foreach ($rii as $file) {
		$info = new SplFileInfo($file);
      	$info_ext = $info->getExtension();
      	$file_name = $info->getFilename();
      	$file_basename = $info->getBasename();
		if ($file->isDir() || $info_ext != 'jpg'){
			continue;
		}
      	
	
	echo '<pre>';
	var_dump($file_basename);
	echo '</pre>';
      
		$files[] = $file->getPathname();
	}