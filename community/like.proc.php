<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

if(!isset($_SESSION)) session_start();
function fAPI() {
    if (isset($_SESSION['user_id'])) {
        $id = @$_POST['idx'];
        
        $r = libQuery("
            SELECT COUNT(*) AS cnt
            FROM hive_bbs_likes
            WHERE user_id = ? AND idx = ?
        ", "ii", array($_SESSION['user_id'], $id));

        if($r[0]['cnt']) {
            return libReturn('이미 해당 글을 추천하였습니다.');
        } else {
            libQuery("
                INSERT INTO hive_bbs_likes
                VALUES (?, ?)
            ;", "ii", array($_SESSION['user_id'], $id));

            libReturn('OK', array("idx"=>$id, "like"=>SQL_Get_bbs_like($id)));
        }
    } else {
        return libReturn('게시글 추천은 로그인 후 사용 가능합니다.');
    }
}
return fAPI();

?>
