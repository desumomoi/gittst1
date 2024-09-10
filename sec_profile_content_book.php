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
        <h1>會員資料修改頁面</h1>
        <p>請輸入相關資料，*為必須輸入欄位</p>
    </div>
</div>
<div class="row" id="modify" name="modify">
    <div class="col-8 offset-2 text-left">
        <form id="reg" name="reg" action="" method="get">
            <div class="input-group mb-3">
                <input type="email" v-model="member.email" class="form-control" placeholder="*請輸入email帳號" readonly>
            </div>
            <div class="input-group mb-3">
                <input type="text" v-model="member.cname" name="cname" id="cname" class="form-control" placeholder="*請輸入姓名" :readonly="readonly" >
                <!-- v-model 是 Vue.js 用來進行雙向資料綁定的指令。這裡的意思是表單中的 <input> 元素的值與 member.cname 變數進行雙向綁定。當用戶輸入內容時，member.cname 的值會自動更新，反之亦然，變數的改變也會反映在輸入框中。 -->
                <!-- :readonly="readonly"作用是讓這個 <input> 元素的 readonly 屬性隨著 Vue 實例中 readonly 變數的變化而動態更新。 -->
            </div>
            <div class="input-group mb-3">
                <input type="text" v-model="member.birthday" name="birthday" id="birthday" onfocus="(this.type='date')" class="form-control" placeholder="*請選擇生日" :readonly="readonly">
            </div>
            <!-- <div class="input-group mb-3">
                <input type="text" v-model="member.mobile" name="mobile" id="mobile" class="form-control" placeholder="*請輸入手機" :readonly="readonly">
            </div> -->
            <label for="fileToUpload" class="form-label">上傳照片：</label>
            <div class="input-group mb-3" v-show="!readonly">
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control w-100 rounded" title="請上傳相片" accept=".jpg, .jpeg, .png, .gif">
                <p>
                    <button type="button" class="btn btn-danger btn-upload" id="uploadForm" name="uploadForm">開始上傳</button>
                </p>

                <div id="progress-div01" class="progress w-100" style="display: none;">
                    <div id="progress-bar01" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>

                <input type="hidden" name="uploadname" id="uploadname" value="">
                <img id="showimg" name="showimg" src="" alt="photo" class="img-fluid" style="display: none;">
            </div>
            <!-- v-if 也是用來控制元素顯示或隱藏，但它會根據條件完全添加或移除該元素。在這裡，當 readonly 為 true 時，元素會存在於 DOM 中；當 readonly 為 false，元素則會完全從 DOM 中移除。相比 v-show，v-if 的開銷較高，因為它需要真正的 DOM 操作。 -->
            <div class="input-group mb-3" v-if="readonly">
                <img :src="`./uploads/${(member.imgname)?member.imgname:'avatar.svg'}`" alt="photo" style="width: 20%;" :title="`檔名：${(member.imgname)?member.imgname:'avatar.svg'}`">
                <!-- :src 是 Vue.js 用來動態綁定 HTML 屬性的語法（簡寫自 v-bind:src）。這裡表示 img 元素的 src 屬性動態綁定到某個變數。具體來說，如果 member.imgname 存在，就使用該變數的值作為圖片路徑；如果 member.imgname 不存在，則顯示預設圖片 'avatar.svg' -->
                <!-- :title 是 Vue.js 的動態屬性綁定（簡寫自 v-bind:title）。這裡的 title 屬性動態設置為 "檔名：${(member.imgname)?member.imgname:'avatar.svg'}"，如果 member.imgname 存在，則顯示實際的檔名，否則顯示預設值 'avatar.svg'。這會顯示在圖片的提示框中。 -->
            </div>
            <!-- v-show 是 Vue.js 用來控制元素顯示或隱藏的指令。當 !readonly（即 readonly 為 false）時，這個元素會被顯示；當 readonly 為 true 時，這個元素會被隱藏。但 v-show 只會透過 CSS (display: none;) 隱藏元素，不會從 DOM 中移除它。 -->
            <div class="input-group mb-3" v-show="!readonly">
                <input type="hidden" v-model="captcha" name="captcha" id="captcha" value="">
                <a href="javascript:void(0);" title="按我更新認證碼" @click="getCaptcha();">
                    <!-- @click 是 Vue.js 中用來綁定點擊事件的指令。當用戶點擊這個元素時，會觸發 Vue 實例中的 getCaptcha() 方法。這裡的 getCaptcha() 是你定義的 Vue 方法，用來處理點擊後的邏輯操作。 -->
                    <canvas id="can"></canvas>
                </a>
                <input type="text" name="recaptcha" id="recaptcha" class="form-control w-100 rounded" placeholder="請輸入驗證碼">
            </div>


            <div class="input-group mb-3">
                <button type="button" class="btn btn-warning btn-lg me-2" style="color: white;" @click="editMember" v-if="readonly">更新會員資料</button>
                <button type="button" class="btn btn-info btn-lg text-white" v-if="readonly" data-bs-toggle="modal" data-bs-target="#pwModal">變更會員密碼</button>
                <button type="button" class="btn btn-primary btn-lg me-2 text-white" @click="saveMember" v-if="!readonly">儲存資料</button>
                <button type="button" class="btn btn-secondary btn-lg me-2 text-white" @click="readonly=true" v-if="!readonly">離開</button>
            </div>
        </form>
    </div>
    <!-- Modal -->
<div class="modal fade" id="pwModal" tabindex="-1" aria-labelledby="pwModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="pwModalLabel"><i class="fas fa-user-lock me-2"></i>密碼變更</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changePW" name="changePW">
            <div class="mb-3">
                <label for="PWOld" class="form-label">請輸入舊密碼</label>
                <input type="password" class="form-control" name="PWOld" id="PWOld" placeholder="Current Password" v-model="PWOld">
            </div>
            <div class="mb-3">
                <label for="PWNew1" class="form-label">請輸入新密碼</label>
                <input type="password" class="form-control" name="PWNew1" id="PWNew1" placeholder="New Password" v-model="PWNew1"  >
            </div>
            <div class="mb-3">
                <label for="PWNew2" class="form-label">請再確認新密碼</label>
                <input type="password" class="form-control" name="PWNew2" id="PWNew2" placeholder="Verify Password" v-model="PWNew2"  >
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" @click="savePW();">儲存密碼</button>
        <button id="mClose" name="mClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
</div>

