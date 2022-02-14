<?
    $GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

    $req = $_POST['req'] ?? '';
    
    function SQL_change_password($user_id, $upw) {
        $upw = password_hash($upw, PASSWORD_DEFAULT);

        libQuery("
            UPDATE hive_account
            SET upw = ?
            WHERE user_id = ?
        ;", 'si', array($upw, $user_id));
    }

    function SQL_getUserIdentity($user_id) {
        return libQuery("
            SELECT *
            FROM vrp_user_identities
            WHERE user_id = ?
        ;", 'i', array($user_id));
    }

    function SQL_getUserHome($user_id) {
        return libQuery("
            SELECT home, number
            FROM vrp_user_homes
            WHERE user_id = ?
        ;", 'i', array($user_id));
    }

    function SQL_CheckPW($user_id, $pw) {
        $upw = libQuery("
            SELECT upw
            FROM hive_account
            WHERE uid = ? AND dflag = FALSE
        ", 's', array($user_id));

        return password_verify($pw, $upw[0]['upw']);

	}

    function SQL_GetUserPhone($user_id) {
        return libQuery("
            SELECT phone_bg
            FROM hive_account
            WHERE user_id = ?
        ", 'i', array($user_id));
    }

    switch($req) {        
        case 'changePW':
            if ($_POST['hive_nowpw']) {
                if ($_POST['hive_pw']) {
                    if ($_POST['hive_pw2']) {
                        if (SQL_getUserAccount($_SESSION['user_id'], $_POST['hive_nowpw'])) {
                            if ($_POST['hive_pw'] == $_POST['hive_pw2']) {
                                SQL_change_password($_SESSION['user_id'], $_POST['hive_pw']);
                                libReturn('OK');
                            } else {
                                libReturn('변경할 비밀번호가 일치하지 않습니다.');
                            }
                        } else {
                            libReturn('현재 비밀번호를 확인해주세요.');
                        }
                    } else {
                        libReturn('변경할 비밀번호 확인을 입력해주세요.');
                    }
                } else {
                    libReturn('변경할 비밀번호를 입력해주세요.');
                }
            } else {
                libReturn('현재 비밀번호를 입력해주세요.');
            }
            break;
        
        case '':
            $identity = SQL_getUserIdentity($_SESSION['user_id'])[0];
            $home = SQL_getUserHome($_SESSION['user_id'])[0] ?? '';
            $thumb = SQL_GetUserPhone($_SESSION['user_id'])[0]['phone_bg'];
            // $point = SQL_getUserAccount($_SESSION['user_id'])[0] ?? 0;
            break;
    }
    
?>