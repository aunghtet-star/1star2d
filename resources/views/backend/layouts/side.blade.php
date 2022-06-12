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

                <li>
                    <a href="{{route('dashboard.index')}}" class="@yield('dashboard')">
                        <i class="metismenu-icon pe-7s-display2 text-dark"></i>
                        <span class="text-dark font-weight-bold">Dashboard</span>
                    </a>
                </li>

                @can('view_admin')
                <li>
                    <a href="{{route('admin-user.index')}}" class="@yield('admin-users')">
                        <i class="metismenu-icon pe-7s-users text-danger"></i>
                        <span class="text-danger font-weight-bold">Admin Users</span>
                    </a>
                </li>
                @endcan


                @can('master')
                <li>
                    <a href="{{route('master.index')}}" class="@yield('master')">
                        <i class="metismenu-icon pe-7s-users text-primary"></i>
                        <span class="text-primary font-weight-bold">Master</span>
                    </a>
                </li>
                @endcan

                @can('agent')
                <li>
                    <a href="{{route('agent.index')}}" class="@yield('agent')">
                        <i class="metismenu-icon pe-7s-users text-primary"></i>
                        <span class="text-primary font-weight-bold">Agent</span>
                    </a>
                </li>
                @endcan


                @can('user')
                <li>
                    <a href="{{route('users.index')}}" class="@yield('users')">
                        <i class="metismenu-icon pe-7s-users text-primary"></i>
                        <span class="text-primary font-weight-bold">Users</span>
                    </a>
                </li>
                @endcan

{{--                @can('view_role')--}}
{{--                <li>--}}
{{--                    <a href="{{route('roles.index')}}" class="@yield('roles')">--}}
{{--                        <i class="metismenu-icon fas fa-user-tag text-dark"></i>--}}
{{--                        <span class="text-danger font-weight-bold">ရာထူး</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                 @endcan--}}

{{--                @can('view_permission')--}}
{{--                <li>--}}
{{--                    <a href="{{route('permissions.index')}}" class="@yield('permissions')">--}}
{{--                        <i class="metismenu-icon fas fa-user-lock text-dark"></i>--}}
{{--                        <span class="text-danger font-weight-bold">Permission</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                @endcan--}}

                @can('dubai_two')
                    <li>
                        <a href="{{route('dubai-two.index')}}" class="@yield('dubai-2D')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D</span>
                        </a>
                    </li>
                @endcan


                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.11am_overview')}}" class="@yield('dubai-2D-overview-11am')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 11AM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.11am')}}" class="@yield('dubai-kyon-11am')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 11AM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.1pm_overview')}}" class="@yield('dubai-2D-overview-1pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 1PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.1pm')}}" class="@yield('dubai-kyon-1pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 1PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.3pm_overview')}}" class="@yield('dubai-2D-overview-3pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 3PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.3pm')}}" class="@yield('dubai-kyon-3pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 3PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.5pm_overview')}}" class="@yield('dubai-2D-overview-5pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 5PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.5pm')}}" class="@yield('dubai-kyon-5pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 5PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.7pm_overview')}}" class="@yield('dubai-2D-overview-7pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 7PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.7pm')}}" class="@yield('dubai-kyon-7pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 7PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_overview')
                    <li>
                        <a href="{{route('dubai-two-overview.9pm_overview')}}" class="@yield('dubai-2D-overview-9pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">2D Overview 9PM</span>
                        </a>
                    </li>
                @endcan

                @can('dubai_two_kyon')
                    <li>
                        <a href="{{route('dubai-two-kyon.9pm')}}" class="@yield('dubai-kyon-9pm')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-info"></i>
                            <span class="text-info font-weight-bold">Dubai 2D Kyon 9PM</span>
                        </a>
                    </li>
                @endcan

                @can('two')
                    <li>
                        <a href="{{route('two.index')}}" class="@yield('2D')">
                            <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                            <span class="text-success font-weight-bold">2D</span>
                        </a>
                    </li>
                @endcan

                @can('two_overview')
                <li>
                    <a href="{{route('two-overview.am_history')}}" class="@yield('2D-over-history-am')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success font-weight-bold">2D overview AM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('two-overview.pm_history')}}" class="@yield('2D-over-history-pm')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success font-weight-bold">2D overview PM</span>
                    </a>
                </li>
                @endcan

                @can('two_kyon')
                <li>
                    <a href="{{route('two-overview.kyon-am')}}" class="@yield('2D-over-kyon-am')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success font-weight-bold">2D ကျွံ AM</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('two-overview.kyon-pm')}}" class="@yield('2D-over-kyon-pm')">
                        <i class="metismenu-icon fas fa-stopwatch-20 text-success"></i>
                        <span class="text-success font-weight-bold">2D ကျွံ PM</span>
                    </a>
                </li>
                @endcan


                @can('three')
                <li>
                    <a href="{{route('three.index')}}" class="@yield('3D')">
                        <i class="metismenu-icon fa-duotone fa-3">d</i>
                        <span class="text-warning font-weight-bold">3D</span>
                    </a>
                </li>
                @endcan


                @can('three_overview')
                <li>
                    <a href="{{route('three-overview.history')}}" class="@yield('3D-over-history')">
                        <i class="metismenu-icon fa-duotone fa-3 text-dark">d</i>
                        <span class="text-warning font-weight-bold">3D overview</span>
                    </a>
                </li>
                @endcan


                @can('three_kyon')
                <li>
                    <a href="{{route('three-overview.kyon')}}" class="@yield('3D-over-kyon')">
                        <i class="metismenu-icon fa-duotone fa-3 text-dark">d</i>
                        <span class="text-warning font-weight-bold">3D ကျွံ</span>
                    </a>
                </li>
                @endcan

                @can('only_brake')
                <li>
                    <a href="{{route('amountbreaks.index')}}" class="@yield('break_number')">
                        <i class="metismenu-icon fas fa-hand-paper text-dark"></i>
                        <span class="text-danger font-weight-bold">တစ်ကွက်ချင်း Limit ကန့်သတ်ရန်</span>
                    </a>
                </li>
                @endcan

                @can('brake')
                <li>
                    <a href="{{route('allbreakwithamount.index')}}" class="@yield('allbreakwithamount')">
                        <i class="metismenu-icon fas fa-hand-paper text-dark"></i>
                        <span class="text-danger font-weight-bold">ဘရိတ်ပမာဏ</span>
                    </a>
                </li>
                @endcan



                @can('view_wallet')
                <li>
                    <a href="{{route('wallet.index')}}" class="@yield('wallet')">
                        <i class="metismenu-icon fas fa-coins text-dark"></i>
                        <span class="text-danger font-weight-bold">ပိုက်ဆံအိတ်</span>
                    </a>
                </li>
                @endcan

               @can('wallet_history')
               <li>
                <a href="{{route('history.index')}}" class="@yield('history')">
                    <i class="metismenu-icon fas fa-solid fa-clock-rotate-left text-dark"></i>
                    <span class="text-danger font-weight-bold">History</span>
                </a>
                </li>
               @endcan

               @can('bet_history')
               <li>
                <a href="{{route('bet_history.index')}}" class="@yield('bet-history')">
                    <i class="metismenu-icon fas fa-solid fa-clock-rotate-left text-dark"></i>
                    <span class="text-success font-weight-bold">Bet History</span>
                </a>
                </li>
               @endcan


                @can('fake_number')
                <li>
                    <a href="{{route('fake_number.index')}}" class="@yield('fake_number')">
                        <i class="metismenu-icon fas fa-solid fa-shuffle text-dark"></i>
                        <span class="text-primary font-weight-bold">Fake Number</span>
                    </a>
                </li>
                @endcan

                @can('real_number')
                <li>
                    <a href="{{route('real_number')}}" class="@yield('real_number')">
                        <i class="metismenu-icon fas fa-solid fa-circle-check text-dark"></i>
                        <span class="text-primary font-weight-bold">Real Number</span>
                    </a>
                </li>
                @endcan


                <li class="mt-5">
                    <a class="dropdown-item bg-warning text-dark" href="{{ route('admin.logout') }}"
                                onclick="
                                         event.preventDefault();
                                         if(confirm('Are you sure?'))
                                         document.getElementById('logout-form').submit();">

                        <i class="metismenu-icon fas fa-sign-out-alt text-danger"></i>
                        <span class="font-weight-bold">Logout</span>
                    </a>
                </li>


                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function(){


        })
    </script>
@endsection
