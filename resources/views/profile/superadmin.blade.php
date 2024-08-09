@extends('layouts.app')
@section('title','Profile Saya')
@section('css')
@endsection
@section('page-title','Profile Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.superadmin') }}" method="post">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-valid @enderror" value="{{ $user->name }}">
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-valid @enderror" value="{{ $user->email }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-valid @enderror">
                            <span class="badge bg-info mt-1">Abaikan Jika Tidak Ingin Mengganti Password</span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-md btn-warning">Update</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
@endsection
