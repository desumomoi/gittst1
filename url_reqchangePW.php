<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string
require_once('./Connections/conn_books_db.php');

if (isset($_GET['emailid']) && $_GET['emailid'] != "") {
    $PWNew1=$_GET['PWNew1'];
    $emailid = $_GET['emailid'];
    // echo "PWNew1: " . $PWNew1 . "<br>";
    // echo "emailid: " . $emailid . "<br>";

    $query = $link->prepare("UPDATE member SET pw1=? WHERE member.emailid=?");
    $query->execute([$PWNew1, $emailid]);
    $result = $query; //將 PDOStatement 賦值給 $result
    // $query = sprintf("UPDATE member SET pw1='%s' WHERE member.emailid='%d'",$PWNew1, $emailid);
    // $result=$link->query($query);
    if ($result) {
        $retcode = array("c" => "1", "m" => '密碼已更新！');
    } else {
        $retcode = array("c" => "0", "m" => "資料無法寫入！若重複出現此訊息，請與管理人員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>