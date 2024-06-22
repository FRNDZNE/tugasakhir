@if (Auth::user()->role->name == 'superadmin')
    <li>
        <a href="{{ route('superadmin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-user-check"></i>
            <span> Pengguna </span>
        </a>
    </li>
@endif