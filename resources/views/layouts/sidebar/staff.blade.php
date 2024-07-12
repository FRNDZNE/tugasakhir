@if (Auth::user()->role->name == 'staff')
    <li>
        <a href="{{ route('staff.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Staff Prodi</span>
        </a>
    </li>
    <li class="menu-title">Utilitas</li>
    <li>
        <a href="{{ route('year.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Tahun & Periode Magang </span>
        </a>
    </li>
@endif
