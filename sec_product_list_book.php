<?php

/** @var PDO $link */
//解決$link跳出錯誤的bug
require_once('./Connections/conn_books_db.php');

//建立product商品RS
$maxRows_rs = 12; //分頁設定數量
$pageNum_rs = 0; //起始頁=0
if (isset($_GET['pageNum_rs'])) {
    $pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;
if (isset($_GET['search_name'])) {
    //使用關鍵字查詢，LIKE用在查詢中進行模糊匹配，在$_GET['search_name']前後加上的'%'表示任意數量的字符
    $queryFirst = sprintf("SELECT * FROM pyclass,product,product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND SUBSTR(product.classid,1,3)=pyclass.classid AND product.p_name LIKE '%%%s%%' ", $_GET['search_name']);
}
// elseif (isset($_GET['pruduct_classid']) && isset($_GET['pyclass_classid'])) {
//     //使用第二層類別查詢
//     $queryFirst=sprintf("SELECT * FROM pyclass,product,product_img, WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND SUBSTR(product.classid,1,3)=pyclass.classid AND pyclass.classid=%d AND product.classid=%d ORDER BY product.classid,product.p_id ASC",$_GET['pyclass_classid'],$_GET['product_classid']);
// }
elseif (isset($_GET['level']) && $_GET['level'] == 1) {
    // 使用第一層類別查詢
    $queryFirst = sprintf("SELECT * FROM pyclass,product,product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND SUBSTR(product.classid,1,3)=pyclass.classid AND pyclass.uplink=%d ORDER BY product.classid,product.p_id ASC", $_GET['classid']);
} elseif (isset($_GET['classid'])) {
    //使用產品類別查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id AND SUBSTR(product.classid,1,3)='%d' ORDER BY product.classid,product.p_id ASC ", $_GET['classid']);
} else {
    //列出產品product資料查詢
    $queryFirst = sprintf("SELECT * FROM product,product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id ORDER BY product.classid,product.p_id ASC ");
}
//LIMIT後加兩個數字是用來指定查詢結果中的起始位置和返回的記錄數量，前面數字表示要跳過的記錄數量（即起始位置），這個數字是從 0 開始計算的，第二個數字表示返回的記錄數量
//這邊$startRow_rs起始是0、$maxRows_rs固定是12，表示會回傳0~11共12筆資料，第二頁變成12,12，表示回傳12~23共12筆資料
$query = sprintf('%s LIMIT %d,%d', $queryFirst, $startRow_rs, $maxRows_rs);
$pList01 = $link->query($query);
$i = 1; //控制每列row產生
?>

<?php //if 有資料就顯示，沒有就顯示alert
if ($pList01->rowCount() != 0) { ?>
    <?php while ($pList01_Rows = $pList01->fetch()) { ?>
        <?php if ($i % 4 == 1) { ?><div class="row"> <?php } ?>
            <div class="card col-md-3 col-6 overflow-hidden card-in-productlist" title="<?php echo $pList01_Rows['p_name']; ?>">
                <a href="./page_goods_book.php?p_id=<?php echo $pList01_Rows['p_id']; ?>"><img src="./pro_book_images/<?php echo $pList01_Rows['img_file']; ?>" class="card-img-top img-fluid" alt="<?php echo $pList01_Rows['p_name']; ?>"></a>
                <div class="card-body px-0">
                    <h5 class="card-title "><?php echo $pList01_Rows['p_name']; ?></h5>
                    <p class="card-text ">
                        <?php echo $pList01_Rows['a_name'];
                        if (!empty($pList01_Rows['c_name'])) {
                            echo '/' . $pList01_Rows['c_name'];
                        } ?></p>
                    <p class="card-text"><?php echo $pList01_Rows['p_price']; ?>元</p>
                    <div class="d-flex  justify-content-evenly">
                        <a href="./page_goods_book.php?p_id=<?php echo $pList01_Rows['p_id']; ?>" class="btn btn-primary" title="更多資訊"><span class="textinbtn">更多資訊</span><i class="fas fa-info-circle"></i></a>
                        <!-- <a href="#" class="btn btn-success" title="放購物車"><span class="textinbtn">放購物車</span><i class="fas fa-cart-shopping"></i></a> -->
                        
                        <button type="button" id="button01[]" name="button01[]" class="btn btn-success" title="放購物車" onclick="addcart(<?php echo $pList01_Rows['p_id']; ?>)"><span class="textinbtn">放購物車</span></span><i class="fas fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
            <?php if ($i % 4 == 0 || $i == $pList01->rowCount()) { ?>
            </div> <?php } ?>
    <?php $i++;
    } ?>
<?php //沒資料，則顯示alert
} else { ?>
    <div class="alert alert-danger" role="alert">抱歉，目前沒有相關產品！</div>
<?php  } ?>


<div class="row mt-2">
    <?php  //取得目前頁數
    if (isset($_GET['totalRows_rs'])) {
        $totalRows_rs = $_GET['$totalRows_rs'];
    } else {
    
        $all_rs = $link->query($queryFirst); //執行$queryFirst 指定的 SQL 查詢，並將查詢結果賦值給 $all_rs 變數
        $totalRows_rs = $all_rs->rowCount(); //計算 $all_rs 結果集中返回的記錄數量，並將這個數字賦值給 $totalRows_rs 變數
    }
    $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1; //總紀錄數除每頁最大紀錄數，ceil向上取整，減去1得到實際可用頁數索引
    //呼叫分業功能函數

    $prev_rs = "&laquo;";
    $next_rs = "&raquo;";
    $separator = "|";
    $max_links = 20;
    $pages_rs = buildNavigation('rs', $pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3);
    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2]; ?>
        </ul>
    </nav>
</div>


<!-- 以下是試作隱藏中間頁的導覽 -->
<?php
function buildPagination($currentPage, $totalPages)
{
    $paginationHtml = '<ul class="pagination justify-content-center">';

    // 設定顯示的頁碼範圍
    $range = 2; // 顯示當前頁碼前後兩頁
    $start = max(1, $currentPage - $range);
    $end = min($totalPages, $currentPage + $range);

    // 顯示上一頁按鈕
    if ($currentPage > 1) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">&laquo; </a></li>';
    } else {
        $paginationHtml .= '<li class="page-item disabled"><span class="page-link">&laquo; </span></li>';
    }

    // 顯示頁碼按鈕
    if ($start > 1) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
        if ($start > 2) {
            $paginationHtml .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $currentPage) {
            $paginationHtml .= '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
        } else {
            $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }

    if ($end < $totalPages) {
        if ($end < $totalPages - 1) {
            $paginationHtml .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
    }

    // 顯示下一頁按鈕
    if ($currentPage < $totalPages) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">&raquo;</a></li>';
    } else {
        $paginationHtml .= '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
    }

    $paginationHtml .= '</ul>';

    return $paginationHtml;
}
?>
<?php
// 假設你已經計算出 $currentPage 和 $totalPages
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = 50; // 假設你有 18 頁

//echo buildPagination($currentPage, $totalPages);
?>