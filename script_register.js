//自訂身分證格式驗證
jQuery.validator.addMethod("tssn", function (value, element, param) {
    let tssn = /^[a-zA-Z]{1}[1-2]{1}[0-9]{8}$/;
    return this.optional(element) || (tssn.test(value));
});
//自訂手機格式驗證
jQuery.validator.addMethod("checkphone", function (value, element, param) {
    let checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;
    return this.optional(element) || (checkphone.test(value));
});
//自訂郵遞區號驗證
jQuery.validator.addMethod("checkMyTown", function (value, element, param) {
    return (value !== "");
});

//撰寫驗證email欄位功能程式
//驗證form #reg表單
$('#reg').validate({
    rules: {
        email: {
            required: true,
            email: true,
            remote: './url_checkmail.php'
        },
        pw1: {
            required: true,
            minlength: 4,
            maxlength: 20,
        },
        pw2: {
            required: true,
            equalTo: '#pw1'
        },
        cname: {
            required: true,
        },
        tssn: {
            required: false,
            tssn: true,
        },
        birthday: {
            required: true
        },
        mobile: {
            checkphone: true,
        },
        address: {
            required: true,
        },
        myTown: {
            checkMyTown: true,
        },
        recaptcha: {
            required: true,
            equalTo: '#captcha',
        },
    },
    messages: {
        email: {
            required: 'email信箱不得為空白',
            email: 'email信箱格式有誤',
            remote: 'email信箱已經註冊'
        },
        pw1: {
            required: '密碼不得為空白',
            minlength: '密碼最小長度為4位(4-20位英文字母與數字的組合)',
            maxlength: '密碼最大長度為20位(4-20位英文字母與數字的組合)',
        },
        pw2: {
            required: '確認密碼不得為空白',
            equalTo: '兩次輸入的密碼必須一致'
        },
        cname: {
            required: '使用者名稱不得為空白',
        },
        tssn: {
            required: '',
            tssn: '身份證ID格式有誤'
        },
        birthday: {
            required: '生日不得為空白'
        },
        mobile: {
            checkphone: '手機號碼格式有誤'
        },
        address: {
            required: '地址不得為空白'
        },
        myTown: {
            checkMyTown: '需選擇郵遞區號'
        },
        recaptcha: {
            required: '驗證碼不得為空白',
            equalTo: '驗證碼需相同'
        },
    },
});

//建立上傳照片功能
//取得元素ID
function getId(el) {
    return document.getElementById(el);
}
//圖示上傳處理
$("#uploadForm").click((e) => {
    e.preventDefault();
    //檢查檔案類型
    let fileName = $('#fileToUpload').val();
    let idxDot = fileName.lastIndexOf(".") + 1;
    let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
        $('#progress-div01').css("display", "flex");
        let file1 = getId("fileToUpload").files[0];
        let formdata = new FormData;
        formdata.append("file1", file1);
        let ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "./url_file_upload_parser.php");
        ajax.send(formdata);
        return false;
    } else {
        alert('目前只支援jpg,jpeg,png,gif檔案格式上傳！');
    }
});
//上傳過程顯示百分比
function progressHandler(event) {
    let percent = Math.round((event.loaded / event.total) * 100);
    $("#progress-bar01").css("width", percent + "%");
    $("#progress-bar01").html(percent + "%");
}
//上傳完成處理顯示圖片
function completeHandler(event) {
    let data = JSON.parse(event.target.responseText);
    if (data.success == "true") {
        $('#uploadname').val(data.fileName);
        $('#showimg').attr({
            'src': 'uploads/' + data.fileName,
            'style': 'display:block;'
        })
        $('button#uploadForm').hide();
    } else {
        alert(data.error);
    }
}
//Upload Failed:上傳發生錯誤
function errorHandler(event) {
    alert('Upload Failed:上傳發生錯誤');

}
//Upload Aborted:上傳作業取消
function abortHandler(event) {
    alert('Upload Aborted:上傳作業取消');
}
//自訂認證碼功能
function getCaptcha() {
    let inputTxt = document.getElementById("captcha");
    //can為canvas的ID名稱
    //150=影像寬、50=影像高、blue=影像背景顏色
    //white=文字顏色，28px=文字大小，5=驗證碼長度
    inputTxt.value = captchaCode("can", 150, 50, "blue", "white", "28px", 5);
}
//查詢縣市
$(function () {
    //啟動認證碼功能    
    getCaptcha();
    //取得縣市代碼後查鄉鎮市的名稱
    $("#myCity").change(function () {
        let CNo = $('#myCity').val();
        if (CNo == "") {
            return false;
        }
        $.ajax({ //將鄉鎮市名稱從後台取出
            url: './url_Town_ajax.php',
            type: 'post',
            dataType: 'json',
            data: {
                CNo: CNo,
            },
            success: function (data) {
                if (data.c == true) {
                    $('#myTown').html(data.m);
                    $('#myZip').val("");
                } else {
                    alert(data.m);
                }
            },
            error: function (data) {
                alert("系統目前無法連接到後台");
            }
        });
    });
    //取得縣市代碼後放入郵遞區號
    $("#myTown").change(function () {
        let AutoNo = $('#myTown').val();
        if (AutoNo == "") {
            return false;
        }
        $.ajax({ //將鄉鎮市名稱從後台取出
            url: './url_Zip_ajax.php',
            type: 'get',
            dataType: 'json',
            data: {
                AutoNo: AutoNo,
            },
            success: function (data) {
                if (data.c == true) {
                    $('#myZip').val(data.Post);
                    $('#zipcode').html(data.Post + data.Cityname + data.Name);
                } else {
                    alert(data.m);
                }
            },
            error: function (data) {
                alert("系統目前無法連接到後台");
            }
        });
    });
});
