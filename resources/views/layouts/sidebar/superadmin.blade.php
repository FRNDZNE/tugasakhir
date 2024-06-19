@if (Auth::user()->role->name == 'superadmin')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Superadmin</span>
        </a>
    </li>
@endif