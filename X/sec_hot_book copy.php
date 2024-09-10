<?php
require_once('./Connections/conn_books_db.php');
$SQLstring = "SELECT * FROM hot,product,product_img WHERE hot.p_id=product.p_id AND hot.p_id=product_img.p_id AND product_img.sort=1  ORDER BY h_sort";
$hot = $link->query($SQLstring);
$i = 1;
?>
<div class="card border-primary mx-md-5 my-5 overflow-hidden">
    <div class="container-fluid">
        <div id="books_bestseller" class="row">
            <div class="card-title col-md-12 text-center my-3">
                <h4><i class="fa-solid fa-crown "></i>暢銷排行</h4>
            </div>
            <?php while ($data = $hot->fetch()) { ?>
                <div class="card col-md-4 col-6 overflow-hidden card-index" title="<?php echo $data['p_name']; ?>">
                    <a href="./page_goods_book.php?p_id=<?php echo $data['p_id']; ?>"><img src="./pro_book_images/<?php echo $data['img_file']; ?>" alt="<?php echo $data['p_name']; ?>" title="<?php echo $data['p_name']; ?>" alt="暢銷排行<?php echo $data['h_sort']; ?>"></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $data['p_name']; ?></h5>
                        <p class="card-text"><?php echo $data['a_name']; ?></p>
                        <p class="card-text"><?php echo $data['p_price']; ?>元</p>
                        <div class="d-flex justify-content-evenly">
                            <a href="./page_goods_book.php?p_id=<?php echo $data['p_id']; ?>" class="btn btn-primary" title="更多資訊"><span class="textinbtn">更多資訊</span><i class="fas fa-info-circle d-none"></i></a>
                            <!-- <a href="#" class="btn btn-success"><span class="textinbtn">放購物車</span><i class="fas fa-cart-shopping d-none"></i></a> -->
                            <button type="button" id="button01[]" name="button01[]" class="btn btn-success" title="放購物車" onclick="addcart(<?php echo $data['p_id']; ?>)"><span class="textinbtn">放購物車</span></span><i class="fas fa-cart-shopping d-none"></i></button>
                        </div>
                    </div>
                </div>
            <?php        }; ?>
            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-info viewallbtn my-4 ">VIEW ALL</a>
            </div>
        </div>
    </div>
</div>


<!-- <div class="card col-md-4 col-6">
    <img src="./pro_book_images/card_best/picb0102.jpg" class="card-img-top" alt="怪獸8號(10)">
    <div class="card-body">
        <h5 class="card-title">怪獸8號(10)</h5>
        <p class="card-text">松本直也</p>
        <p class="card-text">71元</p>
        <a href="#" class="btn btn-primary">更多資訊</a>
        <a href="#" class="btn btn-success">放購物車</a>
    </div>
</div>
<div class="card col-md-4 col-6">
    <img src="./pro_book_images/card_best/picb0103.jpg" class="card-img-top" alt="葬送的芙莉蓮 (11)">
    <div class="card-body">
        <h5 class="card-title">葬送的芙莉蓮 (11)</h5>
        <p class="card-text">阿部司/山田鐘人</p>
        <p class="card-text">70元</p>
        <a href="#" class="btn btn-primary">更多資訊</a>
        <a href="#" class="btn btn-success">放購物車</a>
    </div>
</div>
<div class="card col-md-4 col-6">
    <img src="./pro_book_images/card_best/picb0201.jpg" class="card-img-top" alt="【我推的孩子】(11)">
    <div class="card-body">
        <h5 class="card-title">【我推的孩子】(11)</h5>
        <p class="card-text">赤坂アカ、横槍メンゴ</p>
        <p class="card-text">80元</p>
        <a href="#" class="btn btn-primary">更多資訊</a>
        <a href="#" class="btn btn-success">放購物車</a>
    </div>
</div>
<div class="card col-md-4 col-6">
    <img src="./pro_book_images/card_best/picb0202.jpg" class="card-img-top" alt="3月的獅子(17)">
    <div class="card-body">
        <h5 class="card-title">3月的獅子(17)</h5>
        <p class="card-text">羽海野千花</p>
        <p class="card-text">80元</p>
        <a href="#" class="btn btn-primary">更多資訊</a>
        <a href="#" class="btn btn-success">放購物車</a>
    </div>
</div>
<div class="card col-md-4 col-6">
    <img src="./pro_book_images/card_best/picb0203.jpg" class="card-img-top" alt="我內心的糟糕念頭 (6)">
    <div class="card-body">
        <h5 class="card-title">我內心的糟糕念頭 (6)</h5>
        <p class="card-text">桜井紀雄</p>
        <p class="card-text">70元</p>
        <a href="#" class="btn btn-primary">更多資訊</a>
        <a href="#" class="btn btn-success">放購物車</a>
    </div>
</div> -->