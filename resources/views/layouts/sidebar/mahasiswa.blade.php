@if (Auth::user()->role->name == 'mahasiswa')
    <li>
        <a href="{{ route('mahasiswa.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mahasiswa</span>
        </a>
    </li>
    <li>
        <a href="{{ route('mahasiswa.magang.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Daftar Mitra </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Magang Saya </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Logbook </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Asistensi </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Laporan Akhir </span>
        </a>
    </li>
@endif
