let navsearchheight = document.getElementById("nav-search").offsetHeight;
let naviconheight = document.getElementById("navbaricons").offsetHeight;
console.log("navsearchheight=", navsearchheight);
console.log("naviconheight=", naviconheight);
let winwid = window.innerWidth;
console.log("window.innerWidth=", winwid);
let searchbtn = document.getElementById("button-addon2");
console.log("searchbtn width=" + searchbtn.offsetWidth);

// let harau=document.getElementById("harau");
// console.log('harau height=',harau.offsetHeight);

//以上console用
let content = document.getElementById("content");
let scontent = document.getElementById("scontent");
let footer = document.getElementById("footer");
let contentHeight = content.offsetHeight;
console.log("contentHeight", contentHeight);

let navbar = document.querySelector('.navbar');
let navbarbrand = document.querySelector('.navbar-brand');

//設定content margin-top=navbar height
document.addEventListener('DOMContentLoaded', () => {
    //獲得navbar的height
    let navbarHeight = navbar.offsetHeight;
    let scontentHeight = scontent.offsetHeight;
    let footerHeight = footer.offsetHeight;


    //將content的padding-top設為navbarHeight
    document.querySelector('#content').style.paddingTop = (navbarHeight + 10) + 'px';
    // document.querySelector('#content').style.marginBottom = (scontentHeight + footerHeight +10 ) + 'px';
    console.log(scontentHeight);
    console.log(footerHeight);
    console.log(navbarHeight);

});

//捲動時加上boxshadow
let navbarcollapse = document.querySelector('.navbar .navbar-collapse');
let navbartoggler = document.querySelector('.navbar-toggler');

window.addEventListener('scroll', () => {

    if (window.scrollY != 0) {
        navbar.classList.add('navbar-boxshadow');
    } else {
        if (navbartoggler.classList.contains('collapsed')) {
            navbar.classList.remove('navbar-boxshadow');
        }
    }
});

//navbar order & 加上boxshadow

navbartoggler.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        navbarcollapse.style.order = 6;
    }
    else {
        navbarcollapse.style.order = 3;
    }
    if (!navbartoggler.classList.contains('collapsed')) {
        navbar.classList.add('navbar-boxshadow');
    } else {
        if (window.scrollY === 0) {
            navbar.classList.remove('navbar-boxshadow');
        }
    }
});
window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
        navbarcollapse.style.order = 3;
    } else {
        navbarcollapse.style.order = 6;
    }
});

//dropdown
let dropdowntoggles = document.querySelectorAll(".navbar .dropdown-toggle");
dropdowntoggles.forEach(toggle => {
    toggle.addEventListener("click", function () {
        let dropdownMenu = this.nextElementSibling;

        if (dropdownMenu.classList.contains('show')) {
            // dropdownMenu.classList.add('show');
            setTimeout(() => {
                dropdownMenu.style.opacity = 1;
                dropdownMenu.style.transform = "scaleY(1)";
            }, 10);
        } else {
            dropdownMenu.style.transform = "scaleY(0)";
            // dropdownMenu.style.opacity=0;
            setTimeout(() => {
                dropdownMenu.classList.remove('show');
            }, 10);
        }
    });
});

//dropdown_v2
// let dropdownv2 = document.querySelectorAll(".navbar .dropdown");
// dropdownv2.forEach(function (dropdown) {
//     dropdown.addEventListener('mouseover', function () {
//         // let menu = this.querySelector('dropdown-menu-end');
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.show();
//     });
//     dropdown.addEventListener('mouseleave', function () {
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.hide();
//     });
//     dropdown.addEventListener('click', function (event) {
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.toggle(); //點擊時切換
//         event.preventDefault();
//     });
// })

//V3
// let dropdownv2 = document.querySelectorAll(".navbar .dropdown-toggle");
// dropdownv2.forEach(function (dropdown) {
//     dropdown.addEventListener('mouseover', function () {
//         // let menu = this.querySelector('dropdown-menu-end');
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.show();
//     });
//     dropdown.addEventListener('mouseleave', function () {
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.hide();
//     });
//     dropdown.addEventListener('click', function (event) {
//         let menu = bootstrap.Dropdown.getOrCreateInstance(dropdown);
//         menu.toggle(); //點擊時切換
//         event.preventDefault();
//     });
// })


// js search
let searchicon = document.getElementById("nav-searchicon");
let searchgroup = document.getElementById("search-group");
let searchname = document.getElementById("search_name");
// let searchbtn = document.getElementById("button-addon2");
if (window.innerWidth < 768) {
    searchicon.addEventListener("click", () => {
        searchgroup.style = 'width :300px; opacity:1;visibility :visible;';
        opensearch();
        document.addEventListener("click", function (event) {
            let isClickInsideSearchgroup = searchgroup.contains(event.target);
            let isClickInsideSearchicon = searchicon.contains(event.target);
            if (!isClickInsideSearchgroup && !isClickInsideSearchicon) {
                closesearch();
            }
        })
    });
}
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        searchgroup.style = 'width :""; opacity:1;visibility :visible;';
        opensearch();
    } else {
        searchgroup.style = 'width :0; opacity:0;visibility :hidden;';
        searchicon.style.display = 'block'
        // searchgroup.style.opacity = '0';
        // searchgroup.style.visibility = 'hidden';
        // searchgroup.style.width = '0';
    }
});
function opensearch() {
    searchbtn.style = 'display:block;opacity:1;';
    searchname.style = "transform:scaleX(1);transform-origin: right;";
    searchicon.style.display = 'none'
    // searchbtn.style.display = 'block';
    // searchbtn.style.opacity = '1';
}
function closesearch() {
    searchname.style = "transform:scaleX(0);transform-origin: right;";
    setTimeout(() => {
        searchbtn.style = 'display:none;opacity:0;';
        searchgroup.style = 'width :0; opacity:0;visibility :hidden;';
        searchicon.style.display = 'block'

        // searchbtn.style.display = 'none';
        // searchbtn.style.opacity = '0';
        // searchgroup.style.opacity = '0';
        // searchgroup.style.width = '0';
    }, 500);
}

//addcart
function addcart(p_id) {
    let qty = $("#qty").val();
    if (qty <= 0) {
        alert("產品數量不得為0，請修改");
        return (false);
    }
    if (qty == undefined) {
        qty = 1;
    } else if (qty >= 50) {
        alert("sorry too much");
        return (false);
    }
    $.ajax({
        url: './url_addcart_book.php',
        type: 'get',
        dataType: 'json',
        data: { p_id: p_id, qty: qty, },
        success: function (data) {
            if (data.c == true) {
                alert(data.m);
                window.location.reload();
            } else {
                alert(data.m);
            }
        },
        error: function (data) {
            alert("sorry can not connect to data");
        }
    });
}

//sec_cart.php
function btn_confirmLink(message, url) {
    if (message == "" || url == "") {
        return false;
    }
    if (confirm(message)) {
        window.location = url;
    }
    return false;
}

//將變更數量寫入後台
//script_cart_qtyToData
//cart_content
// script_cart_qtyToData
// $("input.qty-input").change(function () {
//     let qty = $(this).val();
//     let cartid = $(this).attr("cartid");
//     if (qty <= 0 || qty >= 50) {
//         alert("更改數量需大於0及小於50");
//         return false;
//     }
//     $.ajax({
//         url: './url_change_qty_book.php',
//         type: 'post',
//         dataType: 'json',
//         data: {
//             cartid: cartid,
//             qty: qty,
//         },
//         success: function (data) {
//             if (data.c == true) {
//                 //alert(data.m);
//                 window.location.reload();
//             } else {
//                 alert(data.m);
//             }
//         },
//         error: function (data) {
//             alert('系統無法連線到後台');
//         }
//     });
// });

//js for goods
//script_goods_qty
// document.addEventListener('click', function (event) {
//     if (event.target.matches('.btn-minus')) {
//         let goodsqty = document.getElementById('goodsqty');
//         let value = parseInt(goodsqty.value, 10);
//         if (value > 1) {
//             goodsqty.value = value - 1;
//         }
//     }
//     if (event.target.matches('.btn-plus')) {
//         let goodsqty = document.getElementById('goodsqty');
//         let value = parseInt(goodsqty.value, 10);
//         if (value < 50) {
//             goodsqty.value = value + 1;
//         }
//     }
// });


//以下測試用



//js for cart
//設定cart購入數量
