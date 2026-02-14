@extends('website.layout.master')
@push('css')
    <link rel="stylesheet" href="website/css/contact.css" />
@endpush

@section('content')
    <section class="contactbanner">
        <h1 class="bannerHeading">Contact</h1>
    </section>
    <!-- =======contact banner close============= -->
    <!-- ===========contact form start========== -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h3 class="contact_heding">Contact Info</h3>
                    <p class="contact_paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur harum
                        fuga excepturi, mollitia voluptatibus nisi laudantium. Vero, maxime nihil quo asperiores expedita
                        optio possimus totam sunt cumque labore, qui ullam aliquid velit nobis ipsa animi!</p>
                    <ul class="details_contact_list">
                        <li>
                            <div class="contact_icon"><i class="fa-solid fa-location-dot"></i></div>
                            <p class="icon_details">
                                <span class="icon_heading"> address</span>
                                <span>11st Floor New World Tower Miami</span>
                            </p>
                        </li>
                        <li>
                            <div class="contact_icon"><i class="fa-solid fa-phone"></i></div>
                            <p class="icon_details">
                                <span class="icon_heading"> phone</span>
                                <a href="+(801) 2345 - 6789" class="">+(801) 2345 - 6789</a>
                            </p>
                        </li>
                        <li>
                            <div class="contact_icon"><i class="fa-solid fa-envelope"></i></div>
                            <p class="icon_details">
                                <span class="icon_heading"> Email</span>
                                <a href="support@yourmail.com" class="">support@yourmail.com</a>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form_part">
                        <h3 class="">Send A Message</h3>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- <form action="" class="contact_form"> --}}
                        <form action="{{ route('contact.submit') }}" method="POST" class="contact_form">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Your Name*" name="name"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Your Email (Optional)"
                                        name="email">
                                </div>
                                <div class="col-sm-12">
                                    <input type="tel" class="form-control" placeholder="Your Phone No*" name="phone"
                                        required>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Subject*" name="subject"
                                        required>
                                </div>
                                <div class="col-sm-12">

                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                        name="comment" required></textarea>

                                </div>
                            </div>
                            <button type="submit" class="deafult_btn">Submit</button>
                        </form>

                        {{-- <a href="" class="deafult_btn">Submit</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===========contact form close========== -->
@endsection
