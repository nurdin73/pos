@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
@extends('layouts.template')

@section('css')
  <style>
    @media only screen and (max-width: 600px) {
      #d-desktop {
        justify-content: start !important;
        align-items: flex-start !important;
        margin-top: 20px;
      }
      #keterangan {
        text-align: left !important;
      }
    }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Invoice <span class="badge badge-pill badge-primary no_invoice">00000</span></span>
            <div class="btn-group">
              <button class="btn btn-sm btn-primary">Print</button>
              <a href="{{ route('listTransaksi') }}" class="btn btn-sm btn-danger">Kembali</a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 d-flex justify-content-start align-items-start flex-column">
                <span class="font-weight-bold text-uppercase text-primary">Toko</span>
                <span class="text-muted">{{ $settings->nama_toko ?? "RitterCoding" }}</span>
                <span class="text-muted">{{ $settings->no_telp ?? "0834-2333-1111"}}</span>
                <span class="text-muted">NPWP : {{ $settings->npwp ?? "11.222.334.4-556.676" }}</span>
                <span class="text-muted">{{ $settings->alamat ?? "-" }}</span>
              </div>
              <div class="col-md-6 d-flex justify-content-end align-items-end flex-column" id="d-desktop">
                <span class="font-weight-bold text-uppercase text-primary">Transaksi</span>
                <span class="text-muted no_invoice">000000000</span>
                <span class="text-muted" id="tgl_transaksi">{{ date('d F Y') }}</span>
                <span class="text-muted" id="total">RP. 0 ,-</span>
                <span class="text-muted text-right" id="keterangan">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam omnis dicta, nihil ipsum doloribus corrupti.</span>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th style="width: 5%">#</th>
                    <th>Items</th>
                    <th style="width: 8%">Qyt</th>
                    <th style="width: 15%">Harga</th>
                    <th style="width: 15%">Diskon</th>
                    <th style="width: 15%">Total</th>
                  </tr>
                </thead>
                <tbody id="listCarts">
                  
                </tbody>
              </table>
            </div>
            <div class="row justify-content-end">
              <div class="col-md-5">
                <table class="table table-clear table-borderless">
                  <tr>
                    <th>Sub Total</th>
                    <td id="subTotal">Rp. 0 ,-</td>
                  </tr>
                  <tr>
                    <th>Diskon</th>
                    <td id="diskonTrx">Rp. 0 ,-</td>
                  </tr>
                  <tr>
                    <th>Pajak</th>
                    <td id="pajakTrx">Rp. 0 ,-</td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td id="totalTrx">Rp. 0 ,-</td>
                  </tr>
                </table>
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
    const id = '{{ $id }}'
  </script>
  <script src="{{ asset('js/managements/transaksi/invoice.js') }}"></script>
@endsection