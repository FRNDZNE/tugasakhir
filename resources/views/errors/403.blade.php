@extends('errors::layout')
@section('title', __('Unauthorized'))
@section('code', '403')
@section('message', __('Unauthorized'))
@section('button')
    <a href="{{ url('/home') }}" class="btn btn-danger waves-effect waves-light"><i class="fas fa-home me-1"></i> Dashboard</a>
@endsection
