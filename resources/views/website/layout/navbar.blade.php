  <!--NAV-->
  <nav>
      <section class="flex_content" id="logo">
          <figure class="logo fixed_flex">
              <img src="website/img/logo.jpeg" alt="Logo" class="cursor" />
              <figcaption class="cursor">
                  <strong class="title">Inspire</strong> Coaching Academy
              </figcaption>
          </figure>
      </section>
    <section class="flex_content nav_content" id="nav_content">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
        <a href="{{ route('branches') }}" class="{{ request()->routeIs('branches') ? 'active' : '' }} hom">Branches</a>
        <!--<a href="{{ route('home') }}#inquery" class="admission_link">Admission</a>-->
        <a href="{{ route('contactus') }}" class="contact_btn {{ request()->routeIs('contactus') ? 'active' : '' }}">Contact us</a>
        <a href="{{ route('aboutus') }}" class="{{ request()->routeIs('aboutus') ? 'active' : '' }}">About us</a>
    </section>

      <section class="flex_content">
          <a href="javascript:void(0)" class="ham"><i class="fa fa-bars"></i></a>
      </section>
  </nav>
