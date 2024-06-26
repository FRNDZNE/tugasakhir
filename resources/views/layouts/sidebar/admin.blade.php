@if (Auth::user()->role->name == 'admin')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Admin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Admin </span>
        </a>
    </li>
@endif
