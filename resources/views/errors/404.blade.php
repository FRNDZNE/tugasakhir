@extends('errors::layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('button')
    <a href="{{ url('/home') }}" class="btn btn-danger waves-effect waves-light"><i class="fas fa-home me-1"></i> Dashboard</a>
@endsection
