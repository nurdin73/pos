@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-body">
            <span class="lead">Laporan hari ini</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-danger" id="countTransaction">0</div>
                <div class="text-danger">Jumlah Transaksi</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-success" id="keuntungan">0</div>
                <div class="text-success">Keuntungan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-info" id="pendapatan">0</div>
                <div class="text-info">Pendapatan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <span class="lead">Laporan transaksi per jam</span>
          </div>
          <div class="card-body">
            <div class="nav-tabs-boxed">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#jml_trx" role="tab" aria-controls="jml_trx">
                    Jumlah Transaksi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#keuntungan2" role="tab" aria-controls="keuntungan2">
                    Keuntungan
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#pendapatan2" role="tab" aria-controls="pendapatan2">
                    Pendapatan
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="jml_trx" role="tabpanel">
                  <canvas id="myChart"></canvas>
                </div>
                <div class="tab-pane" id="keuntungan2" role="tabpanel">
                  <canvas id="keuntunganChart"></canvas>
                </div>
                <div class="tab-pane" id="pendapatan2" role="tabpanel">
                  <canvas id="pendapatanChart"></canvas>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.bundle.js') }}"></script>
  <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    var keuntunganHariIni = 0
    var pendapatanHariIni = 0
  </script>
  <script src="{{ asset('js/reports/umum/index.js') }}"></script>
@endsection