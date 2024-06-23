@if (Auth::user()->role->name == 'superadmin')
    <li class="menu-title">Menu</li>
    <li>
        <a href="{{ route('superadmin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard </span>
        </a>
    </li>
    <li class="menu-title">Master Pengguna</li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Admin Jurusan</span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Staff Prodi </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mitra Magang </span>
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
            <span> Dosen </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mahasiswa </span>
        </a>
    </li>
    <li class="menu-title">Utilitas</li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Jurusan & Prodi </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Tahun & Periode Magang </span>
        </a>
    </li>
    <li>
        <a href="index.html">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Penilaian </span>
        </a>
    </li>
@endif