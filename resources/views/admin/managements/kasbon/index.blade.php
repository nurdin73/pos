@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/datepickerstn.css') }}"/>
  <style>
    .page-link { cursor: pointer !important; }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-lg-6">
            <div class="card overflow-hidden">
              <div class="card-body p-0 d-flex align-items-center">
                <div class="bg-primary p-4 mfe-3">
                  <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-clipboard') }}"></use>
                  </svg>
                </div>
                <div>
                  <div class="text-value text-primary" id="totalKasbon">0</div>
                  <div class="text-muted text-uppercase font-weight-bold small">Sisa Kasbon</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card overflow-hidden">
              <div class="card-body p-0 d-flex align-items-center">
                <div class="bg-primary p-4 mfe-3">
                  <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-swap-horizontal') }}"></use>
                  </svg>
                </div>
                <div>
                  <div class="text-value text-primary" id="totalTransaksi">0</div>
                  <div class="text-muted text-uppercase font-weight-bold small">Total transaksi</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Data Kasbon</span>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahKasbon">Tambah Kasbon</button>
          </div>
          <div class="card-body">
            <form id="filterData" autocomplete="off">
              <div class="row">
                <div class="col-12 col-md-8">
                  <div class="form-group">
                    <input type="text" name="nama" id="nama" placeholder="Cari Nama (optional)" class="form-control">
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button class="btn btn-warning btn-block reset" type="reset">Reset</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Jumlah Kasbon</th>
                    <th>Sisa</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="listData">

                </tbody>
              </table>
              <div class="paginate d-flex justify-content-end"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('modal')
  <div class="modal fade" id="tambahKasbon" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Kasbon</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form id="formAddKasbon" autocomplete="off">
          <input type="hidden" name="id_kategori" id="id_kategori">
          <div class="modal-body">
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <small><a href="{{ route('managementPelanggan') . "?redirect=" . route('managementKasbon') }}" class="btn-link">Tambah Pelanggan</a></small>
              </div>
              <select name="nama_pelanggan" id="nama_pelanggan" class="form-control" style="width: 100%"></select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jumlah">Jumlah Kasbon</label>
                  <input type="text" name="jumlah" id="jumlah" placeholder="Rp. " class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="add_jatuh_tempo">Jatuh Tempo</label>
                  <input type="text" name="add_jatuh_tempo" id="add_jatuh_tempo" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            {{-- <button class="btn btn-primary" id="btn-submit" type="submit">Save changes</button> --}}
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/jquery-validate.js') }}"></script>
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script src="{{ asset('js/datetimepicker.js') }}"></script>
  <script src="{{ asset('js/datetimepickerid.js') }}"></script>

  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
  </script>
  <script src="{{ asset('js/managements/kasbon/index.js') }}"></script>
@endsection