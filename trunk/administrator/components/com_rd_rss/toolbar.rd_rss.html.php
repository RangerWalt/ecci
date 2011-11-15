<?php
/**
 *
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: toolbar.rd_rss.html.php 33 2007-09-25 15:17:27Z deutz $
 * @package RdRss
 * @subpackage mambo_4_6_2
 *
 * This is free software
 *
 * normal syndicate component changed to show all sections and categories as rss feed
 **/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

class toolbarRdRss {

/**
* Draws the menu for List
*/

	function LIST_ITEM()
	{
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::deleteList("","del");
		mosMenuBar::spacer();
		mosMenuBar::editListX("editA");
		mosMenuBar::spacer();
		mosMenuBar::addnewX("new");
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

/**
* Draws the menu for edit list
*/

	function EDIT_ITEM()
	{
		mosMenuBar::startTable();
		mosMenuBar::save("save");
		mosMenuBar::spacer();
		mosMenuBar::apply("apply");
		mosMenuBar::spacer();
		mosMenuBar::cancel("cancel");
		mosMenuBar::endTable();
	}

}
?>