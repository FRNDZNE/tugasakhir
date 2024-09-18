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
                </span>Notifikasi
            </h5>
        </div>

        <div class="noti-scroll" data-simplebar>
            <!-- item-->
            @foreach (auth()->user()->unreadNotifications as $notification)

            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                <div class="notify-icon {{ $notification->data['background'] }}">
                    <i class="{{ $notification->data['icon'] }}"></i>
                </div>
                <p class="notify-details">{{ $notification->data['heading'] }}</p>
                <p class="text-muted mb-0 user-msg">
                    <small>{{ $notification->data['message'] }}</small>
                </p>
            </a>
            @endforeach
            </div>

        <!-- All-->
        <a href="{{ route('notification.agency') }}" class="dropdown-item text-center text-primary notify-item notify-all">
            View all
            <i class="fe-arrow-right"></i>
        </a>
    </div>
@endif
