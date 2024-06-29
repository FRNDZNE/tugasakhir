@extends('layouts.app')
@section('title','Admin Jurusan')
@section('css')
@endsection
@section('page-title','Admin Jurusan')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Start Modal Tambah --}}
            <!-- Modal trigger button -->
            <button
                type="button"
                class="btn btn-primary btn-md"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah"
            >
                Tambah Admin
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
                                Tambah Admin
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('superadmin.user.admin.store') }}" method="post" id="storeAdmin">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jurusan" class="form-label">Jurusan</label>
                                            <select name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
                                                <option value="0">Pilih Jurusan</option>
                                                @foreach ($data['jurusan'] as $j)
                                                    <option value="{{ $j->id }}">{{ $j->display_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('jurusan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="uuid" class="form-label">NIP/NUPTK</label>
                                            <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror">
                                            @error('uuid')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fullname" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror">
                                            @error('fullname')
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
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('storeAdmin').submit();">Save</button>
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
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['user'] as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->admin->name }}</td>
                            <td>{{ $u->admin->jurusan->display_name }}</td>
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
                                                        Edit Jurusan
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('superadmin.user.admin.update') }}" method="post" id="updateAdmin-{{ $u->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="jurusan" class="form-label">Jurusan</label>
                                                                    <select name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
                                                                        <option value="0">Pilih Jurusan</option>
                                                                        @foreach ($data['jurusan'] as $j)
                                                                            <option value="{{ $j->id }}" @if($j->id == $u->admin->jurusan_id) selected @endif>{{ $j->display_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('jurusan')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="uuid" class="form-label">NIP/NUPTK</label>
                                                                    <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror" value="{{ $u->admin->uuid }}">
                                                                    @error('uuid')
                                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ $u->admin->name }}">
                                                                    @error('fullname')
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
                                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('updateAdmin-{{ $u->id }}').submit();">Update</button>
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
                                                        Hapus Admin
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus {{ $u->admin->name }} Dari Admin Jurusan {{ $u->admin->jurusan->display_name }} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('superadmin.user.admin.delete', $u->id) }}" method="post" id="deleteAdmin-{{ $u->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteAdmin-{{ $u->id }}').submit();">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Delete --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
