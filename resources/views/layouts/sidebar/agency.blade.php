@if (Auth::user()->role->name == 'agency')
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mitra </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mentor </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Seleksi </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Magang </span>
        </a>
    </li>
@endif
