<?php
/**
 *
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: toolbar.rd_rss.php 33 2007-09-25 15:17:27Z deutz $
 * @package RdRss
 * @subpackage mambo_4_6_2
 *
 * This is free software
 *
 * normal syndicate component changed to show all sections and categories as rss feed
 **/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );


switch ($task) {
	case "apply":
	case "new":
	case "edit":
	case "editA":
		toolbarRdRss::EDIT_ITEM();
		break;

	case "list":
	default:
		toolbarRdRss::LIST_ITEM();
		break;

}


?>