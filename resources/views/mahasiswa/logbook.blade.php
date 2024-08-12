@extends('layouts.app')
@section('title','Logbook')
@section('css')
@endsection
@section('page-title','Logbook')
@section('content')
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role->name == 'mahasiswa')

            <!-- Modal trigger button -->
            <button
                type="button"
                class="btn btn-primary btn-md"
                data-bs-toggle="modal"
                data-bs-target="#modalCreate"
            >
                Tambah Logbook
            </button>

            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div
                class="modal fade"
                id="modalCreate"
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
                                Tambah Logbook
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('mahasiswa.logbook.store') }}" method="post" id="createLog">
                                @csrf
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Tanggal</label>
                                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror">
                                        @error('date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Kegiatan</label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="desc" class="form-label">Deskripsi Kegiatan</label>
                                        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control"></textarea>
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
                            <button type="button" onclick="document.getElementById('createLog').submit();" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                <a href="{{ route('agency.profile.mahasiswa', $user->id) }}" class="btn btn-secondary md">Kembali</a>
            @elseif (Auth::user()->role->name == 'dosen')
                <a href="{{ route('dosen.bimbingan.detail', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @endif
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Deskripsi Kegiatan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->desc }}</td>
                            <td>
                                @if (Auth::user()->role->name == 'mahasiswa')

                                {{-- Modal Edit --}}
                                <!-- Modal trigger button -->
                                <button
                                    type="button"
                                    class="btn btn-warning btn-md"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit-{{ $d->id }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div
                                    class="modal fade"
                                    id="modalEdit-{{ $d->id }}"
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
                                                    Edit Logbook
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('mahasiswa.logbook.store') }}" method="post" id="updateLog-{{ $d->id }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $d->id }}">
                                                    <div class="mb-2">
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">Tanggal</label>
                                                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ $d->date }}">
                                                            @error('date')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="form-group">
                                                            <label for="title" class="form-label">Kegiatan</label>
                                                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $d->title }}">
                                                            @error('title')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="form-group">
                                                            <label for="desc" class="form-label">Deskripsi Kegiatan</label>
                                                            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control">{{ $d->desc }}</textarea>
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
                                                <button type="button" class="btn btn-warning" onclick="document.getElementById('updateLog-{{ $d->id }}').submit();">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Edit --}}
                                {{-- Modal Delete --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modaldelete-{{ $d->id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modaldelete-{{ $d->id }}"
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
                                                        Hapus Logbook
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Hapus Logbook Pada Tanggal {{ $d->date }} ? Jika Menghapus Logbook Maka Akan Menghapus Dokumentasi Nya Juga Demikian !</p>
                                                    <form action="{{ route('mahasiswa.logbook.delete', $d->id) }}" method="post" id="deleteLog-{{ $d->id }}">
                                                        @csrf
                                                        @method('DELETE')
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
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteLog-{{ $d->id }}').submit();">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Delete --}}
                                <a href="{{ route('logbook.image.index', $d->id) }}" class="btn btn-md btn-info"><i class="fas fa-file-image"></i></a>
                                @elseif (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                                <a href="{{ route('agency.logimage.mahasiswa',[$user->id, $d->id]) }}" class="btn btn-md btn-info"><i class="fas fa-file-image"></i></a>
                                @elseif (Auth::user()->role->name == 'dosen')
                                <a href="{{ route('dosen.bimbingan.logimage',[$user->id, $d->id]) }}" class="btn btn-md btn-info"><i class="fas fa-file-image"></i></a>
                                @endif
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
