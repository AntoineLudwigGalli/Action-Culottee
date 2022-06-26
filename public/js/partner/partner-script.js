$(".card-partner").mouseenter(function (e){
    e.preventDefault();
    $(this).addClass("orange-filter");
})


$(".card-partner").mouseleave(function (e){
    e.preventDefault();
    $(this).removeClass("orange-filter");
})