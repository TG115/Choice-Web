<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';


function fAPI() {
	$id = @$_GET['idx'];

	$r_prev = array();
	$r_next = array();

	$r_this = libQuery("
		SELECT b.idx, b.bbs, b.title, b.content, b.user_id, b.wdate, b.hit, c.cname
		FROM hive_bbs AS b
			LEFT JOIN hive_category AS c ON c.idx = b.cid
		WHERE b.dflag = 0 AND c.dflag = 0 AND b.idx = ?
		LIMIT 1
	", 'i', array($id));

	if (count($r_this)) {
		$bbs = $r_this[0]['bbs'];

		if (!@$GLOBALS['api_params']['not_view_cnt'] && $r_this[0]['user_id'] != @$_SESSION['user_id']) {
			libQuery("
				UPDATE hive_bbs
				SET hit = hit + 1
				WHERE dflag = 0 AND idx = ?
			", 's', array($id));
		}

		$r_prev = libQuery("
			SELECT b.idx, b.bbs, b.cid, b.title
			FROM hive_bbs AS b
				LEFT JOIN hive_category AS c ON c.idx = b.cid
			WHERE b.dflag = 0
			AND c.dflag = 0
			AND b.bbs = ?
			AND b.idx > ?
			ORDER BY b.idx ASC
			LIMIT 1
		", 'si', array($bbs, $r_this[0]['idx']));

		$r_next = libQuery("
            SELECT b.idx, b.bbs, b.cid, b.title
			FROM hive_bbs AS b
				LEFT JOIN hive_category AS c ON c.idx = b.cid
			WHERE b.dflag = 0
			AND c.dflag = 0
			AND b.bbs = ?
			AND b.idx < ?
			ORDER BY b.idx DESC
			LIMIT 1
            ", 'si', array($bbs, $r_this[0]['idx']));
	} else {
        echo "<script>alert('게시글이 존재하지 않습니다.'); history.back();</script>";
    }

	return libReturn('blog_view', array('id'=>$id, 'bbs'=>$bbs, 'this'=>$r_this, 'prev'=>$r_prev, 'next'=>$r_next));
}
return fAPI();

?>
