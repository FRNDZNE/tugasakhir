@extends('layouts.app')
@section('title','Daftar Prodi ')
@section('css')
@endsection
@section('page-title','Daftar Prodi')
@section('content')
    <div class="card">
        <div class="card-body">
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program Studi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prodi as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->display_name }}</td>
                            <td><a href="{{ route('score.index', $p->id) }}" class="btn btn-primary btn-md">Pilih</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
