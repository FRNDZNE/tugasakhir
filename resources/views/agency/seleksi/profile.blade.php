@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('css')
@endsection
@section('page-title','Detail Mahasiswa')
@section('content')
    <div class="card">
        <div class="card-body">
            @php
                $tahun = $magang->mahasiswa->year->id;
                $periode = $magang->period->id;
            @endphp
            <a href="{{ route('agency.select.intern',[$tahun, $periode]) }}" class="btn btn-md btn-secondary">Kembali</a>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Profil Mahasiswa</h4>
                    <p><b>Nama Lengkap : </b> {{ $magang->mahasiswa->name }}</p>
                    <p><b>NIM : </b> {{ $magang->mahasiswa->uuid }}</p>
                    <p><b>Program Studi : </b> {{ $magang->mahasiswa->prodi->display_name }}</p>
                    <p><b>Semester : </b> {{ $magang->mahasiswa->grade }}</p>
                    <p><b>Kontak : </b> <a href="https://wa.me/{{ $magang->mahasiswa->phone }}" target="_blank">{{ $magang->mahasiswa->phone }}</a></p>
                </div>
                <div class="col-md-6">
                    @if ($magang->status == 'a')
                        <a href="{{ route('agency.absensi.mahasiswa', $magang->id) }}" class="btn btn-md btn-success">Absensi</a>
                        <a href="{{ route('agency.logbook.mahasiswa', $magang->id) }}" class="btn btn-md btn-warning">Logbook</a>
                        <a href="{{ route('agency.score.mahasiswa', $magang->id) }}" class="btn btn-md btn-info">Penilaian</a>
                        <a href="{{ route('agency.report.mahasiswa', $magang->id) }}" @if($magang->submission) target="_blank" @endif class="btn btn-md btn-danger">Laporan Akhir</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($magang->status == 'a')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if (!Auth::user()->role->name == 'mentor')
                        <h4>Mentor</h4>
                            @if ($magang->mentor)
                                <p><b>Nama Lengkap : </b> {{ $magang->mentor->name }}</p>
                                <p><b>Kontak : </b> <a href="https://wa.me/{{ $magang->mentor->contact }}" target="_blank">{{ $magang->mentor->contact }}</a></p>
                            @else
                                <b>Belum Ditentukan</b>
                            @endif
                        @endif

                    </div>
                    <div class="col-md-6">
                        <h4>Dosen Pembimbing</h4>
                        @if ($magang->dosen)
                            <p><b>Nama Lengkap : </b> {{ $magang->dosen->name }}</p>
                            <p><b>Kontak : </b> <a href="https://wa.me/{{ $magang->dosen->phone }}" target="_blank">{{ $magang->dosen->phone }}</a></p>
                        @else
                            <b>Belum Ditentukan</b>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('js')
@endsection
