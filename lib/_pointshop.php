<?
    $GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

    if(!isset($_SESSION)) session_start();

    $req = @$_POST['req'] ?? '';

    function SQL_getItemInfo($idx) {

        $item = libQuery("SELECT * FROM hive_shop WHERE idx = ?", 'i', array($idx))[0];

        $name = $item['name'];
        $idname = $item['code'];
        $price = $item['price'] * (100 - $item['sale']) / 100;
        $amount = $item['amount'];

        return array("idname"=>$idname, "price"=>$price, "itemname"=>$name, "amount"=>$amount);
    }

    function SQL_buy_items($user_id, $itemInfo, $itemname, $amount, $price) {

        libQuery("
            INSERT INTO hive_giveitem (give_id, take_id, idname, itemname, amount, flag, send_date)
            VALUES (?, ?, ?, ?, ?, '구매완료', NOW())
        ;", "iissi", array($user_id, $user_id, $itemInfo['idname'], "{$itemname} {$amount}개", $amount));
    }

    function SQL_get_Mypoint($user_id) {
        $r = libQuery("
            SELECT point
            FROM hive_account
            WHERE user_id = ?
        ;", "i", array($user_id));

        return $r[0]['point'];
    }

    switch ($req) {
        case 'buy':
            $user_id = $_SESSION['user_id'];
            $idx = $_POST['idx'];
            $itemInfo = SQL_getItemInfo($idx);
            $itemname = $itemInfo['itemname'];
            $amount = $_POST['amount'];

            if ($amount > 0) {
                $price = $itemInfo['price'] * $amount;
                $myPoint = SQL_get_Mypoint($user_id);
                if ($myPoint >= $price) {
                    SQL_pointLog($user_id, "아이템 구매", "[" . $itemname ."] " . $amount . "개", ($price * -1));
                    SQL_setUserPoint($user_id, ($price * -1));
                    SQL_buy_items($user_id, $itemInfo, $itemname, $amount, $price);
                    libReturn("success", array("itemname"=>$itemname, "amount"=>$amount, "price"=>$price));
                } else {
                    libReturn("보유 포인트가 부족합니다.");
                }
            } else {
                libReturn("구매 개수를 확인해주세요.");
            }
            break;
    }
?>