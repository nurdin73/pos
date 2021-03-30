@extends('layouts.template')

@section('css')
  <style>
    .page-link { cursor: pointer !important; }
  </style>
@endsection

@section('content')
<main class="c-main">
  <div class="container-fluid">
    <div class="fade-in">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span class="lead">Detail Cabang <span id="namaCabang" class="badge badge-primary badge-pill"></span></span>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover table-condensed" id="dataTables">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th style="width: 5%">Stok</th>
                <th style="width: 15%">Harga Dasar</th>
                <th style="width: 15%">Harga Jual</th>
              </tr>
            </thead>
            <tbody id="listProducts">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@section('js')
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const id = '{{ $id }}'
  </script>
  <script src="{{ asset('js/managements/cabang/detail.js') }}"></script>   
@endsection