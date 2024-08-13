@extends('layouts.app')
@section('title','Dokumentasi Logbook')
@section('css')
@endsection
@section('page-title','Dokumentasi Logbook')
@section('content')
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role->name == 'agency' || Auth::user()->role == 'mentor')
                <a href="{{ route('agency.logbook.mahasiswa', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @elseif (Auth::user()->role->name == 'dosen')
                <a href="{{ route('dosen.bimbingan.logbook', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            @endif
            <div class="port mb-2">
                <div class="row portfolioContainer">
                    @forelse ($gambar as $g)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="gal-detail thumb">
                            <a href="{{ asset($g->path) }}" class="image-popup" title="{{ $g->logbook->date }}">
                                <img src="{{ asset($g->path) }}" class="thumb-img img-fluid" alt="work-thumbnail">
                            </a>
                        </div>
                    </div>
                    @empty
                    <h1 class="mt-2">Gambar Tidak Ada</h1>
                    @endforelse
                </div><!-- end portfoliocontainer-->
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
