<?
	$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
	include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

    $max_row = 20;
    $page = @$_GET['page'] ?: 1;

    $r_cnt = libQuery("
        SELECT COUNT(*) AS cnt
        FROM hive_bbs AS b
            LEFT JOIN hive_category AS c ON b.cid = c.idx
        WHERE b.dflag = FALSE
        AND c.dflag = FALSE
        AND b.bbs = ?
    ", 's', array($bbs));

    $noti_list = libQuery("
        SELECT b.idx, b.wflag, c.cname, b.title, b.user_id, b.wdate, b.hit
        FROM hive_bbs AS b
            LEFT JOIN hive_category AS c ON b.cid = c.idx
        WHERE b.dflag = FALSE
        AND c.dflag = FALSE
        AND b.bbs = ?
        AND b.wflag = '공지'
        ORDER BY b.idx DESC
    ", 's', array($bbs));

    $r_list = libQuery("
        SELECT b.idx, b.wflag, c.cname, b.title, b.user_id, b.wdate, b.hit
        FROM hive_bbs AS b
            LEFT JOIN hive_category AS c ON b.cid = c.idx
        WHERE b.dflag = FALSE
        AND c.dflag = FALSE
        AND b.bbs = ?
        AND b.wflag <> '공지'
        ORDER BY b.idx DESC
        LIMIT ? OFFSET ?
    ", 'sii', array($bbs, $max_row, ($page - 1) * $max_row));

    $r_is_exist_next = $max_row * $page < $r_cnt[0]['cnt'];

    $page > 1 
		? $prev = $page-1 : $prev="";
	$r_is_exist_next
		? $next = $page+1 : $next="";

    $r = array('max_row'=>$max_row, 'page'=>$page, 'prev'=>$prev, 'next'=>$next, 'tot_cnt'=>ceil($r_cnt[0]['cnt'] / $max_row));

?>
