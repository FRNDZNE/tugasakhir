@extends('layouts.app')
@section('title', 'Pilih Dosen Pembimbing')
@section('css')
@endsection
@section('page-title', 'Pilih Dosen Pembimbing')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('staff.select.period', $tahun->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mitra Magang</th>
                        <th>Dosen Pembimbing</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intern as $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->mahasiswa->uuid }}</td>
                            <td>{{ $i->mahasiswa->name }}</td>
                            <td>{{ $i->agency->name }}</td>
                            <td>
                                @if ($i->dosen == null)
                                    Belum Ada Dosen Pembimbing
                                @else
                                    {{ $i->dosen->name }}
                                @endif
                            </td>
                            <td>
                                <!-- Modal trigger button -->
                                <button
                                    type="button"
                                    class="btn btn-pink btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modaldospem-{{ $i->id }}"
                                >
                                    Pilih Dosen Pembimbing
                                </button>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div
                                    class="modal fade"
                                    id="modaldospem-{{ $i->id }}"
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
                                                <h5 class="modal-title text-white" id="modalTitleId">
                                                    Pilih Dosen Pembimbing
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('staff.select.dospem',[$tahun->id, $periode->id]) }}" method="post" id="dospem-{{ $i->id }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                                    <div class="form-group">
                                                        <label for="dosen" class="form-label">Dosen Pembimbing</label>
                                                        <select name="dosen" id="dosen" class="form-control ">
                                                            <option value="0">Pilih Dosen</option>
                                                            @foreach ($dosen as $d)
                                                                <option value="{{ $d->dosen->id }}" @if($d->dosen->id == $i->dosen_id && $i->dosen != null) selected @endif>{{ $d->dosen->name }}</option>
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
                                                <button type="button" class="btn btn-pink" onclick="document.getElementById('dospem-{{ $i->id }}').submit();">Update</button>
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
