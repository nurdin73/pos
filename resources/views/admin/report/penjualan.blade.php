@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Laporan Penjualan</span>
            <button class="btn btn-sm btn-success">Export Excel</button>
          </div>
          <div class="card-body">
            <canvas id="budgetSale"></canvas>
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
  <script src="{{ asset('js/reports/penjualan/index.js') }}"></script>
@endsection