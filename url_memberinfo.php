<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string
require_once('./Connections/conn_books_db.php');

if (isset($_GET['emailid']) && $_GET['emailid'] != "") {
    $emailid = $_GET['emailid'];
    // $query=sprintf("SELECT emailid,email,cname,tssn,birthday,imgname FROM member WHERE emailid=%d",$emailid);
    // $result = $link->query($query); 
    $query=$link->prepare("SELECT emailid,email,cname,birthday,imgname FROM member WHERE emailid=?");
    $query->execute([$emailid]);
    $result = $query; //將 PDOStatement 賦值給 $result
    if ($result) {
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        $retcode = array("c" => "1", "m" => '',"d"=>$data);
    } else {
        $retcode = array("c" => "0", "m" => "資料無法寫入！若重複出現此訊息，請與管理人員聯絡");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>



