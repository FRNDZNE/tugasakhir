@if (Auth::user()->role->name == 'agency')
    <li>
        <a href="{{ route('agency.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mitra </span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.mentor.index', Auth::user()->agency->id) }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mentor </span>
        </a>
    </li>
    <li>
        <a href="{{ route('agency.select.year') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Seleksi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('quota.index', Auth::user()->agency->id) }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Kuota Magang </span>
        </a>
    </li>
@endif
