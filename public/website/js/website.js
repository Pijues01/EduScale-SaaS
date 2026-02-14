//Global variables
var element;

//Detect onclick event
if (window.matchMedia("(max-width: 920px)").matches === false) {
    $(".ham").on("click", function () {
        $(".side_menu").css("right", "0px");
        $(".overlay").css("opacity", "1");
        $(".overlay").css("z-index", "99");
    });

    $(".close").on("click", function () {
        $(".contact").css("top") >= "10%"
            ? $(".contact").hide().css("top", "-100%").fadeOut("100")
            : $(".side_menu").css("right", "-500px");
        $(".overlay").css("opacity", "0");
        $(".overlay").css("z-index", "-1");
    });

    $(".overlay").on("click", function () {
        $(".contact").css("top") >= "10%"
            ? $(".contact").hide().css("top", "-100%").fadeOut("100")
            : $(".side_menu").css("right", "-500px");
        $(".overlay").css("opacity", "0");
        $(".overlay").css("z-index", "-1");
    });
} else {
    $(".ham").on("click", function () {
        $(".side_menu").css("right", "0px");
        $(".overlay").css("opacity", "1");
        $(".overlay").css("z-index", "9");
    });

    $(".close").on("click", function () {
        $(".contact").css("top") >= "10%"
            ? $(".contact").hide().css("top", "-100%").fadeOut("100")
            : $(".side_menu").css("right", "-120%");
        $(".overlay").css("opacity", "0");
        $(".overlay").css("z-index", "-1");
    });

    $(".overlay").on("click", function () {
        $(".contact").css("top") >= "10%"
            ? $(".contact").hide().css("top", "-100%").fadeOut("100")
            : $(".side_menu").css("right", "-120%");
        $(".overlay").css("opacity", "0");
        $(".overlay").css("z-index", "-1");
    });
}

//Scroller Nav
window.onscroll = function () {
    if (
        document.body.scrollTop > 80 ||
        document.documentElement.scrollTop > 80
    ) {
        $("nav").addClass("fixed_nav");
    } else {
        $("nav").removeClass("fixed_nav");
    }
};

//DETECT ESC KEY PRESSED
document.onkeydown = function (evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
        isEscape = evt.key === "Escape" || evt.key === "Esc";
    } else {
        isEscape = evt.keyCode === 27;
    }
    if (isEscape) {
        if ($(".overlay").css("opacity") == "1") {
            $(".contact").css("top") >= "10%"
                ? $(".contact").hide().css("top", "-100%").fadeOut("100")
                : $(".side_menu").css("right", "-120%");
            $(".overlay").css("opacity", "0");
            $(".overlay").css("z-index", "-1");
        }
    }
};

//Dropdown
$(".dropdown").click(function () {
    if ($(this).children("aside").is(":hidden")) {
        $(this).children("aside").show("slow");
        $(this).children("a").css("color", "var(--white)");
    } else {
        $(this).children("aside").hide("slow");
        $(this).children("a").css("color", "var(--lite)");
    }
});

//Global variables
var slidestoshow, arrowmark;
if (window.matchMedia("(max-width: 920px)").matches === false) {
    slidestoshow = 4;
    arrowmark = true;
} else {
    slidestoshow = 1;
    arrowmark = false;
}

$(".blog-slider").slick({
    slidesToShow: slidestoshow,
    slidesToScroll: 1,
    dots: false,
    arrows: arrowmark,
    autoplay: true,
    autoplaySpeed: 2000,
    infinite: true,
});

$(".event-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
});

$(".testimonial_slider").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true, // Enables auto-slide
    autoplayTimeout: 2000, // Time in milliseconds (3 seconds)
    autoplayHoverPause: true, // Pause on hover
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
        },
    },
});

// For upcoming events countdown start

    document.addEventListener("DOMContentLoaded", function () {
        function updateCountdown() {
            const countdownElements = document.querySelectorAll(".countdown");
           
            
            countdownElements.forEach(function (countdown) {
                const eventTime = new Date(countdown.getAttribute("data-event-time")).getTime();
                const now = new Date().getTime();
                const timeLeft = eventTime - now;

                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdown.querySelector(".days").textContent = days;
                    countdown.querySelector(".hours").textContent = hours;
                    countdown.querySelector(".minutes").textContent = minutes;
                    countdown.querySelector(".seconds").textContent = seconds;
                } else {
                    countdown.innerHTML = "<strong>Event Started</strong>";
                }
            });
        }

        setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call
    });

// For upcoming events countdown End

document.getElementById("logo").addEventListener("click", function () {
    window.location.href = "https://ica.pitambarpolley.site/";
});

