<?php
// MooPopUp Module 1.0.1
// @copyright http://www.templateplazza.com
// @license http://www.gnu.org/copyleft/gpl.html GNU/GPL

defined('_JEXEC') or die('Restricted access');

if(defined( '_MooPopUp')) {
	return;
}

define ( '_MooPopUp', 1 );

$useCoo 	= (int) $params->get( 'useCoo', 0 );
$cooTime 	= (int) $params->get( 'cooTime', 3600 );

$mooBrowser 	= (int) $params->get( 'mooBrowser', 1 );
$mooItemid = $params->get( 'mooItemid', 'anywhere' );

$mooStyle = $params->get( 'mooStyle', 'moopopup02.css' );
$mooViewer = $params->get( 'mooViewer', 'both' );

if($mooItemid=="anywhere") {
	if((empty($mooBrowser)) OR ($mooBrowser==0) OR ($mooBrowser=="0")) {
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') == false) {
			return;
		}
	}
} else {
	$mooItemid = explode(",",$mooItemid);
	$Itemid = JRequest::getInt( 'Itemid' );
	$iid = ($Itemid)?$Itemid:"";
	if(in_array($iid,$mooItemid)) {
		if((empty($mooBrowser)) OR ($mooBrowser==0) OR ($mooBrowser=="0")) {
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') == false) {
				return;
			}
		}
	} else {
		return;
	}
}

$user		=& JFactory::getUser();
$userId		= (int) $user->get('id');
if($mooViewer=='visitor') {
	if(!empty($userId)) {
		return;
	}
} elseif ($mooViewer=='registered') {
	if(empty($userId)) {
		return;
	}
}

if($useCoo != 1) {
	if(empty($_COOKIE['tp_show_loaded'])) {
		unset($_COOKIE['tp_show_loaded']);
	}
} else {
	if(empty($_COOKIE['tp_show_loaded'])) {
		setcookie("tp_show_loaded", "loaded", time()+3600);
	} else {
		return;
	}
}

$document =& JFactory::getDocument();
$document->addStyleSheet($mainframe->getBasePath( 0, true ).'modules/mod_moopopup/moopopup/'.$mooStyle);
$document->addCustomTag('<script type="text/javascript" src="'.$mainframe->getBasePath( 0, true ).'modules/mod_moopopup/moopopup/mooMessageBox.js"></script>');

$mooPopUpMessage = $params->get( 'mooPopUpMessage', 'Place Your message here. HTML tags are allowed. <br/> Visit us at <a href ="http://www.templateplazza.com">Templateplazza.com</a> <img src ="modules/mod_moopopup/moopopup/images/tplogo.png" alt="Templateplazza.com"/>' );
$width = (int) $params->get( 'width', 430 );
$height = (int) $params->get( 'height', 320 );
$buttonTitle = $params->get( 'buttonTitle', 'close' );
$boxTitle = $params->get( 'boxTitle', 'Advertisement' );
$isDrag = (int) $params->get( 'isDrag', 1 );
$isDrag = ($isDrag)?'true':'false';
$fadeSpeed = (int) $params->get( 'fadeSpeed', 500 );

$document->addCustomTag('<script language="javascript" type="text/javascript">
window.onload=function(){
	var p = new mooSimpleBox({ width:'.$width.', height:'.$height.', btnTitle:'.$buttonTitle.',closeBtn:\'myBtn\', btnTitle: \'close\',boxClass:\'myBox\', id:\'myID\', fadeSpeed:'.$fadeSpeed.', opacity:\'0.9\', addContentID:\'mooPopUpDiv\', boxTitle:\''.$boxTitle.'\', isDrag:\''.$isDrag.'\'});
	p.fadeIn();
}
</script>');

echo '<!-- Moopopup - Fancy Popup box from http://www.templateplazza.com -->';
echo '<div id="mooPopUpDiv"><br/>'.$mooPopUpMessage.'</div>';

?>