<?php
require_once('./Connections/conn_books_db.php');
//取得產品圖片檔名
$SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
$img_rs = $link->query($SQLstring);
$imgList = $img_rs->fetch();
?>
<!-- lightbox -->
<div class="card mb-3 card-in-goods" style="border:1px solid #000;">
    <div class="row pt-3 px-3">
        <div class="col-md-5">
            <a href="./pro_book_images/<?php echo $imgList['img_file']; ?>" data-lightbox="roadtrip"><img src="./pro_book_images/<?php echo $imgList['img_file']; ?>" alt="<?php echo $data['p_name']; ?>" class="img-fluid" id="imgtst"></a>
        </div>
        <div class="col-md-7 pt-0">
            <div class="card-body ps-0 pt-1">
                <h3 class="card-title "><?php echo $data['p_name']; ?></h3>
                <p class="card-text mt-3">作者：<?php echo $data['a_name']; ?></p>
                <p class="card-text">價格：<?php echo $data['p_price']; ?>元</p>
                <hr class="hr-light">
                <div class="row ms-0">
                    <div class="col-12 ps-0">
                        <p class="card-text mb-0">數量：</p>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary btn-minus" id="btn-minus"><i class="fas fa-minus"></i></button>
                            <input type="number" class="form-control text-center goodsqty" name="qty" id="qty" value="1" min="1" max="50">
                            <button type="button" class="btn btn-outline-secondary btn-plus" id="btn-plus"><i class="fas fa-plus"></i></button>
                        </div>
                        <button type="button" class="btn btn-success rounded-pill btn-lg mt-4 w-100" onclick="addcart(<?php echo $data['p_id']; ?>)">放入購物車<i class="fas fa-cart-shopping fa-lg" title="購物車"></i></button>
                        <button type="button" class="btn btn-success rounded-pill btn-lg mt-4 w-100">加入願望清單<i class="fas fa-heart fa-lg" title="願望清單"></i></button>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                內容簡介
                <?php echo $data['p_content']; ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-body">
                作者介紹
                <?php echo $data['p_authorintro']; ?>
            </div>
        </div>
    </div>

</div>