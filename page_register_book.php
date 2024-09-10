<?php require_once('./Connections/conn_books_db.php');
(!isset($_SESSION)) ? session_start() : "";
// require_once('./Connections/php_lib.php'); 
?>

<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Bookwalker</title>
    <?php require_once('./link_headfile_books.php'); ?>
    <!-- <link rel="stylesheet" href="./style/login.css"> -->
    <link rel="stylesheet" href="./style/register.css">
</head>

<body>
    <div id="header">
        <!-- 引入網頁標頭 -->
        <?php require_once('./sec_navbar_book.php'); ?>
    </div>
    <div id="content">
        <div class="container-fluid">
            <!-- login -->
            <?php require_once('./sec_register_content_book.php'); ?>


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
    <script src="./commlib.js"></script>
    <script src="./jquery.validate.js"></script>
    <script src="./script_register.js"></script>
</body>

</html>