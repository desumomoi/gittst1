<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string
require_once('./Connections/conn_books_db.php');
(!isset($_SESSION)) ? session_start() : "";

if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != "") {

    $emailid = $_SESSION['emailid'];
    $addressid = $_POST['addressid'];
    $ip=$_SERVER['REMOTE_ADDR'];
    $orderid=date('Ymdhis').rand(10000,99999); // 自行產生時間+訂單編號
    $query=$link->prepare("INSERT INTO uorder (orderid,emailid,addressid,howpay,paystatus,status) VALUES (?,?,?,?,?,?)");
    $result=$query->execute([$orderid,$emailid,$addressid,3,35,7]);
    
    // 3,35,7 在表multiselect對映貨到付款,待貨到付款,處理中
    if ($result) {
        $query2=$link->prepare("UPDATE cart SET orderid=?,emailid=?,status='8' WHERE ip=? AND orderid IS NULL");
        $result2=$query2->execute([$orderid,$emailid,$ip]);
        $retcode = array("c" => "1", "m" => '謝謝您，結帳已完成！請至首頁查詢訂單狀態');
    } else {
        $retcode = array("c" => "0", "m" => "結帳失敗！若重複出現此訊息，請與管理人員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>
