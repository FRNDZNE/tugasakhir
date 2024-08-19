@extends('layouts.app')
@section('title','History Magang')
@section('css')
@endsection
@section('page-title','History Magang')
@section('content')
    <div class="card">
        <div class="card-body">
            <hr>
            <table id="datatable" class="table table-borQEdered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mitra Magang</th>
                        <th>Mulai Magang</th>
                        <th>Selesai Magang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $loop->iteration }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
