<?php
/**
 *  @template		cc_loupslider
 *  @version		see info.php of this template
 *  @author			Matthias Glienke, creativecat
 *  @copyright		2012 Matthias Glienke
 *  @license		Copyright by Matthias Glienke, creativecat
 *  @license terms	see info.php of this module
 *  @platform		see info.php of this module
 *  @requirements	PHP 5.2.x and higher
 */

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(!defined('WB_PATH')) {
	require_once(dirname(dirname(__FILE__)).'/framework/globalExceptionHandler.php');
	throw new IllegalFileException();
}
/* -------------------------------------------------------- */

$module_directory	= 'cc_loupslider';
$module_name		= 'cc_loupslider';
$module_function	= 'page';
$module_version		= '1.0.3';
$module_platform	= '2.8.x';
$module_author		= 'Matthias Glienke, creativecat.de';
$module_license		= 'GNU General Public License';
$module_description	= 'Dieses Modul ermöglicht die Integration des Loupsliders von creativecat';

?>