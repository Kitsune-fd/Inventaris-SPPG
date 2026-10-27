@extends('layouts.layouts_app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Data Penggunaan Bahan</h2>

        <a href="#" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Tambah Penggunaan
        </a>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       placeholder="Cari penggunaan bahan...">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary">
                    Cari
                </button>
            </div>
        </div>

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Bahan</th>
                    <th>Jumlah Digunakan</th>
                    <th>Satuan</th>
                    <th>Tujuan</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>30-05-2026</td>
                    <td>Beras</td>
                    <td>50</td>
                    <td>Kg</td>
                    <td>SD Negeri 01 Medan</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>30-05-2026</td>
                    <td>Telur</td>
                    <td>100</td>
                    <td>Butir</td>
                    <td>SD Negeri 02 Medan</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection