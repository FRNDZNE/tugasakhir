@extends('layouts.app')
@section('title','Magang Saya')
@section('css')
@endsection
@section('page-title','Magang Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            @if ($data == null)
                <p>Kamu belum mendaftar magang. Silahkan pilih mitra pada menu mitra magang</p>
            @else
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <h3>Informasi Mentor dan Dosen Pembimbing Magang</h3>
                        <h5>Mentor</h5>
                        @if ($data->mentor)
                        <p><b>Nama : </b> {{ $data->mentor->name }}</p>
                        <p><b>Kontak : </b> <a href="https://wa.me/{{ $data->mentor->contact }}" target="_blank">{{ $data->mentor->contact }}</a></p>
                        @endif
                        <h5>Dosen Pembimbing</h5>
                        @if ($data->dosen)
                        <p><b>Dosen Pembimbing : </b> {{ $data->dosen->name }}</p>
                        <p><b>Kontak : </b> <a href="https://wa.me/{{ $data->dosen->phone  }}" target="_blank">{{ $data->dosen->phone  }}</a></p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h3>Profile Perusahaan</h3>
                        <p>{{ $data->agency->desc == null ?  'Profil Belum Tersedia' : $data->agency->desc}}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@section('js')
@endsection
