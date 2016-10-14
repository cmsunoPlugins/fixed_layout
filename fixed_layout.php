<?php
session_start(); 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest') {sleep(2);exit;} // ajax request
if(!isset($_POST['unox']) || $_POST['unox']!=$_SESSION['unox']) {sleep(2);exit;} // appel depuis uno.php
?>
<?php
include('../../config.php');
include('lang/lang.php');
$q = file_get_contents('../../data/busy.json'); $a = json_decode($q,true); $Ubusy = $a['nom'];
// ********************* actions *************************************************************************
if (isset($_POST['action']))
	{
	switch ($_POST['action'])
		{
		// ********************************************************************************************
		case 'plugin': ?>
		<link rel="stylesheet" type="text/css" media="screen" href="uno/plugins/fixed_layout/fixed_layout.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="uno/plugins/fixed_layout/spectrum/spectrum.css" />
		<div id="blocFixedLayout" class="blocForm">
			<h2><?php echo T_("Fixed Layout");?></h2>
			<p><?php echo T_("This plugin allows to create a page with a fixed background that changes with scrolling. (JQuery Required)");?></p>
			<p><?php echo T_("Just install the shortcode ");?>&nbsp;<code>[[fixed_layout]]</code>&nbsp;<?php echo T_("after BODY in your template (try to see the best place).");?></p>
			<p><?php echo T_("The pictures should have the same dimensions otherwise the CSS will be adapted.");?></p>
			<h3><?php echo T_("Layout :");?></h3>
			<form id="frmLayout">
				<table class="hForm">
					<tr>
						<td><label><?php echo T_("Menu calibration");?></label></td>
						<td><input type="text" style="width:50px;" id="fixedLayoutMenu" name="fixedLayoutMenu" value="0" /></td>
						<td><em><?php echo T_("Vertical calibration in the page after clicking on the menu (px).");?></em></td>
					</tr>
				</table>
				<table id="layout"></table>
			</form>
			<div class="bouton fr" onClick="f_save_fixedLayout();" title="<?php echo T_("Save settings");?>"><?php echo T_("Save");?></div>
			<div class="clear"></div>
		</div>
		<?php break;
		// ********************************************************************************************
		case 'load':
		$a = array();
		if(file_exists('../../data/'.$Ubusy.'/fixed_layout.json'))
			{
			$q = file_get_contents('../../data/'.$Ubusy.'/fixed_layout.json'); $a = json_decode($q,true);
			}
		$q1 = file_get_contents('../../data/'.$Ubusy.'/site.json'); $a1 = json_decode($q1,true);
		$b = array();
		if(isset($a['menuOffset'])) $b['menuOffset'] = $a['menuOffset'];
		if(is_array($a1)) foreach($a1['chap'] as $r)
			{
			if(isset($r['t']) && $r['t'])
				{
				$w = strtr(utf8_decode($r['t']),'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ','aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby');
				$w = preg_replace('/[^a-zA-Z0-9%]/s','',$w);
				if(!isset($a[$w])) $b[$w] = array('typ'=>'color','ref'=>'#dddddd'); // color, img
				else $b[$w] = $a[$w];
				}
			}
		echo json_encode($b);
		exit;
		break;
		// ********************************************************************************************
		case 'save':
		$out = $_POST['data'];
		if (file_put_contents('../../data/'.$Ubusy.'/fixed_layout.json', $out)) echo T_('Backup performed');
		else echo '!'.T_('Impossible backup');
		break;
		// ********************************************************************************************
		}
	clearstatcache();
	exit;
	}
?>
