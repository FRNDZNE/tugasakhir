@extends('layouts.app')
@section('title','Penilaian')
@section('css')
@endsection
@section('page-title','Penilaian')
@section('content')
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                <a href="{{ route('agency.profile.mahasiswa', $magang->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @elseif (Auth::user()->role->name == 'dosen')
                <a href="{{ route('dosen.bimbingan.detail', $magang->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @endif
            <hr>
            <table id="datatable" class="table table-borQEdered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penilaian</th>
                        <th>Nilai</th>
                        @if (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                        <th>Opsi</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @foreach ($score as $key => $s)
                        @php
                            $val = $s->value->firstWhere('intern_id', $magang->id);
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $val ? $val->value : 'N/A' }}</td>
                            @if (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                            <td>
                                <!-- Modal trigger button -->
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $s->id }}"
                                >
                                    Masukkan Nilai
                                </button>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div
                                    class="modal fade"
                                    id="modal-{{ $s->id }}"
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
                                                    {{ $s->name }}
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                @if (!$val)
                                                <form action="{{ route('agency.score.store', $magang->id) }}" method="post" id="create-{{ $s->id }}">
                                                @else
                                                <form action="{{ route('agency.score.store', $magang->id) }}" method="post" id="update-{{ $val->id }}">
                                                @endif
                                                    @csrf
                                                    <input type="hidden" name="score_id" value="{{ $s->id }}">
                                                    @if ($val)
                                                        <input type="hidden" name="id" value="{{ $val->id }}">
                                                        <div class="form-group">
                                                            <label for="nilai" class="form-label">Masukan Nilai</label>
                                                            <input type="number" min="0" name="nilai" id="nilai" class="form-control" @error('nilai') is-valid @enderror @if($val) value="{{ $val->value }}" @endif>
                                                            @error('nilai')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <label for="nilai" class="form-label">Masukan Nilai</label>
                                                            <input type="number" min="0" name="nilai" id="nilai" class="form-control" @error('nilai') is-valid @enderror>
                                                            @error('nilai')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif
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
                                                @if (!$val)
                                                <button onclick="document.getElementById('create-{{ $s->id }}').submit();" type="button" class="btn btn-primary">Simpan</button>
                                                @else
                                                <button onclick="document.getElementById('update-{{ $val->id }}').submit();" type="button" class="btn btn-primary">Simpan</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
