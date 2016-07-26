



$(document).ready(function () {
    console.log ("wurst");

    $('.header').each(function() {
        this.addEventListener("click", function(e) {
            e.preventDefault();
            Menu.open();
            console.log ("click");
        }, false);
    });
});



    function Menu () {
    }

    Menu.mMenuId = "#menu";


    Menu.open = function () {
        $(this.mMenuId).animate({bottom: "0%"});
    };



    function Inlay (selector) {
        var mInlaySelector = selector;

        this.open = function () {
            var inlay = $(mInlaySelector);
            inlay.animate ({bottom: "0px"});
            $(".inlay_popup_content", inlay).show();
        };

        this.close = function () {
            var inlay = $(mInlaySelector);
            inlay.animate({bottom: "-100%"});
            $(".inlay_popup_content", inlay).hide();
        }
    }

