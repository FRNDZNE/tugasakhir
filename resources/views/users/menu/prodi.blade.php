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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prodi as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('user.mahasiswa.index', $p->id) }}">{{ $p->display_name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
