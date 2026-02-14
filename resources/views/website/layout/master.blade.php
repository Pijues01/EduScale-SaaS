<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!--PLUGIN-->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="website/css/owl.carousel.css">

    <link rel="stylesheet" href="website/css/home.css" />
    <link rel="stylesheet" href="website/css/responsive.css">
    @stack('css')



    <title>Inspire Coaching Academy</title>
</head>

<body>

    @include('website.layout.topbar')
    @include('website.layout.navbar')
    @include('website.layout.sidemenu')

    @yield('content')

    @include('website.layout.footer')



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="website/js/website.js"></script>
        @stack('js')

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const admissionLink = document.querySelector(".admission_link");
                const admissionSection = document.getElementById("inquery");

                function handleScroll() {
                    const sectionTop = admissionSection.offsetTop;
                    const sectionHeight = admissionSection.offsetHeight;
                    const scrollPos = window.scrollY || document.documentElement.scrollTop;

                    if (scrollPos >= sectionTop - 50 && scrollPos < sectionTop + sectionHeight) {
                        admissionLink.classList.add("active");
                    } else {
                        admissionLink.classList.remove("active");
                    }
                }

                window.addEventListener("scroll", handleScroll);
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                if (window.location.hash) {
                    const section = document.querySelector(window.location.hash);
                    if (section) {
                        setTimeout(() => {
                            section.scrollIntoView({ behavior: "smooth" });
                        }, 500); // Wait for the page to fully load before scrolling
                    }
                }
            });
        </script>


</body>

</html>
