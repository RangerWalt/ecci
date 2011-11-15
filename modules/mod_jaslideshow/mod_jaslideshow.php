<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

$folder 			= 	$params->get( 'folder', 'images/stories/fruit' );

$mootools 			= 	$params->get('mootools',1);

$swidth 			= 	$params->get( 'swidth', 430 );

$sheight 			= 	$params->get( 'sheight', 200 );

$altimage 			= 	$params->get( 'altimage', 'JA Slideshow - http://www.joomlart.com' );

$orderby 			= 	$params->get( 'orderby', 0);

$sort 				= 	$params->get( 'sort', '1');

$setimagearray 		= 	$params->get( 'setimagearray', '');

$startwith 			= 	$params->get( 'startwith', 0);

$autoresize 		= 	$params->get( 'autoresize', 0);

$timedisplay 		= 	$params->get( 'timedisplay', 9000 );

$timeanimation 		= 	$params->get( 'timeanimation', 2000);

$animation 			= 	$params->get( 'animation', 'combo');

$ppercent 			= 	$params->get( 'ppercent', 10);

$zpercent 			= 	$params->get( 'zpercent', 10);

$effect 			= 	$params->get( 'effect', 'bounceOut');

$showCaption 		= 	$params->get( 'showCaption', 1 );

$showmode 			= 	$params->get( 'showmode', 0 );

$navigation 		= 	$params->get('navigation',"");

$showDescription 	= 	$params->get('showDescription',0);

$descriptions 		= 	$params->get('description',"");

$play		 		= 	$params->get('play',"1");


if($showDescription){
	global $iso_client_lang;
	$descriptionArr = preg_split('/<lang=([^>]*)>/', $descriptions , -1 , PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	$description = '';
	if(count($descriptionArr) > 1){
		for($i=0;$i<count($descriptionArr);$i=$i+2){
			if($descriptionArr[$i] == $iso_client_lang){
				$description = $descriptionArr[($i+1)];
				break;
			}
		}
		if(!$description){
			$description = $descriptionArr[1];
		}
	}
	else{
		$description = $descriptionArr[0];
	}

	$description = str_replace("<br />", "\n", $description);
 	$description = explode("\n",$description);

 	$descriptionArray = array();

	foreach($description as $desc){

		//~ $list = explode(":", $desc , 2);

		//~ $descriptionArray[$list[0]] = $list[1];

		if ($desc) {

			$list = split(":", $desc, 2);

			$list[1] = (count($list) > 1) ? split("&", $list[1]) : array();

			$temp = array();

			for ($i = 0; $i < count($list[1]); ++$i) {

				$l = split("=", $list[1][$i]);

				$temp[trim($l[0])] = trim($l[1]);

			}

			$descriptionArray[$list[0]] = $temp;

		}

	}

}


$folder = checkURL($folder);

if(!$folder){ echo "This folder doesn't exsits."; }

else{

	if (trim($setimagearray) != "")	$images = explode(",", $setimagearray);

	else $images = getFileInDir($folder, $orderby, $sort );



	if (count($images) > 0) {

		$imgcount = 0;

		$firstImage = '';

		$transDetails = '';

		$captionDetails = '';

		$imageArray = array();

		$captionArray = array();

		$listDescription = "";



		foreach($images as $img) {
			
			if ($imgcount++ == 0) {

				if ($startwith)

					$firstImage = $folder . $startwith;

				else

					$firstImage = $folder . $img;

			}

			$imageArray[] = "'$folder"."$img'";

			if($showDescription) {

				$captionsArray[] = (isset($descriptionArray[$img]) && isset($descriptionArray[$img]['caption'])) ? str_replace("'", "\'", $descriptionArray[$img]['caption']) :'';

				$urlsArray[] = (isset($descriptionArray[$img]) && isset($descriptionArray[$img]['url'])) ? $descriptionArray[$img]['url'] :'';

			}

		}
				

		if ($showDescription) {

		 	$listCaption = " captions: ['" . implode("','", $captionsArray) . "'],";

		 	$listURL = " urls: ['" . implode("','", $urlsArray) . "'],";

		}
		
		JHTML::_('behavior.mootools');			
		echo '<script src="'.JURI::base().'/modules/mod_jaslideshow/ja_slideshow/ja-slideshow.js" type="text/javascript"></script>' . "\n";
		
		if (trim($animation) == 'push' or trim($animation == 'wipe')) $transDetails = "transition: Fx.Transitions.$effect";

		else $transDetails = "transition: Fx.Transitions.sineInOut";

		$filename = JPATH_SITE.DS.'templates/'.$mainframe->getTemplate().'/css/ja-slideshow.css';
		$css_path = JURI::base().'templates/'.$mainframe->getTemplate().'/css/';
		if(!file_exists($filename)){
			$css_path = JURI::base().'modules/mod_jaslideshow/ja_slideshow/';
		}

		if ($autoresize && function_exists('imagecreatetruecolor')) {
			for ($i=0; $i<count($imageArray); $i++){
				if ($image1 = processImage ( $imageArray[$i], $swidth, $sheight )) {
					$imageArray[$i] = "'$image1'";
				}
			}			
		}

		if($autoresize && $image1 = processImage( $firstImage, $swidth, $sheight ) ) {
			$firstImage = $image1;
		}
		
		JHTML::stylesheet('ja-slideshow.css', $css_path);

			echo '<div id="ja-slideshowwrap">' . "\n";

				echo '<div id="ja-slideshow-case" class="ja-slideshow-case">' . "\n";

					echo '<img src="' . JURI::base().$firstImage . '" alt="' . $altimage . '" title="' .$altimage. '" />' . "\n";

				echo '</div>' . "\n";
				echo '<div class="ja-slideshow-mask">&nbsp;</div>';
				echo '<div id="ja-slidebar" class="ja-slidebar">' . "\n";
				echo '</div>' . "\n";
			echo '</div>' . "\n";
		?>

		<script type="text/javascript">

			JaSlideshow = new JaSlideshowClass({

					siteurl: '<?php echo JURI::base(); ?>',

					type: '<?php echo $animation; ?>',

					pan: '<?php echo $ppercent; ?>',

					zoom: '<?php echo $zpercent; ?>',

					width: <?php echo $swidth; ?>,

					height: <?php echo $sheight; ?>,

					url: '',

					images: [<?php echo implode(",", $imageArray); ?>],

					<?php if (isset($listCaption)) echo $listCaption; ?>

					<?php if (isset($listURL)) echo $listURL; ?>

					duration: [<?php echo $timeanimation*1000; ?>, <?php echo $timedisplay*1000; ?>],

					<?php echo $transDetails; ?> ,

					navigation: '<?php echo $navigation; ?>',

					classes: ['prev', 'next', 'active'],

					play : <?php echo "'$play'"; ?>,

					thumbnailre: [/\./, 't.']

					});

		</script>

		<?php
	}

}

function processImage ( &$img, $width, $height) {
	if(!$img) return;
	if (substr($img, 0, 4)!='http') {
		$img = $img;
	}
	$img = str_replace(JURI::base(),'',$img);
	$img = str_replace("'",'',$img);
	$img = rawurldecode($img);
	$imagesurl = (file_exists(JPATH_SITE .'/'.$img)) ? jaResize($img,$width,$height) :  '' ;
	return $imagesurl;
}

function jaResize($image,$max_width,$max_height){
			$path = JPATH_SITE;
			$sizeThumb = getimagesize(JPATH_SITE.'/'.$image);
			$width = $sizeThumb[0];
			$height = $sizeThumb[1];
			if(!$max_width && !$max_height) {
		        $max_width = $width;
		        $max_height = $height;
		    }else{
		        if(!$max_width) $max_width = 1000;
		        if(!$max_height) $max_height = 1000;
		    }
			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;
			if (($width <= $max_width) && ($height <= $max_height) ) {
				$tn_width = $width;
				$tn_height = $height;
			} else if (($x_ratio * $height) < $max_height) {
				$tn_height = ceil($x_ratio * $height);
				$tn_width = $max_width;
			} else {
				$tn_width = ceil($y_ratio * $width);
				$tn_height = $max_height;
			}
			// read image
			$ext = strtolower(substr(strrchr($image, '.'), 1)); // get the file extension
			$rzname = strtolower(substr($image, 0, strpos($image,'.')))."_{$tn_width}_{$tn_height}.{$ext}"; // get the file extension
			$resized = $path.'/images/resized/'.$rzname;
			if(file_exists($resized)){
				$smallImg = getimagesize($resized);
				if (($smallImg[0] <= $tn_width && $smallImg[1] == $tn_height) ||
					($smallImg[1] <= $tn_height && $smallImg[0] == $tn_width)) {
						return "images/resized/".$rzname;
				}
			}
			
			if(!file_exists($path.'/images/resized/') && !mkdir($path.'/images/resized/',0755)) return '';
			$folders = explode('/',$image);
			$tmppath = $path.'/images/resized/';
			for($i=0;$i < count($folders)-1; $i++){
				if(!file_exists($tmppath.$folders[$i]) && !mkdir($tmppath.$folders[$i],0755)) return '';
				$tmppath = $tmppath.$folders[$i].'/';
			}
			switch ($ext) {
				case 'jpg':     // jpg
					$src = imagecreatefromjpeg(JPATH_SITE.'/'.$image);
					break;
				case 'png':     // png
					$src = imagecreatefrompng(JPATH_SITE.'/'.$image);
					break;
				case 'gif':     // gif
					$src = imagecreatefromgif(JPATH_SITE.'/'.$image);
					break;
				default:
			}
			$dst = imagecreatetruecolor($tn_width,$tn_height);
			//imageantialias ($dst, true);
			if (function_exists('imageantialias')) imageantialias ($dst, true);
			imagecopyresampled ($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
			imagejpeg($dst, $resized, 90); // write the thumbnail to cache as well...
			
			return "images/resized/".$rzname;
}

function getFileInDir($folder, $orderby, $sort){


	$imagePath 	= JPATH_SITE ."/".$folder;

	$imgFiles 	= JFolder::files( $imagePath );

	$folderPath = $folder .'/';

	$imageFile = array();

	$i = 0;

	foreach ($imgFiles as $file){

		$i_f 	= $imagePath .'/'. $file;

		if ( eregi( "bmp|gif|jpg|png|jpeg", $file ) && is_file( $i_f ) ) {

			$imageFile[$i][0] = $file;

			$imageFile[$i][1] = filemtime($i_f)	;

			$i++;

		}

	}

	$images = sortImage($imageFile, $orderby , $sort);

	return $images;

}



function sortImage($image, $orderby , $sort){

	$sortObj = array();

	$imageName = array();

	if($orderby == 1){

		for($i=0;$i<count($image);$i++){

			$sortObj[$i] = $image[$i][1];

			$imageName[$i] = $image[$i][0];

		}

	}

	else{

		for($i=0;$i<count($image);$i++){

			$sortObj[$i] = $image[$i][0];

		}

		$imageName = $sortObj;

	}

	if($sort == 1) array_multisort($sortObj, SORT_ASC, $imageName);

	elseif($sort == 2)	array_multisort($sortObj, SORT_DESC, $imageName);

	else shuffle($imageName);

	return $imageName;

}



function checkURL($url){

	if(is_dir($url)){ $url = (substr($url,-1,1) == "/") ? $url : $url."/";	return $url; }

	else { return false; }

}
?>
