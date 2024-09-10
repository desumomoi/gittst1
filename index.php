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


</head>

<body>
    <div id="header">
        <!-- 引入網頁標頭 -->
        <?php require_once('./sec_navbar_book.php'); ?>
       
    </div>
    <div id="content">
        <div class="container-fluid">
            <!-- carousel -->
            <?php require_once('./sec_carousel_book.php'); ?>
            <!-- 新品上市 -->
            <?php require_once('./sec_new_book.php'); ?>
            <hr class="hrindex">
            <!-- 暢銷排行 -->
            <?php require_once('./sec_hot_book.php'); ?>
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

</body>

</html>