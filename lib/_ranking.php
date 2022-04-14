<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
	$page = (int)(@$_GET['page'] ?: 1);
	$user_id = (int)(@$_GET['user_id'] ?: 0);
	$where = '';
	if ($user_id) {
		$where = 'WHERE h.user_id = '.$user_id;
	}
	$max_row = 20;
	$offset = ($page - 1) * $max_row;

	$r_cnt = libQuery("
		SELECT COUNT(*) AS cnt
		FROM hive_zombie AS h
		$where
	");

	if ($r_cnt[0]['cnt'] < 1) {
		echo "<script>alert('고유번호를 다시 확인해주세요.');location.href='/ranking.php';</script>";
	}

	$r_list = libQuery("
		SELECT h.user_id, h.exps, a.nickname, rank() over(order by h.exps DESC) AS rank
		FROM hive_zombie AS h
			LEFT JOIN hive_account AS a ON a.user_id = h.user_id
		$where
		ORDER BY h.exps DESC, h.user_id
		LIMIT ?
		OFFSET ?
	", 'ii', array($max_row, $offset));

	if ($user_id) {
		$myrank = libQuery("
			select count(*)+1 as rank 
			from hive_account AS a
				LEFT JOIN hive_zombie AS h ON a.user_id = h.user_id
			where h.exps > (select exps from hive_zombie where user_id=$user_id)")[0]['rank'];
		
		$myrank = $myrank;


		$r_list[0]['rank'] = $myrank;
	}

	$r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

	$page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";


	

	return libReturn('blog_list', array('max_row'=>$max_row, 'page'=>$page, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row), 'prev'=>$prev, 'next'=>$next, 'list'=>$r_list));

}
return fAPI();
?>