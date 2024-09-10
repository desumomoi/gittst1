//將變更數量寫入後台
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
    });
});