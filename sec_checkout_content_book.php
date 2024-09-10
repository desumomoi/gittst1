<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
//取得收件者地址資料
$SQLstring = sprintf("");
$SQLstring = sprintf("SELECT *,city.name AS ctName ,town.name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo ", $_SESSION['emailid']);
$addbook_rs = $link->query($SQLstring);
if ($addbook_rs && $addbook_rs->rowCount() != 0) {
  $data = $addbook_rs->fetch();
  $cname = $data['cname'];
  $mobile = $data['mobile'];
  $myzip = $data['myzip'];
  $address = $data['address'];
  $ctName = $data['ctName'];
  $toName = $data['toName'];
} else {
  $cname = '';
  $mobile =  '';
  $myzip =  '';
  $address =  '';
  $ctName =  '';
  $toName =  '';
}
?>
<h3>結帳作業</h3>
<div class="row">
  <!-- 配送資訊 -->
  <div class="card  col-md-6 col-xl-5 mx-auto " id="haisou">
    <h5 class="card-header" style="color:#007bff;"><i class="fas fa-truck fa-flip-horizontal me-1"></i>配送資訊</h5>
    <div class="card-body d-flex flex-column">
      <h4 class="card-title ">收件人資訊：</h4>
      <h5 class="card-title mb-3">姓名：<?php echo $cname; ?></h5>
      <p class="card-text mb-3">電話：<?php echo $mobile; ?></p>
      <p class="card-text mb-3">郵遞區號：<?php echo $myzip . $ctName . $toName; ?></p>
      <p class="card-text mb-3">地址：<?php echo $address; ?></p>
      <!-- <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recipientModal">選擇其他收件人</a> -->
      <div class="mt-auto"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recipientModal">選擇其他收件人</button></div>
    </div>
  </div>
  <!-- 付款方式 -->
  <div class="card  col-md-6 col-xl-5 mx-auto mt-3 mt-md-0" id="harau">
    <h5 class="card-header" style="color:#000;"><i class="fas fa-credit-card me-1"></i>付款方式</h5>
    <!-- 選擇標籤 -->
    <ul class="nav nav-tabs mt-2" id="myTab" role="tablist" >
      <li class="nav-item " role="presentation" >
        <button class="nav-link  active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" >貨到付款</button>
      </li>
      <li class="nav-item " role="presentation" >
        <button class="nav-link " id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">信用卡</button>
      </li>
      <li class="nav-item " role="presentation" >
        <button class="nav-link " id="epay-tab" data-bs-toggle="tab" data-bs-target="#epay-tab-pane" type="button" role="tab" aria-controls="epay-tab-pane" aria-selected="false">電子支付</button>
      </li>
      <li class="nav-item " role="presentation" >
        <button class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">銀行轉帳</button>
      </li>
      

    </ul>
    <!-- 內容 -->
    <div class="tab-content" id="myTabContent">
      <!-- 貨到付款 -->
      <div class="tab-pane fade pt-3 ps-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <!-- <h4 class="card-title mb-4">收件人資訊：</h4> -->
        <h5 class="card-title mb-3">姓名：<?php echo $cname; ?></h5>
        <p class="card-text mb-3">電話：<?php echo $mobile; ?></p>
        <p class="card-text mb-3">郵遞區號：<?php echo $myzip . $ctName . $toName; ?></p>
        <p class="card-text mb-3">地址：<?php echo $address; ?></p>
      </div>
      <!-- 信用卡 -->
      <div class="tab-pane fade pt-1 ps-1" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <table class="table caption-top" id="cdcard">
          <caption>選擇付款帳號</caption>
          <thead>
            <tr>
              <th scope="col" width="5%">#</th>
              <th scope="col" width="30%">信用卡系統</th>
              <th scope="col" width="35%">發卡銀行</th>
              <th scope="col" width="30%">信用卡號</th>
            </tr>
          </thead>
          <tbody >
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/Visa_Inc._logo.svg" alt="Visa" class="img-fluid"></td>
              <td>玉山商業銀行</td>
              <td>1234 ****</td>
            </tr>
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/MasterCard_Logo.svg" alt="MasterCard" class="img-fluid"></td>
              <td>玉山商業銀行</td>
              <td>1234 ****</td>
            </tr>
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/UnionPay_logo.svg" alt="UnionPay" class="img-fluid"></td>
              <td>玉山商業銀行</td>
              <td>1234 ****</td>
            </tr>
          </tbody>
        </table>
        <button type="button" class="btn btn-outline-success mb-3">使用其他信用卡付款</button>

      </div>
      <!-- 電子支付 -->
      <div class="tab-pane fade pt-1 ps-1" id="epay-tab-pane" role="tabpanel" aria-labelledby="epay-tab" tabindex="0">
        <table class="table caption-top">
          <caption>選擇電子支付方式</caption>
          <thead>
            <tr>
              <th scope="col" width="5%">#</th>
              <th scope="col" width="35%">電子支付系統</th>
              <th scope="col" width="60%">電子支付公司</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/Apple_Pay_logo.svg" alt="Apple_Pay" class="img-fluid"></td>
              <td>Apple Pay</td>
            </tr>
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/Line_pay_logo.svg" alt="Line_pay" class="img-fluid"></td>
              <td>Line pay</td>
            </tr>
            <tr>
              <th scope="row" class="align-middle"><input type="radio" name="creaditCard" id="creaditCard[]" checked></th>
              <td><img src="./pro_book_images/ckout_images/JKOPAY_logo.svg" alt="JKOPAY" class="img-fluid"></td>
              <td>JKOPAY</td>
            </tr>
          </tbody>
        </table>

      </div>
      <!-- 銀行轉帳 -->
      <div class="tab-pane fade pt-3 ps-3" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

        <h4 class="card-title">ATM匯款資訊：</h4>
        <h5 class="card-title">匯款銀行：國泰世華銀行 (銀行代碼：013)</h5>
        <h5 class="card-title">收款人　：林小強</h5>
        <p class="card-text">匯款帳號：1234-4567-7890-1234</p>
        <p class="card-text" style="color: red;">※匯款完成後，需要1、2個工作天，待系統入款完成後，將以簡訊通知訂單完成付款。</p>

      </div>
      
    </div>
  </div>
</div>

<!-- 結帳區 -->
<?php
//建立購物車資料查詢
// $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product.p_id AND cart.p_id=product_img.p_id AND product_img.sort=1 ORDER BY cartid DESC ";
// $cart_rs = $link->query($SQLstring);
$ptotal = 0; //設定累加金額的變數，初始為0

$SQLstring=$link->prepare("SELECT * FROM cart JOIN product ON cart.p_id=product.p_id JOIN product_img ON cart.p_id = product_img.p_id WHERE ip=? AND orderid IS NULL AND product_img.sort=1 ORDER BY cartid DESC");
$SQLstring->execute([$_SERVER['REMOTE_ADDR']]);
?>
<div class="table-responsive-md">
  <table class="table table-hover mt-3 " id="cktable">
    <thead>
      <tr class="table-bg-primary">
        <!-- <td width="10%" class="cidEach">產品編號</td> -->
        <td width="10%">圖片</td>
        <td width="40%">名稱</td>
        <td width="15%">價格</td>
        <td width="15%">數量</td>
        <td width="20%">小計</td>
      </tr>
    </thead>
    <tbody>
      <?php //while ($cart_data = $cart_rs->fetch()) { ?>
      <?php while ($cart_data = $SQLstring->fetch()) { ?>
        <tr>
          <!-- <td class="cidEach"><?php //echo $cart_data['cartid']; ?></td> -->
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
      <tr>
        <td colspan="7">
          <button type="button" class="btn btn-danger mx-3" onclick="window.history.go(-1)"><i class="fas fa-circle-left"></i>重新確認</button>
          <button type="button" id="btn04" class="btn btn-success mx-3" oncl><i class="fas fa-cart-arrow-down pr-2" ></i>確認結帳</button>
        </td>
      </tr>
    </tfoot>
  </table>
</div>

<!-- Modal -->
<?php
//取得所有收件人資料
$SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo ", $_SESSION['emailid']);
$addbook_rs = $link->query($SQLstring);
?>
<div class="modal fade " id="recipientModal" tabindex="-1" aria-labelledby="recipientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recipientModalLabel">收件人資訊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- 新增收件人 -->
        <form action="">
          <div class="row">
            <div class="col-6 col-lg-3 mb-2">
              <input type="text" name="cname" id="cname" class="form-control" placeholder="新增收件人姓名" required>
            </div>
            <div class="col-6 col-lg-3 mb-2">
              <input type="text" name="mobile" id="mobile" class="form-control" placeholder="收件人電話" required>
            </div>
            <div class="col-6 col-lg-3 mb-2">
              <select name="myCity" id="myCity" class="form-control w-100 rounded">
                <option value="">請選擇市區</option>
                <?php $city = "SELECT * FROM city WHERE State=0";
                $city_rs = $link->query($city);
                while ($city_rows = $city_rs->fetch()) { ?>
                  <option value="<?php echo $city_rows['AutoNo']; ?> "><?php echo $city_rows['Name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-6 col-lg-3 mb-2">
              <select name="myTown" id="myTown" class="form-control w-100 rounded">
                <option value="">請選擇地區</option>
              </select>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col">
              <input type="hidden" name="myZip" id="myZip">
              <label for="address" class="form-label" name="add_label" id="add_label">郵遞區號：</label>
              <input type="text" name="address" id="address" class="form-control rounded" placeholder="請輸入地址">
            </div>
          </div>
          <div class="row mt-4 justify-content-center">
            <div class="col-auto">
              <button type="button" class="btn btn-success" id="recipient" name="recipient">新增收件人</button>
            </div>
          </div>
        </form>
        <hr>
        <!-- 已儲存收件人 -->
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">收件者姓名</th>
              <th scope="col">電話</th>
              <th scope="col">地址</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = $addbook_rs->fetch()) {; ?>
              <!-- setdefault為預設收件人 -->
              <tr>
                <th scope="col"><input type="radio" name="gridRadios" id="gridRadios[<?php echo $data['addressid']; ?>]" value="<?php echo $data['addressid']; ?>" <?php echo ($data['setdefault']) ? 'checked' : ''; ?>></th>
                <td><?php echo $data['cname']; ?></td>
                <td><?php echo $data['mobile']; ?></td>
                <td><?php echo $data['myzip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></td>
              </tr>
            <?php  }; ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <!-- <button type="button" class="btn btn-primary">儲存變更</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Loading -->
<div id="loading" class="position-fixed w-100 h-100 top-0 start-0" name="loading" style="display: none; background: rgba(255, 255,255,.5);z-index: 9999;"><i class="fas fa-spinner fa-spin fa-5x fa fw position-absolute top-50 start-50"></i></div>