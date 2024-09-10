let tst = document.querySelector(".pnameEach");
let fontsize = window.getComputedStyle(tst).fontSize;
console.log('pnameEach fontSize=', fontsize);

//tst
// 系統進行結帳處理
$('#btn04').click(function () {
    let msg = "系統將進行結帳處理，請確認產品金額與收件人資料";
    if (!confirm(msg)) return false;
    let addressid = $('input[name=gridRadios]:checked').val();
    $("#loading").show();
    $.ajax({
        url: './url_addorder.php',
        type: 'post',
        dataType: 'json',
        data: {
            addressid: addressid,
        },
        success: function (data) {
            if (data.c == true) {
                alert(data.m);
                window.location.href = "./index.php";
            } else {
                alert("Database response error:" + data.m);
            }
        },
        error: function (data) {
            alert("系統目前無法連接到後台資料庫");
        }
    });
});

// 更換收件人
$('input[name=gridRadios]').change(function () {
    let addressid = $(this).val();
    $.ajax({
        url: './url_changeaddr.php',
        type: 'post',
        dataType: 'json',
        data: {
            addressid: addressid,
        },
        success: function (data) {
            if (data.c == true) {
                alert(data.m);
                // window.location.reload();
            } else {
                alert("Database response error" + data.m);
            }
        },
        error: function (data) {
            alert("系統目前無法連接到後台資料庫");
        }
    });
});

//新增收件人程序js
$('#recipient').click(function () {
    let validate = 0;
    let msg = "";
    let cname = $('#cname').val();
    let mobile = $('#mobile').val();
    let myZip = $('#myZip').val();
    let address = $('#address').val();
    if (cname == "") {
        msg += "收件人不得為空白！\n";
        validate = 1;
    }
    if (mobile == "") {
        msg += "電話不得為空白！\n";
        validate = 1;
    }
    if (myZip == "") {
        msg += "郵遞區號不得為空白！\n";
        validate = 1;
    }
    if (address == "") {
        msg += "地址不得為空白！\n";
        validate = 1;
    }
    if (validate) {
        alert(msg);
        return false;
    }

    $.ajax({
        url: './url_addbook.php',
        type: 'post',
        dataType: 'json',
        data: {
            cname: cname,
            mobile: mobile,
            myZip: myZip,
            address: address,
        },
        success: function (data) {
            if (data.c == true) {
                alert(data.m);
                window.location.reload();
            } else {
                alert("Database response error:" + data.m);
            }

        },
        error: function (data) {
            alert("系統目前無法連接到後台資料庫");
        }
    });
});

//查詢縣市
$(function () {
    //啟動認證碼功能    
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
            $('#myzip').val("");
            $('#add_label').html("");
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
                    $('#add_label').html('郵遞區號：' + data.Post + data.Cityname + data.Name);
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

