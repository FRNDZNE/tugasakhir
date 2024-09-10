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
                    @if ($d->deleted_at)

                    @else

                    @endif
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->agency->name }}</td>
                        <td>{{ $d->period->start }}</td>
                        <td>{{ $d->period->end }}</td>
                        <td>
                            @switch($d->status)
                                @case('c')
                                    @if ($d->deleted_at)
                                        <span class="badge bg-dark">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-info">Dikonfirmasi</span>
                                    @endif
                                    @break
                                @case('p')
                                    <span class="badge bg-warning">Diproses</span>
                                    @break
                                @case('a')
                                    <span class="badge bg-success">Diterima</span>
                                    @break
                                @case('d')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @break
                                @default

                            @endswitch
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
