<?php
if(!isset($_SESSION['cmsuno'])) exit();
?>
<?php
if(file_exists('data/'.$Ubusy.'/fixed_layout.json'))
	{
	$q1 = file_get_contents('data/'.$Ubusy.'/fixed_layout.json');
	$a1 = json_decode($q1,true);
	$o1 = '['; $o2 = ''; $c = 0;
	if(is_array($a1))
		{
		foreach($a1 as $k=>$v)
			{
			if(is_array($v) && isset($v['typ']))
				{
				if($v['typ']=='img') $o1 .= "'".substr($v['ref'],1)."',"; // file
				else $o1 .= "'".$v['ref']."',"; // color
				$o2 .= "jQuery('#section".$c." .content').empty();jQuery('#".$k."BlocChap').appendTo('#section".$c." .content');";
				$Umenu = str_replace('href="#'.$k.'"','href="#section'.$c.'"',$Umenu);
				++$c;
				}
			}
		$o1 = substr($o1,0,-1) . "],'sectionContent': '<div class=\"contentwrap\"><div class=\"content\"></div></div>'";
		$Uscript .= (isset($a1['menuOffset'])?"var Umenuoffset=".$a1['menuOffset'].";":"")."jQuery(document).ready(function(){jQuery('body').fixedScroll({'backgrounds':".$o1."});".$o2."});\r\n";
		$Uhead .= '<link rel="stylesheet" href="uno/plugins/fixed_layout/fixedscroll/fixedScrollLayout.css" type="text/css" />'."\r\n";
		$Uhead .= '<script type="text/javascript" src="uno/plugins/fixed_layout/fixedscroll/fixedScrollLayout.js"></script>'."\r\n";
		$Uhtml = str_replace('[[fixed_layout]]','<div id="scroller" class="scroller"></div>',$Uhtml);
		}
	}
?>
