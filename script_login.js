$(function () {
    $("#formlogin").submit(function () {
        let inputAccount = $("#inputAccount").val();
        let inputPassword = MD5($("#inputPassword").val());
        $("#loading").show();
        //利用$ajax函數呼叫後台的auth_user.php驗證密碼
        $.ajax({
            url: './url_auth_user.php',
            type: 'post',
            dataType: 'json',
            data: {
                inputAccount: inputAccount,
                inputPassword: inputPassword,
            },
            success: function (data) {
                if (data.c == true) {
                    alert(data.m);
                    // window.location.href = $sPath ;
                    window.location.href = "<?php echo $sPath; ?>";
                } else {
                    alert(data.m);
                }
            },
            error: function (data) {
                alert("系統目前無法連接到後台資料庫");
            }
        });
    });
});