<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

if(!isset($_SESSION)) session_start();

$ACT = @$_GET['ACT'] ?: @$_POST['ACT'];

if ($ACT) {
    
    switch ($ACT) {
        case 'w':
            $comment = trim($_POST['comment']);
            $idx = $_POST['idx'];
            if (!$comment) libReturn('댓글을 입력하세요.');

            libQuery("
                INSERT INTO hive_bbs_comment(idx, comment, wdate, user_id)
                SELECT ?, ?, NOW(), ? FROM hive_bbs LIMIT 1
            ", 'isi', array($idx, $comment, $_SESSION['user_id']));

            libReturn('insert');
        break;
        case 'd':
            $cmt_idx = @$_GET['cmt_idx'] ?: @$_POST['cmt_idx'];
            $r = libQuery("
                SELECT user_id
                FROM hive_bbs_comment
                WHERE cmt_idx = ?
            ;", "i", array($cmt_idx));

            if ($r[0]['user_id'] != $_SESSION['user_id'] && !isset($_SESSION['isadmin'])) {
                libReturn("댓글 삭제 권한이 없습니다.");
            } else {

                libQuery("
                    UPDATE hive_bbs_comment
                    SET dflag=1, ddate=CURRENT_TIMESTAMP
                    WHERE dflag = 0 AND cmt_idx=?
                ", 'i', array($cmt_idx));

                libReturn('delete');
            }
        break;
    }
} else {
    return fAPI_cmt();
}

function fAPI_cmt() {
	$id = @$_GET['idx'];


	$r_this = libQuery("
		SELECT *
		FROM hive_bbs_comment
		WHERE idx = ? AND dflag = 0
	", 'i', array($id));

	return libReturn('comment', array('id'=>$id, 'this'=>$r_this));
}


?>
