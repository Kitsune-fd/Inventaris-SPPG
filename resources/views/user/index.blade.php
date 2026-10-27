@extends('layouts.layouts_app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Data User</h2>

        <a href="#" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Tambah User
        </a>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       placeholder="Cari user...">
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
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>Administrator</td>
                    <td>admin</td>
                    <td>admin@sppg.com</td>
                    <td>
                        <span class="badge bg-danger">
                            Admin
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    </td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Petugas Gudang</td>
                    <td>gudang01</td>
                    <td>gudang@sppg.com</td>
                    <td>
                        <span class="badge bg-primary">
                            Petugas
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    </td>
                    <td>
                        👁 ✏ 🗑
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection