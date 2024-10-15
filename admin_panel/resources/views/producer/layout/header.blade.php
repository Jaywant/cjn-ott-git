<header class="header">
    <div class="title-control">
        <button class="btn side-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <a href="{{route('producer.dashboard')}}" class="side-logo primary-color">
            <h3>{{ App_Name() }}</h3>
        </a>
 
        <h1 class="page-title">@yield('page_title')</h1>
    </div>
    <div class="head-control">

        @if( env('DEMO_MODE') == 'ON')
            <div class="demo-mode-box mr-3">
                <span>{{__('label.demo_mode')}}</span>
            </div>
        @endif

        <!-- Profile -->
        <div class="dropdown dropright">
            <a href="#" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{__('label.profile')}}">
                <i class="fa-solid fa-user fa-2xl primary-color" class="avatar-img"></i>
            </a>

            <div class="dropdown-menu p-2 mt-2" aria-labelledby="dropdownMenuLink">
                <div>
                    <?php $data = Producer_Data(); if($data){echo $data['email'] ?: "";} ?>
                </div><hr class="mt-2">
                <a class="dropdown-item primary-color" href="{{ route('producer.logout') }}">
                    <span><i class="fa-solid fa-arrow-right-from-bracket fa-xl mr-2"></i></span>
                    {{__('label.logout')}}
                </a>
            </div>
        </div>
    </div>
</header>