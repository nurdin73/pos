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
            <span class="lead">Sisa Modal</span>
            <span id="sisaModal" class="text-uppercase text-primary font-weight-bold"></span>
            <a href="{{ route('exportModal') }}" class="btn btn-sm btn-success">Export Excel</a>
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
                    <th style="width: 18%">Sisa Modal</th>
                  </tr>
                </thead>
                <tbody id="listProduct">
                  
                </tbody>
              </table>
              <div class="paginate d-flex justify-content-end">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script>
    const URL_API = '{{ url('api/v1') }}'
    var query_params = ""
  </script>
  <script src="{{ asset('js/reports/modal/index.js') }}"></script>
@endsection