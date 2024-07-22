@extends('layouts.app')
@section('title','Daftar Mitra')
@section('css')
@endsection
@section('page-title','Daftar Mitra')
@section('content')
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mitra</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Total Kuota</th>
                        <th>Tersedia</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->agency->name }}</td>
                        <td>{{ $d->period->start }}</td>
                        <td>{{ $d->period->end }}</td>
                        <td>{{ $d->total}}</td>
                        <td>
                            {{ $d->total - $d->intern_count }}
                        </td>
                        <td>

                            <!-- Modal trigger button -->
                            <button
                                type="button"
                                class="btn btn-success btn-md"
                                data-bs-toggle="modal"
                                data-bs-target="#modalIntern-{{ $d->id }}"
                                @if(Auth::user()->mahasiswa->process) disabled @endif
                            >
                                <i class="fas fa-envelope"></i>
                            </button>

                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div
                                class="modal fade"
                                id="modalIntern-{{ $d->id }}"
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
                                                Daftar Magang
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            ></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Ingin Mengajukan {{ $d->agency->name }} Sebagai Tempat Magang ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Close
                                            </button>
                                            <form action="{{ route('mahasiswa.magang.apply') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="mitra" value="{{ $d->agency->id }}">
                                                <input type="hidden" name="mahasiswa" value="{{ Auth::user()->mahasiswa->id }}">
                                                <input type="hidden" name="period" value="{{ $d->period->id }}">
                                                <button type="submit" class="btn btn-success">Ajukan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
