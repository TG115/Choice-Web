<?
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

if(!isset($_SESSION)) session_start();

switch(basename($_SERVER["SCRIPT_NAME"])) {
    case 'notice.php': $bbs = "공지사항"; break;
    case 'freeboard.php': $bbs = "자유 게시판"; break;
    case 'eventboard.php': $bbs = "이벤트 게시판"; break;
    case 'tipboard.php': $bbs = "꿀팁 게시판"; break;
    case 'qnaboard.php': $bbs = "질문 게시판"; break;
        
}

function SQL_Get_bbs($idx) {
    $r = libQuery("
        SELECT bbs
        FROM hive_bbs
        WHERE idx = ?
    ;", "i", array($idx));

    return $r[0]['bbs'] ?? '';
}

function getPageName($bbs) {
    if ($bbs == "공지사항") return "notice.php";
    elseif ($bbs == "자유 게시판") return "freeboard.php";
    elseif ($bbs == "이벤트 게시판") return "eventboard.php";
    elseif ($bbs == "꿀팁 게시판") return "tipboard.php";
    elseif ($bbs == "질문 게시판") return "qnaboard.php";
}

$arr_cate = libQuery("
    SELECT *
    FROM hive_category
    WHERE bbs = ?
;", "s", array(@$_GET['bbs'] ?? SQL_Get_bbs(@$_GET['idx'])));

?>