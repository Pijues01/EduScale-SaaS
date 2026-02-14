 <!--SIDE MENU-->

 <menu id="menu" class="side_menu">
     <a href="javascript:void(0)" class="close"><i class="fa fa-times"></i></a>
     <strong class="fixed_flex logo"><img src="website/img/logo.jpeg" alt="Summit" loading="lazy" /></strong>
     <br />
     <ul>
         <!-- <li><a href="#">Home</a></li>
    <li><a href="#">Basic Parameters</a></li>
    <li><a href="#">Notifications</a></li>
    <li><a href="#">Events</a></li>
    <li><a href="#">Features</a></li>
    <li class="dropdown">
      <a href="javascript:void(0)">Mandatory Disclosure</a>
      <aside>
        <a href="#">Society registration</a>
        <a href="#">NOC</a>
      </aside>
    </li>
    <li><a href="#">About us</a></li>
     -->
         <li><a href="{{route('home')}}">Home</a></li>
         <li><a href="{{route('gallery')}}">Gallery</a></li>
         <li><a href="{{route('branches')}}">Branches</a></li>
         <!--<li><a href="#inquery">Admission</a></li>-->
         <li><a href="{{route('contactus')}}">Contact us</a></li>
         <li><a href="{{route('aboutus')}}">About us</a></li>

         <!-- <li class="fixed_flex">
      <a href="javascript:void(0)" class="btn btn_1 chat_popup"
        >SignUp/LogIn</a
      >
      <a href="#" class="btn btn_2 chat_popup">Admission</a>
    </li>
     -->
         <li class="fixed_flex">
             <a href="{{route('login')}}" class="btn btn_1 chat_popup">LogIn</a>
             {{-- <a href="#" class="btn btn_2 chat_popup">Admission</a> --}}
         </li>
     </ul>
 </menu>
