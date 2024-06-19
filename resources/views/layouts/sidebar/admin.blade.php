@if (Auth::user()->role->name == 'admin')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Admin</span>
        </a>
    </li>
@endif