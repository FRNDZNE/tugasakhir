@extends('layouts.app')
@section('title','Mentor Mitra')
@section('css')
@endsection
@section('page-title','Mentor ' . $data['agent']->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{-- Start Modal Tambah --}}
                        <!-- Modal trigger button -->
                        <button
                            type="button"
                            class="btn btn-primary btn-md"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambah"
                        >
                            Tambah Mentor
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
                                            Tambah Mentor
                                        </h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.mentor.store', $data['agent']->id) }}" method="post" id="storeMentor">
                                            @csrf
                                            <input type="hidden" name="agent" value="{{ $data['agent']->id }}">
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="uuid" class="form-label">Nomor Pegawai</label>
                                                        <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror">
                                                        @error('uuid')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Nama Lengkap</label>
                                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="contact" class="form-label">Kontak</label>
                                                        <input type="number" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror">
                                                        @error('contact')
                                                            <span class="text-danger">{{ $message }}</span>
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
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                                        @error('password')
                                                            <span class="text-danger">{{ $message }}</span>
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
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('storeMentor').submit();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- End Modal --}}
                </div>
                <div class="col text-end">
                    <form action="{{ route('user.mentor.import', Auth::user()->agency->id) }}" method="post" class="d-inline-flex" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="" class="form-control me-2" accept=".xlsx"> <!-- me-2 menambahkan margin kanan -->
                        <button type="submit" class="btn btn-md btn-success">Import</button>
                    </form>
                </div>
            </div>

            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mentor</th>
                        <th>Kontak</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['user'] as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->mentor->name }}</td>
                            <td>{{ $u->mentor->contact }}</td>
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
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Edit Mitra
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.mentor.update', $data['agent']->id) }}" method="post" id="updateMentor-{{ $u->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="uuid" class="form-label">Nomor Induk Pegawai</label>
                                                                    <input type="text" name="uuid" id="uuid" class="form-control @error('uuid') is-invalid @enderror" value="{{ $u->mentor->uuid }}">
                                                                    @error('uuid')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $u->mentor->name }}">
                                                                    @error('name')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="contact" class="form-label">Kontak</label>
                                                                    <input type="number" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ $u->mentor->contact}}">
                                                                    @error('contact')
                                                                        <span class="text-danger">{{ $message }}</span>
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
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password" class="form-label">Password</label>
                                                                    <input type="password" name="password" id="password" class="form-control">
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
                                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('updateMentor-{{ $u->id }}').submit();">Update</button>
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
                                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Hapus Mentor
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus {{ $u->mentor->name }} Dari Mentor ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('user.delete', $u->id) }}" method="post" id="deleteAdmin-{{ $u->id }}">
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
