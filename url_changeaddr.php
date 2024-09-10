<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string
require_once('./Connections/conn_books_db.php');
(!isset($_SESSION)) ? session_start() : "";

if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != "") {

    $emailid = $_SESSION['emailid'];
    $addressid = $_POST['addressid'];
    // 先修改將預設收件人取消
    $query1=$link->prepare("UPDATE addbook SET setdefault=0 WHERE emailid=? AND setdefault=1");
    $result1=$query1->execute([$emailid]);
    // 將選定收件人設定為預設收件人
    $query2=$link->prepare("UPDATE addbook SET setdefault=1 WHERE addressid=? ");
    $result2=$query2->execute([$addressid]);
    if ($result2) {
        $retcode = array("c" => "1", "m" => '收件人已變更！');
    } else {
        $retcode = array("c" => "0", "m" => "資料無法寫入！若重複出現此訊息，請與管理人員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>
<?php
// header('Access-Control-Allow-Origin:*');
// header('Content-Type:application/json;charset=utf-8'); //return json string
// require_once('./Connections/conn_books_db.php');
// (!isset($_SESSION)) ? session_start() : "";

// if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != "") {

//     $emailid = $_SESSION['emailid'];
//     $addressid = $_POST['addressid'];
//     // 先修改將預設收件人取消
//     $query1 = sprintf("UPDATE addbook SET setdefault='0' WHERE emailid='%d' AND  setdefault='1' ", $emailid);
//     $result1 = $link->query($query1);
//     // 將選定收件人設定為預設收件人
//     $query2 = sprintf("UPDATE addbook SET setdefault='1' WHERE addressid = '%d'", $addressid);
//     $result2 = $link->query($query2);
//     if ($result2) {
//         $retcode = array("c" => "1", "m" => '收件人已變更！');
//     } else {
//         $retcode = array("c" => "0", "m" => "資料無法寫入！若重複出現此訊息，請與管理人員聯絡");
//     }
//     echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
// }
// return;
?>





