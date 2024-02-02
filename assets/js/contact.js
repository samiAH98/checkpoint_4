$(document).ready(function () {
    $(".menu-icon").click(function () {
        $(".navbar").toggleClass("active");
    });

    // Ajouter le défilement en douceur vers la partie "Contact" lors du clic sur le lien
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });
});