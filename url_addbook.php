<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); ?>
<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
(!isset($_SESSION)) ? session_start() : '';
if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != "") {
    $emailid = $_SESSION['emailid'];
    $cname = $_POST['cname'];
    $mobile = $_POST['mobile'];
    $myzip = $_POST['myZip'];
    $address = $_POST['address'];
    // $query = sprintf("UPDATE addbook SET setdefault='0' WHERE emailid='%d' AND setdefault ='1';", $emailid);
    // $result = $link->query($query);
    // $query = "INSERT INTO addbook(setdefault,emailid,cname,mobile,myzip,address) VALUES ('1','" . $emailid . "','" . $cname . "','" . $mobile . "','" . $myzip . "','" . $address . "') ";
    // $result = $link->query($query);

    $query1 = $link->prepare("UPDATE addbook SET setdefault='0' WHERE emailid=? AND setdefault='1' ");
    $result1 = $query1->execute([$emailid]); //excute 執行語句
    // $query1->bindParam(1, $emailid,PDO::PARAM_INT); //1是第一個參數的位置，PDO::PARAM_INT指定類型
    // $result1 = $query1->execute(); //excute 執行語句

    $query2=$link->prepare("INSERT INTO addbook(setdefault,emailid,cname,mobile,myzip,address) VALUES ('1',?,?,?,?,?)");
    $result2=$query2->execute([$emailid,$cname,$mobile,$myzip,$address]);
    // $query2->bindParam(1,$emailid,PDO::PARAM_INT);
    // $query2->bindParam(2,$cname,PDO::PARAM_STR);
    // $query2->bindParam(3,$mobile,PDO::PARAM_INT);
    // $query2->bindParam(4,$myzip,PDO::PARAM_INT);
    // $query2->bindParam(5,$address,PDO::PARAM_STR);
    // $result=$query2->execute();

    if ($result2) {
        $retcode = array("c" => "1", "m" => '收件人資料新增成功');
    } else {
        $retcode = array("c" => "0", "m" => '資料無法寫入，請聯絡管理人員');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>