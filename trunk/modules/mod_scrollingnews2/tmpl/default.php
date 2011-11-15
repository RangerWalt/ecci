<?php // no direct access
function html_image_daniele($html,$link,$titolo){
 	if (strlen($html)>300){
 		$i=300;
	   	while(substr( $html,$i,1)!=' '){
	   	 	$i--;
	  	}
	   	$html = substr( $html,0,$i).'...';
	}
	$link="<a href='$link' style='font-size:120%;font-weight:bold'>".$titolo."</a>";
 	$html="<table width=100%>
	 <tr><td style='height:15px;background-color:#eee'>$link</td></tr>
	 <tr><td style='margin-top:5px' VALIGN=TOP>$html</td></tr>
			 </table>";
	return $html;
}

defined('_JEXEC') or die('Restricted access'); 

$show_front	= $params->get( 'show_front', 1 );
$show_titolo= $params->get( 'show_titolo', 0 );
$load_jq 	= $params->get( 'jQuery', 1 );
$img_width  = $params->get( 'img_width', 128 );
$img_float  = $params->get( 'img_float', 'float:left;' );
$scroll_direction = $params->get( 'scroll-direction', 'horizontal' );
$scriviLabel = $params->get( 'scriviLabel', '1' );
$labelPosition= $params->get( 'labelPosition', '1' );

	$t_v= $params->get('tempo_di_visualizzazione'); 
	$t_p= $params->get('tempo_di_passaggio'); 
	$t_v=$t_v+$t_p;


$tot_rows=count($list);

// Output

if ($load_jq==1)	{ ?>
 	<script type="text/javascript" src="modules/mod_scrollingnews2/js/jquery-1.2.3.pack.js"></script>
<?php    }
?>
	<script type="text/javascript" src="modules/mod_scrollingnews2/js/jquery_timer.js"></script>	
<?php
switch($labelPosition){
case 0: //top
	echo '<link href="modules/mod_scrollingnews2/css/style_top.css" rel="stylesheet" type="text/css" />';
	break;
case 1: //bottom
	echo '<link href="modules/mod_scrollingnews2/css/style_bottom.css" rel="stylesheet" type="text/css" />';
	break;
case 2: //right
	echo '<link href="modules/mod_scrollingnews2/css/style_right.css" rel="stylesheet" type="text/css" />';
	break;
case 3: //left
	echo '<link href="modules/mod_scrollingnews2/css/style_left.css" rel="stylesheet" type="text/css" />';
	break;	
}	
?>
	<script language=javascript>
	var cur_notizia;
	var scroll_iniziato;
	var timer;
	var attesa=<?php echo $t_v; ?>;
	var tempo_scroll=<?php echo $t_p; ?>;
	scroll_iniziato=0;
	
	jQuery.noConflict();
	jQuery(document).ready(function(){
	 	cur_notizia=1;
		timer=jQuery.timer(attesa,function(){ scroll(); } );
		jQuery("table#dac_label_container td#dac_label_1" ).attr("class","dac_label_sel");

		<?php if($img_width!=0 && trim($img_width)!='') { ?>jQuery("#dac_news img").attr("style","width:<?php echo $img_width; ?>"); <?php } ?>
		jQuery("div#dcaScroll2_container").mouseover(function(){timer.stop();});
		jQuery("div#dcaScroll2_container").mouseout(function(){timer.reset(attesa,function(){ scroll(); });});
 		jQuery("#dac_label_container td").mouseout(function(){timer.reset(attesa,function(){ scroll(); });});
		
		jQuery("div.container_partenza").html("<div style='padding:2px'>" + jQuery("div#dac_news #n_1").html() +"</div>");
<?php if($scriviLabel=='1' && ($labelPosition=='3' || $labelPosition=='2')) {  		 ?>
		jQuery("#dac_label_container td").mouseover( function() { imposta(jQuery(this).attr("id"));timer.stop(); } );
		jQuery("#dac_label_container td").attr("style","float:clear;width:100%;text-align:left;vertical-align:middle");
<?php	} 
 if($scriviLabel=='1' && ($labelPosition=='1' || $labelPosition=='0' )) {  ?>
		jQuery("#dac_label_container td").mouseover( function() { imposta(jQuery(this).attr("id")); } );
		jQuery("#dac_label_container td").attr("style","text-align:center");
<?php	}
  ?>		

	});
	
	function imposta(id){
	 	timer.stop();
	 	lista=id.split("_");
	 	if (cur_notizia!=lista[2]){
		 	cur_notizia=lista[2];	 	
		 	if(scroll_iniziato==1) {
				jQuery("div.container_arrivo").fadeOut("fast", function() { jQuery("div.container_arrivo").html("<div style='padding:2px'>" + jQuery("div#dac_news #n_"+cur_notizia).html() +"</div>" ).fadeIn("fast"); });
			} else { 
			 	jQuery("div.container_partenza").fadeOut("fast", function() { jQuery("div.container_partenza").html( "<div style='padding:2px'>" + jQuery("div#dac_news #n_"+cur_notizia).html() + "</div>").fadeIn("fast"); });
			}
	
			colora_tab(cur_notizia);		
		 	timer.reset(attesa,function(){ scroll(); });
		}
	} 

	function colora_tab(nTab){		
		jQuery("table#dac_label_container td").attr("class","dac_label");
		jQuery("table#dac_label_container td#dac_label_" + nTab).attr("class","dac_label_sel");
	} 
	
function scroll(){
 	scroll_iniziato=1;
 	timer.stop();
 	cur_notizia ++;
	if(cur_notizia> <?php echo $tot_rows; ?>) cur_notizia=1;
	prev=cur_notizia-1;
	if(prev==0) prev=<?php echo $tot_rows; ?>;	
	colora_tab(cur_notizia);			

	jQuery("div.container_partenza").html("<div style='padding:2px'>" + jQuery("div#dac_news #n_"+prev).html() + "</div>");
	jQuery("div.container_arrivo").html( "<div style='padding:2px'>" +  jQuery("div#dac_news #n_"+cur_notizia).html() +"</div>" );
<?php if($scroll_direction=='vertical') {  ?>
	jQuery("div#dcaScroll2_container").css("top","0px");
	jQuery("div#dcaScroll2_container").animate({top:-<?php echo (str_replace('px','',($params->get('altezza')+10 ))); ?>},tempo_scroll).end();
<?php	} else { ?>
	jQuery("div#dcaScroll2_container").css("left","0px");
	jQuery("div#dcaScroll2_container").animate({left:-(jQuery("div#scroll2Panel").width()) },tempo_scroll).end();
<?php	} ?>
	timer.reset(attesa,function(){ scroll(); });
}
	
	</script> 
<?php 

$html_labels="";
if($scroll_direction=='vertical') {  
$html_Scroll2='
	<div id="dcaScroll2_container" class="scroll_bg_color" style="position:relative;left:0px;top:0px;border 20px solid blue">
		<div class="container_partenza" style="margin-bottom:2px;position:relative;width:'.$params->get('larghezza').'; left:0px;   height:'. $params->get('altezza').';top:0px;overflow:hidden;" ></div>
		<div class="container_mezzo" style="margin:0px;position:relative;width:'.$params->get('larghezza').'; left:0px;   height:10px;top:0px;overflow:hidden;background-color:trasparent" ></div>
		<div class="container_arrivo"   style="margin-bottom:2px;position:relative;width:'.$params->get('larghezza').'; left:0px;   height:'.$params->get('altezza').';top:0px;overflow:hidden;" ></div>
	</div>';	
	$html_Scroll2='<div id="scroll2Panel" style="position:relative;width:'. $params->get('larghezza') .';height:'. $params->get('altezza') .';border:1px solid '. $params->get('border_color') .';overflow:hidden;padding:0px">
		'.$html_Scroll2.'</div>';
	
	} else { 
$html_Scroll2='
	<div id="dcaScroll2_container" class="scroll_bg_color" style="position:relative;left:0px;top:0px;width:200%;margin:0px">
		<table class="scroll_bg_color" border=0px width='.$params->get('larghezza').' cellspacing=0px cellpadding=0px>
		<tr>
			<td width=50%>
				<div class="container_partenza" style="border: 1px solid green;width:100%;   height:'.$params->get('altezza').';top:0px;overflow:hidden;border:0px solid blue;" ></div>
			</td>
			<td width=50%>
				<div class="container_arrivo"   style="border: 1px solid green; 	 	width:100%;   height:'.$params->get('altezza').';top:0px;overflow:hidden;border:0px solid blue;" ></div>
			</td>
		</tr>
		</table>
	</div>';
$html_Scroll2='<div id="scroll2Panel" style="position:relative;width:'. $params->get('larghezza') .';height:'. $params->get('altezza') .';border:1px solid '. $params->get('border_color') .';overflow:hidden;padding:0px">
	'.$html_Scroll2.'</div>';
	
}

if($labelPosition > 1){
	$html_labels='<table id="dac_label_container" width=100% cellspacing=0 cellpadding=0  >';
	for($i=1;$i<=$tot_rows;$i++){
		$html_labels.=" <tr><td valign=middle id='dac_label_$i' class='dac_label'>#-#$i#-#</td></tr>";
	}
	$html_labels.="</table>";
}else {
	$html_labels='<table id="dac_label_container" width=100% cellspacing=0 cellpadding=0  ><tr>';
	for($i=1;$i<=$tot_rows;$i++){
		$html_labels.="<td valign=middle id='dac_label_$i' class='dac_label'>#-#$i#-#</td>";
	}
	$html_labels.="</tr></table>";	
}


$html_blocco='';
switch($labelPosition){
	case 0:  //top
		$html_Scroll2= '<div id="scroll_main" class="scroll_bg_color" style="padding:5px;overflow:hidden;margin-bottom:0px">##html_labels##'.$html_Scroll2.'</div>';
		$html_blocco="$html_Scroll2";
	break;

	case 1:  //bottom
		$html_Scroll2= '<div id="scroll_main" class="scroll_bg_color" style="padding:5px;overflow:hidden;margin-bottom:0px">'.$html_Scroll2.'##html_labels##</div>';
		$html_blocco="$html_Scroll2";
	break;
	case 2:  //right
		$html_Scroll2= '<div id="scroll_main" style="padding-left:10px; padding-top:0px;padding-bottom:0px;padding-right:0px;overflow:hidden">'.$html_Scroll2.'</div>';
		$html_blocco ="<table class=\"scroll_bg_color\" border=0 cellspacing=0 cellpadding=0 width=100%><tr><td valign=top width=68%>$html_Scroll2</td><td width=2%>&nbsp;</td><td valign=top width=30%>##html_labels##</td></tr></table>";
	break;
	case 3:  //left
		$html_Scroll2= '<div id="scroll_main" style="padding-left:0px; padding-top:0px;padding-bottom:0px;padding-right:10px;overflow:hidden">'.$html_Scroll2.'</div>';
		$html_blocco ="<table class=\"scroll_bg_color\" border=0 cellspacing=0 cellpadding=0 width=100%><tr><td valign=top width=30%>##html_labels##</td><td width=2%>&nbsp;</td><td valign=top width=68%>$html_Scroll2</td></tr></table>";
	break;
	
}
$html_blocco .= '
<div id="dac_news" style="position:absolute;visibility:hidden;height:0px;width:0px">	
';
$i=0;	
$html='';
foreach ( $list as $row ) {
	// get Itemid
	switch ( $type ) {
		case 2:
			$query = "SELECT id"
			. "\n FROM #__menu"
			. "\n WHERE type = 'content_typed'"
			. "\n AND componentid = " . (int) $row->id
			;
			$database->setQuery( $query );
			$Itemid = $database->loadResult();
			break;

		case 3:
			if ( $row->sectionid ) {
				$Itemid = $mainframe->getItemid( $row->id, 0, 0, $bs, $bc, $gbs );
			} else {
				$query = "SELECT id"
				. "\n FROM #__menu"
				. "\n WHERE type = 'content_typed'"
				. "\n AND componentid = " . (int) $row->id
				;
				$database->setQuery( $query );
				$Itemid = $database->loadResult();
			}
			break;

		case 1:
		default:
			$Itemid = $mainframe->getItemid( $row->id, 0, 0, $bs, $bc, $gbs );
			break;
	}

	// Blank itemid checker for SEF
	if ($Itemid == NULL) {
		$Itemid = '';
	} else {
		$Itemid = '&amp;Itemid='. $Itemid;
	}

	$link =  $row->link ;
	$i++;
 	$html=$row->introtext;
	$html_blocco.= '<div id="n_' . $i . '">';
	$html_titolo='<a href="'.$link.'" class="miaScroll_title">'.$row->title.'</a>';
	if($show_titolo==1) $html_blocco.= $html_titolo;
	$html_titolo='<a href="'.$link.'" class="miaScroll">'.$row->title.'</a>';
	if ($scriviLabel==1) $html_labels=str_replace( "#-#$i#-#",$html_titolo,$html_labels);
			        else $html_labels=str_replace( "#-#$i#-#",$html_titolo,'');
	$html_blocco .= $html.'
	</div>';
}

$html_blocco = str_replace('##html_labels##',$html_labels, $html_blocco );
echo $html_blocco;
?></div>