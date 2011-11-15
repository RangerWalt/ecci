<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<?php
	$headerstyle    	= $this->params->get("headerstyle", "graphic");
	$headline     		= $this->params->get("headline", "Weblogic");
	$menutype			= $this->params->get("menutype", "dropline");
	$menuname			= $this->params->get("menuname", "mainmenu");
	$browserwidth    	= $this->params->get("browserwidth", "fixed");
	$teaser_height     	= $this->params->get("teaser_height", "161px"); 
	$left_column      	= $this->params->get("left_column", "275px");
	$right_column      	= $this->params->get("right_column", "200px");
	$split_layout   	= $this->params->get("split_layout", "NEWS");
	$showpathway		= ($this->params->get("showpathway", 1)  == 0)?"false":"true";
?>
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/template_css.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<?php if($menutype=="suckerfish") :?>
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/suckerfish.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/ie_suckerfish.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<?php endif; ?>

<?php if($menutype=="dropline") :?>
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/dropline.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/ie_dropline.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<?php endif; ?>

<?php if($browserwidth=="fluid") :?>
<style type = "text/css">
table#main {width:95%; background-image:none; border-left:1px solid #ccc;border-right:1px solid #ccc;}
#top-wrapper {width:95%;}
#footer {width:95%;}
</style>
<?php endif; ?>

<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/ie_hacks.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->

<!--[if lte IE 6]>
<style type="text/css">
<link href="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/css/ie_hacks.css" rel="stylesheet" type="text/css" media="screen" />
#teaser img { behavior: url(<?php echo $this->template?>/css/iepngfix.htc); }
</style>
<![endif]-->

<script type="text/javascript" src="<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/js/mootools.js"></script>
</head>

<body id="page_bg">


<div id="top-wrapper">
<div id="header-top"><jdoc:include type="modules" name="user3" style="none" /></div>
<div id="searchbar"><jdoc:include type="modules" name="user4" style="none" /></div>

<div id="header-<?php echo $headerstyle; ?>">
<h1><a href="<?php echo JURI::base(); ?>" title="<?php echo $headline; ?>"><?php echo $headline; ?></a></h1>
</div>
	<div id="navcontainer">
		<div id="navbar">
<!--[if lte IE 7]>
		<script type="text/javascript">
		sfHover = function() {
			var sfEls = document.getElementById("navbar").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++) {
				sfEls[i].onmouseover=function() {
					this.className+=" sfhover";
				}
				sfEls[i].onmouseout=function() {
					this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
				}
			}
		}
		if (window.attachEvent) window.attachEvent("onload", sfHover);
		</script>
<![endif]-->
	<jdoc:include type="modules" name="menu" style="none" />
		</div>
	</div>
</div>
<?  //banner
	$secid = JRequest::getVar( 'Itemid', 0 );
	if($secid==1) $banner = "teasertraining";
	else if($secid==74) $banner = "teaserpubtraining";
	else if($secid==75) $banner = "teasernews";
	else if($secid==69 ) $banner = "teaserservices";

	else if($secid==64 || $secid==65 || $secid==66 || $secid==67 || $secid==68  )$banner = "teaseraboutus";
	else if($secid==95 || $secid==96|| $secid==97 || $secid==98  )$banner = "teaseraboutus";
	else if($secid==63 || $secid==135 || $secid==136 || $secid==137 || $secid==138) $banner = "teasercontactus";
	else if($secid==80 || $secid==385 || $secid==386 || $secid==387) $banner ="teaserclients";
	else if($secid==79 || $secid==81 || $secid==82 || $secid==83 || $secid==92 || $secid==93 || $secid==83) $banner ="teaserpartners";
	else if($secid==247 )$banner = "teasertrainingsignup";
	else if($secid==61 )$banner = "teaserdownloads";
	else if($secid==60 )$banner = "teasercareers";

	else if($secid==70 ||  $secid==141 ||  $secid==85 ||  $secid==699)$banner = "teaserserviceconsulting";
	else if($secid==388 || $secid==392 || $secid==299 || $secid==300 || $secid==301 || $secid==396 || $secid==182) $banner = "teaserserviceconsulting";
	else if($secid==400 || $secid==392  || $secid==373 || $secid==369  || $secid==420 || $secid==412 || $secid==732) $banner = "teaserserviceconsulting";
	else if($secid>=282 && $secid<=284)$banner = "teaserserviceconsulting";
	else if($secid>=286 && $secid<=301)$banner = "teaserserviceconsulting";
	else if($secid>=353 && $secid<=360)$banner = "teaserserviceconsulting";
	else if($secid>=223 && $secid<=226)$banner = "teaserserviceconsulting";
	else if($secid>=288 && $secid<=290)$banner = "teaserserviceconsulting";
	else if($secid>=483 && $secid<=490)$banner = "teaserserviceconsulting";
	else if($secid>=472&& $secid<=479)$banner = "teaserserviceconsulting";
	else if($secid>=494&& $secid<=501)$banner = "teaserserviceconsulting";
	else if($secid>=291&& $secid<=293)$banner = "teaserserviceconsulting";
	else if($secid>=824&& $secid<=834)$banner = "teaserserviceconsulting";
	else if($secid>=519&& $secid<=529)$banner = "teaserserviceconsulting";
	else if($secid>=533&& $secid<=543)$banner = "teaserserviceconsulting";
	else if($secid>=547&& $secid<=557)$banner = "teaserserviceconsulting";
	else if($secid>=561&& $secid<=571)$banner = "teaserserviceconsulting";
	else if($secid>=575&& $secid<=585)$banner = "teaserserviceconsulting";
	else if($secid>=377&& $secid<=379)$banner = "teaserserviceconsulting";	
	//main menu
	else if($secid>=99&& $secid<=111)$banner = "teaserserviceconsulting";	
		
	//main menu training
	else if($secid==71) $banner = "teaserservicetraining";
	else if($secid>=112 && $secid<=119)$banner = "teaserservicetraining";
	else if($secid>=242 && $secid<=246)$banner = "teaserservicetraining";
	
	else if($secid==469 || $secid==366  || $secid==281  || $secid==409 || $secid==644 || $secid==628 || $secid==652  || $secid==664  || $secid==676 || $secid==688 || $secid==700)$banner = "teaserservicetraining";
	else if($secid==413 || $secid==711 || $secid==722 || $secid==733 || $secid==744 || $secid==755 || $secid==374 || $secid==285) $banner = "teaserservicetraining";
	else if($secid==421 || $secid==370 || $secid==361) $banner = "teaserservicetraining";
	else if($secid>=269 && $secid<=278)$banner = "teaserservicetraining";
	else if($secid>=619 && $secid<=626)$banner = "teaserservicetraining";
	else if($secid>=643 && $secid<=650)$banner = "teaserservicetraining";
	else if($secid>=665 && $secid<=662)$banner = "teaserservicetraining";
	else if($secid>=667 && $secid<=674)$banner = "teaserservicetraining";
	else if($secid>=679 && $secid<=686)$banner = "teaserservicetraining";
	else if($secid>=691 && $secid<=698)$banner = "teaserservicetraining";
	else if($secid>=281 && $secid<=287)$banner = "teaserservicetraining";
	else if($secid>=703 && $secid<=709)$banner = "teaserservicetraining";
	else if($secid>=714 && $secid<=720)$banner = "teaserservicetraining";
	else if($secid>=725 && $secid<=731)$banner = "teaserservicetraining";
	else if($secid>=736 && $secid<=742)$banner = "teaserservicetraining";
	else if($secid>=747 && $secid<=753)$banner = "teaserservicetraining";
	
	//main menu
	else if($secid>=120 && $secid<=124)$banner = "teaserserviceassessment";
	
	else if($secid==403 || $secid==376 || $secid==245 || $secid==444 || $secid==453 || $secid==462  || $secid==471)$banner = "teaserserviceassessment";
	else if($secid==368 || $secid==364 || $secid==372 || $secid==399) $banner = "teaserserviceassessment";
	else if($secid>=237 && $secid<=241)$banner = "teaserserviceassessment";
	else if($secid>=328 && $secid<=332)$banner = "teaserserviceassessment";
	else if($secid>=436 && $secid<=440)$banner = "teaserserviceassessment";
	else if($secid>=445 && $secid<=449)$banner = "teaserserviceassessment";
	else if($secid>=454 && $secid<=458)$banner = "teaserserviceassessment";
	else if($secid>=463 && $secid<=467)$banner = "teaserserviceassessment";
	
	else if($secid==72 || $secid==427 || $secid==423|| $secid==419 || $secid==772 || $secid==371 || $secid==757  || $secid==779 || $secid==768 || $secid==790 || $secid==812  || $secid==823 || $secid==431)$banner = "teaserservicemanaged";
	else if($secid==665 || $secid==367 || $secid==375 || $secid==363 || $secid==653) $banner = "teaserservicemanaged";
	else if($secid>=125 && $secid<=134)$banner = "teaserservicemanaged";
	
	else if($secid>=302 && $secid<=309)$banner = "teaserservicemanaged";
	else if($secid>=310 && $secid<=316)$banner = "teaserservicemanaged";
	else if($secid>=768 && $secid<=775)$banner = "teaserservicemanaged";
	else if($secid>=758 && $secid<=764)$banner = "teaserservicemanaged";
	else if($secid>=780&& $secid<=786)$banner = "teaserservicemanaged";
	else if($secid>=317&& $secid<=323)$banner = "teaserservicemanaged";
	else if($secid>=801 && $secid<=808)$banner = "teaserservicemanaged";
	else if($secid>=791 && $secid<=797)$banner = "teaserservicemanaged";
	else if($secid>=813 && $secid<=819)$banner = "teaserservicemanaged";
	else if($secid>=324 && $secid<=327)$banner = "teaserservicemanaged";
	else
	{
		$banner = "teaser";
	}
?>	

<?php //if ($this->countModules('icon')) : ?>
	<div id="teaser-wrapper">
		<div id="<?=$banner?>" style="height:<?php echo $teaser_height; ?>">
		<jdoc:include type="modules" name="icon" style="none" />
		<? /*echo"<script>alert('$secid');</script>"; */?>
		</div>
	</div>
	<div class="clear"></div>
<?php // endif; ?>


<?php if ($this->countModules('icon')) {
echo "<div id=\"teaser-bottom-$menutype\"></div>";}
else {
echo "<div id=\"teaser-bottom-module-$menutype\"></div>";
}?>


<div class="clear"></div>
<table id="main">
 <tr>

<!-- NEWS STYLE -->
<?php if($split_layout=="NEWS") :?>
	<td id="content">
	<?php if ($showpathway == "true") : ?>
	<div id="pathway"><jdoc:include type="module" name="breadcrumbs" style="none" /></div>
	<?php endif; ?>
	<div class="inside">
	
		<jdoc:include type="message" />
		<jdoc:include type="component" />
	</div>
</td>
<?php if ($this->countModules('left')) : ?>
	<td id="leftcol" style="width:<?php echo $left_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 0px 0px;">
		<div class="inside"><jdoc:include type="modules" name="left" style="xhtml" /></div>
	</td>
<?php endif; ?>
<?php if ($this->countModules('right')) : ?>
	<td id="rightcol" rowspan="2" style="width:<?php echo $right_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 0px 0px;">
		<div class="inside"><jdoc:include type="modules" name="right" style="xhtml" /></div>
	</td>
<?php endif; ?>
<?php endif; ?>
<!-- END NEWS STYLE -->

<!-- BLOG STYLE -->
<?php if ($split_layout=="BLOG") :?>
<?php if ($this->countModules('left')) : ?>
	<td id="leftcol" style="width:<?php echo $left_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 100% 0%;">
		<div class="inside"><jdoc:include type="modules" name="left" style="xhtml" /></div>
	</td>
<?php endif; ?>
<?php if ($this->countModules('right')) : ?>
	<td id="rightcol" style="width:<?php echo $right_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 100% 0%;">
		<div class="inside"><jdoc:include type="modules" name="right" style="xhtml" /></div>
	</td>
<?php endif; ?>
	<td id="content">
	<?php if ($showpathway == "true") : ?>
	<div id="pathway"><jdoc:include type="module" name="breadcrumbs" style="none" /></div>
	<?php endif; ?>
	<div class="inside">
			<?php if ($this->countModules('banner')) : ?>
				<div id="banner"><jdoc:include type="modules" name="banner" style="none" /></div>
			<?php endif; ?>
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</div>
</td>
<?php endif; ?>
<!-- END BLOG STYLE -->

<!-- PORTAL STYLE -->
<?php if ($split_layout=="PORTAL") :?>

<?php if ($this->countModules('left')) : ?>
	<td id="leftcol"  style="width:<?php echo $left_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 100% 0%;">
		<div class="inside">
			<jdoc:include type="modules" name="left" style="xhtml" />
		</div>
	</td>
<?php endif; ?>
<td id="content">
<?php if ($showpathway == "true") : ?>
<div id="pathway"><jdoc:include type="module" name="breadcrumbs" style="none" /></div>
<?php endif; ?>
	<div class="inside">
		<?php if ($this->countModules('banner')) : ?>
				<!--<div id="banner"><jdoc:include type="modules" name="banner" style="none" /></div> -->
		<?php endif; ?>
		<jdoc:include type="message" />
		<jdoc:include type="component" />
	</div>
</td>
<?php if ($this->countModules('right')) : ?>
	<td id="rightcol"  style="width:<?php echo $right_column; ?>; background-image: url(<?php echo $this->baseurl;?>/templates/<?php echo $this->template;?>/images/module_divider.png); background-repeat: repeat-y;background-position: 0px 0px;">
		<div class="inside"><jdoc:include type="modules" name="right" style="xhtml" /></div>
	</td>
<?php endif; ?>
<?php endif; ?>
<!-- END PORTAL STYLE -->


</tr>
<tr>
<td valign="top">

<?php if($this->countModules('user6') or $this->countModules('user7') or $this->countModules('user8')) : ?>
<?php $footermodulecount = $this->countModules('user6') + $this->countModules('user7') + $this->countModules('user8');

if ($footermodulecount == "1"){
	$tdwidth = "100%";
} elseif($footermodulecount == "2"){
	$tdwidth = "50%";
} elseif($footermodulecount == "3"){
	$tdwidth = "50%";
}
?>
<div id="footer" style="width:100%; position:relative; float:left; left:0px; padding-bottom:10px;">
	<div id="inner-wrap" style="width:100%; height:100%">
		<table width="600px" border="0" height="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<?php if ($this->countModules('user6')) : ?>
		    <td style="width:<?php echo $tdwidth; ?>;padding:5px; vertical-align:top; border-right: dashed 1px #e2e2e2;"><jdoc:include type="modules" name="user6" style="xhtml" /></td>
			<?php endif; ?>
			<?php if ($this->countModules('user7')) : ?>
		    <td style="width:<?php echo $tdwidth; ?>;padding:5px; vertical-align:top;"><jdoc:include type="modules" name="user7" style="xhtml" /></td>
			<?php endif; ?>
			<?php if ($this->countModules('user8')) : ?>
		    <td style="width:<?php echo $tdwidth; ?>;padding:5px; vertical-align:top;">
			<jdoc:include type="modules" name="user8" style="xhtml" /></td>
			<?php endif; ?>
		  </tr>
		  <tr><td colspan="3"><br />
				<table align="center" >
					<tr><td colspan="">
					<?php if ($this->countModules('banner')) : ?>
						<div id="banner"><jdoc:include type="modules" name="banner" style="none" /></div>
					<?php endif; ?>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td colspan="">
						<?php if ($this->countModules('banner2')) : ?>
							<div id="banner2"><jdoc:include type="modules" name="banner" style="none" /></div>
						<?php endif; ?>
					</td>	
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td colspan="">
						<?php if ($this->countModules('banner3')) : ?>
							<div id="banner3"><jdoc:include type="modules" name="banner" style="none" /></div>
						<?php endif; ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div><!-- /inner-wrap -->
</div><!-- /footer -->
<?php endif; ?>


</td></tr>
<tr><td colspan="3">
<div class="copyright" style="text-align:right; background:#003300; color:#fff; padding:3px;" >Copyright &copy; <?=date('Y');?> ECC International
	&nbsp;&nbsp; | &nbsp; &nbsp; <a href="index.php?option=com_content&view=article&id=126" style="color:#fff">Terms of Use</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="index.php?option=com_content&view=article&id=127" style="color:#fff">Privacy Policy</a> &nbsp; &nbsp;
	| &nbsp; &nbsp; <a href="index.php?option=com_joomap" style="color:#fff">Site Map</a> &nbsp; &nbsp;
<?php // require(YOURBASEPATH .DS."/js/template.css.php"); ?></div>

</td></tr>
</table>

</body>
</html>