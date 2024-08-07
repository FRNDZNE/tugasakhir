@extends('layouts.app')
@section('title', 'Magang')
@section('css')
@endsection
@section('page-title', 'Magang')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('agency.select.period', $tahun->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intern as $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->mahasiswa->uuid }}</td>
                            <td>{{ $i->mahasiswa->name }}</td>
                            <td>
                                @switch($i->status)
                                    @case('c')
                                        <span class="badge bg-info">Dikonfirmasi</span>
                                        @break
                                    @case('p')
                                        <span class="badge bg-warning">Proses</span>
                                        @break
                                    @case('a')
                                        <span class="badge bg-success">Diterima</span>
                                        @break
                                    @case('d')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('agency.profile.mahasiswa', $i->id) }}" class="btn btn-sm btn-info">Detail</a>
                                @if (Auth::user()->role->name == 'agency')
                                    @if ($i->status == 'c')
                                        <button type="button" onclick="document.getElementById('proses-{{ $i->id }}').submit();" class="btn btn-sm btn-warning">Proses</button>
                                    @elseif ($i->status == 'p')
                                        <button type="button" onclick="document.getElementById('terima-{{ $i->id }}').submit();" class="btn btn-sm btn-success">Terima</button>
                                        <button type="button" onclick="document.getElementById('tolak-{{ $i->id }}').submit();" class="btn btn-sm btn-danger">Tolak</button>

                                    @elseif ($i->status == 'd')
                                        <button type="button" onclick="document.getElementById('restore-{{ $i->id }}').submit();" class="btn btn-sm btn-dark">Restore</button>
                                    @elseif ($i->status == 'a')
                                        <!-- Modal trigger button -->

                                        <button type="button" onclick="document.getElementById('proses-{{ $i->id }}').submit();" class="btn btn-sm btn-warning">Proses</button>
                                        <button
                                            type="button"
                                            class="btn btn-pink btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalMentor-{{ $i->id }}"
                                        >
                                            Pilih Mentor
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div
                                            class="modal fade"
                                            id="modalMentor-{{ $i->id }}"
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
                                                    <div class="modal-header bg-pink">
                                                        <h5 class="modal-title" id="modalTitleId">
                                                            Pilih Mentor Magang
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('agency.mentor', [$tahun->id, $periode->id]) }}" method="post" id="pilihmentor-{{ $i->id }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $i->id }}">
                                                            <div class="form-group">
                                                                <label for="mentor" class="form-label">Pilih Mentor</label>
                                                                <select name="mentor" id="mentor" class="form-control">
                                                                    <option value="0">Pilih Mentor</option>
                                                                    @foreach ($mentor as $m)
                                                                        <option value="{{ $m->id }}" @if($i->mentor_id == $m->id) selected @endif>{{ $m->name }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                        <button type="button" class="btn btn-pink" onclick="document.getElementById('pilihmentor-{{ $i->id }}').submit();">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                <form action="{{ route('agency.proses', [$tahun->id, $periode->id]) }}" id="proses-{{ $i->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                </form>
                                <form action="{{ route('agency.restore', [$tahun->id, $periode->id]) }}" id="restore-{{ $i->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                </form>
                                <form action="{{ route('agency.terima', [$tahun->id, $periode->id]) }}" id="terima-{{ $i->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                </form>
                                <form action="{{ route('agency.tolak', [$tahun->id, $periode->id]) }}" id="tolak-{{ $i->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                </form>
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
