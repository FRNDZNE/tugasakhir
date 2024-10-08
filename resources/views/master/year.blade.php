@extends('layouts.app')
@section('title','Tahun Akademik')
@section('css')
@endsection
@section('page-title','Tahun Akademik')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Start Modal Tambah --}}
            @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'admin')
            <!-- Modal trigger button -->
                <button
                    type="button"
                    class="btn btn-primary btn-md"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah"
                >
                    Tambah
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
                        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                        role="document"
                    >
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title" id="modalTitleId">
                                    Tambah Tahun Ajaran
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('year.store') }}" method="post" id="storeYear">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="form-label">Tahun Ajaran</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
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
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('storeYear').submit();">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- End Modal --}}
            @endif

            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($year as $y)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $y->name }}</td>
                            <td>
                                @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'admin')
                                {{-- Modal Update --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modaledit-{{ $y->id }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modaledit-{{ $y->id }}"
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
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Edit Tahun Ajaran
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('year.store') }}" method="post" id="updateYear-{{ $y->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $y->id }}">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label">Tahun Ajaran</label>
                                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $y->name }}">
                                                            @error('name')
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
                                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('updateYear-{{ $y->id }}').submit();">Update</button>
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
                                        data-bs-target="#modalDelete-{{ $y->id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalDelete-{{ $y->id }}"
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
                                                        Hapus Tahun Ajaran
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus Tahun Ajaran {{ $y->name }} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('year.delete', $y->id) }}" method="post" id="deleteYear-{{ $y->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteYear-{{ $y->id }}').submit();">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Delete --}}
                                @endif
                                <a href="{{ route('period.index', $y->id) }}" class="btn btn-primary btn-md">Pilih</a>
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
