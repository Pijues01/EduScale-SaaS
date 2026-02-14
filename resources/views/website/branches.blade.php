@extends('website.layout.master')
@push('css')
    <link rel="stylesheet" href="website/css/branches.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Enhanced Slider Styles */
        .school_imgs {
            position: relative;
            padding-bottom: 30px;
        }

        .swiper.mySwiper2 {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        .swiper.mySwiper {
            height: 80px;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .swiper.mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.6;
            transition: opacity 0.3s;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
        }

        .swiper.mySwiper .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #3a86ff;
        }

        .swiper.mySwiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-next,
        .swiper-button-prev {
            background-color: rgba(255,255,255,0.3);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            transition: all 0.3s;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(255,255,255,0.5);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }

        /* Enhanced Thumbnail Slider Styles - General that will apply to all */
        .swiper[class*="mySwiper-"] {
            height: 90px;
            box-sizing: border-box;
            padding: 5px 0;
            margin-top: 10px;
        }

        .swiper[class*="mySwiper-"] .swiper-slide {
            width: 80px !important;
            height: 70px !important;
            opacity: 0.7;
            transition: all 0.3s ease;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid #e0e0e0;
        }

        .swiper[class*="mySwiper-"] .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #3a86ff;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .thumbnail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .swiper[class*="mySwiper-"] .swiper-slide:hover .thumbnail-img {
            transform: scale(1.05);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .swiper[class*="mySwiper-"] {
                height: 80px;
            }

            .swiper[class*="mySwiper-"] .swiper-slide {
                width: 70px !important;
                height: 60px !important;
            }
        }

        @media (max-width: 576px) {
            .swiper[class*="mySwiper-"] {
                height: 70px;
            }

            .swiper[class*="mySwiper-"] .swiper-slide {
                width: 60px !important;
                height: 50px !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- ===========about banner start============ -->
    <section class="contactbanner">
        <h1 class="bannerHeading">Branches</h1>
    </section>
    <!-- =======about banner close============= -->
    <!-- =========branches div start============ -->
    <section class="branches_div">
        <div class="container">
            @foreach ($branches as $index => $branch)
                <div class="branches_divs branches_divs1">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <h2>Inspire Coaching Academy
                                <br>
                                ({{ $branch->branch_name }})
                            </h2>
                            <p>{{ $branch->description }}</p>

                            <div class="scholl_info">
                                <h3>Information About {{ $branch->branch_name }} Branch</h3>
                                <div class="school_info_content">
                                    <ul>
                                        <li>
                                            <span class="school_info_icon"><i class="fa-solid fa-location-dot"></i></span>
                                            <span class="schoolDetails"> Plot No: {{ $branch->location }}</span>
                                        </li>
                                        <li>
                                            <span class="school_info_icon"><i class="fa-solid fa-calendar-week"></i></span>
                                            <span class="schoolDetails">Working Hour: {{ $branch->working_hours }}</span>
                                        </li>
                                        <li>
                                            <a href=""> <span class="school_info_icon"><i
                                                        class="fa-solid fa-mobile"></i></span>
                                                <span class="schoolDetails">{{ $branch->contact }}</span></a>
                                        </li>
                                        <li>
                                            <a href=""> <span class="school_info_icon"><i
                                                        class="fa-solid fa-envelope"></i></span>
                                                <span class="schoolDetails">{{ $branch->email }}</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <div class="school_imgs">
                                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                    class="swiper mySwiper2-{{ $index }}">
                                    <div class="swiper-wrapper">
                                        @php
                                            $images = is_string($branch->images)
                                                ? json_decode($branch->images, true)
                                                : $branch->images;
                                        @endphp

                                        @foreach ($images ?? [] as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Branch Image" class="main-slide-img" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next swiper-button-next-{{ $index }}"></div>
                                    <div class="swiper-button-prev swiper-button-prev-{{ $index }}"></div>
                                </div>
                                <div thumbsSlider="" class="swiper mySwiper-{{ $index }}">
                                    <div class="swiper-wrapper">
                                        @php
                                            $images = is_string($branch->images)
                                                ? json_decode($branch->images, true)
                                                : $branch->images;
                                        @endphp

                                        @foreach ($images ?? [] as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Branch Image" class="thumbnail-img" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- =========branches div close============ -->
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all branch sliders
            @foreach ($branches as $index => $branch)
                var swiperThumbs{{ $index }} = new Swiper(".mySwiper-{{ $index }}", {
                    loop: false,
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                    breakpoints: {
                        576: {
                            slidesPerView: 4,
                            spaceBetween: 10
                        },
                        320: {
                            slidesPerView: 3,
                            spaceBetween: 5
                        }
                    }
                });

                var swiperMain{{ $index }} = new Swiper(".mySwiper2-{{ $index }}", {
                    loop: false,
                    spaceBetween: 10,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next-{{ $index }}",
                        prevEl: ".swiper-button-prev-{{ $index }}",
                    },
                    thumbs: {
                        swiper: swiperThumbs{{ $index }},
                    },
                });
            @endforeach
        });
    </script>
@endpush
