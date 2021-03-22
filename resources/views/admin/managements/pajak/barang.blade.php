@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
  <style>
    .form-atas {
      height: 130px;
    }
    @media screen and (max-width: 992px) {
      .form-atas {
        height: auto;
      }
    }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span>Daftar Pajak</span>
              <button class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#addTax">
                <svg class="c-icon">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                <span>Tambah pajak</span>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-8 col-md-6">
                  <div class="form-group">
                    <label for="search_pajak" class="sr-only">Nama Pajak</label>
                    <input type="text" name="search_pajak" id="search_pajak" placeholder="Cari Data Pajak" class="form-control">
                  </div>
                </div>
                <div class="col-4 col-md-2">
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
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th style="width: 30%">Nama Pajak</th>
                    <th style="width: 35%">Nama Barang</th>
                    <th style="width: 20%">Persentase Pajak</th>
                    <th style="width: 15%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listTaxes">
                  
                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end align-items-end">
                <ul class="pagination">
                  
                </ul>
              </nav>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">Pajak Universal</div>
          <div class="card-body d-flex justify-content-between align-items-center" id="taxUniv">
            
          </div>
        </div>

      </div>
    </div>
  </main>
@endsection 

@section('modal')
<!-- Modal Add Data -->
<div class="modal fade" id="addTax" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pajak</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formAddTax" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_pajak">Nama Pajak *</label>
                <div class="row">
                  <div class="col-6 col-md-12">
                    <input type="text" name="nama_pajak" id="nama_pajak" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="type_pajak">Tipe Pajak *</label>
                </div>
                <select name="type_pajak" id="type_pajak" class="custom-select" style="width: 100%">
                  <option value="lokal">Lokal</option>
                  <option value="universal">Universal</option>
                </select>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="barang_id">Nama Barang *</label>
                  <small><a href="{{ route('managementBarang') . "?redirect=" . route('pajakBarang') }}" class="btn-link">Tambah Barang</a></small>
                </div>
                <select name="barang_id" id="barang_id" class="form-control" style="width: 100%">
                  
                </select>
              </div>
              <div class="form-group">
                <label for="persentase_pajak">Persentase Pajak *</label>
                <div class="input-group mb-3">
                  <input type="text" name="persentase_pajak" id="persentase_pajak" class="form-control" placeholder="0.00">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                  </div>
                </div>
              </div>
              {{-- <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="type_pajak" name="type_pajak">
                  <label class="custom-control-label" for="type_pajak">Universal</label>
                </div>
              </div> --}}

            </div>
            <div class="col-md-4">
              <div class="row mb-2">
                <div class="col-12">
                  <ul class="pgwSlider">

                  </ul>
                </div>
              </div>
            </div>
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

<!-- Modal Update Data -->
<div class="modal fade" id="updateTax" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Pajak</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formUpdateTax" autocomplete="off">
        <input type="hidden" name="id_tax" id="idTax">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_pajak_update">Nama Pajak *</label>
                <div class="row">
                  <div class="col-6 col-md-12">
                    <input type="text" name="nama_pajak_update" id="nama_pajak_update" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="type_pajak_update">Tipe Pajak *</label>
                </div>
                <select name="type_pajak_update" id="type_pajak_update" class="custom-select" style="width: 100%">
                  <option value="lokal">Lokal</option>
                  <option value="universal">Universal</option>
                </select>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="barang_id_update">Nama Barang *</label>
                  <small><a href="{{ route('managementBarang') . "?redirect=" . route('pajakBarang') }}" class="btn-link">Tambah Barang</a></small>
                </div>
                <select name="barang_id_update" id="barang_id_update" class="form-control" style="width: 100%">
                  
                </select>
              </div>
              <div class="form-group">
                <label for="persentase_pajak_update">Persentase Pajak *</label>
                <div class="input-group mb-3">
                  <input type="text" name="persentase_pajak_update" id="persentase_pajak_update" class="form-control" placeholder="0.00">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <div class="row mb-2">
                <div class="col-12">
                  <ul class="pgwSlider">

                  </ul>
                </div>
              </div>
            </div>
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
  <script src="{{ asset('js/jquery-mask.js') }}"></script>
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    // const detailSuplierUrl = '{{ route('managementSuplier'). '/detail' }}'
  </script>
  <script src="{{ asset('js/managements/pajak/index.js') }}"></script>
@endsection