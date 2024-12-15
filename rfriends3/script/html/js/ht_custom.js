// メニュー
    function acdMenu() {
        //level 1
        $(".acMenu dd").css("display", "none");
        $(".acMenu2 ul").css("display", "none");

        //level 2
        $(".acMenu dt").click(function() {
            $(".acMenu dt").not(this).next().slideUp("fast");
            $(this).next().slideToggle("fast");
        });

        //level 3
        $(".acMenu2 p").click(function() {
            $(this).toggleClass("openAcd").next().slideToggle("fast");
        });
    }

    $(function() {
        acdMenu();
    });

