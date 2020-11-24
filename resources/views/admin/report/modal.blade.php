@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Modal</span>
            <button class="btn btn-sm btn-success">Export Excel</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama barang</th>
                    <th style="width: 8%">Stok</th>
                    <th style="width: 20%">Terakhir Update</th>
                    <th style="width: 18%">Harga Dasar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Coba</td>
                    <td>Coba</td>
                    <td>22 November 2020</td>
                    <td>Coba</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 