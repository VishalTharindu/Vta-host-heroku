<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search form -->
            <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                <div class="form-group mb-0">
                    <div class="input-group input-group-alternative input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Search" type="text">
                    </div>
                </div>
                <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </form>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center ml-md-auto">
                <li class="nav-item d-xl-none">
                    <!-- Sidenav toggler -->
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-sm-none">
                    <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                        <i class="ni ni-zoom-split-in"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ni ni-bell-55"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                        <span id="badge" class="badge badge-pill badge-light"
                            style="font-size:8px; background:red; color:white; position: relative; top: 4px; right: 4px;">{{
                            Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                        <!-- Dropdown header -->
                        <div class="px-3 py-3">
                            <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{
                                    Auth::user()->unreadNotifications->count() }}</strong>
                                notifications.</h6>
                        </div>

                        @foreach (Auth::user()->unreadNotifications as $notification)
                        <!-- List group -->
                        <div class="list-group list-group-flush">
                            @if ($notification->type == 'App\Notifications\notificationTo')
                            {{-- Interview Process Notificaton --}}
                            <a @role('mr|oic') href="{{ route('interview.index') }}" @endrole @role('ma')
                                href="{{ route('interview.updateTrainee') }}" @endrole
                                class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <!-- <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1.jpg"
                                        class="avatar rounded-circle"> -->
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">Interview</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                <small>{{ $notification->created_at }}</small>
                                            </div>
                                        </div>
                                        @role('mr|oic')
                                        <p class="text-sm mb-0">Interview for
                                            <strong>{{ $notification->data['batch']['year'] }}/{{
                                                $notification->data['batch']['batch_no'] }}</strong>
                                            is completed. Click to review</p>
                                        @endrole
                                        @role('ma')
                                        <p class="text-sm mb-0">Interview for
                                            <strong>{{ $notification->data['batch']['year'] }}/{{
                                                $notification->data['batch']['batch_no'] }}</strong>
                                            is reviewed and accepted. Click here to fill the data</p>
                                        @endrole
                                    </div>
                                </div>
                            </a>
                            @elseif ($notification->type == 'App\Notifications\DropoutNotification')
                            @php
                            $suspendNotification = explode('-',$notification->data['count']);
                            @endphp
                            @if ($suspendNotification[0] == 'suspended')
                            <a href="{{route('suspended.index')}}" class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">New Suspended Trainees</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                <small>{{$notification->created_at->diffForHumans()}}
                                                </small>
                                                {{-- <small class="ml-2 font-weight-bold text-danger"
                                                    onclick="window.open('{{route('markSingleNotification', $notification)}}','_self')">x</small>
                                                --}}
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">New <span
                                                class="font-weight-bold text-danger">{{$suspendNotification[1]}}</span>
                                            trainees have been suspended.</p>
                                    </div>
                                </div>
                            </a>
                            @else
                            <a href="{{route('dropout.index')}}" class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">New Dropout Warnings</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                <small>{{$notification->created_at->diffForHumans()}}</small>
                                                {{-- <small class="ml-2 font-weight-bold text-danger"
                                                    onclick="window.open('{{route('markSingleNotification', $notification)}}','_self')">x</small>
                                                --}}
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">New <span
                                                class="font-weight-bold text-danger">{{$notification->data['count']}}</span>
                                            trainees have been
                                            found as absentees
                                            for 14 days continuously. Click here to view</p>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endif
                        </div>
                        @endforeach
                        <!-- View all -->
                        <a href="{{route('markNotification')}}"
                            class="dropdown-item text-center text-primary font-weight-bold py-3">Mark All As
                            Read</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ni ni-ungroup"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">
                        <div class="row shortcuts px-4">
                            <a href="{{route('home')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                    <i class="ni ni-building"></i>
                                </span>
                                <small>Home</small>
                            </a>
                            <a href="{{route('calendar.index')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                                    <i class="ni ni-calendar-grid-58"></i>
                                </span>
                                <small>Calendar</small>
                            </a>
                            <a href="{{route('attendance.index')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                                    <i class="ni ni-check-bold"></i>
                                </span>
                                <small>Attendance</small>
                            </a>
                            
                            <a href="{{route('trainee.index')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                                    <i class="ni ni-single-02"></i>
                                </span>
                                <small>Trainees</small>
                            </a>
                            <a href="{{route('trainee.overall.result')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                                    <i class="ni ni-hat-3"></i>
                                </span>
                                <small>Results</small>
                            </a>
                            <a href="{{route('logout')}}" class="col-4 shortcut-item">
                                <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                                    <i class="ni ni-button-power"></i>
                                </span>
                                <small>Logout</small>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4.jpg">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="{{route('profile.edit')}}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>