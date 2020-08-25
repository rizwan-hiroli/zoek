<!-- menu profile quick info -->
<div class="profile clearfix">
  <a href="/admin/profile">
    <div class="profile_pic">
        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        
        <h2>{!! \Illuminate\Support\Str::words(auth()->user()->name, 2,'')  !!}</h2>
    </div>
  </a>
</div>
<!-- /menu profile quick info -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
        <li>
          <a href="{{url('admin/company')}}"><i class="fa fa-building"></i> Companies </a>
        </li>
        <li>
          <a href="{{url('admin/employee')}}"><i class="fa fa-users"></i>  Employee</a>
        </li>
  </ul>
</div>
</div>