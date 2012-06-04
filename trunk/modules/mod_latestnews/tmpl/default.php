<style>
.new_black .black a{
	color:black !important;
}
.new_black .black a:hover{
	color:black !important;
	text-decoration: underline  !important;
}
.new_black .black {
	color:black !important;
}
</style>
<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<ul class="">
<?php foreach ($list as $k=>$item) :  ?>
	<li class="latestnews <?php echo !$k ?"ico_news":""?> black" style="padding-right: 20px">
		<a href="<?php echo $item->link; ?>" class="latestnews">
			<?php echo $item->text; ?></a>
	</li>
<?php endforeach; ?>
</ul>