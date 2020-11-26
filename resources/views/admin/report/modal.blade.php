@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Sisa Modal</span>
            <button class="btn btn-sm btn-success">Export Excel</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama barang</th>
                    <th style="width: 8%">Stok</th>
                    <th style="width: 20%">Terakhir Update</th>
                    <th style="width: 18%">Harga Dasar</th>
                    <th style="width: 18%">Sisa Modal</th>
                  </tr>
                </thead>
                <tbody id="listProduct">
                  
                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end">
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
  <script>
    const URL_API = '{{ url('api/v1') }}'
    var query_params = ""
  </script>
  <script src="{{ asset('js/reports/modal/index.js') }}"></script>
@endsection