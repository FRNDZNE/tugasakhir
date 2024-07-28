@extends('layouts.app')
@section('title', $tahun->name)
@section('css')
@endsection
@section('page-title', $tahun->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('staff.select.year') }}" class="btn btn-md btn-secondary">Kembali</a>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($period as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->start }}</td>
                            <td>{{ $p->end }}</td>
                            <td><a href="{{ route('staff.select.intern',[$tahun->id, $p->id]) }}" class="btn btn-info btn-sm">Pilih</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
