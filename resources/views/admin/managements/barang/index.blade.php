@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/PgwSlider/2.3.0/pgwslider.min.css" integrity="sha512-J1G8iGNI7Vk77uSN3MCVgvfTYdKVmqXhNZRI/QdC4L0S6MRImg40OsfF+N95Hix1n/Mxu7PHvdE1ULW4Hgfxyw==" crossorigin="anonymous" />
  <style>
    .modal { overflow: auto !important; }
    .page-link { cursor: pointer !important; }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span>Data Barang</span>
              <button class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#myModal">
                <svg class="c-icon">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                <span>Tambah barang</span>
              </button>
            </div>
          </div>
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
              <table class="table table-striped table-hover table-condensed" id="dataTables">
                <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th style="width: 8%">Stok</th>
                    <th style="width: 15%">Harga Dasar</th>
                    <th style="width: 15%">Harga Jual</th>
                    <th align="center" style="width: 20%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listProducts">
                  
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

@section('modal')
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formAddbarang" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label for="kode_barang">Kode Barang *</label>
                <div class="row">
                  <div class="col-6 col-md-10">
                    <input type="text" name="kode_barang" id="kode_barang" class="form-control">
                  </div>
                  <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalKodeBarang"><i class="fas fa-barcode"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="suplier_id">Suplier <sub class="text-info">Optional</sub></label>
                  <small><a href="{{ route('managementSuplier') . "?redirect=" . route('managementBarang') }}" class="btn-link">Tambah Suplier</a></small>
                </div>
                <select name="suplier_id" id="suplier_id" class="form-control" style="width: 100%">
                  
                </select>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="cabang_id">Cabang <sub class="text-info">Optional</sub></label>
                  <small><a href="{{ route('managementCabang') . "?redirect=" . route('managementBarang') }}" class="btn-link">Tambah Cabang</a></small>
                </div>
                <select name="cabang_id" id="cabang_id" class="form-control" style="width: 100%">
                  
                </select>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="nama_barang">Nama Barang *</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="type_barang">Type Barang *</label>
                    <select name="type_barang" id="type_barang" class="custom-select">
                      <option value="baru">Baru</option>
                      <option value="bekas">Bekas</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="stok">Stok Barang *</label>
                    <input type="text" name="stok" id="stok" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="harga_dasar">Harga dasar *</label>
                    <input type="text" name="harga_dasar" id="harga_dasar" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="harga_jual">Harga jual *</label>
                    <input type="text" name="harga_jual" id="harga_jual" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="kategori">Kategori Barang *</label>
                  <small class="btn-link text-info" id="addCategory" style="cursor: pointer; font-weight: bold;">Tambah kategori</small>
                </div>
                <div id="formAdd" style="display: none">
                  <div class="row">
                      <div class="col-10">
                        <div class="form-group">
                          <input type="text" name="kategoriAdd" id="kategoriAdd" class="form-control">
                        </div>
                      </div>
                      <div class="col-2">
                        <button class="btn btn-success btn-block" id="submitCategory" type="button">Add</button>
                      </div>
                  </div>
                </div>
                <select name="kategori" id="kategori" style="width: 100%" class="form-control">

                </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="row mb-2">
                <div class="col-12">
                  <ul class="pgwSlider">

                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input type="file" name="files" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" multiple>
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="progress" style="display: none">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="eceranOpsi">Barang bisa di jual eceran?</label>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="eceranOpsi" id="eceranOpsi">
                      <label class="custom-control-label" for="eceranOpsi">Ya</label>
                    </div>
                  </div>
                </div>
                <div class="col-12" id="showEceran" style="display: none;">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jumlah_persatuan">Jumlah</label>
                        <input type="text" class="form-control" name="jumlah_persatuan" id="jumlah_persatuan" placeholder="Ex. 12">
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="harga_persatuan">Harga satuan</label>
                        <input type="text" class="form-control" name="harga_persatuan" id="harga_persatuan" placeholder="Rp. 1000">
                      </div>
                    </div>
                  </div>
                  <small class="text-muted text-justify">
                    <strong>* note</strong> <br/>
                    <strong>* Jumlah</strong> <span>adalah isi dari 1 bungkus atau 1 dusbox pada setiap barang. contohnya dalam 1 bungkus rokok berisi 12 batang rokok didalamnya dsb.</span><br/>
                    <strong>* Harga Satuan</strong> <span>adalah harga dari 1 satuan. contohnya adalah harga dari 1 batang rokok adalah Rp.1.500 ,- dsb.</span> <br/>
                  </small>
                </div>
              </div>
            </div>
          </div>
          <small class="btn-link text-info" id="btnShowOther" style="cursor: pointer; font-weight: bold;">Tampilkan lainnya</small>
          <div id="showOther" style="display: none">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="berat">Berat</label>
                  <input type="text" name="berat" id="berat" class="form-control">
                </div>
                
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="diskon">Diskon(%)</label>
                      <input type="text" name="diskon" id="diskon" class="form-control">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="point">Point</label>
                      <input type="number" name="point" id="point" class="form-control">
                    </div>
                  </div>
                </div>
                {{-- <div class="form-group">
                  <label for="rak">Letak rak</label>
                  <input type="text" name="rak" id="rak" class="form-control">
                </div> --}}
              </div>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-center flex-column align-items-center mb-2">
              <span class="text-muted font-weight-bold text-uppercase">Daftar harga</span>
              <div class="dropdown-divider"></div>
              <div id="listTypeHarga" style="width: 100%">
                
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-lg btn-outline-primary" data-toggle="modal" data-target="#typeHargaModal">Tambah type harga? <br> (Grosir / Retailer / Eceran / Gojek)</button>
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

<!-- Modal -->
<div class="modal fade" id="typeHargaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm shadow">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Type Harga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formTypeHarga" autocomplete="off">
          <div class="form-group">
            <input type="text" name="nama_agen" id="nama_agen" placeholder="e.g : Agen" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="harga_type" id="harga_type" placeholder="harga 1 pcs" class="form-control">
          </div>
          <button class="btn btn-sm btn-block btn-primary">Tambahkan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalKodeBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm shadow">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Scan Kode barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="formKodeBarang" autocomplete="off" onsubmit="return(false)">
          <div class="form-group">
            <input type="text" name="inputCodeBarang" id="inputCodeBarang"class="form-control">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PgwSlider/2.3.0/pgwslider.min.js" integrity="sha512-Oz0WQx5ADiBluAj9vpDDLDKZRqMvawtS4jtgi4ebPahhvfB6pWlPdoDbr6gPndcVt4uPn/nX1/8rTuDA2B/qBQ==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const BASE_URL_ADMIN = '{{ url('admin') }}'
    var showAll = false
    var query_params = ""
    var typeHargaAdd = false
  </script>
  <script src="{{ asset('js/managements/barang/barang.js') }}"></script>
@endsection