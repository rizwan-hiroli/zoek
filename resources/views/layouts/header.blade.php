<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        
                        @if(isset(auth()->user()->profile_image))
                            <img src="/uploads/User/{{auth()->user()->profile_image}}" alt="">
                        @else
                            <img src="{{asset('admin/images/img.jpg')}}" alt="">
                        @endif
                        {!! \Illuminate\Support\Str::words(auth()->user()->name, 2,'')  !!} 
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a class="dropdown-item" href="{{ url('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out pull-right"></i>            {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>