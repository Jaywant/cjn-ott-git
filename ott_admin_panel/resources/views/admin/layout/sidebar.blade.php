<div class="sidebar">
    <div class="side-head">
        <a href="{{route('admin.dashboard')}}" class="primary-color side-logo">
            <h3>{{App_Name()}}</h3>
        </a>
        <button class="btn side-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <ul class="side-menu mt-4">
        <li class="side_line {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}{{ request()->routeIs('profile*') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard')}}">
                <i class="fa-solid fa-house fa-2xl menu-icon"></i>
                <span>{{__('label.dashboard')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.basic_element')}}</span></p>
        <li class="dropdown {{ request()->routeIs('type*') ? 'active' : '' }}{{ request()->routeIs('category*') ? 'active' : '' }}{{ request()->routeIs('avatar*') ? 'active' : '' }}{{ request()->routeIs('language*') ? 'active' : '' }}{{ request()->routeIs('season*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-gear fa-2xl menu-icon"></i>
                <span>{{__('label.basic_items')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('type*') ? 'show' : '' }}{{ request()->routeIs('category*') ? 'show' : '' }}{{ request()->routeIs('avatar*') ? 'show' : '' }}{{ request()->routeIs('language*') ? 'show' : '' }}{{ request()->routeIs('season*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('type*') ? 'active' : '' }}">
                    <a href="{{ route('type.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-t fa-2xl submenu-icon"></i>
                        <span>{{__('label.types')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('category*') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-list fa-2xl submenu-icon"></i>
                        <span>{{__('label.category')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('language*') ? 'active' : '' }}">
                    <a href="{{ route('language.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-globe fa-2xl submenu-icon"></i>
                        <span>{{__('label.language')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('season*') ? 'active' : '' }}">
                    <a href="{{ route('season.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-list-ol fa-2xl submenu-icon"></i>
                        <span>{{__('label.season')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('avatar*') ? 'active' : '' }}">
                    <a href="{{ route('avatar.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-user-plus fa-2xl submenu-icon"></i>
                        <span>{{__('label.avatar')}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="side_line {{ request()->routeIs('producer*') ? 'active' : '' }}">
            <a href="{{ route('producer.index') }}">
                <i class="fa-solid fa-user-shield fa-2xl menu-icon"></i>
                <span>{{__('label.producer')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('user*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}">
                <i class="fa-solid fa-users fa-2xl menu-icon"></i>
                <span>{{__('label.users')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('cast*') ? 'active' : '' }}">
            <a href="{{ route('cast.index') }}">
                <i class="fa-solid fa-user-tie fa-2xl menu-icon"></i>
                <span>{{__('label.cast')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.configuration')}}</span></p>
        <li class="side_line {{ request()->routeIs('banner*') ? 'active' : '' }}">
            <a href="{{ route('banner.index') }}">
                <i class="fa-solid fa-scroll fa-2xl menu-icon"></i>
                <span>{{__('label.banner')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('section*') ? 'active' : '' }}">
            <a href="{{ route('section.index') }}">
                <i class="fa-solid fa-bars-staggered fa-2xl menu-icon"></i>
                <span>{{__('label.section')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.content')}}</span></p>
        <li class="side_line {{ request()->routeIs('video*') ? 'active' : '' }}">
            <a href="{{ route('video.index') }}">
                <i class="fa-solid fa-video fa-2xl menu-icon"></i>
                <span>{{__('label.videos')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('tvshow*') ? 'active' : '' }}">
            <a href="{{ route('tvshow.index') }}">
                <i class="fa-solid fa-tv fa-2xl menu-icon"></i>
                <span>{{__('label.tv_shows')}}</span>
            </a>
        </li>
        <li class="dropdown {{ request()->routeIs('upcomingvideo*') ? 'active' : '' }}{{ request()->routeIs('upcomingtvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-clapperboard fa-2xl menu-icon"></i>
                <span>{{__('label.upcoming')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('upcomingvideo*') ? 'show' : '' }}{{ request()->routeIs('upcomingtvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('upcomingvideo*') ? 'active' : '' }}">
                    <a href="{{ route('upcomingvideo.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('upcomingtvshow*') ? 'active' : '' }}">
                    <a href="{{ route('upcomingtvshow.index')}}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('channel*') ? 'active' : '' }}{{ request()->routeIs('ch_video*') ? 'active' : '' }}{{ request()->routeIs('ch_tvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-film fa-2xl menu-icon"></i>
                <span>{{__('label.channel')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('channel*') ? 'show' : '' }}{{ request()->routeIs('ch_video*') ? 'show' : '' }}{{ request()->routeIs('ch_tvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('channel*') ? 'active' : '' }}">
                    <a href="{{ route('channel.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-tower-broadcast fa-2xl submenu-icon"></i>
                        <span>{{__('label.channel')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('ch_video*') ? 'active' : '' }}">
                    <a href="{{ route('ch_video.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('ch_tvshow*') ? 'active' : '' }}">
                    <a href="{{ route('ch_tvshow.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->routeIs('kidsvideo*') ? 'active' : '' }}{{ request()->routeIs('kidstvshow*') ? 'active' : '' }}">
            <a class="dropdown-toggle" id="dropdownMenuClickable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-children fa-2xl menu-icon"></i>
                <span>{{__('label.kids')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('kidsvideo*') ? 'show' : '' }}{{ request()->routeIs('kidstvshow*') ? 'show' : '' }}" aria-labelledby="dropdownMenuClickable">
                <li class="side_line {{ request()->routeIs('kidsvideo*') ? 'active' : '' }}">
                    <a href="{{ route('kidsvideo.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-video fa-2xl submenu-icon"></i>
                        <span>{{__('label.videos')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('kidstvshow*') ? 'active' : '' }}">
                    <a href="{{ route('kidstvshow.index')}}" class="dropdown-item">
                        <i class="fa-solid fa-tv fa-2xl submenu-icon"></i>
                        <span>{{__('label.tv_shows')}}</span>
                    </a>
                </li>
            </ul>
        </li>

        <p class="partition"><span>{{__('label.interaction')}}</span></p>
        <li class="side_line {{ request()->routeIs('comment*') ? 'active' : '' }}">
            <a href="{{ route('comment.index') }}">
                <i class="fa-solid fa-comments fa-2xl menu-icon"></i>
                <span>{{__('label.comment')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('notification*') ? 'active' : '' }}">
            <a href="{{ route('notification.index') }}">
                <i class="fa-solid fa-bell fa-2xl menu-icon"></i>
                <span>{{__('label.notification')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.financial')}}</span></p>
        <li class="side_line {{ request()->routeIs('coupon*') ? 'active' : '' }}">
            <a href="{{ route('coupon.index') }}">
                <i class="fa-solid fa-ticket fa-2xl menu-icon"></i>
                <span>{{__('label.coupon')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('rentpricelist*') ? 'active' : '' }}">
            <a href="{{ route('rentpricelist.index') }}">
                <i class="fa-solid fa-money-check-dollar fa-2xl menu-icon"></i>
                <span>{{__('label.rent_price_list')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('renttransaction*') ? 'active' : '' }}">
            <a href="{{ route('renttransaction.index') }}">
                <i class="fa-solid fa-wallet fa-2xl menu-icon"></i>
                <span>{{__('label.rent_transaction')}}</span>
            </a>
        </li>
        <li class="dropdown {{ request()->routeIs('package*') ? 'active' : '' }}{{ request()->routeIs('payment*') ? 'active' : '' }}{{ request()->routeIs('transaction*') ? 'active' : '' }}">
            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-money-bill fa-2xl menu-icon"></i>
                <span>{{__('label.subscription')}}</span>
            </a>
            <ul class="dropdown-menu side-submenu {{ request()->routeIs('package*') ? 'show' : '' }}{{ request()->routeIs('payment*') ? 'show' : '' }}{{ request()->routeIs('transaction*') ? 'show' : '' }}">
                <li class="side_line {{ request()->routeIs('package*') ? 'active' : '' }}">
                    <a href="{{ route('package.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-box-archive fa-2xl submenu-icon"></i>
                        <span>{{__('label.package')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('transaction*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-wallet fa-2xl submenu-icon"></i>
                        <span>{{__('label.transactions')}}</span>
                    </a>
                </li>
                <li class="side_line {{ request()->routeIs('payment*') ? 'active' : '' }}">
                    <a href="{{ route('payment.index') }}" class="dropdown-item">
                        <i class="fa-solid fa-money-bill-wave fa-2xl submenu-icon"></i>
                        <span>{{__('label.payment')}}</span>
                    </a>
                </li>
            </ul>
        </li>

        <p class="partition"><span>{{__('label.ads')}}</span></p>
        <li class="side_line {{ request()->routeIs('admob*') ? 'active' : '' }}">
            <a href="{{ route('admob.index') }}">
                <i class="fa-brands fa-square-google-plus fa-2xl menu-icon"></i>
                <span>{{__('label.admob')}}</span>
            </a>
        </li>
        <!-- <li class="side_line {{ request()->routeIs('fbads*') ? 'active' : '' }}">
            <a href="{{ route('fbads.index') }}">
                <i class="fa-brands fa-square-facebook fa-2xl menu-icon"></i>
                <span>{{__('label.FaceBook Ads')}}</span>
            </a>
        </li> -->

        <p class="partition"><span>{{__('label.settings')}}</span></p>
        <li class="side_line {{ request()->routeIs('setting*') ? 'active' : '' }}{{ request()->routeIs('smtp*') ? 'active' : '' }}">
            <a href="{{ route('setting') }}">
                <i class="fa-solid fa-gear fa-2xl menu-icon"></i>
                <span>{{__('label.app_settings')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('panel.setting*') ? 'active' : '' }}">
            <a href="{{ route('panel.setting.index') }}">
                <i class="fa-solid fa-palette fa-2xl menu-icon"></i>
                <span>{{__('label.panel_settings')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('system.setting*') ? 'active' : '' }}">
            <a href="{{ route('system.setting.index') }}">
                <i class="fa-solid fa-screwdriver-wrench fa-2xl menu-icon"></i>
                <span>{{__('label.system_settings')}}</span>
            </a>
        </li>
        <li class="side_line {{ request()->routeIs('page*') ? 'active' : '' }}">
            <a href="{{ route('page.index') }}">
                <i class="fa-solid fa-book-open-reader fa-2xl menu-icon"></i>
                <span>{{__('label.page')}}</span>
            </a>
        </li>

        <p class="partition"><span>{{__('label.logout')}}</span></p>
        <li>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket fa-2xl menu-icon"></i>
                <span>{{__('label.logout')}}</span>
            </a>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>