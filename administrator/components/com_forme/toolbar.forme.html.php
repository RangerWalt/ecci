<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/

defined('_JEXEC') or die('Restricted access');

class menuforme {


	function _DEFAULT(){

		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function INFO_MENU()
	{
		JToolBarHelper::back();
	}

	function EDIT_MENU()
	{
		JToolBarHelper::save();
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function SETTINGS_MENU()
	{
		JToolBarHelper::save('saveset');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('cancel');
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function LISTFORMS_MENU()
	{
		JToolBarHelper::addNewX('newform');
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'forms.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		JToolBarHelper::spacer();
		JToolBarHelper::deleteList( ' ', 'deleteform', _FORME_BACKEND_TOOLBAR_REMOVE );
		JToolBarHelper::spacer();
		JToolBarHelper::publishList('publishform');
		JToolBarHelper::spacer();
		JToolBarHelper::unpublishList('unpublishform');
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'test', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function EDITFORM_MENU()
	{
		$cid 	= JRequest::getVar('cid', array());

		if($cid) JToolBarHelper::addNewX('newfield',_FORME_BACKEND_TOOLBAR_NEWFIELD);
		if($cid) JToolBarHelper::spacer();
		if($cid) JToolBarHelper::custom( 'fields.copy.screen', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		if($cid) JToolBarHelper::spacer();
		if($cid) JToolBarHelper::deleteList( ' ', 'deletefield', _FORME_BACKEND_TOOLBAR_REMOVE );
		if($cid) JToolBarHelper::spacer();
		JToolBarHelper::save('saveform');
		JToolBarHelper::apply('applyform');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('cancelform',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
	function EDITFIELD_MENU()
	{
		JToolBarHelper::save('savefield');
		JToolBarHelper::apply('applyfield');
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('cancelfield',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function LISTDATA_MENU()
	{
		JToolBarHelper::archiveList('exportdata',_FORME_BACKEND_TOOLBAR_EXPORT);
		JToolBarHelper::custom('exportalldata','archive_f2.png','archive_f2.png',_FORME_BACKEND_TOOLBAR_EXPORT_ALL,false);
		JToolBarHelper::back('Back','index2.php?option=com_forme&task=forms');
		JToolBarHelper::deleteList('','deldata');
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
	function UPDATE(){
		JToolBarHelper::apply('update',_FORME_BACKEND_TOOLBAR_UPDATE);
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function FIELDS_COPY_SCREEN(){
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'fields.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('fields.copy.cancel',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::spacer();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'main', 'upload.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
}

?>