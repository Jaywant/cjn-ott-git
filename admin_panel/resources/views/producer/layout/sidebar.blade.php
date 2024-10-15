<div class="sidebar">
    <div class="side-head">
        <a href="{{route('producer.dashboard')}}" class="primary-color side-logo">
            <h3>{{App_Name()}}</h3>
        </a>
        <button class="btn side-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
 
    <ul class="side-menu mt-4">
        <li class="side_line {{ request()->routeIs('producer.dashboard') ? 'active' : '' }}">
            <a href="{{ route('producer.dashboard')}}">
                <i class="fa-solid fa-house fa-2xl menu-icon"></i>
                <span>{{__('label.dashboard')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.profile')}}</span></p>
        <li class="side_line {{ request()->routeIs('pprofile*') ? 'active' : '' }}">
            <a href="{{ route('pprofile.index')}}">
                <i class="fa-solid fa-user fa-2xl menu-icon"></i>
                <span>{{__('label.profile')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('pchangepassword*') ? 'active' : '' }}">
            <a href="{{ route('pchangepassword.index')}}">
                <i class="fa-solid fa-lock fa-2xl menu-icon"></i>
                <span>{{__('label.change_password')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.content')}}</span></p>
        <li class="side_line {{ request()->routeIs('pvideo*') ? 'active' : '' }}">
            <a href="{{ route('pvideo.index') }}">
                <i class="fa-solid fa-video fa-2xl menu-icon"></i>
                <span>{{__('label.videos')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('ptvshow*') ? 'active' : '' }}">
            <a href="{{ route('ptvshow.index') }}">
                <i class="fa-solid fa-tv fa-2xl menu-icon"></i>
                <span>{{__('label.tv_shows')}}</span>
            </a>
        </li>
        <li class="dropdown {{ request()->routeIs('pupcomingvideo*') ? 'active' : '' }}{{ request()->routeIs('pupcomingtvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-clapperboard fa-2xl menu-icon"></i>
                <span>{{__('label.upcoming')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('pupcomingvideo*') ? 'show' : '' }}{{ request()->routeIs('pupcomingtvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('pupcomingvideo*') ? 'active' : '' }}">
                    <a href="{{ route('pupcomingvideo.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('pupcomingtvshow*') ? 'active' : '' }}">
                    <a href="{{ route('pupcomingtvshow.index')}}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('pchannel*') ? 'active' : '' }}{{ request()->routeIs('pch_video*') ? 'active' : '' }}{{ request()->routeIs('pch_tvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-film fa-2xl menu-icon"></i>
                <span>{{__('label.channel')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('pchannel*') ? 'show' : '' }}{{ request()->routeIs('pch_video*') ? 'show' : '' }}{{ request()->routeIs('pch_tvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('pchannel*') ? 'active' : '' }}">
                    <a href="{{ route('pchannel.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-tower-broadcast fa-2xl submenu-icon"></i>
                        <span>{{__('label.channel')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('pch_video*') ? 'active' : '' }}">
                    <a href="{{ route('pch_video.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('pch_tvshow*') ? 'active' : '' }}">
                    <a href="{{ route('pch_tvshow.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('pkidsvideo*') ? 'active' : '' }}{{ request()->routeIs('pkidstvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-children fa-2xl menu-icon"></i>
                <span>{{__('label.kids')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('pkidsvideo*') ? 'show' : '' }}{{ request()->routeIs('pkidstvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('pkidsvideo*') ? 'active' : '' }}">
                    <a href="{{ route('pkidsvideo.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('pkidstvshow*') ? 'active' : '' }}">
                    <a href="{{ route('pkidstvshow.index')}}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>

        <p class="partition"><span>{{__('label.logout')}}</span></p>
        <li>
            <a href="{{ route('producer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket fa-2xl menu-icon"></i>
                <span>{{__('label.logout')}}</span>
            </a>

            <form id="logout-form" action="{{ route('producer.logout') }}" method="GET" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>