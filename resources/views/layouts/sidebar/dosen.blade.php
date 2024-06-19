@if (Auth::user()->role->name == 'dosen')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mitra</span>
        </a>
    </li>
@endif