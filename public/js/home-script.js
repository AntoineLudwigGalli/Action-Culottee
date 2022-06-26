$(".dynamic-image-left").mouseenter(function (e){
    e.preventDefault();
    $(this).addClass("animation-right");

})

$(".dynamic-image-left").mouseleave(function (e) {
    e.preventDefault();
    $(this).removeClass("animation-right");
});

$(".dynamic-image-right").mouseenter(function (e){
    e.preventDefault();
    $(this).addClass("animation-left");

})

$(".dynamic-image-right").mouseleave(function (e) {
    e.preventDefault();
    $(this).removeClass("animation-left");
});


