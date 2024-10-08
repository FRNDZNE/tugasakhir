@extends('layouts.app')
@section('title','Notifikasi '. Auth::user()->role->name)
@section('css')
@endsection
@section('page-title','Notifikasi '. Auth::user()->role->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Belum Dibaca</h3>
            <table id="datatable-unread" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Notifikasi</th>
                        <th>Pesan Notifikasi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unreadNotif as $key => $unread)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $unread->data['heading'] }}</td>
                            <td>{{ $unread->data['message'] }}</td>
                            <td>
                                <a href="{{ route('markId', $unread->id) }}" class="btn btn-success btn-sm">Tandai Sudah Dibaca</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3>Sudah Dibaca</h3>
            <table id="datatable-read" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Notifikasi</th>
                        <th>Pesan Notifikasi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($readNotif as $key => $read)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $read->data['heading'] }}</td>
                            <td>{{ $read->data['message'] }}</td>
                            <td>
                                <a href="" class="btn btn-success btn-md">Tandai Sudah Dibaca</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatable-unread').DataTable();
            $('#datatable-read').DataTable();
        });
    </script>
@endsection
@section('js')

@endsection
