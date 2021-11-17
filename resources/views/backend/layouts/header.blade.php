<div class="app-header header-shadow">
    <div class="app-header__logo">
        <h4>1Star2DMM</h4>
        <div class="header__pane ml-auto">
            <div>

            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
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
    <form action="{{url('admin/two/showhide')}}" method="POST">
        @csrf
        @if($twoform->status == 'hide')
        <button class="btn btn-danger btn-sm mr-3" type="submit">2D</button>
        @else
        <button class="btn btn-success btn-sm mr-3" type="submit">2D</button>
        @endif
    </form>

    <form action="{{url('admin/htaitpait/showhide')}}" method="POST">
        @csrf
        @if($htaitpaitform->status == 'hide')
        <button class="btn btn-danger btn-sm mr-3" type="submit" style="font-weight: 700">မြန်ထိုး</button>
        @else
        <button class="btn btn-success btn-sm mr-3" type="submit" style="font-weight: 700">မြန်ထိုး</button>
        @endif
    </form>

    <form action="{{url('admin/three/showhide')}}" method="POST">
        @csrf
        @if($threeform->status == 'hide')
        <button class="btn btn-danger btn-sm mr-3" type="submit">3D</button>
        @else
        <button class="btn btn-success btn-sm mr-3" type="submit">3D</button>
        @endif
    </form>

    <div class="app-header__content">

        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    @if(Auth::guard('adminuser')->check())
                                    <img width="42" class="rounded-circle"
                                        src="https://eu.ui-avatars.com/api/?name={{auth()->guard('adminuser')->user()->name}}"
                                        alt="">
                                    @endif
                                    </a>

                                {{-- <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">

                                    <a href="" tabindex="0"
                                        onclick="event.preventDefault(); document.getElementById('logout-btn').submit()"
                                        class="dropdown-item">Logout</a>

                                    <form action="{{url('logout')}}" method="POST" id="logout-btn"
                                        style="display: none">
                                        @csrf
                                    </form>
                                </div> --}}
                            </div>
                            
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                @if(Auth::guard('adminuser')->check())
                                {{auth()->guard('adminuser')->user()->name}}
                                @endif
                            </div>
                            {{-- <div class="widget-subheading">
                                VP People Manager
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>