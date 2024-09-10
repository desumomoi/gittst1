<?php
if (isset($_POST['formctl']) && $_POST['formctl'] == 'reg') {
    $email = $_POST['email'];
    $pw1 = md5($_POST['pw1']);
    $cname = $_POST['cname'];
    $tssn = $_POST['tssn'];
    $birthday = $_POST['birthday'];
    $mobile = $_POST['mobile'];
    $myZip = $_POST['myZip'] == '' ? NULL : $_POST['myZip'];
    $address = $_POST['address'] == '' ? NULL : $_POST['address'];
    $imgname = $_POST['uploadname'] == '' ? NULL : $_POST['uploadname'];
    $insertsql = "INSERT INTO member (email,pw1,cname,tssn,birthday,imgname) VALUES ('" . $email . "','" . $pw1 . "','" . $cname . "','" . $tssn . "','" . $birthday . "','" . $imgname . "')";
    $Result = $link->query($insertsql);
    $emailid = $link->lastInsertId(); //讀取剛新稱會員編號
    if ($Result) {
        // 將會員姓名電話地址寫入addbook
        $insertsql = "INSERT INTO addbook(emailid,setdefault,cname,mobile,myzip,address) VALUES ('" . $emailid . "','1','" . $cname . "','" . $mobile . "','" . $myZip . "','" . $address . "') ";
        $Result = $link->query($insertsql);
        $_SESSION['login'] = true; //註冊完直接登入
        $_SESSION['emailid'] = $emailid;
        $_SESSION['email'] = $email;
        $_SESSION['cname'] = $cname;
        echo "<script>alert('謝謝您，會員資料已完成註冊，即將回到首頁');location.href='./index.php';</script>";
    }
}
?>

<div class="row">
    <div class="col-lg-12 text-center">
        <h1>會員註冊頁面</h1>
        <p>請輸入相關資料，*為必須輸入欄位</p>
    </div>
</div>
<div class="row">
    <div class="col-8 offset-2 text-left">
        <form id="reg" name="reg" action="./page_register_book.php" method="post">
            <div class="input-group mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="*請輸入email帳號" required>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="pw1" id="pw1" class="form-control rounded" placeholder="*請輸入密碼" required>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="pw2" id="pw2" class="form-control" placeholder="*請再次確認密碼" required>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="cname" id="cname" class="form-control" placeholder="*請輸入姓名" required>
            </div>
            <!-- <div class="input-group mb-3">
                <input type="text" name="tssn" id="tssn" class="form-control" placeholder="請輸入身份證字號" required>
            </div> -->
            <div class="input-group mb-3">
                <input type="text" name="birthday" id="birthday" onfocus="(this.type='date')" class="form-control" placeholder="*請選擇生日" required>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="*請輸入手機" required>
            </div>
            <div class="input-group mb-3">
                <select name="myCity" id="myCity" class="form-control w-100 rounded mb-2">
                    <option value="">請選擇市區</option>
                    <?php $city = "SELECT * FROM city WHERE State=0";
                    $city_rs = $link->query($city);
                    while ($city_rows = $city_rs->fetch()) { ?>
                        <option value="<?php echo $city_rows['AutoNo']; ?> "><?php echo $city_rows['Name']; ?></option>
                    <?php } ?>
                </select><br>
                <select name="myTown" id="myTown" class="form-control w-100 rounded">
                    <option value="">請選擇地區</option>
                </select>
            </div>
            <label for="address" class="form-label" name="zipcode" id="zipcode">郵遞區號：地址</label>
            <div class="input-group mb-3">
                <input type="hidden" name="myZip" id="myZip">
                <input type="text" name="address" id="address" class="form-control rounded" placeholder="請輸入後續地址">
            </div>
            <label for="fileToUpload" class="form-label">上傳照片：</label>
            <div class="input-group mb-3">
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control w-100 rounded" title="請上傳相片" accept=".jpg, .jpeg, .png, .gif">
                <p>
                    <button type="button" class="btn btn-danger btn-upload" id="uploadForm" name="uploadForm">開始上傳</button>
                    <!-- <button type="button" class="btn btn-danger btn-reUpload" id="reUpload" name="reUpload" style="display: none;">重新上傳</button> -->
                </p>

                <div id="progress-div01" class="progress w-100" style="display: none;">
                    <div id="progress-bar01" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>

                <input type="hidden" name="uploadname" id="uploadname" value="">
                <img id="showimg" name="showimg" src="" alt="photo" class="img-fluid" style="display: none;">
            </div>

            <div class="input-group mb-3">
                <input type="hidden" name="captcha" id="captcha" value="">
                <a href="javascript:void(0);" title="按我更新認證碼" onclick="getCaptcha();">
                    <canvas id="can"></canvas>
                </a>
                <input type="text" name="recaptcha" id="recaptcha" class="form-control w-100 rounded" placeholder="請輸入驗證碼">
            </div>
            <input type="hidden" name="formctl" id="formctl" value="reg">
            <div class="input-froup mb-3">
                <button type="submit" class="btn btn-success btn-lg">送出</button>
            </div>
        </form>
    </div>
</div>
