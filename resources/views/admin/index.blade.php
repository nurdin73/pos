@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg" id="countTransaction">0</div>
                <div>Jumlah Transaksi</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg" id="countPendapatan">0</div>
                <div>Jumlah Pendapatan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg" id="countKeuntungan">0</div>
                <div>Jumlah keuntungan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Grafik Penjualan <span id="labelGrafik" class="badge badge-primary">Harian</span></span>
            <div class="btn-group">
              <button class="btn btn-sm btn-outline-primary waktu" data-waktu="days" data-show="Harian">Hari</button>
              <button class="btn btn-sm btn-outline-primary waktu" data-waktu="months" data-show="Bulanan">Bulan</button>
              <button class="btn btn-sm btn-outline-primary waktu" data-waktu="years" data-show="Tahunan">Tahun</button>
            </div>
          </div>
          <div class="card-body" id="grafik-field">
            <canvas id="grafikTrx"></canvas>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span>Produk terlaris</span>
                <a href="{{ route('reportPenjualan') }}" class="btn-link">Show All</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Terjual</th>
                        <th>Harga</th>
                      </tr>
                    </thead>
                    <tbody id="listBestSeller">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span>Transaksi Terbaru</span>
                <a href="{{ route('listTransaksi') }}" class="btn-link">Show All</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody id="listNewTransactions">
                      
                    </tbody>
                  </table>
                </div>
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
  <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection