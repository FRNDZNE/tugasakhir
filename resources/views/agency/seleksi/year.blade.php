@extends('layouts.app')
@section('title','Tahun')
@section('css')
@endsection
@section('page-title','Tahun')
@section('content')
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($year as $y)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $y->name }}</td>
                            <td><a href="{{ route('agency.select.period', $y->id) }}" class="btn btn-info btn-md">Pilih</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
