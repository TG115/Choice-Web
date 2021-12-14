<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/database.php';
	$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';

	$id = $_POST['choice_id'];
	$pw = $_POST['choice_pw'];
	
	function SQL_CheckID($id, $pw) {
        $upw = libQuery("
            SELECT upw
            FROM choice_account
            WHERE uid = ? AND dflag = FALSE
        ", 's', array($id));

        if (count($upw) == 0) return [];

        if (password_verify($pw, $upw[0]['upw'])) {
            return libQuery("
                SELECT *
                FROM choice_account
                WHERE uid = ? AND dflag = FALSE
            ", 's', array($id));
        } else return [];

	}

	function SQL_UpdateLastLogin($id) {
		return libQuery("
			UPDATE choice_account
			SET last_login = NOW()
			WHERE uid = '$id' AND dflag = FALSE
		");
	}

	$r = SQL_CheckID($id, $pw);

    // echo $r;
	if (count($r) == 1) {
		session_start();
		SQL_UpdateLastLogin($id);
		$_SESSION['choice_id'] = $id;
		$_SESSION['choice_nickname'] = $r[0]['nickname'];
		$_SESSION['user_id'] = $r[0]['user_id'];
		if ($r[0]['grade'] > 0) $_SESSION['isadmin'] = true;
		header('location:/');
	} else {
		print "<script> alert('회원정보가 일치하지 않습니다.'); location.replace('/login.php'); </script>";
	}

?>
