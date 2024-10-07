@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h5>Login Saat Ini Sebagai Mahasiswa Magang</h5>
                    @if (!Auth::user()->mahasiswa->status)
                        <p>Akun Anda Belum Diaktifkan, Silahkan Hubungi Staff Prodi Untuk Aktivasi Akun</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
