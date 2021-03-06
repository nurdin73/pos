@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-info" id="totalPenjualan"></div>
                <div>Total Penjualan</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="text-value-lg text-success" id="totalPajak"></div>
                <div>Total Pajak</div>
                <div class="progress progress-xs my-2">
                  <div class="progress-bar bg-warning" role="progressbar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Pajak</span>
            {{-- <a href="{{ route('reportKasbonChart') }}?type=export&query=months" class="btn btn-sm btn-success">Export Excel</a> --}}
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
              <canvas id="grafikPajak"></canvas>
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
    const persentasePajak = '{{ $tax->persentasePajak ?? 0 }}'
  </script>
  <script src="{{ asset('js/reports/pajak/index.js') }}"></script>
@endsection