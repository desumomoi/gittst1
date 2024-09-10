<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 資料庫連接
try {
    $dsn = 'mysql:host=localhost;dbname=expstore_2;charset=utf8';
    $user = 'sales';
    $password = '123456';
    $link = new PDO($dsn, $user, $password);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 設定錯誤處理模式為拋出異常
    date_default_timezone_set("Asia/Taipei");
} catch (PDOException $e) {
    die("資料庫連接失敗: " . $e->getMessage());
}
?>

