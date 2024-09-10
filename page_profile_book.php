<?php require_once('./Connections/conn_books_db.php');
(!isset($_SESSION)) ? session_start() : "";
require_once('./Connections/php_lib.php');
if (!isset($_SESSION['login'])) {
    $sPath = "./login.php?sPath=page_profile_book";
    header(sprintf("Location:%s", $sPath));
}


?>

<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Bookwalker</title>
    <?php require_once('./link_headfile_books.php'); ?>
    <link rel="stylesheet" href="./style/register.css">
    <link rel="stylesheet" href="./style/profile.css">
</head>

<body>
    <div id="header">
        <!-- 引入網頁標頭 -->
        <?php require_once('./sec_navbar_book.php'); ?>
    </div>
    <div id="content">
        <div class="container-fluid">
            <!-- login -->
            <?php require_once('./sec_profile_content_book.php'); ?>


        </div>
    </div>
    <div id="scontent">
        <!-- 服務說明 -->
        <?php require_once('./sec_scontent_book.php') ?>
    </div>
    <div id="footer">
        <!-- 聯絡資訊 -->
        <?php require_once('./sec_footer_book.php') ?>
    </div>
    <!-- JS -->
    <?php require_once('./link_jsfiles.php'); ?>
    <script src="./commlib.js"></script>
    <script src="./jquery.validate.js"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        let Vue3 = Vue.createApp({
            data() {
                return {
                    emailid: <?php echo json_encode($_SESSION['emailid']); ?>, //取得email
                    // member: {}, //會員資料更新物件
                    member: [], //會員資料更新陣列
                    captcha: '', //認證碼變數
                    readonly: true, //讀取模式或編輯模式
                    PWOld: '', //密碼更改舊密碼變數
                    PWNew1: '', //密碼更改新密碼變數1
                    PWNew2: '', //密碼更改新密碼變數2
                }
            },
            methods: {
                // 儲存修改後的密碼到後台
                async savePW() {
                    let valid = $('#changePW').valid();
                    if (valid) {
                        await axios.get('./url_reqchangePW.php', {
                                params: {
                                    emailid: this.member.emailid,
                                    PWNew1: MD5(this.PWNew1),
                                }
                            })
                            .then((res) => {
                                let data = res.data;
                                if (data.c == true) {
                                    $('#changePW').validate().resetForm();
                                    this.PWOld = '';
                                    this.PWNew1 = '';
                                    this.PWNew2 = '';
                                    $('#mClose').click();
                                    alert(data.m);
                                }
                            })
                            .catch(function(error) {
                                alert("系統目前無法連線到後台_changePW");
                            });
                    }
                },
                // 儲存修改後的會員資料到後台
                async saveMember() {
                    let valid = $('#reg').valid(); //呼叫資料驗證函數
                    if (valid) {
                        let imgfile = $('#uploadname').val();
                        if (imgfile != '') {
                            this.member.imgname = imgfile;
                        }
                        await axios.get('./url_reqMember.php', {
                                params: {
                                    birthday: this.member.birthday,
                                    cname: this.member.cname,
                                    emailid: this.member.emailid,
                                    imgname: this.member.imgname,
                                    // tssn: this.member.tssn,
                                }
                            })
                            .then((res) => {
                                let data = res.data;
                                if (data.c == true) {
                                    alert(data.m);
                                    location.reload();
                                }
                            })
                            .catch(function(error) {
                                alert("系統目前無法連線到後台");
                            });
                    }
                },
                //開啟編輯模式
                editMember() {
                    this.readonly = false;
                },
                // 使用第三方AJAX的API取得使用者資料
                getMemberInfo() {
                    axios.get('./url_memberinfo.php', {
                            params: {
                                emailid: this.emailid,
                            }
                        })
                        .then((res) => {
                            let data = res.data;
                            if (data.c == true) {
                                this.member = data.d[0];
                            } else {
                                alert(data.m);
                            }
                        })
                        .catch(function(error) {
                            alert("系統目前無法連線到後台");
                        });
                },
                getCaptcha() {
                    //can為canvas的ID名稱
                    //150=影像寬、50=影像高、blue=影像背景顏色
                    //white=文字顏色，28px=文字大小，5=驗證碼長度
                    this.captcha = captchaCode("can", 150, 50, "blue", "white", "28px", 5);
                },
            },
            mounted() {
                this.getCaptcha();
                this.getMemberInfo();
            }
        });
        Vue3.mount('#modify');
        $('#changePW').validate({
            rules: {

                PWOld: {
                    required: true,
                    remote: './url_checkPW.php?emailid=<?php echo $_SESSION['emailid']; ?>',
                },
                PWNew1: {
                    required: true,
                    minlength: 4,
                    maxlength: 20,
                },
                PWNew2: {
                    required: true,
                    equalTo: '#PWNew1'
                },
            },
            messages: {
                PWOld: {
                    required: '密碼不得為空白',
                    remote: '原始密碼錯誤，請重新輸入',
                },
                PWNew1: {
                    required: '密碼不得為空白',
                    minlength: '密碼最小長度為4位(4-20位英文字母與數字的組合)',
                    maxlength: '密碼最大長度為20位(4-20位英文字母與數字的組合)',
                },
                PWNew2: {
                    required: '確認密碼不得為空白',
                    equalTo: '兩次輸入的密碼必須一致'
                },
            },
        });
    </script>
    <script src="./script_register.js"></script>
</body>

</html>