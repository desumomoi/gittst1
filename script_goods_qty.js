//js for goods
//設定goods購入數量
document.addEventListener('click', function (event) {
    if (event.target.matches('.btn-minus')) {
        let goodsqty = document.getElementById('qty');
        // let goodsqty = document.getElementById('goodsqty');
        let value = parseInt(goodsqty.value, 10);
        if (!isNaN(value) && value > 1) {
            goodsqty.value = value - 1;
        }
    }
    if (event.target.matches('.btn-plus')) {
        let goodsqty = document.getElementById('qty');
        // let goodsqty = document.getElementById('goodsqty');
        let value = parseInt(goodsqty.value, 10);
        if (!isNaN(value) && value < 49) {
            goodsqty.value = value + 1;
        }
    }
});

//addcart
// function addcart(p_id) {
//     let qty = $("#qty").val();
//     if (qty <= 0) {
//         alert("產品數量不得為0，請修改");
//         return (false);
//     }
//     if (qty == undefined) {
//         qty = 1;
//     } else if (qty >= 50) {
//         alert("sorry too much");
//         return (false);
//     }
//     $.ajax({
//         url: './url_addcart_book.php',
//         type: 'get',
//         dataType: 'json',
//         data: { p_id: p_id, qty: qty, },
//         success: function (data) {
//             if (data.c == true) {
//                 alert(data.m);
//                 window.location.reload();
//             } else {
//                 alert(data.m);
//             }
//         },
//         error: function (data) {
//             alert("sorry can not connect to data");
//         }
//     });
// }


// let btnminus = document.getElementById('btn-minus');
// let btnplus = document.getElementById('btn-plus');

// btnminus.addEventListener('click', () => {
//     let goodsqty = document.getElementById('goodsqty');
//     let value = parseInt(goodsqty.value, 10);
//     if (value > 1) {
//         goodsqty.value = value - 1;
//     }
// });
// btnplus.addEventListener('click', () => {
//     let goodsqty = document.getElementById('goodsqty');
//     let value = parseInt(goodsqty.value, 10);
//     if (value < 50) {
//         goodsqty.value = value + 1;
//     }
// })