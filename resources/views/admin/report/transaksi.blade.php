@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="lead">Laporan transaksi hari ini(Per jam)</span>
                <button class="btn btn-sm btn-success">Export Excel</button>
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
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="lead">Laporan transaksi bulan ini(per hari)</span>
                <button class="btn btn-sm btn-success">Export Excel</button>
              </div>
              <div class="card-body">
                <div class="nav-tabs-boxed">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#jml_trx_days" role="tab" aria-controls="jml_trx_days">
                        Jumlah Transaksi
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#keuntungan_per_hari" role="tab" aria-controls="keuntungan_per_hari">
                        Keuntungan
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#pendapatan_per_hari" role="tab" aria-controls="pendapatan_per_hari">
                        Pendapatan
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="jml_trx_days" role="tabpanel">
                      <canvas id="jmlTrxDays"></canvas>
                    </div>
                    <div class="tab-pane" id="keuntungan_per_hari" role="tabpanel">
                      <canvas id="keuntunganPerHari"></canvas>
                    </div>
                    <div class="tab-pane" id="pendapatan_per_hari" role="tabpanel">
                      <canvas id="pendapatanPerHari"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="lead">Laporan transaksi tahun ini(Per bulan)</span>
                <button class="btn btn-sm btn-success">Export Excel</button>
              </div>
              <div class="card-body">
                <div class="nav-tabs-boxed">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#jml_trx_month" role="tab" aria-controls="jml_trx_month">
                        Jumlah Transaksi
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#keuntungan_per_month" role="tab" aria-controls="keuntungan_per_month">
                        Keuntungan
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#pendapatan_per_month" role="tab" aria-controls="pendapatan_per_month">
                        Pendapatan
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="jml_trx_month" role="tabpanel">
                      <canvas id="jmlTrxMonth"></canvas>
                    </div>
                    <div class="tab-pane" id="keuntungan_per_month" role="tabpanel">
                      <canvas id="keuntunganPerBulan"></canvas>
                    </div>
                    <div class="tab-pane" id="pendapatan_per_month" role="tabpanel">
                      <canvas id="pendapatanPerBulan"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="lead">Laporan transaksi semua(Per tahun)</span>
                <button class="btn btn-sm btn-success">Export Excel</button>
              </div>
              <div class="card-body">
                <div class="nav-tabs-boxed">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#jml_trx_years" role="tab" aria-controls="jml_trx_years">
                        Jumlah Transaksi
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#keuntungan_per_years" role="tab" aria-controls="keuntungan_per_years">
                        Keuntungan
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#pendapatan_per_years" role="tab" aria-controls="pendapatan_per_years">
                        Pendapatan
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="jml_trx_years" role="tabpanel">
                      <canvas id="jmlTrxYears"></canvas>
                    </div>
                    <div class="tab-pane" id="keuntungan_per_years" role="tabpanel">
                      <canvas id="keuntunganPerYears"></canvas>
                    </div>
                    <div class="tab-pane" id="pendapatan_per_years" role="tabpanel">
                      <canvas id="pendapatanPerYears"></canvas>
                    </div>
                  </div>
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
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script type="text/javascript" src="{{ asset('js/reports/transaksi/index.js') }}"></script>

@endsection