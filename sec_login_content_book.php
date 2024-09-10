<?php require_once('./Connections/conn_books_db.php'); ?>
<?php  
//取得要返回的php頁面
if(isset($_GET['sPath']) ){
    $sPath=$_GET['sPath'].".php" ;
}else{
    //登入完成進入首頁
    $sPath='./index.php';
}
//檢查是否完成登入驗證
if(isset($_SESSION['login']) ){
    header(sprintf("location:%s",$sPath));
}
?>
<div id="logincontainer" class="container-fluid">
    <div class="mycard mycard-container">
        <div id="login-t" class="text-center">
            <!-- <img src="./pro_book_images/bw_logo.svg" id="profile-img" class="profile-img-card d-block" alt="logo"> -->
            <p id="profile-name" class="profile-name-card text-center">LOGIN</p>
            <form action="" method="post" class="form-signin" id="formlogin">
                <input type="email" name="inputAccount" id="inputAccount" class="form-control" placeholder="Account" required autofocus>
                <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                <button type="submit" class="btn btn-signin mt-4">sign in</button>
            </form>
            <div class="other mt-5 text-center">
                <a href="#" class="mx-3">Forget password?</a>
            </div>
        </div>
        <hr class="login-hr">
        <div id="login-m" class="text-center mt-3 ">
            <p>新用戶</p>
            <a href="./page_register_book.php" class="btn btn-new "><span class="spancreate">建立帳號</span><span><i class="fas fa-square-plus fa-xl"></i></span></a>
        </div>
        <hr class="login-hr">
        <div id="login-b" class="text-center mt-5 snsbtns">
            <p>使用SNS帳號繼續</p>
            <button type="button" class="btn btn-sns mx-3"><i class="fa-brands fa-google fa-2xl"></i></button>
            <button type="button" class="btn btn-sns mx-3"><i class="fa-brands fa-twitter fa-2xl"></i></button>
            <button type="button" class="btn btn-sns mx-3"><i class="fa-brands fa-apple fa-2xl"></i></button>
        </div>
    </div>
</div>
<div id="loading" class="position-fixed w-100 h-100 top-0 start-0" name="loading" style="display: none; background: rgba(255, 255,255,.5);z-index: 9999;"><i class="fas fa-spinner fa-spin fa-5x fa fw position-absolute top-50 start-50"></i></div>

