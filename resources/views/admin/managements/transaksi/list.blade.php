@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">List Transaksi</span>
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">Export Excel</button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                @for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                    @if ($i == date('Y'))
                    <a class="dropdown-item active" href="{{ route('exportTrx')."?year=".$i }}">{{ $i }}</a>
                    @else
                    <a class="dropdown-item" href="{{ route('exportTrx')."?year=".$i }}">{{ $i }}</a>
                    @endif
                @endfor
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th>No invoice</th>
                    <th>Customer</th>
                    <th>Kasir</th>
                    <th style="width: 17%">Tanggal Transaksi</th>
                    <th style="width: 13%">Total</th>
                    <th style="width: 8%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listTransactions">
                  
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const invoiceUrl = '{{ route('managementTransaksi') }}' + "/invoice/"
  </script>
  <script src="{{ asset('js/managements/transaksi/list.js') }}"></script>
@endsection