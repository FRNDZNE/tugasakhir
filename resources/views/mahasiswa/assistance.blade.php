@extends('layouts.app')
@section('title','Asistensi')
@section('css')
@endsection
@section('page-title','Asistensi')
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
                Tambah Asistensi
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
                                Tambah Asistensi
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('mahasiswa.asistensi.store') }}" method="post" id="create">
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
                                        <label for="topic" class="form-label">Topic Bimbingan</label>
                                        <textarea name="topic" id="topic" cols="30" rows="10" class="form-control @error('topic') is-invalid @enderror"></textarea>
                                        @error('topic')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
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
                            <button type="button" onclick="document.getElementById('create').submit();" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Topic Bimbingan</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->topic }}</td>
                            <td>
                                @if ($d->status)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Belum Terverifikasi</span>
                                @endif
                            </td>
                            <td>
                                @if (Auth::user()->role->name == 'mahasiswa')
                                {{-- Modal Edit --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit-{{ $d->id }}"
                                        @if ($d->status)
                                        disabled
                                        @endif
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
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Edit Asistensi
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('mahasiswa.asistensi.store') }}" method="post" id="update-{{ $d->id }}">
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
                                                                <label for="topic" class="form-label">Topic Bimbingan</label>
                                                                <textarea name="topic" id="topic" cols="30" rows="10" class="form-control @error('topic') is-invalid @enderror">{{ $d->topic }}</textarea>
                                                                @error('topic')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                @enderror
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
                                                    <button onclick="document.getElementById('update-{{ $d->id }}').submit();" type="submit" class="btn btn-warning">Update</button>
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
                                        data-bs-target="#modalDelete-{{ $d->id }}"
                                        @if ($d->status)
                                        disabled
                                        @endif
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalDelete-{{ $d->id }}"
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
                                                        Hapus Asistensi
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Ingin menghapus asistensi dengan topik bimbingan {{ $d->topic }} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('mahasiswa.asistensi.delete', $d->id) }}" method="post" id="delete-{{ $d->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button onclick="document.getElementById('delete-{{ $d->id }}').submit();" type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- End Modal Delete --}}
                                @if (Auth::user()->role->name == 'dosen')
                                    @if ($d->status)
                                    <button onclick="document.getElementById('unconfirmed-{{ $d->id }}').submit();" type="submit" class="btn btn-md btn-dark"><i class="fas fa-times"></i></button>
                                        <form action="{{ route('mahasiswa.asistensi.unconfirmed') }}" method="post" id="unconfirmed-{{ $d->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $d->id }}">
                                        </form>
                                    @else
                                    <button onclick="document.getElementById('confirmed-{{ $d->id }}').submit();" type="submit" class="btn btn-md btn-success"><i class="fas fa-check"></i></button>
                                        <form action="{{ route('mahasiswa.asistensi.confirmed') }}" method="post" id="confirmed-{{ $d->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $d->id }}">
                                        </form>
                                    @endif
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
