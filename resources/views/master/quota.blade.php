@extends('layouts.app')
@section('title','Kuota Magang')
@section('css')
@endsection
@section('page-title','Kuota Magang Di '. $data['agent']->name)
@section('content')
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role->name == 'superadmin' || Auth::user()->role->name == 'admin')
                <a href="{{ route('user.agency.index') }}" class="btn btn-secondary btn-md">Kembali</a>
            @endif
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Prodi</th>
                        <th>Periode</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Kuota</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['period'] as $q)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $q->prodi->display_name }}</td>
                            <td>{{ $q->year->name }}</td>
                            <td>{{ $q->start }}</td>
                            <td>{{ $q->end }}</td>
                            @forelse ($q->quota as $quota)
                                <td>{{ $quota->total }}</td>
                                <td>
                                    {{-- Modal Update --}}
                                        <!-- Modal trigger button -->
                                        <button
                                            type="button"
                                            class="btn btn-success btn-md"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalquota-{{ $q->id }}"
                                        >
                                            <i class="fas fa-users-cog"></i>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div
                                            class="modal fade"
                                            id="modalquota-{{ $q->id }}"
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
                                                            Kuota Magang
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('quota.store',$data['agent']->id) }}" method="post" id="updateQuota-{{ $quota->id }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $quota->id }}">
                                                            <input type="hidden" name="period" value="{{ $q->id }}">
                                                            <div class="form-group">
                                                                <label for="total" class="form-label">Kuota Magang</label>
                                                                <input type="number" name="total" id="total" class="form-control @error('total') is-invalid @enderror" value="{{ $quota->total }}">
                                                                @error('total')
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
                                                        <button type="button" class="btn btn-success" onclick="document.getElementById('updateQuota-{{ $quota->id }}').submit();">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- End Modal Update --}}
                                </td>
                            @empty
                                <td>0</td>
                                <td>
                                    {{-- Modal Update --}}
                                        <!-- Modal trigger button -->
                                        <button
                                            type="button"
                                            class="btn btn-success btn-md"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalquota-{{ $q->id }}"
                                        >
                                            <i class="fas fa-users-cog"></i>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div
                                            class="modal fade"
                                            id="modalquota-{{ $q->id }}"
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
                                                            Kuota Magang
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('quota.store', $data['agent']->id) }}" method="post" id="storeQuota">
                                                            @csrf
                                                            <input type="hidden" name="period" value="{{ $q->id }}">
                                                            <div class="form-group">
                                                                <label for="total" class="form-label">Kuota Magang</label>
                                                                <input type="number" name="total" id="total" class="form-control @error('total') is-invalid @enderror">
                                                                @error('total')
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
                                                        <button type="button" class="btn btn-success" onclick="document.getElementById('storeQuota').submit();">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- End Modal Update --}}
                                </td>
                            @endforelse
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
