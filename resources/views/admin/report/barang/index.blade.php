@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg" id="totalBarang"></div>
                <div>Total Barang Keseluruhan</div>
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
                <div>Total Barang Tersedia</div>
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
                <div>Total Barang Terjual</div>
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
            <button class="btn btn-sm btn-success">Export Excel</button>
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
              <nav aria-label="..." class="d-flex justify-content-end align-items-end">
                <ul class="pagination">
                  
                </ul>
              </nav>
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