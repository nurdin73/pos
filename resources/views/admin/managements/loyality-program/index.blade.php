@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Loyality Program</span>
            <button class="btn btn-sm btn-primary">Tambah hadiah</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Hadiah</th>
                    <th style="width: 7%">Stok</th>
                    <th style="width: 7%">Point</th>
                    <th style="width: 12%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Baju</td>
                    <td>100</td>
                    <td>100</td>
                    <td>
                      <button class="btn btn-sm btn-success">Tukar point</button>
                    </td>
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