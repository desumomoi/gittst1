<?php
//建立訂單查詢
$maxRows_rs = 5; //分頁設定數量
$pageNum_rs = 0; //起始頁=0
if (isset($_GET['pageNum_order_rs'])) {
    $pageNum_rs = $_GET['pageNum_order_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

// 列出order資料表查詢
// $queryFirst=sprintf("SELECT uorder.orderid,uorder.create_date AS orderTime ,uorder.remark ,ms1.msname AS howpay,ms2.msname AS status,addbook.* FROM uorder,addbook,multiselect AS ms1,multiselect AS ms2 WHERE ms2.msid=uorder.status AND ms1.msid=uorder.howpay AND uorder.emailid=%d AND uorder.addressid=addbook.addressid ORDER BY uorder.create_date DESC",$_SESSION['emailid'] );
// $queryFirst=sprintf("SELECT uorder.orderid,uorder.create_date AS orderTime,uorder.remark,ms1.msname AS howpay,ms2.msname AS status,addbook.* FROM uorder JOIN multiselect AS ms1 ON ms1.msid = uorder.howpay JOIN multiselect AS ms2 ON ms2.msid = uorder.status JOIN addbook ON addbook.addressid = uorder.addressid WHERE uorder.emailid=%d ORDER BY uorder.create_date DESC ",$_SESSION['emailid']);
// $query=sprintf("%s LIMIT %d,%d",$queryFirst,$startRow_rs,$maxRows_rs);
// $order_rs=$link->query($query);
// $queryFirst = $link->prepare("
//     SELECT 
//         uorder.orderid,
//         uorder.create_date AS orderTime,
//         uorder.remark,
//         ms1.msname AS howpay,
//         ms2.msname AS status,
//         addbook.*
//     FROM
//         uorder
//     JOIN
//         addbook ON uorder.addressid=addbook.addressid
//     JOIN
//         multiselect AS ms1 ON ms1.msid=uorder.howpay
//     JOIN
//         multiselect AS ms2 ON ms2.msid = uorder.status
//     WHERE 
//         uorder.emailid= ?
//     ORDER BY 
//         uorder.create_date DESC
//      LIMIT
//          ?,?
// ");
// $queryFirst->bindValue(1, $_SESSION['emailid'], PDO::PARAM_STR);
// $queryFirst->bindValue(2, $startRow_rs, PDO::PARAM_INT);
// $queryFirst->bindValue(3, $maxRows_rs, PDO::PARAM_INT);
// $queryFirst->execute();
// $queryFirst->execute([$_SESSION['emailid']]);
// $queryFirst->execute([$_SESSION['emailid'], $startRow_rs, $maxRows_rs]);
$queryBase = "
    SELECT 
        uorder.orderid,
        uorder.create_date AS orderTime,
        uorder.remark,
        ms1.msname AS howpay,
        ms2.msname AS status,
        addbook.*
    FROM
        uorder
    JOIN
        addbook ON uorder.addressid=addbook.addressid
    JOIN
        multiselect AS ms1 ON ms1.msid=uorder.howpay
    JOIN
        multiselect AS ms2 ON ms2.msid = uorder.status
    WHERE 
        uorder.emailid= ?
    ORDER BY 
        uorder.create_date DESC
";
$queryFirst=$link->prepare($queryBase);
$queryFirst->execute([$_SESSION['emailid']]);

$queryBaseLimit=$queryBase ." LIMIT ?,?"; // 將 LIMIT 拼接到基本查詢後面
$query2=$link->prepare($queryBaseLimit);
$query2->bindValue(1, $_SESSION['emailid'], PDO::PARAM_STR);
$query2->bindValue(2, $startRow_rs, PDO::PARAM_INT);
$query2->bindValue(3, $maxRows_rs, PDO::PARAM_INT);
$query2->execute();

$order_rs = $query2;
$i = 21; //控制第一筆訂單開啟
?>

<h3>訂單查詢</h3>
<?php if ($order_rs->rowCount() != 0) { ?>
    <div class="accordion" id="accordionOrderlist">
        <?php while ($data01 = $order_rs->fetch()) { ?>
            <?php if($i !=21 ) { echo "<hr>" ; }  ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                    <a href="#" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                        <div class="table-responsive-md w-100 orderTableT" >
                            <table class="table table-hover mt-3 align-middle">
                                <thead>
                                    <tr class="table-warning">
                                        <td class="thtd1" title="訂單編號">訂單編號</td>
                                        <td class="thtd2" title="下單日期時間">下單日期時間</td>
                                        <td class="thtd3" title="付款方式">付款方式</td>
                                        <td class="thtd4" title="訂單狀態">訂單狀態</td>
                                        <td class="thtd5" title="收件人">收件人</td>
                                        <td class="thtd6" title="地址">地址</td>
                                        <td class="thtd7" title="備註說明">備註說明</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tbtd1" title="訂單編號"><?php echo $data01['orderid']; ?></td>
                                        <td class="tbtd2" title="下單日期時間"><?php echo $data01['orderTime']; ?></td>
                                        <td class="tbtd3" title="付款方式"><?php echo $data01['howpay']; ?></td>
                                        <td class="tbtd4" title="訂單狀態"><?php echo $data01['status']; ?></td>
                                        <td class="tbtd5" title="收件人"><?php echo $data01['cname']; ?></td>
                                        <td class="tbtd6" title="地址"><?php echo $data01['address']; ?></td>
                                        <td class="tbtd7" title="備註說明"><?php echo $data01['remark']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </a>
                </h2>

                <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == 21) ? 'show' : '' ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionOrderlist">
                    <div class="accordion-body">
                        <?php
                        //建立購物車資料查詢
                        $SQLstring = $link->prepare("SELECT *,ms1.msname AS status FROM cart JOIN product ON cart.p_id=product.p_id JOIN product_img ON cart.p_id = product_img.p_id JOIN multiselect AS ms1 ON cart.status=ms1.msid WHERE cart.orderid=? AND product_img.sort=1 ORDER BY cart.create_date DESC");
                        $SQLstring->execute([$data01['orderid']]);
                        $cart_rs = $SQLstring;
                        $SQLstring = sprintf("SELECT *,ms1.msname AS status FROM cart,product,product_img,multiselect as ms1 WHERE cart.orderid='%s' AND ms1.msid=cart.status AND cart.p_id=product.p_id AND product.p_id=product_img.p_id AND cart.p_id=product_img.p_id AND product_img.sort=1 ORDER BY cart.create_date DESC ", $data01['orderid']);
                        $cart_rs = $link->query($SQLstring);
                        $ptotal = 0; //設定累加金額的變數，初始為0
                        ?>
                        <div class="table-responsive-lg orderTableB">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="table-bg-primary text-start">
                                        <td width="10%">圖片</td>
                                        <td width="40%">名稱</td>
                                        <td width="10%">價格</td>
                                        <td width="10%">數量</td>
                                        <td width="15%">小計</td>
                                        <td width="15%">狀態</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($cart_data = $cart_rs->fetch()) {
                                    ?>
                                        <?php //while ($cart_data = $SQLstring->fetch()) { 
                                        ?>
                                        <tr>
                                            <td class="imgEach"><img src="./pro_book_images/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                            <td class="pnameEach"><?php echo $cart_data['p_name']; ?></td>
                                            <td class="priceEach">
                                                <h4 class="my-auto">$<?php echo $cart_data['p_price']; ?></h4>
                                            </td>
                                            <td class="qytEach">
                                                <p class="my-auto"><?php echo $cart_data['qty']; ?></p>
                                            </td>
                                            <td class="tpriceEach">
                                                <h4 class="my-auto">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                            </td>
                                            <td class="statusEach">
                                                <h4 class="my-auto"><?php echo $cart_data['status']; ?></h4>
                                            </td>

                                        </tr>
                                    <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">累計：<?php echo $ptotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">運費：100</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="color_red">總計：<?php echo $ptotal + 100; ?></td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php $i++;        } ?>
    </div>
    <?php  //取得目前頁數
    if (isset($_GET['totalRows_rs'])) {
        $totalRows_rs = $_GET['$totalRows_rs'];
    } else {
        $all_rs = $queryFirst -> fetchAll();
        $totalRows_rs = count($all_rs); //計算 $all_rs 結果集中返回的記錄數量，並將這個數字賦值給 $totalRows_rs 變數
        // $all_rs = $link->query($queryFirst); //執行$queryFirst 指定的 SQL 查詢，並將查詢結果賦值給 $all_rs 變數
        // $totalRows_rs = $all_rs->rowCount(); //計算 $all_rs 結果集中返回的記錄數量，並將這個數字賦值給 $totalRows_rs 變數
    }
    $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1; //總紀錄數除每頁最大紀錄數，ceil向上取整，減去1得到實際可用頁數索引
    //呼叫分業功能函數

    $prev_rs = "&laquo;";
    $next_rs = "&raquo;";
    $separator = "|";
    $max_links = 20;
    $pages_rs = buildNavigation('order_rs', $pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3);
    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php echo $pages_rs[0] . $pages_rs[1] . $pages_rs[2]; ?>
        </ul>
    </nav>

<?php  } else { ?>
    <div class="alert alert-warning text-center mt-3" role="alert">目前還沒有任何訂單</div>
    <div class="text-center"><a href="./index.php" class="btn btn-success mb-3 mx-auto">點我去逛逛</a></div>
<?php  } ?>

<!-- 9/8做到P29 -->