@extends('layouts.app')
@section('title','Laporan Akhir')
@section('css')
@endsection
@section('page-title','Pengumpulan Laporan Akhir')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mahasiswa.report.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($data)
                    <input type="hidden" name="id" value="{{ $data->id }}">
                @endif
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="path" class="form-label">File Laporan Akhir</label>
                            <input type="file" name="path" id="path" class="form-control @error('path') is-invalid @enderror" accept=".pdf">
                            @error('path')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($data)
                <a href="{{ asset('/') }}reports/{{ $data->path }}" target="_blank" class="btn btn-md btn-danger">{{ $data->path }}</a>
            @else
                <h5>Belum Ada Laporan</h5>
            @endif
        </div>
    </div>
@endsection
@section('js')
    @error('path')
        <script>
            Swal.fire({
                title: "Kesalahan",
                text: "{{ $message }}",
                icon: "error",
            });
        </script>
    @enderror
@endsection
