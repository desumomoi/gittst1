//將變更數量寫入後台
document.addEventListener('click', function (event) {
        //如果點擊減少
        if (event.target.closest('button[id^="btn-minus-"]')) {
            let button=event.target.closest('button');
            let id = button.getAttribute('data-id');
            let qtyincart = document.getElementById('qty-' + id);
            let value = parseInt(qtyincart.value, 10);
            if (value > 1) {
                qtyincart.value = value - 1;
                $(qtyincart).trigger('change'); //手動觸發change
            }
        }
        //如果點擊增加
        if (event.target.closest('button[id^="btn-plus-"]')) {
            let button=event.target.closest('button');
            let id = button.getAttribute('data-id');
            let qtyincart = document.getElementById('qty-' + id);
            let value = parseInt(qtyincart.value, 10);

            if (value < 49) {
                qtyincart.value = value + 1;
                $(qtyincart).trigger('change'); //手動觸發change
            }
        }
})

$("input.qty-input").change(function () {
    let qty = $(this).val();
    let cartid = $(this).attr("cartid");
    if (qty <= 0 || qty >= 50) {
        alert("更改數量需大於0及小於50");
        return false;
    }
    $.ajax({
        url: './url_change_qty_book.php',
        type: 'post',
        dataType: 'json',
        data: {
            cartid: cartid,
            qty: qty,
        },
        success: function (data) {
            if (data.c == true) {
                //alert(data.m);
                window.location.reload();
            } else {
                alert(data.m);
            }
        },
        error: function (data) {
            alert('系統無法連線到後台');
        }
        // error: function (xhr, status, error) {
        //     console.error("AJAX Error: ", status, error);
        //     console.log("Response Text: ", xhr.responseText); // 檢查
        //     alert('系統無法連線到後台');
        // }
        
    });
});