<?php

/** @var PDO $link */
//解決$link跳出錯誤的bug
require_once('./Connections/conn_books_db.php'); ?>

<?php
//列出產品類別第一層
$SQLstring = 'SELECT * FROM pyclass WHERE level=1 ORDER BY sort'; //
$pyclass01 = $link->query($SQLstring);
$i = 1; //控制編號
?>
<div class="accordion accordion-flush " id="accordionBooksidebar">
    <?php while ($pyclass01_Rows = $pyclass01->fetch()) {
        $i = $pyclass01_Rows['classid']; ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne<?php echo $i; ?> ">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                    <i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-lg fa-fw"></i>
                    <?php echo $pyclass01_Rows['cname']; ?>
                </button>
            </h2>
            <?php //解決sidebar開啟不準確問題


            if (isset($_GET['p_id'])) { // 使用產品查詢要獲得上一層類別
                $SQLstring = sprintf("SELECT uplink FROM pyclass,product WHERE pyclass.classid=SUBSTR(product.classid,1,3) AND p_id=%d ", $_GET['p_id']);
                $classid_rs = $link->query($SQLstring);
                $data = $classid_rs->fetch();
                $ladder = $data['uplink'];
            } elseif (isset($_GET['level']) && $_GET['level'] == 1) { //使用第一層類別查詢
                $ladder = $_GET['classid'];
            } elseif (isset($_GET['classid'])) { //如果使用類別查詢取得上一層類別
                $SQLstring = "SELECT uplink FROM pyclass WHERE level=2 AND classid= " . $_GET['classid'];
                $classid_rs = $link->query($SQLstring);
                $data = $classid_rs->fetch();
                $ladder = $data['uplink'];
            } else {
                $ladder = 1;
            }
            //列出產品對應的第二層資料
            $SQLstring = sprintf('SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort', $pyclass01_Rows['classid']);
            $pyclass02 = $link->query($SQLstring);
            ?>
            <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == $ladder) ? 'show' : ''; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionBooksidebar">
                <div class="accordion-body">
                    <table class="table">
                        <tbody>
                        <tr>
                                    <td><a href="./page_allproducts_book.php?classid=<?php echo $pyclass01_Rows['classid']; ?>&level=1 "><i class="fas <?php echo $pyclass01_Rows['fonticon']; ?>  fa-fw"></i>全部品項</a></td>
                                </tr>
                            <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                                <tr>
                                    <td><a href="./page_allproducts_book.php?classid=<?php echo $pyclass02_Rows['classid']; ?> "><i class="fas <?php echo $pyclass02_Rows['fonticon']; ?>  fa-fw"></i><?php echo $pyclass02_Rows['cname']; ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php $i++;
    } ?>
</div>