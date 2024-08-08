@extends('layouts.app')
@section('title','Nilai Saya')
@section('css')
@endsection
@section('page-title','Nilai Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <hr>
            <table id="datatable" class="table table-borQEdered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penilaian</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($score as $key => $s)
                        @php
                            $val = $s->value->firstWhere('intern_id', Auth::user()->mahasiswa->intern->id);
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $val ? $val->value : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
