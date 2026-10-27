@extends('layouts.layouts_app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Data Bahan Masuk</h2>

        <a href="#" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Tambah Bahan Masuk
        </a>
    </div>

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       placeholder="Cari bahan masuk...">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary">
                    Cari
                </button>
            </div>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode Transaksi</th>
                    <th>Nama Bahan</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>01/06/2026</td>
                    <td>BM-001</td>
                    <td>Beras Premium</td>
                    <td>CV Pangan Sejahtera</td>
                    <td>100</td>
                    <td>Kg</td>
                    <td>Rp 15.000</td>
                    <td>Rp 1.500.000</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>02/06/2026</td>
                    <td>BM-002</td>
                    <td>Telur Ayam</td>
                    <td>UD Sumber Protein</td>
                    <td>50</td>
                    <td>Tray</td>
                    <td>Rp 60.000</td>
                    <td>Rp 3.000.000</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>03/06/2026</td>
                    <td>BM-003</td>
                    <td>Daging Ayam</td>
                    <td>PT Berkah Tani Nusantara</td>
                    <td>80</td>
                    <td>Kg</td>
                    <td>Rp 35.000</td>
                    <td>Rp 2.800.000</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>04/06/2026</td>
                    <td>BM-004</td>
                    <td>Wortel</td>
                    <td>PT Sayur Makmur Abadi</td>
                    <td>40</td>
                    <td>Kg</td>
                    <td>Rp 12.000</td>
                    <td>Rp 480.000</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>05/06/2026</td>
                    <td>BM-005</td>
                    <td>Pisang</td>
                    <td>CV Buah Segar Indonesia</td>
                    <td>60</td>
                    <td>Sisir</td>
                    <td>Rp 20.000</td>
                    <td>Rp 1.200.000</td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection