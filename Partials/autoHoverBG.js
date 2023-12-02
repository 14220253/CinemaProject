$(document).ready(function () {
    for (let index = 0; index < 350; index++) {
        $("section").append(`<span></span>`);
    }
    setInterval(function () {
        let spans = $("section span");
        let randomSpan = spans.eq(Math.floor(Math.random() * spans.length));
        randomSpan.addClass('hover').delay(1).queue(function (next) {
            $(this).removeClass('hover');
            next();
        });
    }, 10);


})