<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); ?>
<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
(!isset($_SESSION))?session_start():'';
if(isset($_POST['inputAccount']) && isset($_POST['inputPassword']) ){
    $inputAccount=$_POST['inputAccount'];
    $inputPassword=$_POST['inputPassword'];
    $query=sprintf("SELECT * FROM member WHERE email='%s' AND pw1='%s' ",$inputAccount,$inputPassword);
    $result=$link->query($query);
    if($result){
        if ($result->rowCount()==1) {
            $data=$result->fetch();
            if ($data['active']) {
                $_SESSION['login']=true ;
                $_SESSION['emailid']=$data['emailid'] ;
                $_SESSION['email']=$data['email'] ;
                $_SESSION['cname']=$data['cname'] ;
                $_SESSION['imgname']=$data['imgname']; //會員頭像
                $retcode=["c"=>"1","m"=>'會員驗證成功' ];
            }else{
                $retcode=["c"=>"2","m"=>'會員帳號鎖定中！請聯繫管理人員'];
            }
        }else{
            $retcode=["c"=>"2","m"=>"帳號或密碼錯誤！請重新輸入"];
        }
    }else{
        $retcode=["c"=>"0","m"=>"會員驗證失敗！請聯繫管理人員"];
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>