<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
	$page = (int)(@$_GET['page'] ?: 1);
	$user_id = (int)(@$_GET['user_id'] ?: 0);
	$where = '';
	if ($user_id) {
		$where = 'WHERE u.user_id = '.$user_id;
	}
	$max_row = 20;
	$offset = ($page - 1) * $max_row;

	$r_cnt = libQuery("
		SELECT COUNT(*) AS cnt
		FROM hive_point_log
        WHERE user_id = ?
	;", "i", array($_SESSION['user_id']));


	$r_list = libQuery("
		SELECT *
		FROM hive_point_log
        WHERE user_id = ?
		ORDER BY date DESC
		LIMIT ?
		OFFSET ?
	", 'iii', array($_SESSION['user_id'], $max_row, $offset));

	$r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

	$page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";


	

	return libReturn('blog_list', array('max_row'=>$max_row, 'page'=>$page, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row), 'prev'=>$prev, 'next'=>$next, 'list'=>$r_list));

}
return fAPI();
?>