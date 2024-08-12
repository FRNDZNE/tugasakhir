@extends('layouts.app')
@section('title','Absensi')
@section('css')
@endsection
@section('page-title','Absensi')
@section('content')
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                <a href="{{ route('agency.profile.mahasiswa', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @elseif (Auth::user()->role->name == 'dosen')
                <a href="{{ route('dosen.bimbingan.detail', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @endif
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                        <th>Alasan</th>
                        <th>Validasi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tanggal as $key => $date)
                        @php
                            $kehadiran = $absen->firstWhere('date', $date);
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $date }}</td>
                            {{-- kolom status kehadiran --}}
                            <td>
                                @if ($kehadiran)
                                    @switch($kehadiran->status)
                                        @case('s')
                                            <span class="badge bg-warning">Sakit</span>
                                            @break
                                        @case('i')
                                            <span class="badge bg-info">Izin</span>
                                            @break
                                        @case('a')
                                            <span class="badge bg-dark">Tanpa Keterangan</span>
                                            @break
                                        @case('l')
                                            <span class="badge bg-danger">Libur</span>
                                            @break
                                        @case('h')
                                            <span class="badge bg-success">Hadir</span>
                                            @break
                                        @default

                                    @endswitch
                                @else
                                    <span class="badge bg-secondary">Belum Absensi</span>
                                @endif
                            </td>
                            <td>
                                @if ($kehadiran)
                                    {{ $kehadiran->reason }}
                                @endif
                            </td>
                            {{-- End kolom kehadiran --}}
                            <td>
                                @if ($kehadiran)
                                    @if ($kehadiran->isvalid)
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Belum Terverifikasi</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                            {{-- Modal Absen Untuk Mahasiswa --}}
                            @if (Auth::user()->role->name == 'mahasiswa')
                                {{-- Modal Absen --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAbsen-{{ $date }}"
                                        @if ($kehadiran)
                                            @if ($kehadiran->isvalid)
                                                disabled
                                            @endif
                                        @else
                                            @if ($date > $today)
                                                disabled
                                            @endif
                                        @endif
                                    >
                                        Absen
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalAbsen-{{ $date }}"
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
                                                        Absensi Tanggal {{ $date }}
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($kehadiran)
                                                        <form action="{{ route('mahasiswa.absensi.store') }}" method="POST" id="update-{{ $kehadiran->id }}">
                                                    @else
                                                    <form action="{{ route('mahasiswa.absensi.store') }}" method="POST" id="create-{{ $date }}">
                                                    @endif
                                                        @csrf
                                                        @if ($kehadiran)
                                                            <input type="hidden" name="id" value="{{ $kehadiran->id }}">
                                                        @endif
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="day" class="form-label">Tanggal</label>
                                                                <input type="date" name="day" id="day" class="form-control" value="{{ $date }}" readonly>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $statues = [
                                                                "s" => "sakit",
                                                                "i" => "izin",
                                                                "a" => "tanpa keterangan",
                                                                "l" => "libur",
                                                                "h" => "hadir",
                                                            ];
                                                        @endphp
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="status-{{ $date }}" class="form-label">Status</label>
                                                                <select name="status" id="status-{{ $date }}" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                    @foreach ($statues as $key => $status)
                                                                        <option @if($kehadiran) @if($kehadiran->status == $key) selected @endif @endif value="{{ $key }}">{{ ucwords($status) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="desc" class="form-label">Alasan</label>
                                                                <input type="text" name="desc" id="desc" class="form-control" @if($kehadiran) value="{{ $kehadiran->reason }}" @endif>
                                                                <span class="badge bg-info mt-1">Abaikan Jika Hadir Atau Libur</span>
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
                                                    <button
                                                    @if ($kehadiran)
                                                    onclick="document.getElementById('update-{{ $kehadiran->id }}').submit();"
                                                    @else
                                                    onclick="document.getElementById('create-{{ $date }}').submit();"
                                                    @endif
                                                    type="button" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Absen --}}
                            {{-- End Modal Absen Mahasiswa --}}
                            @elseif (Auth::user()->role->name == 'agency' || Auth::user()->role->name == 'mentor')
                                {{-- Modal Absen --}}
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAbsen-{{ $date }}"
                                        @if (!$kehadiran)
                                            @if ($date > $today)
                                                disabled
                                            @endif
                                        @endif
                                    >
                                        Absen
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalAbsen-{{ $date }}"
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
                                                        Absensi Tanggal {{ $date }}
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($kehadiran)
                                                    <form action="{{ route('agency.absensi.store', $user->id) }}" method="POST" id="update-{{ $kehadiran->id }}">
                                                    @else
                                                    <form action="{{ route('agency.absensi.store', $user->id) }}" method="POST" id="create-{{ $date }}">
                                                    @endif
                                                        @csrf
                                                        @if ($kehadiran)
                                                            <input type="hidden" name="id" value="{{ $kehadiran->id }}">
                                                            {{-- @dd($kehadiran->id) --}}
                                                        @endif
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="day" class="form-label">Tanggal</label>
                                                                <input type="date" name="day" id="day" class="form-control" value="{{ $date }}" readonly>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $statues = [
                                                                "s" => "sakit",
                                                                "i" => "izin",
                                                                "a" => "tanpa keterangan",
                                                                "l" => "libur",
                                                                "h" => "hadir",
                                                            ];
                                                        @endphp
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="status-{{ $date }}" class="form-label">Status</label>
                                                                <select name="status" id="status-{{ $date }}" class="form-control">
                                                                    <option value="">Pilih</option>
                                                                    @foreach ($statues as $key => $status)
                                                                        <option @if($kehadiran) @if($kehadiran->status == $key) selected @endif @endif value="{{ $key }}">{{ ucwords($status) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="desc" class="form-label">Alasan</label>
                                                                <input type="text" name="desc" id="desc" class="form-control" @if($kehadiran) value="{{ $kehadiran->reason }}" @endif readonly>
                                                                <span class="badge bg-info mt-1">Abaikan Jika Hadir Atau Libur</span>
                                                            </div>
                                                        </div>
                                                        @if ($kehadiran)
                                                        @php
                                                            $valid = true;
                                                            $invalid = false;
                                                        @endphp
                                                        <div class="mb-2">
                                                            <div class="form-group">
                                                                <label for="validation" class="form-label">Validasi</label>
                                                                <select class="form-control" name="validation" id="validation">
                                                                    <option value="0" @if($kehadiran->isvalid) selected @endif>Tidak Valid</option>
                                                                    <option value="1" @if($kehadiran->isvalid) selected @endif>Valid</option>
                                                                </select>
                                                            </div>
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
                                                    <button
                                                    @if ($kehadiran)
                                                    onclick="document.getElementById('update-{{ $kehadiran->id }}').submit();"
                                                    @else
                                                    onclick="document.getElementById('create-{{ $date }}').submit();"
                                                    @endif
                                                    type="button" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Modal Absen --}}
                            @endif
                            {{-- End Modal Absen Untuk Agency dan Mentor --}}
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
