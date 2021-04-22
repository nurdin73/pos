@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Laporan Penjualan</span>
            <a href="{{ route('exportPenjualaBarang') . "?type=export" }}" class="btn btn-sm btn-success">Export Excel</a>
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
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/reports/penjualan/index.js') }}"></script>
@endsection