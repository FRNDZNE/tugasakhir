@extends('layouts.app')
@section('title','Input Gambar Logbook')
@section('css')
@endsection
@section('page-title','Input Gambar Logbook')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('agency.logbook.mahasiswa', $user->id) }}" class="btn btn-md btn-secondary">Kembali</a>
            <div class="port mb-2">
                <div class="row portfolioContainer">
                    @foreach ($gambar as $g)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="gal-detail thumb">
                            <a href="{{ asset($g->path) }}" class="image-popup" title="{{ $g->logbook->date }}">
                                <img src="{{ asset($g->path) }}" class="thumb-img img-fluid" alt="work-thumbnail">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div><!-- end portfoliocontainer-->
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
