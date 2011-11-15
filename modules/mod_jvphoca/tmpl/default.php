<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id ="jvphoca_module" style="text-align:center;float: left; width: 100%;">
<?php foreach ($outputs as $output) { ?>
<div style="width: <?php echo $box_width; ?>%;<?php if ($layout != 1) echo 'float: left;';  ?>"><?php echo $output ?></div>
<?php } ?>
<?php 
if ($overview) {
?>
<div style="text-align: center;clear: both;">
    <a href="index.php?option=com_phocagallery&Itemid=<?php echo $Itemid; ?>" title="<?php echo $overview_text; ?>"><?php echo $overview_text; ?></a>
</div>
<?php    
}
?>
</div>
<div style="clear:both"></div>

