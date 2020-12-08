@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Pembelian Barang</span>
            <button class="btn btn-sm btn-success">Export Excel</button>
          </div>
          <div class="card-body">
            <form id="filterExport">
              <div class="row">
                <div class="col-6 col-md-6">
                  <label for="nama-barang" class="sr-only">Nama Barang</label>
                  <input type="text" name="nama_barang" id="nama-barang" class="form-control" placeholder="Nama Barang">
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <select name="sorting" id="sorting" class="custom-select">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Filter</button>
                  </div>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-group">
                    <button type="reset" class="btn btn-block btn-warning btn-reset">Reset</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width: 15%">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th style="width: 15%">Tanggal Update</th>
                    <th style="width: 10%">Stok Awal</th>
                    <th style="width: 15%">Harga Dasar</th>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script type="text/javascript">
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script type="text/javascript" src="{{ asset('js/reports/pembelian/index.js') }}"></script>
@endsection