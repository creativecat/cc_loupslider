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
// Delete record from the database
$values = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_cc_loupslider WHERE section_id = '$section_id'");
if(isset($values)&&$values->numRows() > 0) {
	while($row = $values->fetchRow()) {
		$loupslider_id = $row['loupslider_id'];
	}
}
$database->query("DELETE FROM ".TABLE_PREFIX."mod_cc_loupslider_images WHERE loupslider_id = '$loupslider_id'");
$database->query("OPTIMIZE TABLE  `".TABLE_PREFIX."mod_cc_loupslider_images`");
$database->query("DELETE FROM ".TABLE_PREFIX."mod_cc_loupslider WHERE section_id = '$section_id'");
$database->query("OPTIMIZE TABLE  `".TABLE_PREFIX."mod_cc_loupslider`");
$path = WB_PATH.MEDIA_DIRECTORY.'/cc_loupslider_';
$folder = $path.$section_id;
rm_full_dir($folder);

?>