<?php
/**
* DOCMan List Module
* @Copyright (C) Paolo De Nictolis
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (is_callable(array($params,"get"))) {				// Mambo 4.5.0 compatibility
	$catid	= intval($params->get( 'catid', ""));
	//$catid	= $params->get( 'catid', "");
    $showlinks = intval($params->get( 'showlinks', 1));
    $showdescription = intval($params->get( 'showdesc', 1));    
} else {
	$catid = "";
    $showlinks = 1;
    $showdescription = 1;
}

$spacer = "&nbsp;&nbsp;&nbsp;&nbsp;"; //four spaces, used to indent docs list
//$spacer = "||||";
$fontsize = 18; //this variable holds font size to apply


if ($catid == ""){
    //gets all document categories
    $database->setQuery("SELECT id, title, description FROM #__categories WHERE section = 'com_docman' AND published = 1 ORDER BY ordering");
} else {
/*echo "<script>alert('$catid');</script>";*/
    //gets just docs belonging to given category
    //$database->setQuery("SELECT id, title, description FROM #__categories WHERE section = 'com_docman' AND parent_id = ".intval($catid)." AND published = 1 ORDER BY ordering");
	$database->setQuery("SELECT id, title, description FROM #__categories WHERE section = 'com_docman' AND id = ".intval($catid)." AND published = 1 ORDER BY ordering");

}

$rows = $database->loadObjectList();

if ( is_null($rows) ) {
    echo "EMPTY DOC STORE";
} else {
    foreach ($rows as $categ) {
        //echo "<font style='font-size:". $fontsize. "px'><strong>" . $categ->title . "</strong></font><br />";
		echo "<font style='color: #0099CC; font-size:". $fontsize. "px'><strong>" . $categ->title . "</strong></font><br />";
        listSubCategories($categ->id, $spacer, $fontsize-1, $showlinks, $showdescription);
        listDocuments($categ->id, $spacer, $showlinks, $showdescription); 
        echo "<br /><br />";        
    }
}

function listSubCategories( $parent_id, $spacer, $fontsize, $bshowlinks, $bshowdescription ) {
    global $database;
    $database->setQuery("SELECT id, title, description FROM #__categories WHERE parent_id = ".$parent_id." AND published = 1 ORDER BY ordering");
    $rows = $database->loadObjectList();
    if ( is_null($rows) ) {
        //no result, steps back in recursion and prints documents list
    } else {
        //print category and recursion
        foreach ($rows as $subcateg) {
            echo "<font style='color: #0099CC; font-size:". $fontsize. "px'>" . $spacer . $subcateg->title . "</font><br />";            
            listSubCategories($subcateg->id, $spacer.$spacer, $fontsize-1, $bshowlinks, $bshowdescription);
            listDocuments($subcateg->id, $spacer.$spacer, $bshowlinks, $bshowdescription);            
            echo "<br />";
        }
    }
}

function listDocuments( $id, $spacer, $bshowlinks, $bshowdescription ) {
    global $database;
    $database->setQuery("SELECT id, dmname, dmdescription, dmdate_published FROM #__docman WHERE catid = ".$id." AND published = 1 ORDER BY dmdate_published DESC");
    $rows = $database->loadObjectList();
	$ctr=0;
    foreach($rows as $doc) 
	{
		$linkedtitle = $spacer; 
         if ( $bshowlinks ) 
		 {
            $daynew = 7; //number of days pasted which a document is "old"
            $ctr++;          
		    
            if ( ((strtotime("now") - strtotime($doc->dmdate_published))/(86400)) < $daynew ) {
                $linkedtitle .= " <font color='red'><strong>*NEW*  </strong></font>";
            }
            $linkedtitle .= "<a href='index.php?option=com_docman&amp;task=doc_download&amp;gid=" . $doc->id;
            $linkedtitle .= "' class='doclink'>". $doc->dmname . "</a><br />";
			
            echo $linkedtitle;
			
         } else {
            echo $spacer. "<strong>" . strtoupper($doc->dmname) . "</strong><br />";
         }
         if ( $bshowdescription ) { 
            echo $spacer. $doc->dmdescription;
         }
    }
}
?>