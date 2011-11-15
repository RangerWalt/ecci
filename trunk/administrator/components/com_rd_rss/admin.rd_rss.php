<?php
/**
 *
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: admin.rd_rss.php 34 2007-09-25 20:11:37Z deutz $
 * @package RdRss
 * @subpackage mambo_4_6_2
 *
 * This is free software
 *
 * normal syndicate component changed to show all sections and categories as rss feed
 **/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

define('_COMP_NAME','com_rd_rss');
define('_COMP_VERSION','1.0RC1');

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' ) | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_contact' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path.'/administrator/components/'._COMP_NAME.'/languages/'.$mosConfig_lang.'_admin.php')) {
  include_once($mosConfig_absolute_path.'/administrator/components/'._COMP_NAME.'/languages/'.$mosConfig_lang.'_admin.php');
} else {
  include_once($mosConfig_absolute_path.'/administrator/components/'._COMP_NAME.'/languages/english_admin.php');
}


// Include the admin.[componentname].html.php
require_once( $mainframe->getPath( 'admin_html' ) );

// Include the [componetename].class.php from JOOMLAROOT/components/com_[componentname]/
require_once( $mainframe->getPath( 'class' ) );


$id = mosGetParam( $_REQUEST, 'id', '' );
$cid = mosGetParam( $_REQUEST, 'cid', array(0) );

if (!is_array( $cid )) {
	$cid = array(0);
}


switch ($task) {

	case "save":
		rdRss::save( $option );
		break;

 	case "cancel":
		rdRss::cancel($option, $task, $id );
		break;

	case "apply":
		$id = rdRss::save( $option, $task, 0 );
	case "new":
	case "edit":
	case "editA":
		rdRss::edit($option, $task, $id);
		break;

	case "del":
		rdRss::del( $option, $section, $task, $cid );
		break;

	case "publish":
		rdRss::changePublished( $cid, 1, $option, $task );
		break;

	case "unpublish":
		rdRss::changePublished( $cid, 0, $option, $task );
		break;

	case "list":
	default:
		rdRss::show( $option,'list' );
		break;
}

class rdRss {

	// ---------------------------------------------------------------
	/**
	*
	* @param $option
	*/
	function changePublished( $cid=null, $state=0, $option, $task )
	{
		global $database, $my;

		if (count( $cid ) < 1) {
			$action = $state == 1 ? _RDRSS_PUBLISHED : _RDRSS_UNPUBLISHED;
			echo "<script> alert('"._RDRSS_SELITEM." $action'); window.history.go(-1);</script>\n";
			exit;
		}
		$search = mosGetParam( $_REQUEST, 'search', '' );

		$total = count ( $cid );
		$cids = implode( ',', $cid );

		$query = "UPDATE #__rd_rss"
		. "\n SET published = $state"
		. "\n WHERE id IN ( $cids ) AND ( checked_out = 0 OR (checked_out = $my->id ) )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (count( $cid ) == 1) {
			$row = new rdRssData( $database );
			$row->checkin( $cid[0] );
		}

		if ( $state == "1" ) {
			$msg = $total . _RDRSS_ITEMSP;
		} else if ( $state == "0" ) {
			$msg = $total . _RDRSS_ITEMSUP;
		}

		mosRedirect( 'index2.php?option='. $option . '&amp;task=list&amp;search='. $search . '&mosmsg='. $msg );
	}
	// ---------------------------------------------------------------
	/**
	*
	* @param $option
	*/
	function show( $option, $task ) {
		global $database, $mainframe, $mosConfig_list_limit;
		require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );

		$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
		$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

		$search = mosGetParam( $_REQUEST, 'search', '' );

		$filter = "";
		if ($search) {
			$filter .= "WHERE name like '%$search%'";
		}

		// get the total number of records
		$database->setQuery( "SELECT count(*) FROM #__rd_rss $filter");

		$total = $database->loadResult();

		$pageNav = new mosPageNav( $total, $limitstart, $limit );

		$query = "SELECT * "
		. "\n  FROM  #__rd_rss "
		. "\n $filter "
		. "\n ORDER BY name "
		. "\n LIMIT $pageNav->limitstart,$pageNav->limit"
		;
		$database->setQuery( $query );
		$rows = $database->loadObjectList();

		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		HtmlRdRss::show( $option,  $task, $rows, $pageNav, $search );
	}
	// ---------------------------------------------------------------
	/**
	* edit a records
	* @param string The current GET/POST option
	*/
	function edit( $option, $task, $id ) {
		global $database,$mosConfig_absolute_path;

		$row = new rdRssData( $database );
		$row->load( $id );

		// fail if checked out not by 'me'
		if ($row->checked_out && $row->checked_out <> $my->id) {
			mosRedirect( 'index2.php?option='. $option, _RDRSS_TI . $row->name . _RDRSS_EAA );
		}
		$lookup 			= '';
		if ($id) {
			$catids=$row->catids;
			if ( $catids ) {
				$query = "SELECT c.id AS `value`, c.section AS `id`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
				. "\n FROM #__sections AS s"
				. "\n INNER JOIN #__categories AS c ON c.section = s.id"
				. "\n WHERE s.scope = 'content'"
				. "\n AND c.id IN ( $catids )"
				. "\n ORDER BY s.name,c.name"
				;
				$database->setQuery( $query );
				$lookup = $database->loadObjectList();
			}

		}
		// build the html select list for category
		$category[] = mosHTML::makeOption( '', _RDRSS_ALLCATS );
		$query = "SELECT c.id AS `value`, c.section AS `id`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
		. "\n FROM #__sections AS s"
		. "\n INNER JOIN #__categories AS c ON c.section = s.id"
		. "\n WHERE s.scope = 'content'"
		. "\n ORDER BY s.name,c.name"
		;
		$database->setQuery( $query );
		$category = array_merge( $category, $database->loadObjectList() );
		$category = mosHTML::selectList( $category, 'catid[]', 'class="inputbox" size="10" multiple="multiple"', 'value', 'text', $lookup );
		$lists['catids'] = $category;
		if ($id == '1') {
			$params =& new mosAdminParameters( $row->params, $mosConfig_absolute_path.'/administrator/components/'._COMP_NAME.'/rd_xf_config_xml', 'component' );
		} else {
			$params =& new mosAdminParameters( $row->params, $mosConfig_absolute_path.'/administrator/components/'._COMP_NAME.'/rd_x_config_xml', 'component' );
		}
		HtmlRdRss::edit($option, $task, $id, $row, $params, $lists);
	}
	// ---------------------------------------------------------------
	/**
	*
	* @param $option
	*/
	function del($option, $section, $task, $cid) {
		global $database;

		foreach ($cid as $elm) {
			if ($elm != '1') {
				$row = new rdRssData( $database );
				$row->load( $elm );
				$row->delete();
			} else {
				$noway = 1;
			}
		}
		if ($noway) {
			mosRedirect( "index2.php?option=$option&amp;task=list", _RDRSS_FCNBD );
		} else {
			mosRedirect( "index2.php?option=$option&amp;task=list" );
		}
	}
	// ---------------------------------------------------------------
	/**
	*
	* @param $option
	*/
	function cancel($option, $task, $id ) {
		global $database;
		if ($id) {
			$row = new rdRssData( $database );
			$row->load( $id );
			$row->checkin();
		}

		mosRedirect( "index2.php?option=$option&amp;task=list" );
	}
	// ---------------------------------------------------------------
	/**
	*
	* @param $option
	*/
	function save($option, $section, $task, $redirect=1) {
		global $database, $mainframe,$my;

		$row = new rdRssData( $database );
		if (!$row->bind( $_POST )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$params = mosGetParam( $_POST, 'params', '' );
		if (is_array( $params )) {
			$txt = array();
			foreach ( $params as $k=>$v) {
				$txt[] = "$k=$v";
			}
			$row->params = implode( "\n", $txt );
		}
		$catids	= mosGetParam( $_POST, 'catid', array() );
		$row->catids	= implode( ',', $catids );

		$isNew = ($row->id < 1);
		if ($isNew) {

			$row->created			= $row->created ? $row->created : date( "Y-m-d H:i:s" );
			$row->created_by 		= $row->created_by ? $row->created_by : $my->id;
			$row->modified 			= date( "Y-m-d H:i:s" );
			$row->modified_by 		= $my->id;
		} else {
			$row->modified 			= date( "Y-m-d H:i:s" );
			$row->modified_by 		= $my->id;
			$row->checkin();
		}

		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$msg = $row->name . _RDRSS_SCSA;
		if ($redirect) {
			mosRedirect( "index2.php?option=$option&amp;task=list", $msg );
		} else {
			return $row->id;
		}
	}

}
?>