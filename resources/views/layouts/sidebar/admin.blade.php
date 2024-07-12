@if (Auth::user()->role->name == 'admin')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard Admin</span>
        </a>
    </li>
    <li class="menu-title">Master Pengguna</li>
    <li>
        <a href="{{ route('user.staff.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Staf Prodi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.agency.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mitra Magang </span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.dosen.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dosen </span>
        </a>
    </li>
    <li>
        <a href="{{ route('user.dosen.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Mahasiswa </span>
        </a>
    </li>

    <li class="menu-title">Utilitas</li>
    @php
        $jurusan = Auth::user()->admin->jurusan->id;
        $prodis = Auth::user()->admin->jurusan->prodi;
    @endphp
    <li>
        <a href="{{ route('prodi.index', $jurusan) }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Program Studi </span>
        </a>
    </li>
    <li>
        <a href="{{ route('year.index') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Tahun & Periode Magang </span>
        </a>
    </li>
    <li>
        <a href="#prodi" data-bs-toggle="collapse">
            <i class="mdi mdi-account-multiple-plus-outline"></i>
            <span> Penilaian </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="prodi">
            <ul class="nav-second-level">
                @foreach ($prodis as $prodi)
                <li>
                    <a href="#">{{ $prodi->display_name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </li>

@endif
