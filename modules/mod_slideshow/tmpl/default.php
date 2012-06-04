<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php 
		//$image = explode( ",", trim($params->get( 'images' )) );
		$url = explode( ",", trim($params->get( 'urls' )) );
		$title = explode( ",", trim($params->get( 'titles' )) );
		
		$addhttp = trim($params->get( 'addhttp' ));
		
		$folder = "images/stories/partners-home";
		
		// if folder doesnt contain slash to start, add
		if (strpos($folder, '/') !== 0) {	
			$folder = '/'.$folder;
		}
		// construct absolute path to directory
		$abspath_folder = $mosConfig_absolute_path.$folder;
		
		$abspath_folder = $mosConfig_absolute_path.$folder;
		
		// Scan folder for images
		$handle = opendir($abspath_folder);
		$exts = "gif,png";
		$exts = explode(',', $exts);
		while (($file = readdir($handle)) !== false) {
			foreach($exts as $ext) { 
				if (preg_match('/\.'.$ext.'$/i', $file, $test)) { 
					$image[] = $file; 
				}
			}
		}
		
		if ($addhttp)
		{
			for($i=0;$i<count($image);$i++)
			{
				$url[$i]="http://".(isset($url[$i])?$url[$i]:"");
			}
		}
		
		$space=trim($params->get( 'space' ));
		$spacetext = "&nbsp;";
		for($i=1;$i<$space;$i++) 
		{
			$spacetext .= "&nbsp;";
		}

		?>
		<script language="JavaScript1.2">
		var sliderwidth="<?php echo trim($params->get( 'width' )); ?>px"
		var sliderheight="<?php echo trim($params->get( 'height' )); ?>px"
		var slidebgcolor="<?php echo trim($params->get( 'bgcolor' )); ?>"
		var stopslide="<?php echo trim($params->get( 'stopslide' )); ?>"

		var slidespeed=<?php echo trim($params->get( 'speed' )); ?>

		var slidesspace=parseInt('<?php echo trim($params->get( 'slidesspace' )); ?>')

		var imagegap="<?php echo $spacetext; ?>"
		var leftrightslide=new Array()
		var finalslide=''
		<?php 
		for($i=0;$i<count($image);$i++)
		{
			$alt =  $title[$i] ? ' alt="'. $title[$i] .'"' : '';
			$alttitle =  $title[$i] ? ' title="'. $title[$i] .'"' : '';

			if ( $params->get( 'linked' ) ) 
			{
				$link =  $url[$i] ? '<a href="'. $url[$i] .'">' : '';
				$link_end =  $url[$i] ? '</a>' : '';
			}
			
			$templink = $link.'<img src="'.JURI::root() . trim($params->get( 'folder' ))."/". $image[$i].'" border="0"'.$alt.$alttitle.">".$link_end;
		?>
		leftrightslide[<?php echo $i; ?>]='<?php echo $templink; ?>'
		<?php 
		} 
		?>
		</script>
		<script src="<?php echo JURI::root(); ?>modules/mod_slideshow/scripts/script.js" language="JavaScript1.2"></script>