@extends('layouts.app')
@section('title', $data['prodi']->display_name)
@section('css')
@endsection
@section('page-title','Data Mahasiswa '. $data['prodi']->display_name)
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Start Modal Tambah --}}
            <!-- Modal trigger button -->
            @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'admin')
                <a href="{{ route('user.mahasiswa.menu') }}" class="btn btn-secondary btn-md">Kembali</a>
            @endif

            <button
                type="button"
                class="btn btn-primary btn-md"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah"
            >
                Tambah Mahasiswa
            </button>
            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div
                class="modal fade"
                id="modalTambah"
                tabindex="-1"
                data-bs-backdrop="static"
                data-bs-keyboard="false"

                role="dialog"
                aria-labelledby="modalTitleId"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="modalTitleId">
                                Tambah Mahasiswa
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('user.mahasiswa.store') }}" method="post" id="storeMahasiswa">
                                @csrf
                                <input type="hidden" name="prodi" value="{{ $data['prodi']->id }}">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror">
                                            @error('fullname')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="uuid" class="form-label">NIM</label>
                                            <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror">
                                            @error('uuid')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Tahun Akademik</label>
                                            <select name="year" id="year" class="form-control @error('year') is-invalid @enderror">
                                                <option value="0">Pilih Tahun Akademik</option>
                                                @foreach ($data['year'] as $year)
                                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('year')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="class" class="form-label">Kelas</label>
                                            <input type="text" name="class" id="class" class="form-control @error('class') is-invalid @enderror">
                                            @error('class')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="grade" class="form-label">Semester</label>
                                            <input type="text" name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror">
                                            @error('grade')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact" class="form-label">No Telepon</label>
                                            <input type="number" name="contact" min="0" id="contact" class="form-control @error('contact') is-invalid @enderror">
                                            @error('contact')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('storeMahasiswa').submit();">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Modal --}}

            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Tahun</th>
                        @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'staff')
                        <th>Status</th>
                        <th>Opsi</th>
                        @else
                        <th>Opsi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['user'] as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->mahasiswa->uuid }}</td>
                            <td>{{ $u->mahasiswa->name }}</td>
                            <td>{{ $u->mahasiswa->class }}</td>
                            <td>{{ $u->mahasiswa->grade }}</td>
                            <td>{{ $u->mahasiswa->year->name }}</td>
                            @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'staff')
                            <td>
                                @if ($u->mahasiswa->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Belum Aktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- Modal Update --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modaledit-{{ $u->id }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modaledit-{{ $u->id }}"
                                        tabindex="-1"
                                        data-bs-backdrop="static"
                                        data-bs-keyboard="false"

                                        role="dialog"
                                        aria-labelledby="modalTitleId"
                                        aria-hidden="true"
                                    >
                                        <div
                                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Edit Mahasiswa
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.mahasiswa.update') }}" method="post" id="updateMahasiswa-{{ $u->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ $u->mahasiswa->name }}">
                                                                    @error('fullname')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="uuid" class="form-label">NIM</label>
                                                                    <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror" value="{{ $u->mahasiswa->uuid }}">
                                                                    @error('uuid')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="year" class="form-label">Tahun Ajaran</label>
                                                                    <select name="year" id="year" class="form-control @error('year') is-invalid @enderror">
                                                                        <option value="0">Pilih Tahun Ajaran</option>
                                                                        @foreach ($data['year'] as $year)
                                                                            <option value="{{ $year->id }}" @if($year->id == $u->mahasiswa->year_id) selected @endif>{{ $year->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('year')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="class" class="form-label">Kelas</label>
                                                                    <input type="text" name="class" id="class" class="form-control @error('class') is-invalid @enderror" value="{{ $u->mahasiswa->class }}">
                                                                    @error('class')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="grade" class="form-label">Semester</label>
                                                                    <input type="text" name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror" value="{{ $u->mahasiswa->grade }}">
                                                                    @error('grade')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $u->email }}">
                                                                    @error('email')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password" class="form-label">Password</label>
                                                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                                                    <span class="text-info">Abaikan Jika Tidak Ingin Mengganti Password</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="contact" class="form-label">No Telepon</label>
                                                                    <input type="number" name="contact" min="0" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ $u->mahasiswa->phone }}">
                                                                    @error('contact')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('updateMahasiswa-{{ $u->id }}').submit();">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                {{-- End Modal Update --}}
                                {{-- Modal Delete --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDelete-{{ $u->id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalDelete-{{ $u->id }}"
                                        tabindex="-1"
                                        data-bs-backdrop="static"
                                        data-bs-keyboard="false"

                                        role="dialog"
                                        aria-labelledby="modalTitleId"
                                        aria-hidden="true"
                                    >
                                        <div
                                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Hapus Mahasiswa
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus {{ $u->mahasiswa->name }} Dari Daftar Mahasiswa ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('user.delete', $u->id) }}" method="post" id="deleteMahasiswa-{{ $u->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteMahasiswa-{{ $u->id }}').submit();">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Delete --}}
                                @if ($u->mahasiswa->status)
                                    <a onclick="document.getElementById('disabled-{{ $u->id }}').submit()" class="btn btn-md btn-secondary"><i class="fas fa-user-times"></i></a>
                                @else
                                    <a onclick="document.getElementById('enabled-{{ $u->id }}').submit()" class="btn btn-md btn-info"><i class="fas fa-user-check"></i></a>
                                @endif
                                <form action="{{ route('user.mahasiswa.disabled', $u->id) }}" method="post" id="disabled-{{ $u->id }}">
                                    @csrf
                                </form>
                                <form action="{{ route('user.mahasiswa.enabled', $u->id) }}" method="post" id="enabled-{{ $u->id }}">
                                    @csrf
                                </form>
                            </td>
                            @else
                                @if ($u->mahasiswa->accepted)
                                    <td>Sudah Diterima Magang</td>
                                @else
                                    <td>Belum Daftar Magang</td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
