<?php

if ( (!function_exists('register_frontend_modfiles') || !defined('MOD_FRONTEND_CSS_REGISTERED')) && file_exists(WB_PATH .'/modules/cc_loupslider/frontend.css')) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/cc_loupslider/frontend.css');
	echo "\n</style>\n";
}
require_once(WB_PATH.'/framework/functions.php');

$result = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_cc_loupslider WHERE section_id = '$section_id'");
if(isset($result)&&$row = $result->fetchRow()){
	$loupslider_id = $row['loupslider_id'];
	$navigation = $row['navigation'];
	$random = $row['random'];
	$easing = $row['easing'];
	$watermark = $row['watermark'];
	$resize_x = $row['resize_x'];
	$slider_nav = floor($resize_x/2)+6;
	$resize_y = $row['resize_y'];
	$durationTimeOut = $row['durationTimeOut'];
	$durationBlende = $row['durationBlende'];
	$opacity = $row['opacity'];
}
else echo 'Es ist ein Fehler bei der Datenbankabfrage aufgetreten.';
echo '
<script type="text/javascript">
	WB_URL = ' . WB_URL . ';
	function start_cc_loupslider(){
		$("#slider_front").loupslider({';
			if ($easing!=''&&$easing!='0') echo '
			easing: "'.$easing.'",';
			if ($durationTimeOut!=''&&$durationTimeOut!='0') echo '
			durationTimeOut: '.$durationTimeOut.',';
			else echo '
			durationTimeOut: 8000,';
			if ($durationBlende!=''&&$durationBlende!='0') echo '
			durationBlende: '.$durationBlende.',';
			else echo '
			durationBlende: 3000,';
			if ($navigation!=''&&$navigation!='0') echo '
			navigation: true,';
			else echo '
			navigation: false,';
			if ($random!=''&&$random!='0') echo '
			random: true,';
			else echo '
			random: false,';
			if ($opacity!=''&&$opacity!='0') echo '
			opacity: '.$opacity;
			else echo '
			opacity: 0.7';
	echo '
		});
		$(".right_nav").css({marginRight: "-'.$slider_nav.'px"});
		$(".left_nav").css({marginLeft: "-'.$slider_nav.'px"});
	}
</script>
';

$url = WB_URL.MEDIA_DIRECTORY.'/cc_loupslider_';
$folder_url = $url.$section_id;
$files = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_cc_loupslider_images WHERE loupslider_id = '$loupslider_id'");
if(isset($files)&&$files->numRows() > 0) {
	echo '
	<div id="slider_front">';
	$titles = array();
	$links = array();
	$zahler=0;
	while($row = $files->fetchRow()) {
		echo '
		<img src="'.$folder_url.'/'.$row['picture'].'" width="'.$resize_x.'" height="'.$resize_y.'" alt="'.$row['alt'].'" />';
		$titles[]=$row['title'];
		$links[$zahler]['link']=$row['link'];
		$links[$zahler]['linkname']=$row['linkname'];
		$zahler++;
	}

	echo '
		<div id="slider_title"></div>
	</div>
	<div id="slider_titles">';
	foreach($titles as $title){
		echo '
		<div class="slider_title">'.$title.'</div>';
	}
	echo '
	</div>
	<div id="slider_links">';
	foreach($links as $link){
		echo '
		<div class="slider_links">';
		if ($link['link']!=''&&$link['link']!='0'){
		echo '<a href="'.$link['link'].'" class="slider_link round_all schatten" >';
		if($link['linkname']!='') echo $link['linkname'];
		else echo 'Zur Galerie';
		echo '</a>';
		}
		echo '</div>';
	}
	echo '
	</div>
	<img src="'.WB_URL.'/modules/cc_loupslider/images/shadow.png" alt="cc_loupslider Schatten" class="cc_loupslider_shadow" />
';
}
?>
