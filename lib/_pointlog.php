<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
    
	$page = (int)(@$_GET['page'] ?: 1);
	$user_id = (int)(@$_GET['user_id'] ?: 0);
    $where = '';
    $filename = strtolower(basename($_SERVER["SCRIPT_NAME"]));
    if ($filename === 'pointlogs.php') {
        $where = "WHERE user_id = {$_SESSION['user_id']}";
    } elseif ($filename === 'pointlog.php') {
        $where = "WHERE category = '포인트 지급'";
        if ($user_id) {
            $where .= " AND user_id = {$user_id}";
        }
    } else return;
	$max_row = 20;
	$offset = ($page - 1) * $max_row;

	$r_cnt = libQuery("
		SELECT COUNT(*) AS cnt
		FROM hive_point_log
        $where
	;");


	$r_list = libQuery("
		SELECT *
		FROM hive_point_log
        $where
		ORDER BY date DESC
		LIMIT ?
		OFFSET ?
	", 'ii', array($max_row, $offset));

	$r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

	$page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";


	

	return libReturn('blog_list', array('max_row'=>$max_row, 'page'=>$page, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row), 'prev'=>$prev, 'next'=>$next, 'list'=>$r_list));

}
return fAPI();
?>