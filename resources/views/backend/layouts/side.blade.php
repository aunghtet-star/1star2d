<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                @if('view_admin')
                @can('view_admin')
                <li>
                    <a href="{{url('admin')}}" class="@yield('admin-users')">
                        <i class="metismenu-icon pe-7s-users text-danger"></i>
                        <span class="text-danger">Admin Users</span>
                    </a>
                </li>
                @endcan
                @endif
                
                <li>
                    <a href="{{route('users.index')}}" class="@yield('users')">
                        <i class="metismenu-icon pe-7s-users text-primary"></i>
                        <span class="text-primary">Users</span>
                    </a>
                </li>

                @if('view_role')
                @can('view_role')
                <li>
                    <a href="{{route('roles.index')}}" class="@yield('roles')">
                        <i class="metismenu-icon fas fa-user-tag text-dark"></i>
                        <span class="text-danger">ရာထူး</span>
                    </a>
                </li>
                 @endcan
                @endif

                @if('view_permission')
                @can('view_permission')
                <li>
                    <a href="{{route('permissions.index')}}" class="@yield('permissions')">
                        <i class="metismenu-icon fas fa-user-lock text-dark"></i>
                        <span class="text-danger">Permission</span>
                    </a>
                </li>
                @endcan
                @endif

                <li>
                    <a href="{{route('two.index')}}" class="@yield('2D')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success">2D</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{route('two-overview.index')}}" class="@yield('2D-over')">
                        <i class="metismenu-icon pe-7s-note2"></i>
                        2D Overview
                    </a>
                </li> --}}
                <li>
                    <a href="{{route('two-overview.am_history')}}" class="@yield('2D-over-history-am')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-warning"></i>
                        <span class="text-warning">2D overview AM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('two-overview.pm_history')}}" class="@yield('2D-over-history-pm')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success">2D overview PM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('two-overview.kyon-am')}}" class="@yield('2D-over-kyon-am')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-warning"></i>
                        <span class="text-warning">2D ကျွံ AM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('two-overview.kyon-pm')}}" class="@yield('2D-over-kyon-pm')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success">2D ကျွံ PM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('three.index')}}" class="@yield('3D')">
                        <i class="metismenu-icon fa-duotone fa-3">d</i>
                        <span class="text-danger">3D</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('three-overview.history')}}" class="@yield('3D-over-history')">
                        <i class="metismenu-icon fa-duotone fa-3 text-dark">d</i>
                        <span class="text-warning">3D overview</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('three-overview.kyon')}}" class="@yield('3D-over-kyon')">
                        <i class="metismenu-icon fa-duotone fa-3 text-dark">d</i>
                        <span class="text-warning">3D ကျွံ</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{route('amountbreaks.index')}}" class="@yield('break_number')">
                        <i class="metismenu-icon fas fa-hand-paper text-dark"></i>
                        <span class="text-danger">သီးသန့်ဘရိတ်နံပါတ်</span>
                    </a>
                </li> --}}

                <li>
                    <a href="{{route('allbreakwithamount.index')}}" class="@yield('allbreakwithamount')">
                        <i class="metismenu-icon fas fa-hand-paper text-dark"></i>
                        <span class="text-danger">ဘရိတ်ပမာဏ</span>
                    </a>
                </li>


                @if('view_wallet')
                @can('view_wallet')
                <li>
                    <a href="{{route('wallet.index')}}" class="@yield('wallet')">
                        <i class="metismenu-icon fas fa-coins text-dark"></i>
                        <span class="text-danger">ပိုက်ဆံအိတ်</span>
                    </a>
                </li>
                @endcan
                @endif

                @if('view_profile')
                @can('view_profile')
                <li>
                    <a href="{{route('profile')}}" class="@yield('profile')">
                        <i class="metismenu-icon fas fa-user text-dark"></i>
                        <span class="text-primary">Profile</span>
                    </a>
                </li>
                @endcan
                @endif

                <li>
                    <a href="{{route('fake_number.index')}}" class="@yield('fake_number')">
                        <i class="metismenu-icon fas fa-user text-dark"></i>
                        <span class="text-primary">Fake Number</span>
                    </a>
                </li>   

                <li>
                    <a href="{{route('real_number')}}" class="@yield('real_number')">
                        <i class="metismenu-icon fas fa-user text-dark"></i>
                        <span class="text-primary">Real Number</span>
                    </a>
                </li>   

                <li class="mt-5">
                    <a class="dropdown-item bg-warning text-dark" href="{{ route('logout') }}" 
                                onclick="
                                         event.preventDefault();
                                         if(confirm('Are you sure?'))
                                         document.getElementById('logout-form').submit();">
                                         
                        <i class="metismenu-icon fas fa-sign-out-alt text-danger"></i>
                        <span>Logout</span>
                    </a>
                </li>
                    

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</div>