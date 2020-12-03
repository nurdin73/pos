@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-body">
            <span class="lead">Management Stok</span>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-6 col-md-3">
                  <div class="form-group">
                    <label for="search_kode_barang" class="sr-only">Kode Barang</label>
                    <input type="text" name="search_kode_barang" id="search_kode_barang" placeholder="Cari Kode(optional)" class="form-control">
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="form-group">
                    <label for="search_nama_barang" class="sr-only">Nama Barang</label>
                    <input type="text" name="search_nama_barang" id="search_nama_barang" placeholder="Cari Nama(optional)" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <select name="sorting" id="sorting" class="form-control">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button type="reset" class="btn btn-warning btn-block btn-reset">Reset</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th style="width: 7%">Stok</th>
                    <th style="width: 15%">Harga Dasar</th>
                    <th style="width: 15%">Harga Jual</th>
                    <th style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listProducts">
                  
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

@section('modal')
  <!-- Modal -->
  <div class="modal fade" id="detailStok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex justify-content-between align-item-center">
              <img src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png" alt="tes" width="30" height="30" class="rounded-circle img-fluid" id="imageProduct">
              <div class="d-flex justify-content-start flex-column ml-1">
                <small class="font-weight-bold" id="nameProduct"></small>
                <small class="text-muted" id="kodeProduct"></small>
              </div>
            </div>
            <div class="d-flex justify-content-end align-items-end flex-column ml-1">
              <small class="text-muted"><span id="hargaDasar"></span></small>
              <small class="badge badge-success" id="stokProduct"></small>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <button class="btn btn-sm btn-primary btn-block" id="updateStok" data-toggle="modal" data-target="#changeStok">Edit Stok</button>
            </div>
            <div class="col-6">
              <button class="btn btn-sm btn-outline-primary btn-block" id="showStok" data-toggle="modal" data-target="#listStokHistory">Lihat Stok</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="changeStok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateStokForm">
            <input type="hidden" name="idProd" id="idProd">
            <div class="row mb-2">
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input stats" id="stats1" type="radio" value="tambah" name="radios" checked>
                  <label class="form-check-label" for="stats1">Tambah</label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input stats" id="stats2" type="radio" value="kurangi" name="radios">
                  <label class="form-check-label" for="stats2">Kurangi</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="harga_dasar">Harga Dasar</label>
                  <input type="text" name="harga_dasar" id="harga_dasar" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                  <input type="text" name="jumlah" id="jumlah" class="form-control">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-sm">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="listStokHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stok history</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-primary">
            <div class="d-flex justify-content-center align-items-center flex-column">
              <small class="text-muted">Sisa Modal</small>
              <span class="text-uppercase font-weight-bold" id="modal"></span>
            </div>
          </div>
          <div class="listStok">
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="updateStokHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update history</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateStokHistoryForm">
            <input type="hidden" name="idStok" id="idStok">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="harga_dasar_history">Harga Dasar</label>
                  <input type="text" name="harga_dasar_history" id="harga_dasar_history" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="jumlah_history">Jumlah</label>
                  <input type="text" name="jumlah_history" id="jumlah_history" class="form-control">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-sm">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const BASE_URL = '{{ url('/') }}'
    var query_params = ""
  </script>
  <script src="{{ asset('js/managements/stock/index.js') }}"></script>
@endsection