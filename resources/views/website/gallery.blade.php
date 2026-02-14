@extends('website.layout.master')
@push('css')
    <link rel="stylesheet" href="website/css/gallery.css" />
@endpush

@section('content')
    <!-- ===========about banner start============ -->
    <section class="contactbanner">
        <h1 class="bannerHeading">Gallery</h1>
    </section>
    <!-- =======about banner close============= -->
    <!-- Main Section -->
    <div id="custom-container">
        <header id="custom-header">
            <h4 id="custom-header-title">A Glimpse into Our Journey ...</h4>
        </header>

        <main class="custom-grid">
            @foreach ($images as $img)
                <div class="custom-grid-item">
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image 1">
                </div>
            @endforeach
        </main>

    </div>
@endsection
