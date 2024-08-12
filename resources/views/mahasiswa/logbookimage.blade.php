@extends('layouts.app')
@section('title','Input Gambar Logbook')
@section('css')
@endsection
@section('page-title','Input Gambar Logbook')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('mahasiswa.logbook.index') }}" class="btn btn-secondary btn-md">Kembali</a>
            <!-- Modal trigger button -->
            <button
                type="button"
                class="btn btn-primary btn-md"
                data-bs-toggle="modal"
                data-bs-target="#modalCreate"
            >
                Tambah Gambar
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
                                Tambah Gambar
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('logbook.image.store', $log->id) }}" method="post" id="createImage" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="gambar" class="form-label">Masukan Foto</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    @error('gambar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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
                            <button type="button" onclick="document.getElementById('createImage').submit();" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gambar as $g)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img width="300px" height="auto" src="{{ asset($g->path) }}" alt="gambar rusak"></td>
                            <td>
                                {{-- Modal Edit --}}
                                <!-- Modal trigger button -->
                                <button
                                    type="button"
                                    class="btn btn-warning btn-md"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit-{{ $g->id }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div
                                    class="modal fade"
                                    id="modalEdit-{{ $g->id }}"
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
                                                <form action="{{ route('logbook.image.update', $log->id) }}" method="post" id="updateImage-{{ $g->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $g->id }}">
                                                    <div class="form-group">
                                                        <label for="gambar" class="form-label">Masukan Foto</label>
                                                        <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                                        @error('gambar')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
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
                                                <button type="button" class="btn btn-warning" onclick="document.getElementById('updateImage-{{ $g->id }}').submit();">Update</button>
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
                                        data-bs-target="#modaldelete-{{ $g->id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modaldelete-{{ $g->id }}"
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
                                                        Hapus Gambar
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus Gambar ?
                                                    <form action="{{ route('logbook.image.delete', [$log->id, $g->id]) }}" method="post" id="deleteLog-{{ $g->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        {{-- <input type="hidden" name="id" value="{{ $g->id }}"> --}}
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
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteLog-{{ $g->id }}').submit();">Hapus</button>
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
