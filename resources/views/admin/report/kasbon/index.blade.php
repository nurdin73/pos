@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg" id="totalKasbon"></div>
                <div>Total Kasbon</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-success" id="totalDibayar"></div>
                <div>Total Dibayar</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-danger" id="totalSisa"></div>
                <div>Total Sisa</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Kasbon</span>
            <button class="btn btn-sm btn-success">Export Excel</button>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-end">
              <div class="btn-group">
                <button class="btn btn-sm btn-outline-primary timeBtn" data-query="days">Hari</button>
                <button class="btn btn-sm btn-outline-primary timeBtn" data-query="months">Bulan</button>
                <button class="btn btn-sm btn-outline-primary timeBtn" data-query="years">Tahun</button>
              </div>
            </div>
            <div id="grafik-field">
              <canvas id="grafikTrx"></canvas>
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
  </script>
  <script src="{{ asset('js/reports/kasbon/index.js') }}"></script>
@endsection