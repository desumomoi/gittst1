<?php

/** @var PDO $link */
//解決$link跳出錯誤的bug
require_once('./Connections/conn_books_db.php');

$level1Open = "";
$level2Open = "";
$level3Open = "";
$level4Open = "";

if (isset($_GET['p_id']) && $_GET['p_id'] != "") {
    //使用p_id產品代碼取出資料
    //處理第一層
    // (SELECT classid as... WHERE level=1) as uplevel 選擇了pyclass中所有level=1的行並將全部重新命名(為up...)最後將此子查詢命名為uplevel。這個子查詢的結果將會成為一個臨時表包含所有level=1的分類
    // $SQLstring = sprintf("SELECT product.classid AS product_classid, pyclass.classid AS pyclass_classid, uplevel.upclassid, uplevel.uplevel, uplevel.upcname,SUBSTRING_INDEX(product.p_name,' (',1) AS p_nameOnlyTitle , product.*,pyclass.* FROM product     JOIN pyclass ON SUBSTR(product.classid,1,3)=pyclass.classid     JOIN (SELECT classid AS upclassid,level AS uplevel,cname AS upcname FROM pyclass WHERE level=1) AS uplevel ON pyclass.uplink=uplevel.upclassid WHERE product.p_id=%d", $_GET['p_id']);
    $SQLstring = sprintf("SELECT * FROM product,pyclass,(SELECT classid as upclassid,level as uplevel,cname as upcname FROM pyclass WHERE level=1 ) as uplevel WHERE SUBSTR(product.classid,1,3)=pyclass.classid AND pyclass.uplink=uplevel.upclassid AND product.p_id=%d", $_GET['p_id']);

    $classid_rs = $link->query($SQLstring);
    $data = $classid_rs->fetch();
    $level1Cname = $data['upcname'];
    $level1Upclassid = $data['upclassid'];
    $level1 = $data['uplevel'];
    $level1Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level1Upclassid . '&level=' . $level1 . '">' . $level1Cname . '</a></li>';
    //處理第二層
    $level2Cname = $data['cname'];
    $level2classid = $data['classid'];
    // $level2classid = $data['pyclass_classid'];
    // $level2 = $data['level'];
    $level2Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level2classid . '">' . $level2Cname . '</a></li>';


    // 處理第三層(產品名稱)
    $level3Open = '<li class="breadcrumb-item active" aria-current="page">' . $data['p_name'] . '</li>';


    //下面暫時隔離
    //處理第三層(系列名稱)
    // $level3classid = $data['product_classid'];
    // $level3Pname = $data['p_nameOnlyTitle'];
    // $level3Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level3classid . '">' . $level3Pname . '</a></li>';

    //處理第四層(集數)
    // $level4Open = '<li class="breadcrumb-item active" aria-current="page">' . $data['p_name'] . '</li>';
}
//用classid查詢未完成
// elseif (isset($_GET['level']) && isset($_GET['pyclass_classid']) && isset($_GET['product_classid'])) {
//     //使用完整classid(作品)查詢
//     //處理第一層
//     // $SQLstring=sprintf("SELECT * FROM product,pyclass,(SELECT classid as upclassid,level as uplevel,cname as cname FROM pyclass WHERE level=1 )as uplevel,SUBSTRING_INDEX(product.p_name,' (',1) as p_nameOnlyTitle WHERE SUBSTR(product.classid,1,3)=pyclass.classid AND pyclass.uplink=uplevel.upclassid AND product.classid=%d",$_GET['classid']);
//     $SQLstring = sprintf("SELECT product.*,pyclass.*,uplevel.upclassid,uplevel.uplevel,uplevel.upcname,product.classid AS product_classid,pyclass.classid AS pyclass_classid ,SUBSTRING_INDEX(product.p_name,' (',1) AS p_nameOnlyTitle FROM product JOIN pyclass ON SUBSTR(product.classid,1,3)=pyclass.classid JOIN (SELECT classid AS uplcassid,level AS uplevel,cname AS upcname FROM pyclass WHERE level=1 )AS uplevel ON pyclass.uplink=uplevel.upclassid WHERE product.classid=%d", $_GET['product_classid']);
//     $classid_rs = $link->query($SQLstring);
//     $data = $classid_rs->fetch();
//     $level1Cname = $data['upcname'];
//     $level1Upclassid = $data['upclassid'];
//     $level1 = $data['uplevel'];
//     $level1Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level1Upclassid . '&level=' . $level1 . '">' . $level1Cname . '</a></li>';
//     //處理第二層
//     $level2Cname = $data['cname'];
//     $level2classid = $data['pyclass_classid'];
//     $level2 = $data['level'];
//     $level2Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level2classid . '">' . $level2Cname . '</a></li>';
//     //處理第三層
//     $level3Pname = $data['p_nameOnlyTitle'];
//     $level3Open = '<li class="breadcrumb-item active" aria-current="page">' . $level3Pname . '</li>';
// } 
elseif (isset($_GET['search_name'])) {
    //使用關鍵字查詢
    $level1Open = '<li class="breadcrumb-item active" aria-current="page">關鍵字查詢：' . $_GET['search_name'] . '</li>';
} elseif (isset($_GET['level']) && isset($_GET['classid'])) {
    //選擇第一層類別
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=%d AND classid=%d ", $_GET['level'], $_GET['classid']);
    $classid_rs = $link->query($SQLstring);
    $data = $classid_rs->fetch();
    $level1Cname = $data['cname'];
    $level1Open = '<li class="breadcrumb-item active" aria-current="page">' . $level1Cname . '</li>';
} elseif (isset($_GET['classid'])) {
    //選擇第二層類別
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND classid=%d", $_GET['classid']);
    $classid_rs = $link->query($SQLstring);
    $data = $classid_rs->fetch();
    $level2Cname = $data['cname'];
    $level2Uplink = $data['uplink'];
    $level2Open = '<li class="breadcrumb-item active" aria-current="page">' . $level2Cname . '</li>';
    //需加處理上一層
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=1 AND classid=%d", $level2Uplink);
    $classid_rs = $link->query($SQLstring);
    $data = $classid_rs->fetch();
    $level1Cname = $data['cname'];
    $level1 = $data['level'];
    $level1Open = '<li class="breadcrumb-item active" aria-current="page"><a href="./page_allproducts_book.php?classid=' . $level2Uplink . '&level=' . $level1 . '"> ' . $level1Cname . '</a></li>';
}
?>
<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./page_allproducts_book.php">全部商品</a></li>
        <?php echo $level1Open . $level2Open . $level3Open; ?>
    </ol>
</nav>