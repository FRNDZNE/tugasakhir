@if (Auth::user()->role->name == 'mentor')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mentor</span>
        </a>
    </li>
@endif