@extends('layouts.app')
@section('title','Profile Saya')
@section('css')
@endsection
@section('page-title','Profile Saya')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.agency') }}" method="post">
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" readonly id="name" class="form-control" value="{{ $user->agency->name }}">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="uuid" class="form-label">Kode Perusahaan</label>
                            <input type="number" min="0" name="uuid" id="uuid" class="form-control" readonly value="{{ $user->agency->uuid }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="contact" class="form-label">Nomor Telepon</label>
                            <input type="number" min="0" name="contact" id="contact" class="form-control @error('contact') is-valid @endif" value="{{ $user->agency->contact }}">
                            @error('contact')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="day" class="form-label">Hari Kerja</label>
                            <input type="number" min="0" name="day" id="day" class="form-control @error('day') is-valid @endif" value="{{ $user->agency->day }}">
                            @error('day')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ $user->agency->address }}">
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="desc" class="form-label">Deskripsi Singkat Perusahaan</label>
                            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control">{{ $user->agency->desc }}</textarea>
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
