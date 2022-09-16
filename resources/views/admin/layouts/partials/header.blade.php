<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="home" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('/img/user1-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li> --}}
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-bell"></i>
                <span class="badge badge-warning navbar-badge badge-sm" class="unread_notification_count">
                    @if (count(Auth::user()->unreadNotifications) > 0)
                        {{count(Auth::user()->unreadNotifications)}}
                    @endif
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                <span class="dropdown-item dropdown-header" ><span class="unread_notification_count">{{count(Auth::user()->unreadNotifications)}}</span> Notifications</span>
                <div class="dropdown-divider"></div>
                @php
                    $yy = 0;
                @endphp
                <p id="notices_list">
                    @forelse (Auth::user()->unreadNotifications as $notice)
                        @if ($yy < 10)
                            <a href="#" class="dropdown-item">
                                <small>
                                    <i class="fa fa-envelope "></i> The <b>{{$notice->data['lab_service_name']}}</b> results <br> for <b>{{$notice->data['patient_name']}}</b> are ready.
                                    {{-- <a class="ml-4" href="#" onclick="clear_notifiactions('{{$notice->id}}')"><i class="fa fa-check "></i>Mark as read</a> --}}
                                </small>
                                <span class="float-right text-muted text-sm">{{(date_diff(date_create(),date_create($notice->data['result_timestamp']))->format('%d days, %h hrs and %i mins ago'))}}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endif
                        @php
                            $yy ++;
                        @endphp
                    @empty
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-envelope mr-2"></i> No new notifications
                            {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
                        </a>
                    @endforelse
                </p>
                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item dropdown-footer" onclick="clear_notifiactions()">Mark all as read</a>
            </div>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fa fa-th-large"></i></a>
        </li> --}}
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->lastname . ' ' . Auth::user()->firstname }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
