@if (Auth::user()->role->name == 'dosen')
    <li>
        <a href="{{ route('dosen.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Dosen</span>
        </a>
    </li>
    <li>
        <a href="{{ route('dosen.bimbingan.year') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mahasiswa Bimbingan </span>
        </a>
    </li>
@endif
