<?php
//建立訂單查詢
$maxRows_rs = 5; //分頁設定數量
$pageNum_rs = 0; //起始頁=0
if (isset($_GET['pageNum_order_rs'])) {
    $pageNum_rs = $_GET['pageNum_order_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;
// 列出order資料表查詢
// $queryFirst=$link->prepare("SELECT ur");
// $queryFirst=sprintf("SELECT uorder.orderid,uorder.create_date AS orderTime ,uorder.remark ,ms1.msname AS howpay,ms2.msname AS status,addbook.* FROM uorder,addbook,multiselect AS ms1,multiselect AS ms2 WHERE ms2.msid=uorder.status AND ms1.msid=uorder.howpay AND uorder.emailid=%d AND uorder.addressid=addbook.addressid ORDER BY uorder.create_date DESC",$_SESSION['emailid'] );
// $queryFirst=sprintf("SELECT uorder.orderid,uorder.create_date AS orderTime,uorder.remark,ms1.msname AS howpay,ms2.msname AS status,addbook.* FROM uorder JOIN multiselect AS ms1 ON ms1.msid = uorder.howpay JOIN multiselect AS ms2 ON ms2.msid = uorder.status JOIN addbook ON addbook.addressid = uorder.addressid WHERE uorder.emailid=%d ORDER BY uorder.create_date DESC ",$_SESSION['emailid']);
// $query=sprintf("%s LIMIT %d,%d",$queryFirst,$startRow_rs,$maxRows_rs);
// $order_rs=$link->query($query);
$queryFirst = $link->prepare("
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
     LIMIT
         ?,?
");

// $queryFirst->execute([$_SESSION['emailid']]);
$queryFirst->execute([$_SESSION['emailid'], $startRow_rs, $maxRows_rs]);
$order_rs = $queryFirst;
$i = 21; //控制第一筆訂單開啟
?>

<h3>訂單查詢</h3>
<?php if ($order_rs->rowCount() != 0) { ?>
    <div class="accordion" id="accordionOrderlist">
        <?php while ($data01 = $order_rs->fetch()) { ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                    <a href="#" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr class="table-warning text-center">
                                    <td width="10%">訂單編號</td>
                                    <td width="20%">下單日期時間</td>
                                    <td width="15%">付款方式</td>
                                    <td width="15%">訂單狀態</td>
                                    <td width="10%">收件人</td>
                                    <td width="20%">地址</td>
                                    <td width="10%">備註說明</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $data01['orderid']; ?></td>
                                    <td><?php echo $data01['orderTime']; ?></td>
                                    <td><?php echo $data01['howpay']; ?></td>
                                    <td><?php echo $data01['status']; ?></td>
                                    <td><?php echo $data01['cname']; ?></td>
                                    <td><?php echo $data01['address']; ?></td>
                                    <td><?php echo $data01['remark']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </a>
                </h2>

                <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse show" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionOrderlist">
                    <div class="accordion-body">
                        <?php
                        //建立購物車資料查詢
                        $SQLstring = $link->prepare("SELECT * FROM cart JOIN product ON cart.p_id=product.p_id JOIN product_img ON cart.p_id = product_img.p_id WHERE ip=? AND orderid IS NULL AND product_img.sort=1 ORDER BY cartid DESC");
                        $SQLstring->execute([$_SERVER['REMOTE_ADDR']]);
                        $ptotal = 0; //設定累加金額的變數，初始為0
                        ?>
                        <div class="table-responsive-md">
                            <table class="table table-hover mt-3 " id="cktable">
                                <thead>
                                    <tr class="table-bg-primary">
                                        <td width="10%">圖片</td>
                                        <td width="40%">名稱</td>
                                        <td width="15%">價格</td>
                                        <td width="15%">數量</td>
                                        <td width="20%">小計</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //while ($cart_data = $cart_rs->fetch()) { 
                                    ?>
                                    <?php while ($cart_data = $SQLstring->fetch()) { ?>
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
            <hr>
        <?php $i++;
        } ?>
    </div>
<?php  } else { ?>
    <div class="alert alert-warning text-center mt-3" role="alert">目前還沒有任何訂單</div>
    <div class="text-center"><a href="./index.php" class="btn btn-success mb-3 mx-auto">點我去逛逛</a></div>
<?php  } ?>