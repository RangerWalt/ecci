<?php
/**
 *
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: rd_rss.class.php 33 2007-09-25 15:17:27Z deutz $
 * @package RdRss
 * @subpackage mambo_4_6_2
 *
 * This is free software
 *
 * normal syndicate component changed to show all sections and categories as rss feed
 **/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//
// Classdefinition
//

class rdRssData extends mosDBTable {
	var $id 					= null; 	// int(11) unsigned NOT NULL auto_increment
	var $name					= "";		// varchar(255) not null
	var $catids					= "";		// text
	var $published				= "0";  	// tinyint(1)
	var $created				= "";  		// datetime NOT NULL default '0000-00-00 00:00:00'
	var $created_by      		= ""; 		// int(11) unsigned
	var $modified				= "";  		// datetime NOT NULL default '0000-00-00 00:00:00'
	var $modified_by      		= ""; 		// int(11) unsigned
	var $checked_out_time		= "";  		// datetime NOT NULL default '0000-00-00 00:00:00'
	var $checked_out      		= ""; 		// int(11) unsigned
	var $state  	     		= "0"; 		// tinyint(3) NOT NULL default '0'
	var $params					= "";		// text

	function rdRssData( &$_db ) {
		$this->mosDBTable( '#__rd_rss', 'id', $_db );
	}

	function delete($oid=null) {
		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		//$this->_db->setQuery( "UPDATE $this->_tbl set status = '1' WHERE $this->_tbl_key = '".$this->$k."'" );
		$this->_db->setQuery( "DELETE FROM $this->_tbl WHERE $this->_tbl_key = '".$this->$k."'" );
		if ($this->_db->query()) {
			return true;
		} else {
			$this->_error = $this->_db->getErrorMsg();
			return false;
		}
	}
}

/** EOF **/?>