<?php
//.......
define( '_JEXEC', 1 );

$path = dirname(__FILE__);
$path = str_replace ('\\', '/', $path);
if ($pos = strpos ($path, '/modules/')) {
    $path = substr($path, 0, $pos);
}
define('JPATH_BASE', $path );

define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('site');

/**
 * INITIALISE THE APPLICATION
 *
 * NOTE :
 */
// set the language
$mainframe->initialise();
$cat = $_REQUEST['cat'];
if (!$cat || ($cat == '')) exit;
$db = &JFactory::getDBO();
$config = new JConfig();

$db->setQuery("SELECT *,a.title AS cattitle FROM #__phocagallery_categories AS a INNER JOIN #__phocagallery AS b ON a.id = b.catid WHERE b.catid='".$cat."' AND a.published='1' AND b.published='1' ORDER BY b.ordering");
$db->query();
$listimg = $db->loadObjectList();
$db->setQuery("SELECT id  FROM #__menu WHERE link LIKE '%option=com_phocagallery%'");                                                                                                   
$Itemid = $db->loadResult();
$catlink = JRoute::_('index.php?option=com_phocagallery&view=category&id='.$cat.'&Itemid='.$Itemid);
$site_url = JURI::base();
if ($pos = strpos ($site_url, '/modules/')) {
    $site_url = substr($site_url, 0, $pos).'/';
}
$xml = '';
$xml .= '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
        xmlns:media="http://search.yahoo.com/mrss/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
>
    <channel>
        <title>'.$listimg[0]->cattitle.'</title>
        <link>'.$site_url.$catlink.'</link>
         <description></description>
        <generator>'.$site_url.'</generator>
        <image>
            <url>'.$site_url.'modules/mod_jvphoca/assets/logo.png</url>
            <title>'.$config->sitename.'</title>
            <link>'.$catlink.'</link>
        </image>';
foreach ($listimg as $key => $image) {
        $thumb = explode('/',$image->filename); 
        $thumblink = $site_url.'images/phocagallery';
        for ($i=0;$i<count($thumb)-1;$i++) {
            $thumblink .= '/'.$thumb[$i];   
        }
        $thumblink .= '/thumbs/phoca_thumb_m_'.$thumb[count($thumb)-1];
        $xml .= '
        <item>
            <title>'.$image->title.'</title>
            <link>'.$site_url.'images/phocagallery/'.$image->filename.'</link>
            <description>'.$image->description.'</description>
            <pubDate>'.$image->date.'</pubDate>
            <author>'.$site_url.'</author>
            <guid isPermaLink="false">'.$site_url.'images/phocagallery/'.$image->filename.'</guid>
            <media:content url="'.$site_url.'images/phocagallery/'.$image->filename.'" type="image/jpeg"/>
            <media:title>'.$image->title.'</media:title>
            <media:thumbnail url="'.$thumblink.'" width="100" />
            <media:credit role="photographer">'.$config->sitename.'</media:credit>
        </item>';
}
$xml.='</channel>
</rss>';
header("Content-Type: application/xml; charset=UTF-8");
echo $xml;
?>