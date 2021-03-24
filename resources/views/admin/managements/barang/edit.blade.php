@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Edit Barang <span id="kode-barang" class="badge badge-info"></span></span>
            <a href="{{ route('managementBarang') }}" class="btn btn-primary btn-sm">
              Kembali
            </a>
          </div>
          <div class="card-body">
            <div class="nav-tabs-boxed">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Data</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Images</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#type_harga" role="tab" aria-controls="type_harga">Type Harga</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#kodeBarang" role="tab" aria-controls="kode_barang">Kode barang</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                  <form id="updateProduct" autocomplete="off">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="suplier">Suplier <sub class="text-info">Optional</sub></label>
                          <select id="suplier" style="width: 100%" class="custom-select"></select>
                        </div>
                        <div class="form-group">
                          <label for="cabang">Cabang <sub class="text-info">Optional</sub></label>
                          <select id="cabang" style="width: 100%" class="custom-select"></select>
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
                              <label for="satuan">Satuan(gram,pcs)</label>
                              <input type="text" name="satuan" id="satuan" class="form-control">
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="type_barang">Type Barang *</label>
                              <select name="type_barang" id="type_barang" class="form-control">
                                <option value="baru">Baru</option>
                                <option value="bekas">Bekas</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-6">
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
                                <div class="col-9">
                                  <div class="form-group">
                                    <input type="text" name="kategoriAdd" id="kategoriAdd" class="form-control">
                                  </div>
                                </div>
                                <div class="col-3">
                                  <button class="btn btn-success btn-block" id="submitCategory" type="button">Add</button>
                                </div>
                            </div>
                          </div>
                          <select name="kategori" id="kategori" style="width: 100%" class="custom-select">
                            
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <small class="btn-link text-info" id="btnShowOther" style="cursor: pointer; font-weight: bold;">Tampilkan lainnya</small>
                        <div id="showOther" style="display: none">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="berat">Berat</label>
                                <input type="text" name="berat" id="berat" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="diskon">Diskon(%)</label>
                                <input type="number" name="diskon" id="diskon" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="point">Point</label>
                                <input type="number" name="point" id="point" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                  <div class="row" id="fieldImage">
                    <div class="col-md-3 col-sm-4 col-6 mb-2" id="fieldUpload">
                      <form id="uploadFile" enctype="multipart/form-data">
                        <div class="form-group">
                          <div class="input-group mb-3">
                            <div class="custom-file">
                              <input type="file" name="files" class="update-file" id="updateFile" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="updateFile">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="progress" style="display: none">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="type_harga" role="tabpanel">
                  <div class="d-flex justify-content-center flex-column align-items-center mb-2">
                    <div id="listTypeHarga" style="width: 100%">
                      
                    </div>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-lg btn-outline-primary" data-toggle="modal" data-target="#typeHargaModal">Tambah type harga? <br> (Grosir / Retailer / Eceran / Gojek)</button>
                  </div>
                </div>
                <div class="tab-pane" id="kodeBarang" role="tabpanel">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-striped table-borderless">
                        <thead>
                          <tr>
                            <th>Kode barang</th>
                            <th style="width: 10%">Action</th>
                          </tr>
                        </thead>
                        <tbody id="listCodeProduct">
                          
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <form action="#" id="addKode" autocomplete="off">
                        <div class="form-group">
                          <label for="barcode">Scan kode barang</label>
                          <input type="text" id="barcode" class="form-control" autofocus>
                          <small>Gunakan scanner untuk mempercepat proses</small>
                        </div>
                        <button class="btn btn-sm btn-primary">Simpan</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('modal')
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
            <input type="hidden" id="idProdPrice">
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
  <div class="modal fade" id="updatePrice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm shadow">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Type Harga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="formTypeHargaUpdate" autocomplete="off">
            <input type="hidden" id="idProdPrice">
            <div class="form-group">
              <input type="text" name="nama_agen_update" id="nama_agen_update" placeholder="e.g : Agen" class="form-control">
            </div>
            <div class="form-group">
              <input type="text" name="harga_type_update" id="harga_type_update" placeholder="harga 1 pcs" class="form-control">
            </div>
            <button class="btn btn-sm btn-block btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
    const data = null
  </script>
  <script src="{{ asset('js/managements/barang/barangUpdate.js') }}"></script>
@endsection