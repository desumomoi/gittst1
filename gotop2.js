(function ($) {
    $('body').append("<img id='goTopButton' style='display:none;z-index=5;cursor:pointer;' title='回到頂端'/> ");
    var img = './images2/totop5.png', //宣告變數設定的圖檔名稱
        location = 0.95, //按鈕出現在螢幕的高度
        // tranlate = translateY(0%),
        right = 10, //距離右邊的px值
        opacity = 0.6, //預設透明度
        speed = 800, //捲動速度

        $button = $('#goTopButton'), //定義JQUERY呼叫圖片ID
        $body = $(document), //定義JQUERY網頁
        $win = $(window); //定義JQUERY瀏覽器chrome
    $button.attr('src', img); //將圖設定到goTopButton的src

    //建立當網頁捲動時呼叫自訂函數
    window.goTopMove = function () {
        //從網頁取的與頂端的數值約為75-165px
        var scrollH = $body.scrollTop(),
            winH = $win.height(),
            css = { 
                "top": winH * location + 'px', 
                'position': 'fixed', 
                'right': right, 
                'opcaity': opacity ,
                'transform': 'none'
            }; //將參數設定CSS
        //如果捲動與頂端超過20px就顯示圖片
        if (scrollH > 400) {
            css = { 
                // 'transform': 'translateY(-100%)',
                "top": winH * (location-0.1) + 'px', 
                'transition': '0.5s ease' 
                };
            $button.css(css);
            $button.fadeIn('slow');
        }
        else if ( scrollH > 30) {
            $button.css(css);
            $button.fadeIn('slow');
        }
        else {
            $button.fadeOut('slow');
            css = { 'transform': 'none', 'transition': 'none','opcaity':'0'};
            $button.css(css);
        }
        // if (scrollH < 500) {
        //     $button.css(css);
        //     $button.fadeIn('slow');
        // }
        // else if ( scrollH > 500) {
        //     // ass = { "top": winH * 0.5 }
        //     css = { 
        //         // 'transform': 'translateY(-100%)',
        //         "top": winH * (location-0.1) + 'px', 
        //         'transition': '0.5s ease' 
        //         };
        //     $button.css(css);
        //     $button.fadeIn('slow');
        // }



    };

    //設定瀏覽器監聽兩個動作scroll 和 resize
    $win.on({
        scroll: function () { goTopMove(); },
        resize: function () { goTopMove(); }
    });

    //設定瀏覽器監聽三個圖片動作，分別為1滑鼠滑入 與2滑鼠滑出 與3按下
    $button.on({
        mouseover: function () {
            css = { 
                'opacity': '1', 
                // 'top': winH * (location) + 'px', 
                // 'transform': 'rotateY(360deg)', 'transition': '1s ease' 
            };
            $button.css(css);
        },
        mouseout: function () { 
            css = { 'opacity': '0.6', 
                // 'transform': 'rotateY(0deg)', 'transition': '0.5s ease' 
            };
            $button.css(css); },
        click: function () {
            css = { 'transform': 'translate(0,-3000%) ', 'transition': 'transform 0.8s ease 0.2s' };
            $button.css(css);
            $("html,body").animate({ scrollTop: 0 }, speed);
        }
    });

})(jQuery);
