@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h5>Login Saat Ini Sebagai Mitra Magang</h5>
                    {{-- <h5>WOY</h5> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
