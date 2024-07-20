@extends('layouts.app')
@section('title','Logbook')
@section('css')
@endsection
@section('page-title','Logbook')
@section('content')
    <div class="card">
        <div class="card-body">
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
                            <form action="{{ route('mahasiswa.logbook.store') }}" method="post" id="createLog" enctype="multipart/form-data">
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

            <!-- Optional: Place to the bottom of scripts -->
            <script>
                const myModal = new bootstrap.Modal(
                    document.getElementById("modalId"),
                    options,
                );
            </script>

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

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
