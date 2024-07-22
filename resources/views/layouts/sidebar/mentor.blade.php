@if (Auth::user()->role->name == 'mentor')
    <li>
        <a href="{{ route('mentor.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mentor</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Bimbingan </span>
        </a>
    </li>
@endif
