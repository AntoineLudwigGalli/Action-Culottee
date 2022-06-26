$(".dynamic-image").mouseenter(function (e){
    e.preventDefault();
    $(this).addClass("animation");

})

$(".dynamic-image").mouseleave(function (e) {
    e.preventDefault();
    $(this).removeClass("animation");
});




