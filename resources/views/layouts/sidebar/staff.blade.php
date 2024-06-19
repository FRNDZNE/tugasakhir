@if (Auth::user()->role->name == 'staff')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Staff Prodi</span>
        </a>
    </li>
@endif