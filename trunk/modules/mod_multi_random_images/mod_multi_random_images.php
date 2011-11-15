<?php  

// Multiple Random Images Module v1.0 //
/**
* @ packaged for Joomla 1.0.12
* @ Copyright (C) 2008 Auburn Tech [www.auburntech.com]
* @ All rights reserved
* @ Multi Random Image Module is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @ version 1.0
**/

// Code leveraged from and inspired by:
// Joomla Random Image Module - stingrey
// http://photomatt.net/scripts/randomimage/
// http://www.desilva.biz/arrays/in_array.html

// no direct access
defined('_VALID_MOS') or die('Restricted access');

global $mosConfig_absolute_path, $mosConfig_live_site;

// User Defined Parameters
$folder = 		$params->get('folder');
$count 	= 		$params->get('count');
$exts 	= 		$params->get('exts');
$orientation = 	$params->get('orientation');
$div_class = 	$params->get('div_class');
$img_class = 	$params->get('img_class');
$img_margin = 	$params->get('img_margin');
$img_width = 	$params->get('img_width');
$img_height = 	$params->get('img_height');

$files = array(); 

if (!$folder) $folder = $mosConfig_live_site.'/images/stories';

// if folder includes livesite info, remove
if (strpos($folder, $mosConfig_live_site) === 0) {
	$folder = str_replace($mosConfig_live_site, '', $folder);
}
// if folder includes absolute path, remove
if (strpos($folder, $mosConfig_absolute_path) === 0) {
	$folder= str_replace($mosConfig_absolute_path, '', $folder);
}
// if folder doesnt contain slash to start, add
if (strpos($folder, '/') !== 0) {	
	$folder = '/'.$folder;
}
// construct absolute path to directory
$abspath_folder = $mosConfig_absolute_path.$folder;

// Scan folder for images
$handle = opendir($abspath_folder);
$exts = explode(',', $exts);
while (($file = readdir($handle)) !== false) {
	foreach($exts as $ext) { 
		if (preg_match('/\.'.$ext.'$/i', $file, $test)) { 
			$files[] = $file; 
		}
	}
}
closedir($handle); 

// Shuffle for extra randomness - probably not needed
shuffle($files); 

// get x number of files
for($i=0; $i<$count; $i++) {
	// generate random key
	$r = mt_rand(0, count($files)-1);
	// create variable to hold multi image set
	if(isset($imgset)) {
		if(in_array($files["$r"], $imgset)) {
			--$i;
		}
		else {
			$imgset[] = $files["$r"];
		}
	}
	else {
		$imgset[] = $files["$r"];
	}
}

$image = $mosConfig_live_site.$folder.'/'.$image_name;

if ($div_class) {$div_class = ' class="'.$div_class.'"';}
else {$div_class = '';}

if ($img_class) {$img_class = ' class="'.$img_class.'"';}
else {$img_class = '';}

if ($img_margin) {$img_margin = ' style="margin:'.$img_margin.'"';}
else {$img_class = '';}

if ($img_width) {$img_width = ' width="'.$img_width.'"';}
else {$img_width = '';}

if ($img_height) {$img_height = ' height="'.$img_height.'"';}
else {$img_height = '';}

//process each image in set
foreach ($imgset as $img) {
	if ($orientation=="vert"){ 
		echo '<div'.$div_class.'><img'.$img_class.$img_margin.' src="'.$mosConfig_live_site.$folder.'/'.$img.'"'.$img_width.' alt="Random Image" /></div>';
	}
	else {
		echo '<div'.$div_class.'><img'.$img_class.$img_margin.' src="'.$mosConfig_live_site.$folder.'/'.$img.'"'.$img_height.' alt="Random Image" /></div>';
	}
}

?>