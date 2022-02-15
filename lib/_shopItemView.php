<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
	return libQuery("SELECT * FROM hive_shop WHERE idx = ?", 'i', array($_GET['idx']));
}
return fAPI();
?>