<?php

if(defined('WB_URL')) {
	
	// Create table for galleries
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_cc_loupslider`");
	$mod_slider = 'CREATE TABLE  `'.TABLE_PREFIX.'mod_cc_loupslider` ('
		 . '`loupslider_id` INT NOT NULL AUTO_INCREMENT,'
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `navigation` TINYINT NOT NULL DEFAULT \'0\','
		. ' `random` TINYINT NOT NULL DEFAULT \'0\','
		. ' `easing` VARCHAR(64) NOT NULL DEFAULT \'0\','
		. ' `watermark` VARCHAR(128) NOT NULL DEFAULT \'0\','
		. ' `resize_x` SMALLINT NOT NULL DEFAULT \'0\','
		. ' `resize_y` SMALLINT NOT NULL DEFAULT \'0\','
		. ' `durationTimeOut` MEDIUMINT(9) NOT NULL DEFAULT \'0\','
		. ' `durationBlende` MEDIUMINT(9) NOT NULL DEFAULT \'0\','
		. ' `opacity` VARCHAR(3) NOT NULL DEFAULT \'0\','
		. ' PRIMARY KEY ( `loupslider_id` )'
		. ' )';
	$database->query($mod_slider);

	// Create table for single pictures
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_cc_loupslider_images`");
	$mod_slider = 'CREATE TABLE  `'.TABLE_PREFIX.'mod_cc_loupslider_images` ('
		 . '`image_id` INT NOT NULL AUTO_INCREMENT,'
		. ' `loupslider_id` INT NOT NULL DEFAULT \'0\','
		. ' `picture` VARCHAR(256) NOT NULL DEFAULT \'0\','
		. ' `title` VARCHAR(512) NOT NULL DEFAULT \'0\','
		. ' `alt` VARCHAR(256) NOT NULL DEFAULT \'0\','
		. ' `linkname` VARCHAR(128) NOT NULL DEFAULT \'0\','
		. ' `link` VARCHAR(256) NOT NULL DEFAULT \'0\','
		. ' PRIMARY KEY ( `image_id` )'
		. ' )';
	$database->query($mod_slider);
	
}

?>