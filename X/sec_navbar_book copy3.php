<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
$SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY classid";
$nav1 = $link->query($SQLstring);
?>


<?php
//讀取後台購物車內產品數量
$SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='" . $_SERVER['REMOTE_ADDR'] . "'   ";
$cart_rs = $link->query($SQLstring);
?>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid align-items-center justify-content-between">
        <!-- LOGO -->
        <a class="navbar-brand" href="./index.php"><img src="./pro_book_images/bw_logo.svg" class="img_cos-contain" alt="bookwalker"></a>
        <!-- 可折疊部分，平常在中間(order:3)，摺疊在最右(order:6) -->
        <div class="collapse navbar-collapse nav-o3" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <?php while ($data1 = $nav1->fetch()) { ?>
                    <li class="nav-item"><a class="nav-link" href="./page_allproducts_book.php"><?php echo $data1['cname']; ?></a></li>
                <?php }  ?>
            </ul>
        </div>
        <!-- 固定顯示icon跟搜尋列，order:4 -->
        <!-- 搜尋列 -->
        <div class="navbar_cos-nonecollapse d-flex justify-content-between nav-o4 nav-search" id="nav-search">
            <form class="d-flex" name="search" id="search" action="./page_allproducts_book.php" method="get">
                <div class="input-group" id="search-group">
                    <input type="text" name="search_name" id="search_name" class="form-control" placeholder="Search..." value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : ""; ?>" required>
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"> <i class="fas fa-search fa-lg"></i></button></span>
                </div>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link nav-searchicon" id="nav-searchicon" href="#"><i class="fas fa-search fa-lg" title="搜尋"></i></a></li>
            </ul>
        </div>
        <!-- ICON -->
        <div class="navbar_cos-nonecollapse d-flex justify-content-between nav-o4 nav-icons" id="navbaricons">
            <ul class="navbar-nav navbar_cos-stayrow ">
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-book-open fa-lg" title="書櫃"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-heart fa-lg" title="願望清單"></i></a></li>
                <li class="nav-item position-relative"><a class="nav-link" href="./page_cart.php"><i class="fas fa-cart-shopping fa-lg " title="購物車"></i><span class="badge rounded-pill text-bg-info position-absolute top-50 start-50" title="購物車"><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span></a></li>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg" title="會員中心"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item" type="button">會員中心</button></li>
                            <li><button class="dropdown-item" type="button">消費紀錄</button></li>
                            <li><button class="dropdown-item" type="button" onclick="btn_confirmLink('確定登出？','./url_logout_book.php');">登出</button></li>
                        </ul>
                    </li>

                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="./page_login_book.php"><i class="fas fa-right-to-bracket fa-lg" title="登入"></i></a></li>
                <?php } ?>
            </ul>
        </div>
        <!-- </div> -->
        <!-- 摺疊按鈕，order:5 -->
        <button class="navbar-toggler nav-o5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


    </div>
</nav>