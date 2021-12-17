<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

function fAPI() {
	$page = (int)(@$_GET['page'] ?: 1);
	$user_id = (int)(@$_GET['user_id'] ?: 0);
	$where = '';
	if ($user_id) {
		$where = "AND (g.give_id = $user_id OR g.take_id = $user_id)";
	}
	$max_row = 20;
	$offset = ($page - 1) * $max_row;

    $filename = strtolower(basename($_SERVER["SCRIPT_NAME"]));
    if ($filename == 'givelog.php') {
        $flag = '원격배송';
    } elseif ($filename == 'quicklog.php') {
        $flag = '퀵배송';
	} elseif ($filename == 'registerlog.php') {
        $flag = '회원가입 선물';
    } else return;

	$r_cnt = libQuery("
		SELECT COUNT(*) AS cnt
		FROM choice_giveitem AS g
		WHERE g.flag = '$flag' $where
	");

	if ($r_cnt[0]['cnt'] < 1) {
		echo "<script>alert('고유번호를 다시 확인해주세요.');</script>";
	}

	$r_list = libQuery("
		SELECT g.*, a.nickname AS give_nickname, b.nickname AS take_nickname
		FROM choice_giveitem AS g
        LEFT JOIN choice_account AS a ON a.user_id = g.give_id
        LEFT JOIN choice_account AS b ON b.user_id = g.take_id
		WHERE g.flag = '$flag' $where
		ORDER BY send_date DESC
		LIMIT ?
		OFFSET ?
	", 'ii', array($max_row, $offset));

	$r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

	$page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";


	

	return libReturn('log_list', array('max_row'=>$max_row, 'page'=>$page, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row), 'prev'=>$prev, 'next'=>$next, 'list'=>$r_list));

}
return fAPI();
?>