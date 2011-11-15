<?php

/**
* @package jDMTree 1.5 - Docman jDMTree Module 1.5.1
* @copyright (C) 2008 http://www.youthpole.com
* @author Josh Prakash
*
* --------------------------------------------------------------------------------
* All rights reserved.  Docman tree module for Joomla!
* Other credits & copyrights:
* dhtml tree structure base : http://www.dhtmlgoodies.com
*	cookie functions : http://www.mach5.com/support/analyzer/manual/html
*	                   /General/CookiesJavaScript.htm
*
* @license		GNU/GPL, see LICENSE.php
* This module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* Revisions
* Nov-11-2008 - php5 compatibility fix for <?
* --------------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class docmantree{

	
	var $elementArray = array();
	var $nameOfCookie = "jdmtree_expanded"; // Name of the cookie where the expanded nodes are stored.
	
	function docmantree()
	{
	}
	function applyStyle()
	{
		?>
		<style type="text/css">
		/*
		(c) jDMTree 1.5 for Joomla 1.5 - Docman Tree Module, Josh Prakash, http://www.youthpole.com - 2008 	
		*/		
   .joshdctree li{
	list-style-type:none;	
    background:none;
	font-family: "Trebuchet MS", Arial, Helvetica, "Sans Serif";
	font-size:14px;
	text-decoration:none;
	color: #0099CC;
	}
	
	  .joshdctree li a{
		text-decoration: none;
		color: #0099CC;
	}


   .joshdctree img{
	padding-top:1px;
	padding-right: 3px;
	}

   .joshdctree div ul li a {
	text-decoration	: none;
	           } 

    .joshdctree{
	margin-left:0px;
	padding-left:0px;
	}

    .joshdctree ul{
	margin-left:3px;
	padding-left:0px;
	display:none;
		}

     .tree_link{
	line-height:13px;
	padding-left:1px;
	text-decoration:none;
	
	}

	
     .tree_node{
	text-decoration	: underline;

	}

  .jdmroothov {
	text-decoration	: none;
           } 
  .jdmcredits {
	font-size:8px;
	padding-left:30px;
	display:none;

           } 
		</style>		
		<?php		
	}


	function writeJavascript()
	{
		?>
		<script type="text/javascript">
		/*
		(c) jDMTree 1.5 for Joomla 1.5 - Docman Tree Module, Josh Prakash, http://www.youthpole.com - 2008
		*/		
		var plusNode = 'modules/mod_jdmtree15/jDMtree/images/docmantree_expand.gif';
		var minusNode = 'modules/mod_jdmtree15/jDMtree/images/docmantree_collapse.gif';

		var nameOfCookie = '<?php echo $this->nameOfCookie; ?>';
		<?php
		$cookieValue = "";
		if(isset($_COOKIE[$this->nameOfCookie]))$cookieValue = $_COOKIE[$this->nameOfCookie];		
		echo "var initExpandedNodes =\"".$cookieValue."\";\n";
		?>		
		function Get_Cookie(name) { 
		   var start = document.cookie.indexOf(name+"="); 
		   var len = start+name.length+1; 
		   if ((!start) && (name != document.cookie.substring(0,name.length))) return null; 
		   if (start == -1) return null; 
		   var end = document.cookie.indexOf(";",len); 
		   if (end == -1) end = document.cookie.length; 
		   return unescape(document.cookie.substring(len,end)); 
		} 
		// This function has been slightly modified
		function Set_Cookie(name,value,expires,path,domain,secure) { 
			expires = expires * 60*60*24*1000;
			var today = new Date();
			var expires_date = new Date( today.getTime() + (expires) );
		    var cookieString = name + "=" +escape(value) + 
		       ( (expires) ? ";expires=" + expires_date.toGMTString() : "") + 
		       ( (path) ? ";path=" + path : "") + 
		       ( (domain) ? ";domain=" + domain : "") + 
		       ( (secure) ? ";secure" : ""); 
		    document.cookie = cookieString; 
		} 
		/*
		End cookie functions
		*/
		
		function expandNode(e,inputNode)
		{
			if(initExpandedNodes.length==0)initExpandedNodes=",";
			if(!inputNode)inputNode = this; 
			if(inputNode.tagName.toLowerCase()!='img')inputNode = inputNode.parentNode.getElementsByTagName('IMG')[0];	
			
			var inputId = inputNode.id.replace(/[^\d]/g,'');			
			
			var parentUl = inputNode.parentNode;
			var subUl = parentUl.getElementsByTagName('UL');

			if(subUl.length==0)return;
			if(subUl[0].style.display=='' || subUl[0].style.display=='none'){
				subUl[0].style.display = 'block';
				inputNode.src = minusNode;
				initExpandedNodes = initExpandedNodes.replace(',' + inputId+',',',');
				initExpandedNodes = initExpandedNodes + inputId + ',';
				
			}else{
				subUl[0].style.display = '';
				inputNode.src = plusNode;	
				initExpandedNodes = initExpandedNodes.replace(','+inputId+',',',');			
			}
			Set_Cookie(nameOfCookie,initExpandedNodes,60);
			
			
			
		}
		
		function initTree()
		{
			// Assigning mouse events
			var parentNode = document.getElementById('docmantree');
			var lis = parentNode.getElementsByTagName('LI'); // Get reference to all the images in the tree
			for(var no=0;no<lis.length;no++){
				var subNodes = lis[no].getElementsByTagName('UL');
				if(subNodes.length>0){
					lis[no].childNodes[0].style.visibility='visible';	
				}else{
					lis[no].childNodes[0].style.visibility='hidden';
				}
			}	
			
			var images = parentNode.getElementsByTagName('IMG');
			for(var no=0;no<images.length;no++){
				if(images[no].className=='tree_plusminus')images[no].onclick = expandNode;				
			}	

			var aTags = parentNode.getElementsByTagName('A');
			var cursor = 'pointer';
			if(document.all)cursor = 'hand';
			for(var no=0;no<aTags.length;no++){
				aTags[no].onclick = expandNode;		
				aTags[no].style.cursor = cursor;		
			}
			var initExpandedArray = initExpandedNodes.split(',');

			for(var no=0;no<initExpandedArray.length;no++){
				if(document.getElementById('plusMinus' + initExpandedArray[no])){
					var obj = document.getElementById('plusMinus' + initExpandedArray[no]);	
					expandNode(false,obj);
				}
			}				
		}
		
		window.onload = initTree;
		
		</script>	
		<?php
		
	}
	
	
	
	/*
	This function adds elements to the array
	*/
	
	function addToArray($id,$name,$parentID,$url="",$target="",$imageIcon="modules/mod_jdmtree15/jDMtree/images/docmantree_folder.png"){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$url,$target,$imageIcon);
	}
	
	function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){			
			echo "<ul>";
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$urlAdd = "";
				if($this->elementArray[$parentID][$no][2]){
					$urlAdd = " href=\"".$this->elementArray[$parentID][$no][2]."\"";
					if($this->elementArray[$parentID][$no][3])$urlAdd.=" target=\"".$this->elementArray[$parentID][$no][3]."\"";	
				}
				//echo "<li class=\"tree_node\"><img height=\"13\" width= \"11\" class=\"tree_plusminus\" id=\"plusMinus".$this->elementArray[$parentID][$no][0]."\" src=\"modules/mod_jdmtree15/jDMtree/images/docmantree_expand.gif\"><img height=\"14\" width= \"14\" src=\"".$this->elementArray[$parentID][$no][4]."\"><a class=\"tree_link\"$urlAdd>".$this->elementArray[$parentID][$no][1]."</a>";	
				echo "<li class=\"tree_node\"><img style=\"padding-left:10px;\" class=\"tree_plusminus\" id=\"plusMinus".$this->elementArray[$parentID][$no][0]."\" src=\"modules/mod_jdmtree15/jDMtree/images/docmantree_expand.gif\"><img src=\"".$this->elementArray[$parentID][$no][4]."\"><a style=\"color: #666666; \" class=\"tree_link\"$urlAdd>".$this->elementArray[$parentID][$no][1]."</a>";	
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
				echo "</li>";
			}	
      		
			echo "</ul>";			
		}		
	}
	
	function drawTree(){
		echo "<div id=\"docmantree\">";
		echo "<ul id=\"docmantreetopNodes\" class=\"joshdctree\">";
		for($no=0;$no<count($this->elementArray[0]);$no++){
			$urlAdd = "";
			if($this->elementArray[0][$no][2]){
				$urlAdd = " href=\"".$this->elementArray[0][$no][2]."\"";
				if($this->elementArray[0][$no][3])$urlAdd.=" target=\"".$this->elementArray[0][$no][3]."\"";	
			}
			//echo "<li onmouseover=\"this.className='jdmroothov'\" onmouseout=\"this.className='tree_node'\" class=\"tree_node\" id=\"node_".$this->elementArray[0][$no][0]."\"><img height=\"16\" width= \"12\" id=\"plusMinus".$this->elementArray[0][$no][0]."\" class=\"tree_plusminus\" src=\"modules/mod_jdmtree15/jDMtree/images/docmantree_expand.gif\"><img height=\"16\" width= \"16\" src=\"".$this->elementArray[0][$no][4]."\"><a class=\"tree_link\"$urlAdd>".$this->elementArray[0][$no][1]."</a>";	
			echo "<li onmouseover=\"this.className='jdmroothov'\" onmouseout=\"this.className='tree_node'\" class=\"tree_node\" id=\"node_".$this->elementArray[0][$no][0]."\"><img  id=\"plusMinus".$this->elementArray[0][$no][0]."\" class=\"tree_plusminus\" src=\"modules/mod_jdmtree15/jDMtree/images/docmantree_expand.gif\"><img height=\"16\" width= \"16\" src=\"".$this->elementArray[0][$no][4]."\"><a style=\"text-decoration: none; color: #333; \" class=\"tree_link\"$urlAdd>".$this->elementArray[0][$no][1]."</a>";		
      //numlinks to be appended above, if required in future
			$this->drawSubNode($this->elementArray[0][$no][0]);
			echo "</li>";	
		}	
		echo "</ul>";
                /* if you wish to remove this credits link, you are expected to display it elsewhere from your website as per copyright license */	
                echo "</br><a class= \"jdmcredits\" href=\"http://www.youthpole.com\">(c) DOCMan jDMTree 1.5.1 </a>";
		echo "</div>";	
	}
}
?>
