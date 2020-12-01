@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Suplier List</span>
            <button class="btn btn-sm btn-primary">Tambah Suplier</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-stripped table-hover">
                <thead>
                  <tr>
                    <th>Suplier</th>
                    <th style="width: 15%">Email</th>
                    <th style="width: 50%">Alamat</th>
                    <th style="width: 10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Coba</td>
                    <td>Coba@gmail.com</td>
                    <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate, delectus!</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fas fa-book"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                      </div>
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