@extends('layouts.app')
@section('title','Profile Saya')
@section('css')
@endsection
@section('page-title','Profile Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.mahasiswa') }}" method="post">
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
                            <span class="badge bg-info">Abaikan Jika Tidak Ingin Mengganti Password</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" readonly id="name" class="form-control" value="{{ $user->mahasiswa->name }}">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="uuid" class="form-label">NIM</label>
                            <input type="number" min="0" name="uuid" id="uuid" class="form-control" readonly value="{{ $user->mahasiswa->uuid }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select name="prodi" id="prodi" class="form-control" disabled>
                                <option value="{{ $user->mahasiswa->prodi_id }}" selected>{{ $user->mahasiswa->prodi->display_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grade" class="form-label">Semester</label>
                            <input type="text" name="grade" id="grade" class="form-control" readonly value="{{ $user->mahasiswa->grade }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="class" class="form-label">Kelas</label>
                            <input type="text" name="class" id="class" class="form-control" readonly value="{{ $user->mahasiswa->class }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->mahasiswa->phone }}">
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
