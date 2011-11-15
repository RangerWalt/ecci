<?php
/**
* @version		$Id: mod_jDMTree1.5
* @package		DOCMan jDMTree Module for Joomla 1.5
* @copyright	Copyright (C) youthpole.com. All rights reserved.
* @author     Josh Prakash
* @license		GNU/GPL, see LICENSE.php
* This module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* * Revisions
* Nov-01-2008 - Security implementation compatible to docman component
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

    require_once(JPATH_SITE.DS.'modules'.DS.'mod_jdmtree15' .DS.'jDMtree'.DS.'docmantree.php');

		$user = & JFactory::getUser();
		$db			=& JFactory::getDBO();
    $menu    = &JSite::getMenu();
    $acl   = &JFactory::getACL();
  
//$my contains user information, $acl contains account level information
    $myGid = intval($acl->get_group_id($user->usertype));
//    18 - Registered
//		19 - Author
//		20 - Editor
//		21 - Publisher
//		23 - Manager
//		24 - Administrator
//		25 - Super Administrator


    $items	= $menu->getItems('link', 'index.php?option=com_docman');
    $itemid ='';
    if(isset($items[0]))
        {
      $itemid = $items[0]->id;
        }


    $countd 		= intval( $params->get( 'countd', 4 ) ); //document count
    $lengthc    = intval( $params->get( 'lengthc', 20 ) );	 // Max length of category before truncation
    $lengthd    = intval( $params->get( 'lengthd', 20 ) );	 // Max length of docs before truncation
    $orderby = $params->get( 'orderby', 'dmlastupdateon DESC');		      // Sort order
    $moredesc = $params->get( 'moredesc', 'View Category');		      // Description for More Button
    $docGif = "modules/mod_jdmtree15/jDMtree/images/docmantree_sheet.png";
    $catGif = "modules/mod_jdmtree15/jDMtree/images/docmantree_cat.gif";
    $nodeId = 0;
    $counter = 0;
    $doclink = "";
    $catlink = "";
    $curcat = 0;
    $precat = -1;

    /* Query to retrieve all categories that belong under the docman section and that are published. */
	  $queryc = "SELECT cc.* "
	. "\n FROM #__categories AS cc"
  . "\n WHERE cc.section = 'com_docman'"
	. "\n AND cc.published = 1"
	. "\n AND cc.access <= " . (int) $user->get('gid')
	. "\n ORDER BY cc.parent_id,cc.ordering "
	;
		$db->setQuery($queryc);
		$rows = $db->loadObjectList();
		
		$tree = new docmantree();	// Creating new tree object

	   foreach ( $rows as $row ) { // let's append categories & sub categories to the tree
  
  
            if(strlen($row->name) > $lengthc){
              $row->name  = substr($row->name,0,($lengthc - 3));
              $row->name .= "...";
              }
        
            //
            $tree->addToArray($row->id,$row->name,$row->parent_id,"");
  
            if($row->id > $nodeId){$nodeId=$row->id;} // get max id
          }
          $nodeId++;

          /* Query to retrieve all docs that are approved & published. */
	        $queryd = "SELECT a.* "
	         . "\n FROM #__docman AS a"
	         . "\n WHERE a.published = 1"
	         . "\n AND a.approved = 1";
          if ($user->guest) {
                //not logged in

 	             $queryd .= "\n AND a.dmowner = -1";
               $queryd .= "\n ORDER BY a.catid ASC,".$orderby;

              }  
          else {
               //
             		$queryd .= "\n AND ( a.dmowner = " . $user->get('id');
             	 	$queryd .= "\n OR a.dmmantainedby = " . $user->get('id');
             	 	$queryd .= "\n OR a.dmowner = -1 ";
                        //
             	 	      switch($myGid){
             	 	      case 18:
             	 	        $queryd .= "\n OR a.dmowner = 0 ";
                      case 19: 
                        $queryd .= "\n OR a.dmowner = -4 ";
             	 	      case 20:
             	 	        $queryd .= "\n OR a.dmowner = -6 ";
             	 	      case 21:
             	 	        $queryd .= "\n OR a.dmowner = -3 ";
                        }
             	 	      //
                        
                         $queryd .= "\n  ) ";
             	 	        
                          /*
           	 	 if ($user->groupsIn != '0,0') {
                	$queryd .= "\n OR a.dmowner IN (" . $user->groupsIn . ")";
                	$queryd .= "\n OR a.dmmantainedby IN (" . $user->groupsIn . ")";
                  } */
               //
               $queryd .= "\n ORDER BY a.catid ASC,".$orderby;
              }
	         $db->setQuery( $queryd );
	         $rows = $db->loadObjectList();
           $n=count($rows);
           $i=0;

           foreach ( $rows as $row ) { // now let's append docs to the tree
                $curcat=$row->catid; // cat of cur row
                $counter++;
                $i++;
                if ( $precat== -1 || $curcat == $precat || $counter == 1 ) { //doccount check
    
                      if ($counter<=$countd ) { //counterchk
                            if(strlen($row->dmname) > $lengthd){
                                  $row->dmname  = substr($row->dmname,0,($lengthd - 3));
                                  $row->dmname .= "...";
                                    }  
  //
                          //  $doclink = JRoute::_('index.php?option=com_docman&amp;task=doc_details&amp;gid='. $row->id .'&amp;Itemid='. $itemid.'');
						  	$doclink = JRoute::_('index.php?option=com_docman&amp;task=doc_download&amp;gid='. $row->id .'&amp;Itemid=61');
                            $tree->addToArray($nodeId,$row->dmname,$row->catid,$doclink,"",$docGif);
                            $nodeId++;
                            } // counterchk

                        } //doccount check
                else { //cat change 

                    /*  removed to hide category view
				      if ( $precat!=$curcat ) { //counterchk for more btn
                            //$catlink = JRoute::_('index.php?option=com_docman&amp;task=cat_view&amp;gid='. $precat .'&amp;Itemid='. $itemid.'');
							$catlink = JRoute::_('index.php?option=com_docman&amp;task=cat_view&amp;gid='. $precat .'&amp;Itemid=61');
                           // $tree->addToArray($nodeId,$moredesc,$precat,$catlink,"",$catGif);
							$tree->addToArray($nodeId,$moredesc,$precat,$catlink,"",$catGif);
                            $nodeId++;
                            $counter=0; //reset here
                            }//counterchk for more btn
						*/
                      if ($counter<$countd ){ //cat with few docs
                          //lets not forget the current node
                          if(strlen($row->dmname) > $lengthd){ 
                                $row->dmname  = substr($row->dmname,0,($lengthd - 3));
                                $row->dmname .= "...";
                                }  
  //
                        //  $doclink = JRoute::_('index.php?option=com_docman&amp;task=doc_details&amp;gid='. $row->id .'&amp;Itemid='. $itemid.'');
						$doclink = JRoute::_('index.php?option=com_docman&amp;task=doc_download&amp;gid='. $row->id .'&amp;Itemid='. $itemid.'');
                          $tree->addToArray($nodeId,$row->dmname,$row->catid,$doclink,"",$docGif);
                          $nodeId++;
                          $counter++; //has to count this one too
                          }//cat with few docs

                      } //cat change

              $precat=$curcat;
            /*  removed to hide category view
			
			if($i==$n){// for the last row
                  $catlink = JRoute::_('index.php?option=com_docman&amp;task=cat_view&amp;gid='. $precat .'&amp;Itemid='. $itemid.'');
                  //$tree->addToArray($nodeId,$moredesc,$precat,$catlink,"",$catGif);
				  $tree->addToArray($nodeId,$moredesc,$precat);
                  $nodeId++;
                  } //for the last row */
      } // for loop
 /*------------------------------------*/
 //now it's time to draw the tree
      $tree->writeJavascript();
      $tree->drawTree();
      $tree->applyStyle();
