<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
	$page = (int)(@$_GET['page'] ?: 1);
	$category = @$_GET['cate'];
	$where = "AND category = '$category'";
	if (basename($_SERVER["SCRIPT_NAME"]) === 'shop.php') $where .= ' AND status = TRUE';
	$max_row = 15;
	$offset = ($page - 1) * $max_row;

	$r_cnt = libQuery("
		SELECT COUNT(*) AS cnt
		FROM hive_shop
		WHERE dflag = FALSE $where
	");

	// if ($r_cnt[0]['cnt'] < 1) {
	// 	echo "<script>alert('고유번호를 다시 확인해주세요.');</script>";
	// }

	$r_list = libQuery("
		SELECT *
		FROM hive_shop
		WHERE dflag = FALSE $where
		ORDER BY wdate DESC
		LIMIT ?
		OFFSET ?
	", 'ii', array($max_row, $offset));

	$r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

	$page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";
        
	return libReturn('shop_list', array('max_row'=>$max_row, 'page'=>$page, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row), 'prev'=>$prev, 'next'=>$next, 'list'=>$r_list));
}

return fAPI();
?>