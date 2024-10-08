@if (Auth::user()->role->name == 'superadmin')
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
                </span>Notification Superadmin
            </h5>
        </div>

        <div class="noti-scroll" data-simplebar>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                <div class="notify-icon">
                    <img src="assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                <p class="notify-details">Cristina Pride</p>
                <p class="text-muted mb-0 user-msg">
                    <small>Hi, How are you? What about our next meeting</small>
                </p>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <div class="notify-icon bg-primary">
                    <i class="mdi mdi-comment-account-outline"></i>
                </div>
                <p class="notify-details">Caleb Flakelar commented on Admin
                    <small class="text-muted">1 min ago</small>
                </p>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <div class="notify-icon">
                    <img src="assets/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                <p class="notify-details">Karen Robinson</p>
                <p class="text-muted mb-0 user-msg">
                    <small>Wow ! this admin looks good and awesome design</small>
                </p>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <div class="notify-icon bg-warning">
                    <i class="mdi mdi-account-plus"></i>
                </div>
                <p class="notify-details">New user registered.
                    <small class="text-muted">5 hours ago</small>
                </p>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <div class="notify-icon bg-info">
                    <i class="mdi mdi-comment-account-outline"></i>
                </div>
                <p class="notify-details">Caleb Flakelar commented on Admin
                    <small class="text-muted">4 days ago</small>
                </p>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <div class="notify-icon bg-secondary">
                    <i class="mdi mdi-heart"></i>
                </div>
                <p class="notify-details">Carlos Crouch liked
                    <b>Admin</b>
                    <small class="text-muted">13 days ago</small>
                </p>
            </a>
        </div>

        <!-- All-->
        <a href="{{ route('notification.superadmin') }}" class="dropdown-item text-center text-primary notify-item notify-all">
            View all
            <i class="fe-arrow-right"></i>
        </a>
    </div>
@endif
