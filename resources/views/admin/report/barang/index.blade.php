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
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-primary" id="totalBarang"></div>
                <div class="text-primary">Total Barang Keseluruhan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-warning" id="totalBarangMasuk"></div>
                <div class="text-warning">Total Barang Tersedia</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-success" id="totalBarangKeluar"></div>
                <div class="text-success">Total Barang Terjual</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Barang</span>
            <a href="{{ route('exportProduct') }}" class="btn btn-sm btn-success">Export Excel</a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th style="width: 15%">Harga Dasar</th>
                    <th style="width: 10%">Sisa Stok</th>
                    <th style="width: 10%">Terjual</th>
                  </tr>
                </thead>
                <tbody id="listProducts">
                  
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
  </script>
  <script src="{{ asset('js/reports/barang/index.js') }}"></script>
@endsection