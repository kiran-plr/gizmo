$('.header-top-slider').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
    navText: ["<i class='bx bxs-left-arrow' ></i>", "<i class='bx bxs-right-arrow' ></i>"],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});
$('.company-logo-slider').owlCarousel({
    autoplay: true,
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    responsive: {
        0: {
            items: 3
        },
        600: {
            items: 4
        },
        1000: {
            items: 4
        }
    }
});
$('.product-slider').owlCarousel({
    // autoplay: true,
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    responsive: {
        0: {
            items: 2.3
        },
        600: {
            items: 3.5
        },
        1000: {
            items: 4
        }
    }
})
$('.reviews-slider').owlCarousel({
    // autoplay: true,
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    navText: ["<i class='bx bxs-left-arrow' ></i>", "<i class='bx bxs-right-arrow' ></i>"],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
})