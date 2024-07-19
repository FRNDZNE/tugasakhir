@extends('layouts.app')
@section('title','Magang Saya')
@section('css')
@endsection
@section('page-title','Magang Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>Daftar Magang Saya Saat Ini</h3>
                    <p><b>Nama Instansi : </b> {{ $data->agency->name }}</p>
                    <p><b>Alamat : </b> {{ $data->agency->address }}</p>
                    <p><b>Contact : </b> {{ $data->agency->contact }}</p>
                    <p><b>Hari Kerja : </b> {{ $data->agency->day }} Hari</p>
                    <p><b>Mulai Magang : </b> {{ $data->period->start }}</p>
                    <p><b>Mulai Magang</b> {{ $data->period->end }}</p>
                    <p><b>Status : </b>
                        @if ($data->status == 'c')
                            <span class="badge bg-info">Ter Konfirmasi</span>
                        @elseif ($data->status == 'p')
                            <span class="badge bg-warning">Sedang Diproses</span>
                        @elseif ($data->status == 'a')
                            <span class="badge bg-success">Diterima</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h3>Profile Perusahaan</h3>
                    <p>{{ $data->agency->profile == null ?  'Profil Belum Tersedia' : $data->agency->profile}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
