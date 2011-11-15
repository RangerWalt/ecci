<?php
/**
 *
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: admin.rd_rss.html.php 33 2007-09-25 15:17:27Z deutz $
 * @package RdRss
 * @subpackage mambo_4_6_2
 *
 * This is free software
 *
 * normal syndicate component changed to show all sections and categories as rss feed
 **/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @package Joomla
* @subpackage Syndicate
*/
class HtmlRdRss {

	function show($option, $task, $rows, $pageNav, $search)
	{
		global $my, $mosConfig_live_site;

		mosCommonHTML::loadOverlib();

		echo "<form action=\"index2.php\" method=\"post\" name=\"adminForm\">";

		echo "<table class=\"adminheading\">";
		echo "<tr><th class=\"addedit\" rowspan=\"2\">"._RDRSS_ITEM."</th>";
		echo "<td colspan=\"2\" align=\"right\"></td></tr>";
		echo "<tr><td>Filter:</td><td> <input type=\"text\" name=\"search\" value=\"" . $search . "\" class=\"text_area\" onChange=\"document.adminForm.submit();\" />";
		echo "</td></tr></table>";

		echo "<table class=\"adminlist\"><tr>";
		echo "<th width=\"5\">";
		echo "<input type=\"checkbox\" name=\"toggle\" value=\"\" onClick=\"checkAll(" . count( $rows ) . ");\" />";
		echo "</th><th class=\"title\" >"._RDRSS_NAME;
		echo "</th><th class=\"title\" >"._RDRSS_URL;
 		echo "</th><th class=\"title\" >"._RDRSS_PUBLISHED;
		echo "</th><th class=\"title\" >"._RDRSS_ID;
		echo "</th></tr>";

		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$checked = mosCommonHTML::CheckedOutProcessing( $row, $i );
			$link = 'index2.php?option='.$option.'&amp;task=edit&amp;hidemainmenu=1&amp;id='. $row->id;

			if ( $row->published ) {
				$img = 'publish_g.png';
				$alt = _RDRSS_PUBLISHED;
				$todo = 'unpublish';
			} else {
				$img = 'publish_x.png';
				$alt = _RDRSS_UNPUBLISHED;
				$todo = 'publish';
			}


			echo "<tr class=\"row" .$k ."\"><td>";
			echo $checked;
			echo "</td><td>";

			if ( $row->checked_out && $row->checked_out != $my->id   ) {
				echo $row->name;
			} else {
				echo '<a href="' . $link. '" title="'.$row->name.'">';
				echo htmlspecialchars($row->name, ENT_QUOTES);
				echo "</a>";
			}
			echo "</td>";
			echo "<td>";
			echo $mosConfig_live_site . '/index.php?option=com_rd_rss&amp;id='.$row->id;
			echo "</td>";
			echo "<td>";

			echo "<a href=\"javascript: void(0);\"  onClick=\"return listItemTask('cb$i','$todo')\">";
			echo "<img src=\"images/$img\" width=\"12\" height=\"12\" border=\"0\" alt=\"$alt\" />";

			echo "</td>";
			echo "<td>";
			echo $row->id;
			echo "</td>";

			echo "</tr>";
			$k = 1 - $k;
		}
		echo "</table>";
		echo $pageNav->getListFooter();

		echo "<input type=\"hidden\" name=\"option\" value=\"".$option."\" />";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
		echo "<input type=\"hidden\" name=\"hidemainmenu\" value=\"0\" />";

		echo "</form><br />";
	}


	function edit ($option,  $task, $id, $row, $params,$lists)
	{
		global $mosConfig_live_site;

		mosCommonHTML::loadOverlib();
		mosCommonHTML::loadCalendar();

		echo "<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "	function submitbutton(pressbutton) {\n";
		echo "		var form = document.adminForm;\n";
		echo "		if (pressbutton != '') {\n";
		echo "			if (pressbutton == 'cancel') {\n";
		echo "				submitform( pressbutton );\n";
		echo "			} else {\n";
		echo "				// do field validation \n";
		echo "				if (form.name.value == \"\"){\n";
		echo "					alert( \"Item must have a name\" );\n";
		echo "				} else {\n";
		echo "\n				submitform( pressbutton );\n";
		echo "				}\n";
		echo "			}\n";
		echo "		}\n";
		echo "	}\n";
		echo "//-->\n";
		echo "</script>\n";


		echo "<form action=\"index2.php\" method=\"post\" name=\"adminForm\">\n";
		$id = $row->id;
		echo "<table class=\"adminheading\"><tr><th>";
		echo $id ? 'Edit ' : 'Add '; echo _RDRSS_ITEM;
		echo "</th></tr></table>";
		echo "<p>";
		echo "</p>";

		echo "<table cellspacing=\"2\" cellpadding=\"0\" width=\"100%\">";
		echo "<tr><td width=\"100%\" valign=\"top\">";

			echo "<table class=\"adminform\"><tr><th colspan=\"2\" >";
			echo _RDRSS_SETTINGS;
			echo "</th></tr>";

			echo "<tr><td valign=\"top\" align=\"right\" width=\"40%\">";
			echo _RDRSS_NAME;
			echo "</td><td>";
			echo "<input type=\"text\" name=\"name\" size=\"50\" maxlength=\"255\" value=\"" . $row->name . "\" class=\"text_area\" />";
			echo "</td></tr>";

			echo "<tr><td valign=\"top\" align=\"right\">";
			echo _RDRSS_PUBLISHED;
			echo "</td><td>";
			echo "<input type=\"checkbox\" name=\"published\" value=\"1\""; echo $row->published ? 'checked="checked"' : ''; echo "  />";
			echo "</td></tr>";

			echo "<tr><td valign=\"top\" align=\"right\" width=\"40%\">";
			echo _RDRSS_CATEGORY;
			echo "</td><td>";
			echo $lists['catids'];
			echo "</td></tr>";

			echo "</table>";

			echo "<table class=\"adminform\"><tr><th colspan=\"2\">";
			echo _RDRSS_PARAMETERS;
			echo "</th></tr>";

			echo "<tr><td valign=\"top\" colspan=\"2\">";
			echo $params->render();
			echo "</td></tr>";

			echo "</table>";

		echo "</td></tr>";
		echo "</table>";

		echo "<input type=\"hidden\" name=\"created\" value=\"".$row->created."\" />";
		echo "<input type=\"hidden\" name=\"created_by\" value=\"".$row->created_by."\" />";
		echo "<input type=\"hidden\" name=\"modified\" value=\"".$row->modified."\" />";
		echo "<input type=\"hidden\" name=\"modified_by\" value=\"".$row->modified_by."\" />";
		echo "<input type=\"hidden\" name=\"id\" value=\"".$row->id."\" />";
		echo "<input type=\"hidden\" name=\"option\" value=\"".$option."\" />";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
		echo "<input type=\"hidden\" name=\"hidemainmenu\" value=\"0\" />";

		echo "</form><br />";
	}
}
?>