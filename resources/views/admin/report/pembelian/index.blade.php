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
                <div class="col-6 col-md-4">
                  <label for="nama-barang" class="sr-only">Nama Barang</label>
                  <input type="text" name="nama-barang" id="nama-barang" class="form-control" placeholder="Nama Barang">
                </div>
                <div class="col-6 col-md-2">
                  <label for="date-start" class="sr-only">Date Start</label>
                  <input type="text" name="date-start" id="date-start" class="form-control" placeholder="Tanggal Mulai">
                </div>
                <div class="col-6 col-md-2">
                  <label for="date-end" class="sr-only">Date End</label>
                  <input type="text" name="date-end" id="date-end" class="form-control" placeholder="Tanggal Akhir">
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
                    <label for="btn-submit" class="sr-only">Button</label>
                    <button type="submit" class="btn btn-block btn-primary">Filter</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th style="width: 7%">Stok</th>
                    <th style="width: 15%">Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>0000002</td>
                    <td>Coba</td>
                    <td>100</td>
                    <td>Rp. 1.000.000 ,-</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js" integrity="sha512-zHDWtKP91CHnvBDpPpfLo9UsuMa02/WgXDYcnFp5DFs8lQvhCe2tx56h2l7SqKs/+yQCx4W++hZ/ABg8t3KH/Q==" crossorigin="anonymous"></script>
  <script type="text/javascript">
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script type="text/javascript" src="{{ asset('js/reports/pembelian/index.js') }}"></script>
@endsection