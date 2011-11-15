<?php


defined('_JEXEC') or die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.controller');

class ArtAdminerController extends JController {
	function __construct() {
		parent::__construct();
	}
	
	function adminer() {
		require_once(JPATH_COMPONENT.DS.'admin.artadminer.html.php');
		$option = JRequest::getCmd('option');
		HTML_ArtAdminer::adminer($option);
	}
	
	function settings() {
		require_once(JPATH_COMPONENT.DS.'admin.artadminer.html.php');
		JTable::addIncludePath(JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_artadminer' . DS . 'database');
		$settings =& JTable::getInstance('artadminer_setting', 'Table');
		$settings->load(1);
		$option = JRequest::getCmd('option');		
		HTML_ArtAdminer::settings($option, $settings);
	}
	
	function settings_save() {
		JTable::addIncludePath(JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_artadminer' . DS . 'database');
		$option = JRequest::getCmd('option');
		$post = JRequest::get('post');
		$row =& JTable::getInstance('artadminer_setting', 'Table');
		
		if (!$row->bind($post)) {
			return JError::raiseWarning(500, $row->getError());
		}
		
		if (!$row->store()) {
			return JError::raiseWarning(500, $row->getError());
		}
		
		$this->setMessage('Settings Saved');
		$this->setRedirect('index.php?option=' . $option . '&task=settings');
	}
	
}

?>