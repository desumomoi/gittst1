<?php require_once('./Connections/conn_books_db.php'); //資料庫連線
(!isset($_SESSION)) ? session_start() : "";
require_once('./Connections/php_lib.php');
?>

<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>allproducts</title>
    <?php require_once('./link_headfile_books.php'); ?>
</head>

<body>
    <div id="header">
        <!-- 引入網頁標頭 -->
        <?php require_once('./sec_navbar_book.php'); ?>
    </div>

    <div id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 引入sidebar -->
                    <?php require_once('./sec_sidebar_book.php'); ?>
                </div>
                <div class="col-md-10">
                    <!-- 麵包屑 -->
                    <?php require_once('./sec_breadcrumb_book.php'); ?>
                    <!-- 引入商品 -->
                    <?php require_once('./sec_product_list_book.php'); ?>
                </div>
            </div>
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