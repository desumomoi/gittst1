<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
$SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC ";
$cart_rs = $link->query($SQLstring);
$ptotal = 0; //設定累加的變數，初始=0

?>
<h3>購物車</h3>
<?php if ($cart_rs->rowCount() != 0) { ?>
    <a href="./index.php" id="btn01" name="btn01" class="btn btn-primary">繼續購物</a>
    <button type="button" id="btn02" name="btn02" class="btn btn-info" onclick="window.history.go(-1)">回到上一頁</button>
    <button type="button" id="btn03" name="btn03" class="btn btn-success" onclick="btn_confirmLink('確定清空購物車？','./url_shopcart_del_book.php?mode=2');">清空購物車</button>
    <a href="./page_checkout_book.php" id="btn04" name="btn04" class="btn btn-warning">前往結帳</a>

    <div class="table-responsive-md">
        <table class="table table-hover mt-3">
            <thead>
                <tr class="table-warning">
                    <td width="10%">產品編號</td>
                    <td width="10%">圖片</td>
                    <td width="25%">名稱</td>
                    <td width="15%">價格</td>
                    <td width="10%">數量</td>
                    <td width="15%">小計</td>
                    <td width="15%">下次再買</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($cart_data = $cart_rs->fetch()) { ?>
                    <tr>
                        <td><?php echo $cart_data['cartid']; ?></td>
                        <td><a href="./page_goods_book.php?p_id=<?php echo $cart_data['p_id']; ?>"><img src="./pro_book_images/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></a></td>
                        <td><a href="./page_goods_book.php?p_id=<?php echo $cart_data['p_id']; ?>"><?php echo $cart_data['p_name']; ?></a></td>
                        <td>
                            <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']; ?></h4>
                        </td>
                        <td>
                            <!-- <div class="input-group"><input type="number" class="form-control qty-input" name="qty[]" id="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required style="min-width:60px;"></div> -->
                            <div class="input-group mx-auto qytControlCart">
                                <button type="button" class="btn btn-outline-secondary px-1" id="btn-minus-<?php echo $cart_data['cartid']; ?>" data-id="<?php echo $cart_data['cartid']; ?>"><i class="fas fa-minus"></i></button>
                                <input type="number" class="form-control text-center px-0 mx-0 qty-input" name="qty-<?php echo $cart_data['cartid']; ?>" id="qty-<?php echo $cart_data['cartid']; ?>" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>">
                                <button type="button" class="btn btn-outline-secondary px-1" id="btn-plus-<?php echo $cart_data['cartid']; ?>" data-id="<?php echo $cart_data['cartid']; ?>"><i class="fas fa-plus"></i></button>
                            </div>
                        </td>
                        <td>
                            <h4 class=" color_e600a0 pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                        </td>
                        <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmLink('確定刪除本資料？','./url_shopcart_del_book.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">取消</button></td>
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
<?php  } else { ?>
    <div class="alert alert-warning text-center mt-3" role="alert">抱歉！目前購物車是空的</div>
    <div class="text-center"><a href="./index.php" class="btn btn-success mb-3 mx-auto">點我去逛逛</a></div>
    <!-- <button class="btn btn-success mx-auto mb-3 d-block" onclick="window.location.href='./index.php';">點我去逛逛 </button> -->
<?php } ?>