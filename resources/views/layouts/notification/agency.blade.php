@if (Auth::user()->role->name == 'agency')
    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i class="fe-bell noti-icon"></i>
        <span class="badge bg-danger rounded-circle noti-icon-badge">{{auth()->user()->unreadNotifications->count()}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-lg">
        <!-- item-->
        <div class="dropdown-item noti-title">
            <h5 class="m-0">
                <span class="float-end">
                    <a href="" class="text-dark">
                        <small>Clear All</small>
                    </a>
                </span>Notification Agency
            </h5>
        </div>

        <div class="noti-scroll" data-simplebar>
            <!-- item-->
            @foreach (auth()->user()->unreadNotifications as $notification)

            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                <div class="notify-icon">
                    <img src="assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                <p class="notify-details">Cristina Pride</p>
                <p class="text-muted mb-0 user-msg">
                    <small>{{ $notification->data['data'] }}</small>
                </p>
            </a>
            @endforeach
            </div>

        <!-- All-->
        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
            View all
            <i class="fe-arrow-right"></i>
        </a>
    </div>
@endif
