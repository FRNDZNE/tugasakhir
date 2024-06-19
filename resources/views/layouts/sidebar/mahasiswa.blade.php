@if (Auth::user()->role->name == 'mahasiswa')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mahasiswa</span>
        </a>
    </li>
@endif