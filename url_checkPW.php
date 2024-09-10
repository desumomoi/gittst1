<?php
include_once('./Connections/conn_books_db.php');

if (isset($_GET['emailid'])) {
    $emailid = $_GET['emailid'];
    $PWOld=MD5($_GET['PWOld']);
    // $query = sprintf("SELECT emailid FROM member WHERE emailid='%d' AND pw1='%s'",$emailid,$PWOld);
    // $result=$link->query($query);
    $query = $link->prepare("SELECT emailid FROM member WHERE emailid=? AND pw1=?");
    // $query->bindValue(1,$emailid,PDO::PARAM_INT);
    // $query->bindValue(2,$PWOld,PDO::PARAM_STR);
    // $query->execute();
    $query->execute([$emailid,$PWOld]);
    $result = $query; //將 PDOStatement 賦值給 $result
    $row=$result->rowCount();
    if ($row!=0) {
        echo 'true';
        return;
    }
}
echo 'false';
return;
?>