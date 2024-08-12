@extends('layouts.app')
@section('title', 'Bimbingan Saya')
@section('css')
@endsection
@section('page-title', 'Bimbingan Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('dosen.bimbingan.period', $tahun->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mitra Magang</th>
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
                                <a href="{{ route('dosen.bimbingan.detail', $i->id ) }}" class="btn btn-sm btn-info">Detail</a>
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
