<?
    $GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

    $req = $_POST['req'];
    
    function SQL_get_user_id($user_id) {

        $r = libQuery("
            SELECT COUNT(*) AS cnt
            FROM choice_account
            WHERE user_id = ?
        ", 'i', array($user_id));

        return $r[0]['cnt'];
    }

    function SQL_get_logincode($user_id) {

        $r = libQuery("
            SELECT logincode
            FROM choice_account
            WHERE user_id = ?
        ", 'i', array($user_id));

        return $r[0]['logincode'];
    }

    function SQL_get_ID($id) {

        $r = libQuery("
            SELECT COUNT(*) AS cnt
            FROM choice_account
            WHERE uid = ?
        ", 's', array($id));

        return $r[0]['cnt'];
    }

    function SQL_get_UID($user_id) {

        $r = libQuery("
            SELECT uid
            FROM choice_account
            WHERE user_id = ?
        ", 'i', array($user_id));

        return $r[0]['uid'];
    }

    function SQL_setting_code($user_id, $code) {

        libQuery("
            UPDATE choice_account
            SET logincode = ?
            WHERE user_id = ?
        ", 'si', array($code, $user_id));

    }

    function SQL_sign_up($user_id, $uid, $upw) {
        $upw = password_hash($upw, PASSWORD_DEFAULT);

        libQuery("
            UPDATE choice_account
            SET uid = ?, upw = ?
            WHERE user_id = ?
        ", 'ssi', array($uid, $upw, $user_id));

    }

    switch($req) {
        case 'setCode':
            $user_id = $_POST['user_id'];
            $hasUserId = SQL_get_user_id($user_id);
            if ($hasUserId) {
                $userLoginCode = SQL_get_logincode($user_id);
                if ($userLoginCode) {
                    libReturn('HASCODE');
                } else {
                    $code = uniqid();
                    SQL_setting_code($user_id, $code);
                    libReturn('OK');
                }
            } else {
                libReturn('NOACCOUNT');
            }
            break;
        
        case 'signup':
            if ($_POST['choice_id']) {
                if (SQL_get_ID($_POST['choice_id']) == 0) {
                    if ($_POST['choice_pw']) {
                        if ($_POST['choice_pw2']) {
                            if ($_POST['choice_pw'] == $_POST['choice_pw2']) {
                                if ($_POST['choice_user_id']) {
                                    $hasUserId = SQL_get_user_id($_POST['choice_user_id']);
                                    if ($hasUserId) {
                                        if (!SQL_get_UID($_POST['choice_user_id'])) {
                                            if (@$_POST['choice_code']) {
                                                $user_code = SQL_get_logincode($_POST['choice_user_id']);
                                                if ($user_code) {
                                                    if ($_POST['choice_code'] == $user_code) {
                                                        SQL_sign_up($_POST['choice_user_id'], $_POST['choice_id'], $_POST['choice_pw']);
                                                        libReturn('OK');
                                                    } else {
                                                        libReturn('인증번호가 일치하지 않습니다.');
                                                    }
                                                } else {
                                                    libReturn('인증번호가 일치하지 않습니다.');
                                                }
                                            } else {
                                                libReturn('인증번호를 입력해주세요.');
                                            }
                                        } else {
                                            libReturn('이미 회원으로 가입된 고유번호입니다.');
                                        }
                                    } else {
                                        libReturn('초이스 서버에 가입된 고유번호가 아닙니다. 만약 가입되어 있다면 서버 접속 후 재시도해주세요.');
                                    }
                                } else {
                                    libReturn('고유번호를 입력해주세요.');
                                }
                            } else {
                                libReturn('비밀번호가 일치하지 않습니다.');
                            }
                        } else {
                            libReturn('비밀번호 확인을 입력해주세요.');
                        }
                    } else {
                        libReturn('비밀번호를 입력해주세요.');
                    }
                } else {
                    libReturn('중복된 아이디입니다. 다른 아이디를 입력해주세요.');
                }
            } else {
                libReturn('아이디를 입력해주세요.');
            }
            break;
    }
    
?>