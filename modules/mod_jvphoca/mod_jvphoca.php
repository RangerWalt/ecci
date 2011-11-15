<?php
/*
 * Copyright joomlakurse.ch
 */
 
defined('_JEXEC') or die('Restricted access');// no direct access

include_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'helpers'.DS.'phocagallery.php' );
include_once( JPATH_SITE.DS.'components'.DS.'com_phocagallery'.DS.'helpers'.DS.'phocagallery.php' );

$user 		=& JFactory::getUser();
$db 		=& JFactory::getDBO();
$menu 		= &JSite::getMenu();
$document	= & JFactory::getDocument();
		
//..Adding Css to Header
$document->addStyleSheet(JURI::base(true).'/modules/mod_jvphoca/assets/jv_phoca.css');
$document->addCustomTag("<!--[if IE]>\n<link rel=\"stylesheet\" href=\"".JURI::base(true)."/modules/mod_jvphoca/assets/jv_phoca_ie.css\" type=\"text/css\" />\n<![endif]-->");
$document->addScript( 'http://lite.piclens.com/current/piclens.js' );

$paramsC = JComponentHelper::getParams('com_phocagallery') ;

//... These params I get from the author of Phoca Gallery, no need in this module. Leave them as default ...........
$display_description_detail = $params->get( 'display_description_detail', 0 );
$description_detail_height 	= $params->get( 'description_detail_height', 16 );
$img_cat_size				= 'medium';
$font_color 				= $params->get( 'font_color', '#135cae' );
$background_color 			= $params->get( 'background_color', '#fcfcfc' );
$background_color_hover 	= $params->get( 'background_color_hover', '#f5f5f5' );
$image_background_color 	= $params->get( 'image_background_color', '#f5f5f5' );
$border_color 				= $params->get( 'border_color','#e8e8e8' );
$border_color_hover 		= $params->get( 'border_color_hover','#135cae' );
$phocagallery_module_width 	= $params->get( 'phocagallery_module_width', '' );
$display_name 				= $params->get( 'display_name', 1 );
$display_icon_detail 		= $params->get( 'display_icon_detail', 1 );
$display_icon_download 		= $params->get( 'display_icon_download', 0 );
$font_size_name 			= $params->get( 'font_size_name', 12 );
$char_length_name 			= $params->get( 'char_length_name', 11 );
$detail_window = $params->get( 'detail_window', 0 );
$medium_image_width 		= $params->get( 'medium_image_width' , 100 );
$medium_image_height 		= $params->get( 'medium_image_height', 100 );
$front_modal_box_width 		= $params->get( 'front_modal_box_width', 680 );
$front_modal_box_height 	= $params->get( 'front_modal_box_height', 560 );
$front_popup_window_width 	= $params->get( 'front_popup_window_width', 680 );
$front_popup_window_height 	= $params->get( 'front_popup_window_height', 560 );
$image_background_shadow = $params->get( 'image_background_shadow', 'none' );
//.............................................................................................................
//.. These are our params .....................................................................................
$cat_limit                  = $params->get( 'cat_limit', 5 );
$pix_randomize              = $params->get( 'pix_randomize', 1 );  
$show_number                = $params->get( 'show_number', 0 );  
$show_title                 = $params->get( 'show_title', 1 );  
$show_play                  = $params->get( 'playbutton', 1 ); 
$piclens                    = $params->get( 'piclens', 1 );  
$overview                   = $params->get( 'overview', 0 );  
$overview_text              = $params->get( 'overview_text', 'Show all categories' ); 
$link_to                    = $params->get( 'link_to', 5 );  
$layout                     = $params->get( 'layout', 0 );  
//...............................................................................................................
		
if ( $image_background_shadow != 'none' ) {	
			$imageBgCSS = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$image_background_shadow.'.'.PhocaGalleryHelperFront::getFormatIconComponent().'\') 0 0 no-repeat;';
} else {
	$imageBgCSS = 'background: '.$image_background_color .';';
}
	
$document->addCustomTag( "<style type=\"text/css\">\n"
						." #jvphoca_module .name {color: $font_color ;}\n"
						." #jvphoca_module .phocagallery-box-file {background: $background_color ; border:1px solid $border_color ;}\n"
						." #jvphoca_module .phocagallery-box-file-first { $imageBgCSS }\n"
						." #jvphoca_module .phocagallery-box-file:hover, .phocagallery-box-file.hover {border:1px solid $border_color_hover ; background: $background_color_hover ;}\n"
						." </style>\n");

$document->addCustomTag( "<!--[if IE]>\n<style type=\"text/css\">\n"
								."phocagallery-box-file{
background-color: expression(isNaN(this.js)?(this.js=1,
this.onmouseover=new Function(\"this.className+=' hover';\"),
this.onmouseout=new Function(\"this.className=this.className.replace(' hover','');\")):false););
}"
								." </style>\n<![endif]-->");

//END CSS

// Window
JHTML::_('behavior.modal', 'a.modal-button');
$button = new JObject();
$button->set('name', 'image');

if ($display_description_detail == 1) {
	$front_popup_window_height	= $front_popup_window_height + $description_detail_height;
}
$db->setQuery("SELECT id  FROM #__menu WHERE link LIKE '%option=com_phocagallery%'");                                                                                                   
$Itemid = $db->loadResult();
// PARAMS - Height of box
$category_box_space = $params->get( 'category_box_space', 0 );
// PARAMS - Display Buttons (height will be smaller)
$detail_buttons = $params->get( 'detail_buttons', 1 );

// PARAMS - Detail buttons
if ($detail_buttons != 1) {
	$front_popup_window_height	= $front_popup_window_height - 45;
}

// PARMAS - Standard popup window - get this from paramaters
if ($detail_window == 1) {
	$button->set('methodname', 'js-button');
	$button->set('options', "window.open(this.href,'win2','width=".$front_popup_window_width.",height=".$front_popup_window_height.",menubar=no,resizable=yes'); return false;");
	
} else { //modal popup box
	// PARAMS
	$modal_box_overlay_color = $params->get( 'modal_box_overlay_color', '#000000' );
	$modal_box_overlay_opacity = $params->get( 'modal_box_overlay_opacity', 0.7 );
	$modal_box_border_color = $params->get( 'modal_box_border_color', '#000000' );
	$modal_box_border_width = $params->get( 'modal_box_border_width', '10' );
	
	$button->set('modal', true);
	$button->set('methodname', 'modal-button');
	$button->set('options', "{handler: 'iframe', size: {x: ".$front_popup_window_width.", y: ".$front_popup_window_height."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
	
	$document->addCustomTag( "<style type=\"text/css\"> \n"  
	." #sbox-window.phocagallery-random-window   {background-color:".$modal_box_border_color.";padding:".$modal_box_border_width."px} \n"
	." #sbox-overlay.phocagallery-random-overlay  {background-color:".$modal_box_overlay_color.";} \n"			
	." </style> \n");
}

// ACCESS RIGHTS

// All categories where the user has access
$query = 'SELECT cc.title AS text, cc.id AS id, cc.parent_id as parentid, cc.alias as alias, cc.access as access, cc.params as params'
		. ' FROM #__phocagallery_categories AS cc'
        . ' RIGHT JOIN #__phocagallery AS img ON img.catid = cc.id'
		. ' WHERE cc.published = 1'
		. ' AND cc.access <= '. $user->get('aid', 0)
		. ' ORDER BY img.date DESC';
		
$db->setQuery( $query );
$categories = $db->loadObjectList();

$unSet = 0;
foreach ($categories as $key => $category) { 
	// USER RIGHT - ACCESS =======================================
	$rightDisplay	= 1;
	
	if (isset($categories[$key]->params)) {
		$rightDisplay = PhocaGalleryHelper::getUserRight ($categories[$key]->params, 'accessuserid', $category->access, $user->get('aid', 0), $user->get('id', 0), 0);
	}
		
	if ($rightDisplay == 0) {
		unset($categories[$key]);
		$unSet = 1;
	}
	// ============================================================
}
if ($unSet == 1) {
	$categories = array_values($categories);
}	

$allowedCategories = $categories;

// From objects to array only
$last_result = 0;
$indx = 0;
$allowedCategoriesArray = array();
foreach ($allowedCategories as $key => $value) {
    $allowedCategoriesArray[] = $value->id;
}
$k = count($allowedCategoriesArray);
for ($i=0;$i<$k;$i++) {
   for ($j=$i+1;$j<$k;$j++) {    
     if (!$allowedCategoriesArray[$i]) continue;
     if (!$allowedCategoriesArray[$j]) continue;
     if ($allowedCategoriesArray[$i] == $allowedCategoriesArray[$j]) unset($allowedCategoriesArray[$j]);
   }
}      
$vacat = array();
foreach($allowedCategoriesArray as $key => $value) {
    $vacat[] = $value;   
}

$outputs = array();  
$k = 0;
$box_width = round(100 / $cat_limit) - 0.1;
for ($g=0;$g<$cat_limit;$g++) {
    $current_cat = $vacat[$g];
    $image = '';
    $query = 'SELECT cc.id AS idcat, a.id AS idimage' .
    ' FROM #__phocagallery_categories AS cc' .
    ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id' .
    ' WHERE a.published = 1' .
    ' AND cc.published = 1' .
    ' AND cc.id=' .$current_cat;
    if ($pix_randomize) {
        $query .= ' ORDER BY RAND()';
    } else {
        $query .= ' ORDER BY a.ordering';   
    }

    $db->setQuery($query);
    $image = $db->loadObject();
    //.. Get the current image info .....
    if ($image) {
	        $query = 'SELECT cc.title AS cattitle,cc.id, a.id, a.catid, a.title, a.alias, a.filename ,'
	        . ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as catslug, '
	        . ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
	        . ' FROM #__phocagallery_categories AS cc'
	        . ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
	        . ' WHERE a.id = ' . $image->idimage
	        . ' LIMIT 1';

	        $db->setQuery($query);
	        $image_object = $db->loadObject();
            $db->setQuery("SELECT COUNT(*) FROM #__phocagallery WHERE catid = '".$current_cat."'");
            $total = $db->loadResult();
            
	        $items	 = $menu->getItems('link', 'index.php?option=com_phocagallery&view=category&id='.$image_object->id);
	        $itemscat= $menu->getItems('link', 'index.php?option=com_phocagallery&view=categories');


	        if(isset($itemscat[0]))
	        {
		        $itemid = $itemscat[0]->id;
		        $image_object->link ='index.php?option=com_phocagallery&view=detail&catid='. $image_object->catslug .'&id='. $image_object->slug .'&Itemid='.$itemid . '&tmpl=component&detail='.$detail_window.'&buttons='.$detail_buttons;
	        }
	        else if(isset($items[0]))
	        {
		        $itemid = $items[0]->id;
		        $image_object->link = 'index.php?option=com_phocagallery&view=detail&catid='. $image_object->catslug .'&id='. $image_object->slug .'&Itemid='.$itemid . '&tmpl=component&detail='.$detail_window.'&buttons='.$detail_buttons ;
	        }
	        else
	        {
		        $itemid = 0;
		        $image_object->link = 'index.php?option=com_phocagallery&view=detail&catid='. $image_object->catslug .'&id='. $image_object->slug . '&tmpl=component&detail='.$detail_window.'&buttons='.$detail_buttons ;
	        }
	        
	        //..........................
	        $file_thumbnail = PhocaGalleryHelperFront::displayFileOrNoImage($image_object->filename, $img_cat_size);
	        $image_object->linkthumbnailpath = $file_thumbnail['rel'];
	        $image_object->linkthumbnailpathabs = $file_thumbnail['abs'];
	        //..........................

	        jimport( 'joomla.filesystem.file' );
	        $imageWidth 	= 100;
	        $imageHeight	= 100;
	        if (JFile::exists($image_object->linkthumbnailpathabs))
	        {
		        list($width, $height) = GetImageSize( $image_object->linkthumbnailpath );
		        
		        if ($width > $height) {
			        if ($width > 100) {
				        $imageWidth		= 100;
				        $rate 			= $width / 100;
				        $imageHeight	= $height / $rate;
			        } else {
				        $imageWidth		= $width;
				        $imageHeight	= $height;
			        }
		        }
		        else {
			        if ($height > 100) {
				        $imageHeight	= 100;
				        $rate 			= $height / 100;
				        $imageWidth 	= $width / $rate;
			        } else {
				        $imageWidth		= $width;
				        $imageHeight	= $height;
			        }
		        }
	        }

	        $imageWidthBg 	= 100;	
	        $imageHeightBg	= 100;

	        $boxImageHeight = 100;
	        $boxImageWidth 	= 120;

	        if ($show_title == 1) {
		        $boxImageHeight = $boxImageHeight + 20;
	        }
		    $boxImageHeight = $boxImageHeight + 20;

	        if ( $category_box_space > 0 ) {		
		        $boxImageHeight = $boxImageHeight + $category_box_space;
	        }

	        if ( $image_background_shadow != 'none' ) {		
		        $boxImageHeight = $boxImageHeight + 18;
		        $imageWidthBg 	= 118;	
		        $imageHeightBg	= 118;
	        }


	        if ($phocagallery_module_width !='') {
		        $outputs[$k]	= '<div style="width:'.$phocagallery_module_width.'px;text-align:center;">';
	        } else {
		        $outputs[$k]	= '';
	        }
            if ($link_to == 1) {
                if ($piclens == 1) {
                    $slideshow_link = '<a  title="Slideshow" href="javascript:PicLensLite.start({feedUrl:\''.JURI::base().'modules/mod_jvphoca/rss.php?cat='.$current_cat.'\'});">';
                } else {
                    $slideshow_link = '<a class="'.$button->methodname.'" title="Slideshow" href="'.JRoute::_($image_object->link).'" rel="'. $button->options.'">'; 
                }
            } elseif ($link_to == 2) {
                $slideshow_link = '<a title="'. JText::_('Show all categories').'" href="index.php?option=com_phocagallery&Itemid='.$Itemid.'">'; 
            } else {
                $slideshow_link = '<a title="" href="#">'; 
            }
	        $outputs[$k] .= '<div class="phocagallery-box-file" style="height:'.$boxImageHeight.'px; width:'.$boxImageWidth.'px">' . "\n";
	        $outputs[$k] .= '<center>'  . "\n"
		                    .'<div class="phocagallery-box-file-first" style="height:'.$imageHeightBg.'px;width:'.$imageWidthBg.'px;">'. "\n"
		                    .'<div class="phocagallery-box-file-second">' . "\n"
		                    .'<div class="phocagallery-box-file-third">' . "\n"
		                    .'<center>' . "\n"
		                    .$slideshow_link; 
	        $outputs[$k] .= '<img src="'.JURI::base(true).'/'.$image_object->linkthumbnailpath.'" alt="'.$image_object->title.'" width="'.$imageWidth.'" height="'.$imageHeight.'" />';
	        $outputs[$k] .= '</a>'
		         .'</center>' . "\n"
		         .'</div>' . "\n"
		         .'</div>' . "\n"
		         .'</div>' . "\n"
		         .'</center>' . "\n";
		         

	        if ($show_title == 1)
	        {
		        $outputs[$k] .= '<div class="name" style="text-align:center;color: '.$font_color.' ;font-size:'.$font_size_name.'px;">'./* PhocaGalleryHelperFront::wordDelete($image_object->title, $char_length_name, '...') */$image_object->cattitle.' ';
                if ($show_number == 1) {
                    $outputs[$k] .= '('.$total.')';
                }
                $outputs[$k] .= '</div>';
            }
			if ($show_play) {
                    $outputs[$k] .= '<div class="detail" style="text-align:center;margin-top: 5px;">';  
                    $outputs[$k] .= '<a  title="Slideshow" href="javascript:PicLensLite.start({feedUrl:\''.JURI::base().'modules/mod_jvphoca/rss.php?cat='.$current_cat.'\'});">';
			        $outputs[$k] .= '<img src="'.JURI::base(true).'/'.'modules/mod_jvphoca/assets/icon-view.gif" alt="'.$image_object->title.'" />';
			        $outputs[$k] .= '</a>';
		            $outputs[$k] .= '</div>';
            }        
	                $outputs[$k] .= '</div>';

	        if ($phocagallery_module_width !='') {
		        $outputs[$k]	.= '</div>';
	        } else {
		        $outputs[$k]	.= '';
	        }
    } else { 
		    $outputs[] = '';
    }
    $k++;
}
require(JModuleHelper::getLayoutPath('mod_jvphoca'));

?>