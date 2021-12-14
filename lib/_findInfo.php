<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/database.php';
	$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';

    $req = $_POST['req'] ?? '';
	
    switch($req) {
        case '':
            echo "<script>alert('올바르지 않은 접근입니다.');location.href='/';</script>";
            break;
        case 'id':
            $user_id = $_POST['f_user_id'] ?? '';
            $logincode = $_POST['f_logincode'] ?? '';
			$r = SQL_findID($user_id, $logincode);
			if (count($r) == 1) {
				print "<script> alert('" . $r[0]['nickname'] . "[" . $r[0]['user_id'] . "]님의 ID는 " . $r[0]['uid'] . " 입니다.'); location.href = '/findID.php'; </script>";
			} else {
				print "<script> alert('일치하는 회원정보가 없습니다.'); location.href = '/findID.php'; </script>";
			}
            break;

        case 'pw':
            $user_id = $_POST['f_user_id'] ?? '';
            $id = $_POST['f_id'] ?? '';
            $logincode = $_POST['f_logincode'] ?? '';
			$r = SQL_findPW($user_id, $id, $logincode);
			if (count($r) == 1) {
				if (!isset($_SESSION)) {
					session_start();
				}
				$_SESSION['changeinfo'] = $r[0];
				print "<script> location.href = '/changePW.php'; </script>";
			} else {
				print "<script> alert('일치하는 회원정보가 없습니다.'); location.href = '/findPW.php'; </script>";
			}
            break;

		case 'changePW':
			if ($_POST['choice_pw']) {
				if ($_POST['choice_pw2']) {
					if ($_POST['choice_pw'] == $_POST['choice_pw2']) {
						SQL_change_password($_POST['c_user_id'], $_POST['choice_pw']);
                        if (!isset($_SESSION)) {
                            session_start();
                        }
						unset($_SESSION['changeinfo']);
						libReturn('OK');
					} else {
						libReturn('변경할 비밀번호가 일치하지 않습니다.');
					}
				} else {
					libReturn('변경할 비밀번호 확인을 입력해주세요.');
				}
			} else {
				libReturn('변경할 비밀번호를 입력해주세요.');
			}
            break;
			
    }
    
	function SQL_findID($user_id, $logincode) {
		return libQuery("
			SELECT nickname, user_id, uid
			FROM choice_account
			WHERE user_id = ? AND logincode = ? AND dflag = FALSE
		", 'is', array($user_id, $logincode));
	}

	function SQL_findPW($user_id, $id, $logincode) {
		return libQuery("
			SELECT user_id, uid
			FROM choice_account
			WHERE user_id = ? AND uid = ? AND logincode = ? AND dflag = FALSE
		", 'iss', array($user_id, $id, $logincode));
	}

	function SQL_change_password($user_id, $upw) {
        $upw = password_hash($upw, PASSWORD_DEFAULT);

        libQuery("
            UPDATE choice_account
            SET upw = ?
            WHERE user_id = ?
        ;", 'si', array($upw, $user_id));
    }
	
	// $r = SQL_CheckID($id, $pw);
	// if (count($r) == 1) {
	// 	session_start();
	// 	SQL_UpdateLastLogin($id);
	// 	$_SESSION['choice_id'] = $id;
	// 	$_SESSION['choice_nickname'] = $r[0]['nickname'];
	// 	$_SESSION['user_id'] = $r[0]['user_id'];
	// 	if ($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 17) $_SESSION['isadmin'] = true;
	// 	header('location:/');
	// } else {
	// 	print "<script> alert('회원정보가 일치하지 않습니다.'); location.replace('/login'); </script>";
	// }

?>
