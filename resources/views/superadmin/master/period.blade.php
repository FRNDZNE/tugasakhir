@extends('layouts.app')
@section('title', $data['year']->name)
@section('css')
@endsection
@section('page-title','Daftar Periode Magang Tahun Ajaran ' . $data['year']->name)
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Start Modal Tambah --}}
            <!-- Modal trigger button -->
            <a href="{{ route('superadmin.year.index') }}" class="btn btn-secondary btn-md">Kembali</a>
            <button
                type="button"
                class="btn btn-primary btn-md"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah"
            >
                Tambah Periode
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
                                Tambah Periode
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('superadmin.period.store', $data['year']->id) }}" method="post" id="storePeriod">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="prodi" class="form-label">Pilih Prodi</label>
                                            <select name="prodi" id="prodi" class="form-control">
                                                <option value="0">Pilih  Prodi</option>
                                                @foreach ($data['prodi'] as $prodi)
                                                    <option value="{{ $prodi->id }}">{{ $prodi->display_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('prodi')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dateStart" class="form-label">Tanggal Mulai</label>
                                            <input type="date" name="start" id="dateStart" class="form-control @error('start') is-invalid @enderror">
                                            @error('start')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dateEnd" class="form-label @error('end') is-invalid @enderror">Tanggal Selesai</label>
                                            <input type="date" name="end" id="dateEnd" class="form-control">
                                            @error('end')
                                                {{ $message }}
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
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('storePeriod').submit();">Save</button>
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
                        <th>Prodi</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['period'] as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->prodi->display_name }}</td>
                            <td>{{ $p->start }}</td>
                            <td>{{ $p->end }}</td>
                            <td>
                                {{-- Modal Update --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modaledit-{{ $p->id }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modaledit-{{ $p->id }}"
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
                                                        Edit Periode
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('superadmin.period.update', $data['year']->id) }}" method="post" id="updatePeriod-{{ $p->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $p->id }}">
                                                        <div class="row mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="prodi" class="form-label">Pilih Prodi</label>
                                                                    <select name="prodi" id="prodi" class="form-control">
                                                                        <option value="0">Pilih  Prodi</option>
                                                                        @foreach ($data['prodi'] as $prodi)
                                                                            <option value="{{ $prodi->id }}" @if($prodi->id == $p->prodi_id) selected @endif>{{ $prodi->display_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('prodi')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="dateStart" class="form-label">Tanggal Mulai</label>
                                                                    <input type="date" name="start" id="dateStart" class="form-control" value="{{ $p->start }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="dateEnd" class="form-label">Tanggal Selesai</label>
                                                                    <input type="date" name="end" id="dateEnd" class="form-control" value="{{ $p->end }}">
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
                                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('updatePeriod-{{ $p->id }}').submit();">Update</button>
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
                                        data-bs-target="#modalDelete-{{ $p->id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalDelete-{{ $p->id }}"
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
                                                        Hapus Prodi
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    Hapus Periode {{ $p->prodi->display_name }} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('superadmin.period.delete', [$data['year']->id, $p->id]) }}" method="post" id="deleteProdi-{{ $p->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteProdi-{{ $p->id }}').submit();">Hapus</button>
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
