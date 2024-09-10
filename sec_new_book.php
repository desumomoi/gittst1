<?php
require_once('./Connections/conn_books_db.php');
$SQLstring = "SELECT * FROM product,product_img WHERE p_open=1 AND product_img.sort=1 AND product.p_id=product_img.p_id  ORDER BY p_publidate DESC LIMIT 6 ";
//LIMIT 6 表示返回6筆資料
//DATEDIFF可設置時間條件 這邊先用LIMIT就好
//AND DATEDIFF(NOW(),product.p_publidate)<=30
$new = $link->query($SQLstring);
    // $datanew=$new->fetch();
; ?>
<!-- <div class="mx-md-5 my-5  overflow-hidden"></div> -->
<!-- <div class=""></div> -->
<div id="books_new" class="row gx-md-3 gx-1 gy-md-4 gy-2 mx-md-5 my-5 overflow-hidden">
    <div class="books_new-title col-md-12 text-center">
        <h4><i class="fa-solid fa-bullhorn"></i>新品上市</h4>
    </div>
    <?php while ($datanew = $new->fetch()) {  ?>
        <div class="col-md-4 col-6 overflow-hidden card-index-box">
            <div class="card overflow-hidden card-index px-md-3 px-2" title="<?php echo $datanew['p_name']; ?>">
                <a href="./page_goods_book.php?p_id=<?php echo $datanew['p_id']; ?>"> <img src="./pro_book_images/<?php echo $datanew['img_file']; ?>" class="card-img-top " alt="<?php echo $datanew['p_name']; ?>" title="<?php echo $datanew['p_name']; ?>"></a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $datanew['p_name']; ?></h5>
                    <p class="card-text"><?php echo $datanew['a_name']; ?></p>
                    <p class="card-text"><?php echo $datanew['p_price']; ?>元</p>
                    <div class="d-flex justify-content-evenly">
                        <a href="./page_goods_book.php?p_id=<?php echo $datanew['p_id']; ?>" class="btn btn-primary" title="更多資訊"><span class="textinbtn">更多資訊</span><i class="fas fa-info-circle"></i></a>
                        <!-- <a href="#" class="btn btn-success"><span class="textinbtn">放購物車</span><i class="fas fa-cart-shopping"></i></a> -->
                        <button type="button" id="button01[]" name="button01[]" class="btn btn-success" title="放購物車" onclick="addcart(<?php echo $datanew['p_id']; ?>)"><span class="textinbtn">放購物車</span></span><i class="fas fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>
        </div>
    <?php  } ?>
    <div class="col-md-12 text-center">
        <a href="./page_allproducts_book.php" class="btn btn-info viewallbtn my-4 ">VIEW ALL</a>
    </div>
</div>


