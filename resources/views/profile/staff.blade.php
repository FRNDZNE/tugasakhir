@extends('layouts.app')
@section('title','Profile Saya')
@section('css')
@endsection
@section('page-title','Profile Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.staff') }}" method="post">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-valid @enderror" value="{{ $user->email }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-valid @enderror">
                            <span class="badge bg-info mt-1">Abaikan Jika Tidak Ingin Mengganti Password</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" readonly id="name" class="form-control" value="{{ $user->staff->name }}">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="uuid" class="form-label">NIP / NUPTK</label>
                            <input type="number" min="0" name="uuid" id="uuid" class="form-control" readonly value="{{ $user->staff->uuid }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select name="prodi" id="prodi" class="form-control" disabled>
                                <option value="{{ $user->staff->prodi_id }}" selected>{{ $user->staff->prodi->display_name }}</option>
                            </select>
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
