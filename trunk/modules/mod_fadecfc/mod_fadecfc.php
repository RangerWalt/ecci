<?php
/**
* Fading Content from Category Module for Joomla! 1.0.x
* Version 1.2
* Distributor: mediahof
* Author: Dominik Gorczyca,
* xhtml 1.0 strict
* http://www.mediahof.de/
**/

defined( '_VALID_MOS' ) or die ( 'Restricted access' );

$categoryid		= intval( $params->get( 'categoryid' ) );
$positionLeft	= intval( $params->get( 'positionLeft' ) );
$positionTop	= intval( $params->get( 'positionTop' ) );
$width				= intval( $params->get( 'width' ) );
$height				= intval( $params->get( 'height' ) );
$fadeSpeed		= intval( $params->get( 'fadeSpeed' ) );
$fadeOutTime	= intval( $params->get( 'fadeOutTime' ) )*1000;

$class				= $params->get( 'class' );
$alias				= $params->get( 'alias' );

$idPrefix = 'idfade';

switch ( $params->get( 'sort' ))
{
	case 'az': $sortBy = '`title` DESC';	break;
	case 'za': $sortBy = '`title` ASC';	break;
	case '19': $sortBy = '`id` DESC';	break;
	case '91': $sortBy = '`id` ASC';	break;
	case 'rd': $sortBy = ' RAND()'; break;
}

if ($categoryid > 0)
{
	$database->setQuery('SELECT * FROM `#__content` WHERE `catid`= '.$categoryid.' AND `state` = 1 ORDER BY '.($alias == 'ja' ? str_replace(array('`title`','`id`'), '`title_alias`', $sortBy) : $sortBy));
	$contents = $database->loadObjectList();

	$divStyle	= 'style="'.
							'position:absolute;'.
							'text-align:left;'.
							'overflow:hidden;'.
							'margin-top:'.($positionTop != 0 ? $positionTop.'px' : 0).';'.
							'margin-left:'.($positionLeft != 0 ? $positionLeft.'px' : 0).';'.
							'width:'.$width.'px;'.
							'height:'.$height.'px;'.
							'z-index:2;'.
							'display:none;'.
							'"';

	$tresc = "\n".'<div'.(!empty($class) ? $class = ' class="'.$class.'" ' : '').'>';
	for ($cn = 0; $cn < count($contents); $cn++)
	{
		$tresc .= "\n".'<div id="'.$idPrefix.($cn+1).'" '.$divStyle.'>'."\n".($contents[$cn]->fulltext == '' ? $contents[$cn]->introtext : $contents[$cn]->fulltext)."\n".'</div>'."\n";
	}

	$fade2next = '<script type="text/javascript">'."\n"
							.'//<![CDATA['."\n"
							.'//----------------------------------------------------------'."\n"
							.'//  Fade2Next by Dominik Gorczyca - mediahof'."\n"
							.'//----------------------------------------------------------'."\n"
							.'function transparent(f2nid , trans){'."\n"
							.'document.getElementById(f2nid).style.display="block";'."\n"
							.'var x = document.getElementById(f2nid).style;'."\n"
							.'if (window.navigator.appName == "Microsoft Internet Explorer") {'."\n"
							.'x.filter="alpha(opacity="+trans+")"; } else {'."\n"
							.'x.opacity=(trans/100); }}'."\n"
							.'function fadeOut(f2nid, zeit) {'."\n"
							.'var count=0; var trans=100;'."\n"
							.'for(count=1; count<=20; count++) {'."\n"
							.'trans=100-(count*5);'."\n"
							.'setTimeout("transparent(\'"+f2nid+"\',"+trans+" )",(zeit*count)); }}'."\n"
							.'function fadeIn(f2nid, zeit) {'."\n"
							.'var count=0; var trans=0;'."\n"
							.'for(count=1 ;count<=20; count++) {'."\n"
							.'trans=(count*5 );'."\n"
							.'setTimeout("transparent(\'"+f2nid+"\',"+trans+" )",(zeit*count)); }}'."\n"
							.'function fadek(f2nid) {'."\n"
							.'if (k==1) {k=0;} else {'."\n"
							.'if (oft==1) {'."\n"
							.'fadeOut(f2nid+oft,'.$fadeSpeed.'); oft=oftc;'."\n"
							.'fadeIn(f2nid+oft,'.$fadeSpeed.');'."\n"
							.'k=1;} else {fadeOut(f2nid+oft,'.$fadeSpeed.');'."\n"
							.'fadeIn(f2nid+(oft-1),'.$fadeSpeed.');'."\n"
							.'oft=oft-1;}}} var oft='.count($contents).';'."\n"
							.'var oftc=oft; var k=0; fadeIn(\''.$idPrefix.'\'+oft,'.$fadeSpeed.');'."\n"
							.'var aktiv=window.setInterval("fadek(\''.$idPrefix.'\')",'.$fadeOutTime.');'."\n"
							.'//]]>'."\n".'</script>'."\n";

	echo $tresc.$fade2next.'</div>'."\n";
}
?>