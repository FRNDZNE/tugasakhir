@if (Auth::user()->role->name == 'staff')
    <li>
        <a href="{{ route('staff.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Staff Prodi</span>
        </a>
    </li>
    <li class="menu-title">Master Pengguna</li>
    <li>
        <a href="{{ route('user.mahasiswa.index', Auth::user()->staff->prodi->id) }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mahasiswa </span>
        </a>
    </li>
    <li class="menu-title">Utilitas</li>
    <li>
        <a href="{{ route('year.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Tahun & Periode Magang </span>
        </a>
    </li>
    <li>
        <a href="{{ route('score.index', Auth::user()->staff->prodi->id) }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Penilaian </span>
        </a>
    </li>
@endif
