<?php

require_once('../../config.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require_once(WB_PATH.'/modules/admin.php');

if (!isset($section_id)) {
	$section_id = $admin->get_post('section_id');
	echo 'section_id war nicht korrekt gesetzt!<br/>Jetzt: '.$section_id;
}
if (!isset($page_id)) {
	$page_id = $admin->get_post('page_id');
	echo 'page_id war nicht korrekt gesetzt!<br/>Jetzt: '.$page_id;
}

// Update the mod_wysiwygs table with the contents
$url = WB_URL.MEDIA_DIRECTORY.'/cc_loupslider_';
$path = WB_PATH.MEDIA_DIRECTORY.'/cc_loupslider_';
$folder_url = $url.$section_id;
$folder_path = $path.$section_id;
$watermark_path = $folder_path.'/cc_loupslider_watermark/watermark.png';
$watermark_url = $folder_url.'/cc_loupslider_watermark/watermark.png';
$loupslider_id = $admin->get_post('loupslider_id');

if ($admin->get_post('speichern')!=''){
	
	// Ausgabeoptionen abfragen
	$navigation=$admin->get_post('navigation');
	$random=$admin->get_post('random');
	$easing=$admin->get_post('easing');
	$durationTimeOut=$admin->get_post('durationTimeOut');
	$durationBlende=$admin->get_post('durationBlende');
	$opacity=$admin->get_post('opacity');
	
	// Bildoptionen abfragen
	$resize_x=$admin->get_post('resize_x');
	$resize_y=$admin->get_post('resize_y');
	
	// Wasserzeichen hochladen und speichern
	$success=false;
	include_once(WB_PATH.'/modules/cc_loupslider/class.upload.php');
	if (isset($_FILES['watermark'])){
		$handle = new upload($_FILES['watermark']);
		if ($handle->uploaded) {
			$handle->file_new_name_body   = 'watermark';
			$handle->image_resize		= true;
			$handle->image_x			= $resize_x/100*14;
			$handle->image_ratio_y		= true;
			$handle->file_overwrite = true;
			$handle->image_convert = 'png';
			$handle->process($folder_path.'/cc_loupslider_watermark/');
			if ($handle->processed) {
				$success=true;
				$handle->clean();
			} else {
				echo 'Es ist ein Fehler aufgetreten: '.$handle->error.'<br/>';
			}
		}
	}
	if ($success==true) echo 'Wasserzeichen erfolgreich hochgeladen<br/>';
	$success=false;
	
	// Check, ob Wasserzeichen existiert
	if (file_exists($watermark_path)) {
		$watermark = '1';
	}
	else $watermark = '0';
	
	// Daten für Gallery in Datenbank speichern
	if ($navigation!=''||$random!=''||$easing!=''||$resize_x!=''||$resize_y!=''||$watermark!=''){
		$query = "UPDATE ".TABLE_PREFIX."mod_cc_loupslider SET navigation = '$navigation', random = '$random', easing = '$easing', resize_x = '$resize_x', resize_y = '$resize_y', watermark = '$watermark', durationTimeOut = '$durationTimeOut', durationBlende = '$durationBlende', opacity = '$opacity' WHERE loupslider_id = '$loupslider_id'";
		$database->query($query);
	}

	// Bilder hochladen und speichern
	if (isset($_FILES['new_image']['name'][0])){
		// Array neu anordnen
		$zahler=0;
		foreach ($_FILES['new_image']['name'] as $image){
			$images[$zahler]['name']=$image;
			$zahler++;
		}
		$zahler=0;
		foreach ($_FILES['new_image']['type'] as $image){
			$images[$zahler]['type']=$image;
			$zahler++;
		}
		$zahler=0;
		foreach ($_FILES['new_image']['tmp_name'] as $image){
			$images[$zahler]['tmp_name']=$image;
			$zahler++;
		}
		$zahler=0;
		foreach ($_FILES['new_image']['error'] as $image){
			$images[$zahler]['error']=$image;
			$zahler++;
		}
		$zahler=0;
		foreach ($_FILES['new_image']['size'] as $image){
			$images[$zahler]['size']=$image;
			$zahler++;
		}
		// Bilder hochladen
		$images_values = array();
		$zahler=0;
		foreach ($images as $image){
			$handle = new upload($image);
			if ($handle->uploaded) {
				$handle->image_resize	= true;
				$handle->image_x		= $resize_x;
				$handle->image_y		= $resize_y;
				$handle->image_ratio_crop = true;
				$handle->file_overwrite = true;
				$handle->image_convert = 'jpg';
				if (file_exists($watermark_path)) {
					$handle->image_watermark			= $watermark_path;
					$handle->image_watermark_x			= -10;
					$handle->image_watermark_y			= -10;
					$handle->image_watermark_position	= 'BR';
				}
				$handle->jpeg_quality = 80;
				$handle->process($folder_path.'/');
				if ($handle->processed) {
					$success=true;
					$picture = $handle->file_dst_name;
					// Überprüfen, ob dieses Bild bereits in der Datenbank vorhanden ist
					$check_image = $database->query("SELECT picture FROM ".TABLE_PREFIX."mod_cc_loupslider_images WHERE picture = '$picture' AND loupslider_id = '$loupslider_id'");
					if((isset($check_image)&&$check_image->numRows()==0)||!isset($check_image)) {
						$database->query("INSERT INTO ".TABLE_PREFIX."mod_cc_loupslider_images (loupslider_id,picture,title,alt,link,linkname) VALUES ('$loupslider_id','$picture','','','','')");
					}
					else echo $picture.' wurde aktualisiert.<br/>';
					$handle->clean();
					$zahler++;
				} else {
					echo 'Es ist ein Fehler aufgetreten: '.$handle->error.'<br/>';
				}
			}
		}
		if ($success==true) {
			echo 'Bilder erfolgreich hochgeladen<br/>';
			
		}
	}

	// Bildoptionen abfragen
	if (is_array($admin->get_post('title'))){
		$zahler=0;
		foreach ($admin->get_post('title') as $value){
			$images_values[$zahler]['title'] = $value;
			$zahler++;
		}
	}
	if (is_array($admin->get_post('alt'))){
		$zahler=0;
		foreach ($admin->get_post('alt') as $value){
			$images_values[$zahler]['alt'] = $value;
			$zahler++;
		}
	}
	if (is_array($admin->get_post('linkname'))){
		$zahler=0;
		foreach ($admin->get_post('linkname') as $value){
			$images_values[$zahler]['linkname'] = $value;
			$zahler++;
		}
	}
	if (is_array($admin->get_post('link'))){
		$zahler=0;
		foreach ($admin->get_post('link') as $value){
			$images_values[$zahler]['link'] = $value;
			$zahler++;
		}
	}
	if (is_array($admin->get_post('picture'))){
		$zahler=0;
		foreach ($admin->get_post('picture') as $value){
			$images_values[$zahler]['picture'] = $value;
			$zahler++;
		}
	}
	// Daten für einzelne Bilder in Datenbank speichern
	$zahler=0;
	foreach($images_values as $values){
		if (isset($values['title'])) $title = $values['title'];
		else $title = '';
		if (isset($values['alt'])) $alt = $values['alt'];
		else $alt = '';
		if (isset($values['linkname'])) $linkname = $values['linkname'];
		else $linkname = '';
		if (isset($values['link'])) $link = $values['link'];
		else $link = '';
		$image = $values['picture'];
		$database->query("UPDATE ".TABLE_PREFIX."mod_cc_loupslider_images SET title = '$title', alt = '$alt', linkname = '$linkname', link = '$link' WHERE picture = '$image'");
		$zahler++;
	}
}
// Bilder löschen, falls Löschenbutton gedrückt wurde
elseif ($admin->get_post('loeschen')!=''&&is_array($admin->get_post('delete'))){
	foreach ($admin->get_post('delete') as $value){
		unlink($folder_path.'/'.$value);
		$database->query("DELETE FROM ".TABLE_PREFIX."mod_cc_loupslider_images WHERE picture = '$value'");
	}
	$database->query("OPTIMIZE TABLE  `".TABLE_PREFIX."mod_cc_loupslider_images`");
}
// Wasserzeichen löschen, falls Löschbutton gedrückt wurde
elseif ($admin->get_post('watermark_loeschen')!=''){
	if (file_exists($watermark_path)) {
		unlink($folder_path.'/cc_loupslider_watermark/watermark.png');
	}
	$database->query("UPDATE ".TABLE_PREFIX."mod_cc_loupslider SET watermark = '0' WHERE loupslider_id = '$loupslider_id'");
}
// Check, ob ein Fehler aufgetreten ist
if($upload=false) {
	$admin->print_error($database->get_error(), $js_back);
} else {
	$admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>