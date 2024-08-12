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
            <a href="{{ route('dosen.bimbingan.intern',[$tahun, $periode]) }}" class="btn btn-md btn-secondary">Kembali</a>
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
                    <a href="{{ route('dosen.bimbingan.asistensi', $magang->id) }}" class="btn btn-md btn-secondary">Asistensi</a>
                    <a href="{{ route('dosen.bimbingan.absensi', $magang->id) }}" class="btn btn-md btn-success">Absensi</a>
                    <a href="{{ route('dosen.bimbingan.logbook', $magang->id) }}" class="btn btn-md btn-warning">Logbook</a>
                    <a href="{{ route('dosen.bimbingan.score', $magang->id) }}" class="btn btn-md btn-info">Penilaian</a>
                    <a href="{{ route('dosen.bimbingan.report', $magang->id) }}" @if($magang->submission) target="_blank" @endif class="btn btn-md btn-danger">Laporan Akhir</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Mentor</h4>
                    @if ($magang->mentor)
                        <p><b>Nama Lengkap : </b> {{ $magang->mentor->name }}</p>
                        <p><b>Kontak : </b> <a href="https://wa.me/{{ $magang->mentor->contact }}" target="_blank">{{ $magang->mentor->contact }}</a></p>
                    @else
                        <b>Belum Ditentukan</b>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection
