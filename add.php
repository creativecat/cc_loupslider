<?php
require_once(WB_PATH.'/framework/functions.php');
if (!isset($section_id)) {
	$section_id = $admin->get_post('section_id');
	echo 'section_id war nicht korrekt gesetzt!<br/>Jetzt: '.$section_id;
}
if (!isset($page_id)) {
	$page_id = $admin->get_post('page_id');
	echo 'page_id war nicht korrekt gesetzt!<br/>Jetzt: '.$page_id;
}

// Insert an extra row into the database
$database->query("INSERT INTO ".TABLE_PREFIX."mod_cc_loupslider (page_id, section_id, navigation, random, easing, watermark, resize_x, resize_y, durationTimeOut, durationBlende, opacity) VALUES ('$page_id', '$section_id', '0', '0', '0', '', '724', '407', '8000', '3000', '0.8')");
$path = WB_PATH.MEDIA_DIRECTORY.'/cc_loupslider_';
$folder = $path.$section_id;
make_dir($folder);
make_dir($folder.'/cc_loupslider_watermark');
// Create index.php file
$content = ''.
"<?php

header('Location: ../');

?>";
	$handle = fopen($folder.'/index.php', 'w');
	fwrite($handle, $content);
	fclose($handle);
	change_mode($folder.'/index.php', 'file');
	
	$handle = fopen($folder.'/cc_loupslider_watermark/index.php', 'w');
	fwrite($handle, $content);
	fclose($handle);
	change_mode($folder.'/cc_loupslider_watermark/index.php', 'file');

?>