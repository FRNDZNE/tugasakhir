@if (Auth::user()->role->name == 'mahasiswa')
    <li>
        <a href="{{ route('mahasiswa.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Mahasiswa</span>
        </a>
    </li>
    @if (!Auth::user()->mahasiswa->accepted)
    <li>
        <a href="{{ route('mahasiswa.magang.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Daftar Mitra </span>
        </a>
    </li>
    @endif
    <li>
        <a href="{{ route('mahasiswa.magang.detail') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Magang Saya </span>
        </a>
    </li>
    @if (Auth::user()->mahasiswa->accepted ?? false )
        <li>
            <a href="{{ route('mahasiswa.logbook.index') }}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span> Logbook (Nanti lok masih panik) </span>
            </a>
        </li>
        <li>
            <a href="{{ route('mahasiswa.asistensi.index') }}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span> Asistensi </span>
            </a>
        </li>
        <li>
            <a href="{{ route('mahasiswa.report.index') }}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span> Laporan Akhir </span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span> Nilai Akhir </span>
            </a>
        </li>
    @endif
@endif
