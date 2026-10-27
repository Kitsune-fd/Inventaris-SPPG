@extends('layouts.layouts_app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Laporan Stok Bahan Baku</h2>

        <button class="btn btn-success">
            <i class="bi bi-printer"></i>
            Cetak Laporan
        </button>
    </div>

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <h6>Total Jenis Bahan</h6>
                        <h3>15</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <h6>Stok Aman</h6>
                        <h3>10</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <h6>Stok Menipis</h6>
                        <h3>3</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <h6>Stok Habis</h6>
                        <h3>2</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                <input type="date" class="form-control">
            </div>

            <div class="col-md-3">
                <input type="date" class="form-control">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary">
                    Filter
                </button>
            </div>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Bahan</th>
                    <th>Nama Bahan</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Satuan</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>BHN-001</td>
                    <td>Beras Premium</td>
                    <td>Sumber Karbohidrat</td>
                    <td>250</td>
                    <td>Kg</td>
                    <td>
                        <span class="badge bg-success">
                            Aman
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>BHN-002</td>
                    <td>Telur Ayam</td>
                    <td>Sumber Protein</td>
                    <td>80</td>
                    <td>Tray</td>
                    <td>
                        <span class="badge bg-success">
                            Aman
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>BHN-003</td>
                    <td>Daging Ayam</td>
                    <td>Sumber Protein</td>
                    <td>25</td>
                    <td>Kg</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            Menipis
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>BHN-004</td>
                    <td>Wortel</td>
                    <td>Sayur</td>
                    <td>40</td>
                    <td>Kg</td>
                    <td>
                        <span class="badge bg-success">
                            Aman
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>BHN-005</td>
                    <td>Pisang</td>
                    <td>Buah</td>
                    <td>0</td>
                    <td>Sisir</td>
                    <td>
                        <span class="badge bg-danger">
                            Habis
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection