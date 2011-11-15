<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = explode( '=', _ISO );

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<?php
if ( $my->id ) {
	initEditor();
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/theme030/css/template_css.css" rel="stylesheet" type="text/css" />
<link href="css/template_css.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="tail">	
	<div class="main">
		<div id="logo">
			<a href="index.php"><img src="<?php echo $mosConfig_live_site;?>/templates/theme030/images/logo.gif" alt="" /></a>
		</div>
		<div id="topmenu">
			<?php mosLoadModules('user3', -1);?>
		</div>
		<div id="header">
			<a href="#"><img src="<?php echo $mosConfig_live_site;?>/templates/theme030/images/header_t.gif" alt="" /></a>
		</div>
		<div id="content">
			<table class="shadow">
				<tr>
					<td class="c1">
						<div id="pathway">
							<div class="space">
								<?php mosPathWay(); ?>
							</div>
						</div>
						<div class="c_tl">
							<div class="c_bl">
								<div class="space">
									<?php if (mosCountModules (user1) and mosCountModules (user2)) {?>
									<table>
										<tr>
											<td class="user1">
												<div class="user_bg"><?php mosLoadModules('user1', -3);?></div>
											</td>
											<td><div class="column_separator"></div></td>
											<td class="user2">
												<div class="user_bg"><?php mosLoadModules('user2', -3);?></div>
											</td>
										</tr>
									</table>
									<?php } ?>
									<?php mosMainBody(); ?>
									<div id="banner">
										<?php mosLoadModules('banner', -1);?>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td><div class="column_separator">&nbsp;</div></td>
					<td>
						<div class="c2">
							<?php mosLoadModules('user4', -1);?>
							<?php mosLoadModules('right', -3);?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div id="footer">
	<div class="main">
		<div class="space">
			<?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?>
		</div>
	</div>
</div>

<?php mosLoadModules('debug', -1);?>
</body>
</html>

