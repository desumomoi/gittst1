<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string
require_once('./Connections/conn_books_db.php');

if (isset($_GET['emailid']) && $_GET['emailid'] != "") {
    // $query=sprintf("SELECT emailid,email,cname,tssn,birthday,imgname FROM member WHERE emailid=?",$emailid);
    // $result = $link->query($query); 
    $emailid = $_GET['emailid'];
    $cname = $_GET['cname'];
    $birthday = $_GET['birthday'];
    $imgname = $_GET['imgname'];
    // $tssn = $_GET['tssn'];
    $query = $link->prepare("UPDATE member SET cname=?,birthday=?,imgname=? WHERE member.emailid=?");
    $query->execute([$cname,$birthday,$imgname,$emailid]);
    $result = $query; //將 PDOStatement 賦值給 $result
    if ($result) {
        (!isset($_SESSION)?session_start():"");
        $_SESSION['cname']=$cname;
        $_SESSION['imgname']=$imgname;
        $retcode = array("c" => "1", "m" => '謝謝您！會員資料已更新！');
    } else {
        $retcode = array("c" => "0", "m" => "資料無法寫入！若重複出現此訊息，請與管理人員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>






