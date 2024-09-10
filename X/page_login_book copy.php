<?php require_once('./Connections/conn_books_db.php');
(!isset($_SESSION)) ? session_start() : "";
// require_once('./Connections/php_lib.php'); 
?>
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
<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Bookwalker</title>
    <?php require_once('./link_headfile_books.php'); ?>
    <link rel="stylesheet" href="./style/login.css">
</head>

<body>
    <div id="header">
        <!-- 引入網頁標頭 -->
        <?php require_once('./X/sec_navbar_book%20copy.php'); ?>
    </div>
    <div id="content">
        <div class="container-fluid">
            <!-- login -->
            <?php require_once('./sec_login_content_book.php'); ?>


        </div>
    </div>
    <div id="scontent">
        <!-- 服務說明 -->
        <?php require_once('./sec_scontent_book.php') ?>
    </div>
    <div id="footer">
        <!-- 聯絡資訊 -->
        <?php require_once('./sec_footer_book.php') ?>
    </div>
    <!-- JS -->
    <?php require_once('./link_jsfiles.php'); ?>

<script>
$(function () {
    $("#formlogin").submit(function () {
        let inputAccount = $("#inputAccount").val();
        let inputPassword = $("#inputPassword").val();
        $("#loading").show();
        //利用$ajax函數呼叫後台的auth_user.php驗證密碼
        $.ajax({
            url: './url_auth_user.php',
            type: 'post',
            dataType: 'json',
            data: {
                inputAccount: inputAccount,
                inputPassword: inputPassword,
            },
            success: function (data) {
                if (data.c == true) {
                    alert(data.m);
                    // window.location.href = $sPath;
                    window.location.href = "<?php echo $sPath; ?>";
                } else {
                    alert(data.m);
                }
            },
            error: function (data) {
                alert("系統目前無法連接到後台資料庫");
            }
        });
    });
});
     </script>
</body>

</html>