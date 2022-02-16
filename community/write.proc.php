<?
	$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
	include_once 'bbs.proc.php';

	function fAPI() {
		$ACT = @$_GET['ACT'] ?: @$_POST['ACT'];
		$idx = @$_GET['idx'] ?: @$_POST['idx'];
        $bbs = @$_GET['bbs'] ?: @$_POST['bbs'];
        $wflag = "일반글";
        if (isset($_POST['noti'])) if ($_POST['noti']) $wflag = "공지";
        $cid = @$_GET['cid'] ?: @$_POST['cid'];
		$date = date("Y-m-d H:i:s");
		$ip = $_SERVER["REMOTE_ADDR"];

        if ($bbs == '') $bbs = SQL_Get_bbs($idx);
        if ($bbs == '') echo "<script>alert('존재하지 않는 게시판입니다.'); location.href='/';</script>";
		switch ($ACT) {
			case 'w':
			case 'u':
				
				$title = trim($_POST['title']);
				$conts = trim($_POST['conts']);

				if (!$title) libReturn('제목을 입력하세요.');
				if (strlen($title) > 200) libReturn('제목이 너무 길어요.');

				if ($ACT == 'w') {
					libQuery("
						INSERT INTO hive_bbs(bbs, wflag, cid, title, content, wdate, user_id)
						VALUES(?, ?, ?, ?, ?, NOW(), ?)
					", 'ssissi', array($bbs, $wflag, $cid, $title, $conts, $_SESSION['user_id']));

					libReturn('insert', array("bbs"=>$bbs,"pagename"=>getPageName($bbs)));
				} else {
                    libQuery("
                        UPDATE hive_bbs
                        SET   wflag = ?
                            , cid = ?
                            , title = ?
                            , content = ?
                            , user_id = ?
                        WHERE dflag = 0 AND idx=?
                    ", 'sissii', array($wflag, $cid, $title, $conts, $_SESSION['user_id'], $idx));
					
					libReturn('update', array("bbs"=>$bbs,"pagename"=>getPageName($bbs)));
				}
			break;
			case 'r':
				$r = libQuery("
					SELECT * FROM hive_bbs WHERE dflag = 0 AND idx=?
				", 'i', array($idx));

				if (count($r)) {
					return libReturn('write_r', array('ACT'=>$ACT, 'idx'=>$idx, 'bbsOne'=>$r));
				} else {
					return libReturn('write_r', array('ACT'=>$ACT, 'idx'=>$idx, 'err_msg'=>'존재하지 않는 글입니다.'));
				}
			break;
			case 'd':
				libQuery("
					UPDATE hive_bbs
					SET dflag=1, ddate=CURRENT_TIMESTAMP
					WHERE dflag = 0 AND idx=?
				", 'i', array($idx));

				libReturn('delete', array("bbs"=>$bbs,"pagename"=>getPageName($bbs)));
			break;
		}
	}
	return fAPI();
		
?>