@extends('website.layout.master')

@section('content')
    <header class="flex">
        <article>
            <h1 class="title big">
                Welcome to <br /><em>Inspire</em> Coaching Academy
            </h1>
            <h4>Empowering Excellence, Shaping Futures</h4>
            <p>
                At ICA, we are committed to transforming education. With a legacy of
                inspiring success, we provide exceptional learning experiences
                tailored to help students achieve their dreams. Whether it's academic
                excellence, skill-building, or career advancement, ICA is your trusted
                partner on the journey to greatness.
            </p>
            <a href="#" class="btn btn_3">Explore more</a>
        </article>
        <section class="flex">
            <aside class="padding_1x">
                <h2 class="sub_title">Admission</h2>
                <b><i>Empowering Your Journey to Success</i></b>
                <p>
                    It is a long established fact that a reader will be distracted by
                    the readable content of a page when looking at its layout.
                </p>

                <a href="#"><i class="fa fa-angle-right"></i></a>
            </aside>
            <aside class="padding_1x">
                <h2 class="sub_title">Prospectus</h2>
                <b><i>Your Gateway to World-Class Education</i></b>
                <p>
                    It is a long established fact that a reader will be distracted by
                    the readable content of a page when looking at its layout.
                </p>
                <a href="#"><i class="fa fa-angle-right"></i></a>
            </aside>
            <aside class="padding_1x">
                <h2 class="sub_title">Features</h2>
                <b><i>Why Choose Inspire Coaching Academy?</i></b>
                <p>
                    It is a long established fact that a reader will be distracted by
                    the readable content of a page when looking at its layout.
                </p>
                <a href="#"><i class="fa fa-angle-right"></i></a>
            </aside>
        </section>
    </header>

    <!--MAIN-->
    <main>
        <!--division_2-->
        <div class="divisions division_2 flex" id="notice">
            <section class="flex_content padding_2x">
                <div class="title_header">
                    <h2 class="title medium">Notifications</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard.
                    </p>
                    <span class="bar_blue"></span>
                </div>
                <marquee direction="up" id="notification" onmouseover="this.stop();" onmouseleave="this.start();">
                    <!--notification begining-->
                    @foreach ($notifications as $notification)
                        <a href="{{ route('notification.details', ['id' => $notification->id]) }}" class="flex fixed_flex"
                            class="flex fixed_flex" target="_blank">
                            <figure>
                                <img src="/website/img/notice2.jpg" alt="" loading="lazy" />
                            </figure>
                            <article>
                                <h3 class="title">
                                    {{ $notification->title }}
                                </h3>
                                <p>
                                    {{ $notification->shortdescription }}
                                </p>
                                <aside class="fixed_flex">
                                    <span>
                                        <i class="fa fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($notification->create_time)->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fa fa-clock-o"></i>
                                        {{ \Carbon\Carbon::parse($notification->create_time)->format('h:i A') }}
                                    </span>
                                </aside>
                            </article>
                        </a>
                    @endforeach
                    <!--notification ends-->
                    <!--notification begining-->
                    {{-- <a href="#" class="flex fixed_flex">
                        <figure>
                            <img src="https://i.postimg.cc/tJ7PYG7h/02.jpg" alt="" loading="lazy" />
                        </figure>
                        <article>
                            <h3 class="title">
                                Lilliovi simple & cool web designing root way
                            </h3>
                            <p>
                                There are many variations of passages of Lorem Ipsum
                                available, but the majority have suffered alteration...
                            </p>
                            <aside class="fixed_flex">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    12-08-2023
                                </span>
                                <span>
                                    <i class="fa fa-clock-o"></i>
                                    20:38 pm
                                </span>
                            </aside>
                        </article>
                    </a> --}}
                    <!--notification ends-->
                    <!--notification begining-->
                    {{-- <a href="#" class="flex fixed_flex">
                        <figure>
                            <img src="https://i.postimg.cc/tJ7PYG7h/02.jpg" alt="" loading="lazy" />
                        </figure>
                        <article>
                            <h3 class="title">
                                Lilliovi simple & cool web designing root way
                            </h3>
                            <p>
                                There are many variations of passages of Lorem Ipsum
                                available, but the majority have suffered alteration...
                            </p>
                            <aside class="fixed_flex">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    12-08-2023
                                </span>
                                <span>
                                    <i class="fa fa-clock-o"></i>
                                    20:38 pm
                                </span>
                            </aside>
                        </article>
                    </a> --}}
                    <!--notification ends-->
                    <!--notification begining-->
                    {{-- <a href="#" class="flex fixed_flex">
                        <figure>
                            <img src="https://i.postimg.cc/tJ7PYG7h/02.jpg" alt="" loading="lazy" />
                        </figure>
                        <article>
                            <h3 class="title">
                                Lilliovi simple & cool web designing root way
                            </h3>
                            <p>
                                There are many variations of passages of Lorem Ipsum
                                available, but the majority have suffered alteration...
                            </p>
                            <aside class="fixed_flex">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    12-08-2023
                                </span>
                                <span>
                                    <i class="fa fa-clock-o"></i>
                                    20:38 pm
                                </span>
                            </aside>
                        </article>
                    </a> --}}
                    <!--notification ends-->
                </marquee>
            </section>
            <section class="flex_content padding_2x" id="event">
                <div class="title_header">
                    <h2 class="title medium">Upcoming Events</h2>
                    <p>
                        Join us for insightful sessions, workshops, and academic events at Inspire Coaching Academy.
                    </p>
                    <span class="bar_white"></span>
                    <ul class="logo-slider event-slider">
                        <li>
                            <h3 class="title small">New Batch Admissions Open!</h3>
                            <p>
                                Enroll now and secure your seat for the upcoming academic session ...
                            </p>
                             <!-- <aside class="fixed_flex">
                                <span>25<sub>day</sub></span>
                                <span>11<sub>hrs</sub></span>
                                <span>30<sub>min</sub></span>
                                <span>03<sub>sec</sub></span>
                            </aside>  -->
                            <aside class="fixed_flex countdown" data-event-time="2025-06-01T12:00:00">
                                <span><strong class="days">00</strong><sub>days</sub></span>
                                <span><strong class="hours">00</strong><sub>hrs</sub></span>
                                <span><strong class="minutes">00</strong><sub>min</sub></span>
                                <span><strong class="seconds">00</strong><sub>sec</sub></span>
                            </aside>
                            <a href="#" class="btn btn_2">Event details</a>
                        </li>
                        <li>
                            <h3 class="title small">Mock Test for Competitive Exams</h3>
                            <p>
                                Test your skills and get real-time feedback. Limited seats available!
                            </p>
                             <!-- <aside class="fixed_flex">
                                <span>25<sub>day</sub></span>
                                <span>11<sub>hrs</sub></span>
                                <span>30<sub>min</sub></span>
                                <span>03<sub>sec</sub></span>
                            </aside>  -->
                            <aside class="fixed_flex countdown" data-event-time="2025-06-25T10:30:00">
                                <span><strong class="days">00</strong><sub>days</sub></span>
                                <span><strong class="hours">00</strong><sub>hrs</sub></span>
                                <span><strong class="minutes">00</strong><sub>min</sub></span>
                                <span><strong class="seconds">00</strong><sub>sec</sub></span>
                            </aside>
                            <a href="#" class="btn btn_2">Join Now</a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

        <!--division_3-->
        <div class="divisions division_3 padding_2x">
            <section class="title_header">
                <h1 class="title">Contribution Towards Society</h1>
                <p>Replenish man have thing gathering lights yielding shall you</p>
                <span class="bar"></span>
            </section>
            <section class="slider padding_0x">
                <ul class="card logo-slider blog-slider">
                    <!--card begining-->
                    <li>
                        <figure>
                            <img src="https://i.postimg.cc/vBB5JsvW/01.webp" alt="" loading="lazy" />
                        </figure>
                        <article class="padding_1x">
                            <strong class="tag">Examination</strong>
                            <a href="#" class="title small">Lorem Ipsum is simply dummy text of the printing</a>
                            <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random
                                text. It has roots in a piece of classical...
                            </p>
                            <aside class="fixed_flex">
                                <span class="flex-content">
                                    <a href="#"><i class="fa fa-calendar"></i> 12-08-2020</a>
                                    <a href="#"><i class="fa fa-clock-o"></i> 20:38 pm</a>
                                </span>
                            </aside>
                        </article>
                    </li>
                    <!--card ends-->
                    <!--card begining-->
                    <li>
                        <figure>
                            <img src="https://i.postimg.cc/vBB5JsvW/01.webp" alt="" loading="lazy" />
                        </figure>
                        <article class="padding_1x">
                            <strong class="tag">Examination</strong>
                            <a href="#" class="title small">Lorem Ipsum is simply dummy text of the printing</a>
                            <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random
                                text. It has roots in a piece of classical...
                            </p>
                            <aside class="fixed_flex">
                                <span class="flex-content">
                                    <a href="#"><i class="fa fa-calendar"></i> 12-08-2020</a>
                                    <a href="#"><i class="fa fa-clock-o"></i> 20:38 pm</a>
                                </span>
                            </aside>
                        </article>
                    </li>
                    <!--card ends-->
                    <!--card begining-->
                    <li>
                        <figure>
                            <img src="https://i.postimg.cc/vBB5JsvW/01.webp" alt="" loading="lazy" />
                        </figure>
                        <article class="padding_1x">
                            <strong class="tag">Examination</strong>
                            <a href="#" class="title small">Lorem Ipsum is simply dummy text of the printing</a>
                            <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random
                                text. It has roots in a piece of classical...
                            </p>
                            <aside class="fixed_flex">
                                <span class="flex-content">
                                    <a href="#"><i class="fa fa-calendar"></i> 12-08-2020</a>
                                    <a href="#"><i class="fa fa-clock-o"></i> 20:38 pm</a>
                                </span>
                            </aside>
                        </article>
                    </li>
                    <!--card ends-->
                    <!--card begining-->
                    <li>
                        <figure>
                            <img src="https://i.postimg.cc/vBB5JsvW/01.webp" alt="" loading="lazy" />
                        </figure>
                        <article class="padding_1x">
                            <strong class="tag">Examination</strong>
                            <a href="#" class="title small">Lorem Ipsum is simply dummy text of the printing</a>
                            <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random
                                text. It has roots in a piece of classical...
                            </p>
                            <aside class="fixed_flex">
                                <span class="flex-content">
                                    <a href="#"><i class="fa fa-calendar"></i> 12-08-2020</a>
                                    <a href="#"><i class="fa fa-clock-o"></i> 20:38 pm</a>
                                </span>
                            </aside>
                        </article>
                    </li>
                    <!--card ends-->
                    <!--card begining-->
                    <li>
                        <figure>
                            <img src="https://i.postimg.cc/vBB5JsvW/01.webp" alt="" loading="lazy" />
                        </figure>
                        <article class="padding_1x">
                            <strong class="tag">Examination</strong>
                            <a href="#" class="title small">Lorem Ipsum is simply dummy text of the printing</a>
                            <p>
                                Contrary to popular belief, Lorem Ipsum is not simply random
                                text. It has roots in a piece of classical...
                            </p>
                            <aside class="fixed_flex">
                                <span class="flex-content">
                                    <a href="#"><i class="fa fa-calendar"></i> 12-08-2020</a>
                                    <a href="#"><i class="fa fa-clock-o"></i> 20:38 pm</a>
                                </span>
                            </aside>
                        </article>
                    </li>
                    <!--card ends-->
                </ul>
            </section>
        </div>

        <!--division_4-->
        <div class="divisions division_4 future" onmousemove="animate_balls(event)">
            <div class="title_header">
                <h2 class="title medium">We promise best future for your kids</h2>
                <p>
                    It is a long established fact that a reader will be distracted by
                    the readable content of a page when looking at its layout.
                </p>
                <aside class="fixed_flex">
                    <a href="{{ route('gallery') }}" class="btn btn_1">Explore more</a>
                    <a href="{{ route('gallery') }}"><i class="fa fa-angle-right"></i></a>
                    <a href="{{ route('gallery') }}">Gallery Portfolio</a>
                </aside>
            </div>
            <div class="cards">
                <span class="ball"></span>
                <span class="ball"></span>
                <span class="ball"></span>
                <span class="ball"></span>
                <section class="fixed_flex">
                    @foreach ($images as $img)
                        <figure class="flex_content">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="" loading="lazy" />
                        </figure>
                    @endforeach
                </section>
            </div>
        </div>


        <!-- TESTMONIAL START -->
        <section class="testimonial">
            <div class="round">

            </div>
            <div class="row">
                <div class="div_left">
                    <div class="owl-carousel testimonial_slider">
                        <div class="item">
                            <div class="testimonial_img">
                                <img src="website/img/t1.jpg" alt="" title="" loading="lazy">
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, neque aut. Optio voluptatum
                                asperiores minima. Suscipit, dolor! Enim recusandae temporibus doloremque sit quae ab ipsum!
                            </p>
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="name">
                                Carolyn Ortiz
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial_img">
                                <img src="website/img/t1.jpg" alt="" title="" loading="lazy">
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, neque aut. Optio voluptatum
                                asperiores minima. Suscipit, dolor! Enim recusandae temporibus doloremque sit quae ab ipsum!
                            </p>
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="name">
                                Carolyn Ortiz
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial_img">
                                <img src="website/img/t1.jpg" alt="" title="" loading="lazy">
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, neque aut. Optio voluptatum
                                asperiores minima. Suscipit, dolor! Enim recusandae temporibus doloremque sit quae ab ipsum!
                            </p>
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="name">
                                Carolyn Ortiz
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial_img">
                                <img src="website/img/t1.jpg" alt="" title="" loading="lazy">
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, neque aut. Optio voluptatum
                                asperiores minima. Suscipit, dolor! Enim recusandae temporibus doloremque sit quae ab ipsum!
                            </p>
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="name">
                                Carolyn Ortiz
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial_img">
                                <img src="website/img/t1.jpg" alt="" title="" loading="lazy">
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, neque aut. Optio voluptatum
                                asperiores minima. Suscipit, dolor! Enim recusandae temporibus doloremque sit quae ab ipsum!
                            </p>
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="name">
                                Carolyn Ortiz
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div_right">
                    <div class="title_header">
                        <h2 class="title medium">Some valuable feedback from our students</h2>
                        <p>
                            Supposing so be resolving breakfast am or perfectly. It drew a hill from me. Valley by oh twenty
                            direct me so. Departure defective arranging rapturous did believe him all had supported. Family
                            months lasted simple set nature vulgar him. Picture for attempt joy excited ten carried manners
                            talking how.
                        </p>
                    </div>
                    <a href="#" class="btn btn_1">Explore more</a>
                </div>
            </div>

        </section>
        <!-- TESTIMONIAL CLOSE -->

        <!-- =======contact inquery section start========= -->
        <section class="inquery" id="inquery">
            <div class="container">
                <div class="inquery_div">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-5">
                            <img src="website/img/inquery1.jpg" alt="" title="" loading="lazy"
                                class="inquery_img">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-7">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="inquery_form">
                                <div class="title_header">
                                    <h2 class="title medium">Admission Consultation</h2>
                                    <p>
                                        Get expert guidance on choosing the right academic path, understanding admission
                                        requirements, and preparing a strong application.
                                        Our professional consultants help students navigate the complex admission process
                                        with ease, ensuring the best chances of securing
                                        admission to their dream institutions. Whether you need assistance with college
                                        selection, application review, or interview preparation,
                                        we are here to support you every step of the way.
                                    </p>
                                </div>
                                <form action="{{ route('consult.submit') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Your Name*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Email Address (Optional)">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="tel" name="phone" class="form-control"
                                                placeholder="Phone Number*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="subject" class="form-control"
                                                placeholder="Subject*" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="comment" placeholder="Leave a message here" id="floatingTextarea2"
                                                style="height: 200px" required></textarea>
                                        </div>
                                        <div class="col-sm-12">
                                            {{-- <a href="" class="deafult_btn">Submit Now</a> --}}
                                            <button class="deafult_btn" type="submit">Submit Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
            </div>

        </section>
        <!-- =======contact inquery section close========= -->
    </main>
@endsection
