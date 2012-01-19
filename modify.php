<?php

if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/cc_loupslider/backend.css")) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/cc_loupslider/backend.css');
	echo "\n</style>\n";
}

require_once(WB_PATH.'/framework/functions.php');

if (!isset($section_id)) {
	$section_id = $admin->get_post('section_id');
	echo 'section_id war nicht korrekt gesetzt!<br/>Jetzt: '.$section_id;
}
if (!isset($page_id)) {
	$page_id = $admin->get_post('page_id');
	echo 'page_id war nicht korrekt gesetzt!<br/>Jetzt: '.$page_id;
}
// Get page content
$url = WB_URL.MEDIA_DIRECTORY.'/cc_loupslider_';
$path = WB_PATH.MEDIA_DIRECTORY.'/cc_loupslider_';
$folder_url = $url.$section_id;
$folder_path = $path.$section_id;

//Get Modul-Version
$modul_version = $database->get_one("SELECT version FROM ".TABLE_PREFIX."addons WHERE name = 'cc_loupslider'");

$values = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_cc_loupslider WHERE section_id = '$section_id'");
if(isset($values)&&$values->numRows() > 0) {
	while($row = $values->fetchRow()) {
		$loupslider_id = $row['loupslider_id'];
		$navigation = $row['navigation'];
		$random = $row['random'];
		$easing = $row['easing'];
		$resize_x = $row['resize_x'];
		$resize_y = $row['resize_y'];
		$watermark = $row['watermark'];
		$durationTimeOut = $row['durationTimeOut'];
		$durationBlende = $row['durationBlende'];
		$opacity = $row['opacity'];
	}
}
else echo 'Es ist ein Fehler bei der Datenbankabfrage aufgetreten!';

?>
<!-- BEGIN main_block -->
<form action="<?php echo WB_URL; ?>/modules/cc_loupslider/save.php" method="post" class="cc_loupslider_form" enctype="multipart/form-data">
	<div class="cc_loupslider_header">
		Loupslider verwalten <span class="small">(Version <?php echo $modul_version; ?>)</span>
		<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
		<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
		<input type="hidden" name="loupslider_id" value="<?php echo $loupslider_id; ?>" />
	</div>
	<div class="cc_loupslider_option">
		Ausgabeoptionen
		<div class="cc_loupslider_show"></div>
	</div>
	<div class="cc_loupslider_option_content">
		<p class="cc_loupslider_dreispalten">Navigation einblenden:<input type="checkbox" name="navigation" <?php if ($navigation=='1') echo 'checked="checked" '; ?>value="1" /></p>
		<p class="cc_loupslider_dreispalten">Bilder zufällig anzeigen: <input type="checkbox" name="random" <?php if ($random=='1') echo 'checked="checked" '; ?>value="1" /></p>
		<p class="cc_loupslider_dreispalten">Easing-Effekt: 
			<select name="easing">
				<option value="0" <?php if ($easing=='0'||$easing=='') echo 'selected="selected" '; ?>>Kein Effekt gewählt</option>
			<?php $easing_options = array('easeInQuad', 'easeOutQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce');
				foreach ($easing_options as $option){
				echo '<option value="'.$option.'"';
				if ($easing==$option) echo 'selected="selected" ';
				echo '>'.$option.'</option>';
				}
				?>
			</select>
		</p>
		<p class="cc_loupslider_dreispalten">
			Wartezeit bis zum Wechsel:
			<input type="text" name="durationTimeOut" value="<?php if ($durationTimeOut!=''&&$durationTimeOut!='0') echo $durationTimeOut; else echo '8000' ?>" /> ms
		</p>
		<p class="cc_loupslider_dreispalten">
			Dauer des Wechsels:
			<input type="text" name="durationBlende" value="<?php if ($durationBlende!=''&&$durationBlende!='0') echo $durationBlende; else echo '3000' ?>" /> ms
		</p>
		<p class="cc_loupslider_dreispalten">
			Transparenz der Hintergrundbilder:
			<input type="text" name="opacity" value="<?php if ($opacity!=''&&$opacity!='0') echo $opacity; else echo '0.8' ?>" /> (0-1)
		</p>
		<div class="div_submit">
			<input type="submit" name="speichern" class="submit cc_loupslider_button left" style="margin-left: 15px" value="Hochladen / speichern" />
		</div>
	</div>
	<div class="cc_loupslider_option">
		Bildoptionen
		<div class="cc_loupslider_show"></div>
	</div>
	<div class="cc_loupslider_option_content">
		<p class="cc_loupslider_dreispalten">Horizontal anpassen:<br/>
			<input type="text" name="resize_x" value="<?php 
			if ($resize_x==''||$resize_x=='0') echo '724';
			else echo $resize_x;
			?>" /> px<br/>
			Vertikal anpassen:<br/>
			<input type="text" name="resize_y" value="<?php 
			if ($resize_y==''||$resize_y=='0') echo '407';
			else echo $resize_y;
			?>" /> px
		</p>
		<p class="cc_loupslider_dreispalten">Wasserzeichen:<br/>
			<input type="file" name="watermark" class="watermark" /><br/>
		</p>
		<p class="cc_loupslider_dreispalten">
			<?php
			$watermark_img = $folder_path.'/cc_loupslider_watermark/watermark.png';
			if (file_exists($watermark_img)) {
				echo 'Aktuelles Wasserzeichen:<br/>
				<img src="'.$folder_url.'/cc_loupslider_watermark/watermark.png" alt="Watermark" class="watermark_img" />';
			}
			?>
		</p>
		<div class="div_submit">
			<input type="submit" name="speichern" class="submit cc_loupslider_button left" value="Hochladen / speichern" />
			<input type="submit" name="watermark_loeschen" class="loeschen cc_loupslider_button" value="Wasserzeichen l&ouml;schen" />
		</div>
	</div>
	<div class="cc_loupslider_option">
		Neues Bild hochladen
		<div class="cc_loupslider_show"></div>
	</div>
	<div class="cc_loupslider_option_content">
		<p>
			<input type="file" size="32" class="new_image" name="new_image[0]" /><br/>
			<span class="small">Bitte beachten Sie, dass bei vielen Bilder die Ladezeit zunimmt.<br/>BITTE BEACHTEN: Bitte zuerst alle Einstellungen unter Bildoptionen einstellen. Wasserzeichen und Größe kann später nur eingeschränkt geändert werden.</span>
		</p>
		<div class="div_submit">
			<input type="submit" name="speichern" class="submit left cc_loupslider_button" value="Hochladen / speichern" />
			<span class="cc_loupslider_button upload left">Weiteres Uploadfeld hinzufügen</span>
			<input type="button" class="abbrechen cc_loupslider_button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';" />
		</div>
	</div>
	<div class="cc_loupslider_option">
		Aktuelle Bilder
		<div class="cc_loupslider_show"></div>
	</div>
	<div class="cc_loupslider_option_content">
		<p><span class="small">BITTE BEACHTEN: Es sollten mindestens 3 Bilder hochgeladen worden sein, damit der Slider fehlerfrei funktioniert.</span></p>
<?php

$abfrage = $database->query("SELECT gallery_id, title, page_id FROM ".TABLE_PREFIX."mod_cc_gallery");
if(isset($abfrage)&&$abfrage->numRows()>0) {
	$zahler=0;
	while($row = $abfrage->fetchRow()) {
		$gallery[$zahler]['gallery_id'] = $row['gallery_id'];
		$gallery[$zahler]['title'] = $row['title'];
		$page_link = $database->get_one("SELECT link FROM ".TABLE_PREFIX."pages WHERE page_id = '".$row['page_id']."'");
		$gallery[$zahler]['page_link'] = page_link($page_link).'?gallery_id='.$gallery[$zahler]['gallery_id'];
		$zahler++;
	}
}


$zahler=0;
$files = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_cc_loupslider_images WHERE loupslider_id = '$loupslider_id'");
if(isset($files)&&$files->numRows()>0) {
	while($row = $files->fetchRow()) {
		echo '
		<div class="cc_loupslider_dreispalten">
			<p>
				<input type="hidden" name="picture['.$zahler.']" value="'.$row['picture'].'" /><br/>
				<input type="checkbox" name="delete['.$zahler.']" value="'.$row['picture'].'" />Bild zum L&ouml;schen ausw&auml;hlen<br/><br/>
				Titel:<br/>
				<input type="text" name="title['.$zahler.']" value="'.$row['title'].'" /><br/>
				Alternativtext:<br/>
				<input type="text" name="alt['.$zahler.']" value="'.$row['alt'].'" /><br/>
				Linkname:<br/>
				<input type="text" name="linkname['.$zahler.']" value="'.$row['linkname'].'" /><br/>
				<span class="select_link active">
					Link:<br/>
					<input type="text" name="link['.$zahler.']" value="'.$row['link'].'" />
				</span>';
			if (isset($gallery)){
				echo '
				<span class="select_gallery" >
					Galerie:<br/>
					<select name="links['.$zahler.']">
						<option value="">Keine Galerie gewählt</option>';
					foreach ($gallery as $gal){
						echo '
						<option value="'.$gal['page_link'].'"';
						if ($gal['page_link']==$row['link']) echo ' selected="selected"';
						echo '>'.$gal['title'].' (ID: '.$gal['gallery_id'].')</option>';
					}
					echo '
					</select>
				</span>
				<span class="show_links cc_loupslider_button">Galerie auswählen</span>
			</p>';
			}
		echo '
		</div>
		<p class="cc_loupslider_zweispalten">
			<img src="'.$folder_url.'/'.$row['picture'].'" class="cc_preview" width="500" height="auto" />
		</p>
		<div class="clearer linie"></div>
		';
		$zahler++;
	}
}
else echo '<p>Noch kein Bilder hochgeladen.</p>';
?>
	</div>
<?php
	echo '
		<div class="div_submit">
			<input type="submit" name="speichern" class="submit left cc_loupslider_button" value="Hochladen / speichern" />
			<input type="submit" name="loeschen" class="loeschen cc_loupslider_button" value="Auswahl l&ouml;schen" />
			<input type="button" class="abbrechen cc_loupslider_button" value="'.$TEXT['CANCEL'].'" onclick="javascript: window.location = \''.ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'\';" />
		</div>';
?>
</form>
<hr/>
<!-- END main_block -->