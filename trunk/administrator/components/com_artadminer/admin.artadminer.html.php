<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class HTML_ArtAdminer {
	
	function settings($option, &$row) {
		HTML_ArtAdminer::setSettingsToolbar();
		
		?>
		<form action="index.php" method="post" name="adminForm">
			<div class="col100" id="editForm">
			<fieldset class="adminform">
			<table class="admintable">
				<tbody>
					<tr>
						<td width="20%" class="key" title="CSS file. Default values: adminer1.css, adminer2.css, adminer3.css">
							<label for="cssfile">CSS file</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="cssfile" id="cssfile" size="40" maxlength="255" value="<?php echo $row->cssfile; ?>" />
						</td>
					</tr>
					<tr>
						<td width="20%" class="key" title="Auto login. When set adminer will automatically connect to database using credentials stored in Joomla!">
							<label for="autologin">Auto login</label>
						</td>
						<td>
							<?php echo JHTML::_('select.booleanlist',  'autologin', '', $row->autologin ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="task" value="settings" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="id" value="1" />
		</form>
		<?php
	}
	
	function adminer($option) {
		HTML_ArtAdminer::setAdminerToolbar();
		$row =& JTable::getInstance('artadminer_setting', 'Table');
					
		$row->load(1);
		$adminerUrl = JURI::base() . 'components/' . $option . '/adminer.php?cssfile=' . JURI::base() . 'components/com_artadminer/css/' . $row->cssfile;
		$cfg = new JConfig();
		if ($row->autologin) {
			$adminerUrl .= '&server=' . $cfg->host . '&username=' . $cfg->user . '&password=' . $cfg->password;
		}
		
		?>
		<iframe style="width:100%;height:1630px; border: none;" src="<?php echo $adminerUrl; ?>"></iframe>
		<?php
	}

	function setAdminerToolbar() {
	}
	
	function setSettingsToolbar() {
		JToolBarHelper::title('Settings', 'config.png');
		JToolBarHelper::custom('settings_save', 'save.png', 'default.png', 'Save', false);
		JToolBarHelper::custom('settings', 'cancel.png', 'default.png', 'Cancel', false);
	}
	
}


?>