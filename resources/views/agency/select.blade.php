@extends('layouts.app')
@section('title','Seleksi')
@section('page-title','Seleksi')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="get">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" class="form-label">Periode</label>
                            <select name="" id="" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" class="form-label">Prodi</label>
                            <select name="" id="" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-md">Filter</button>
                    </div>
                </div>
            </form>
            <hr>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
