@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap4-select2-theme@1.0.3/src/css/bootstrap4-select2-theme.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Edit Barang</span>
            <a href="{{ route('managementBarang') }}" class="btn btn-primary btn-sm">
              Kembali
            </a>
          </div>
          <div class="card-body">
            <div class="nav-tabs-boxed">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Data</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Images</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                  <form id="updateProduct">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama_barang">Nama Barang</label>
                          <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                        </div>
                        
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="type_barang">Type Barang</label>
                              <select name="type_barang" id="type_barang" class="form-control">
                                <option value="baru">Baru</option>
                                <option value="bekas">Bekas</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="stok">Stok Barang</label>
                              <input type="text" name="stok" id="stok" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="harga_dasar">Harga dasar</label>
                              <input type="text" name="harga_dasar" id="harga_dasar" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="harga_jual">Harga jual</label>
                              <input type="text" name="harga_jual" id="harga_jual" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="d-flex justify-content-between align-items-center">
                            <label for="kategori">Kategori Barang</label>
                            <small class="btn-link" id="addCategory" style="cursor: pointer; font-weight: bold;">Tambah kategori</small>
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
                          <select name="kategori" id="kategori" style="width: 100%" class="form-control">
                            
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <small class="btn-link" id="btnShowOther" style="cursor: pointer; font-weight: bold;">Tampilkan lainnya</small>
                        <div id="showOther" style="display: none">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="berat">Berat</label>
                                <input type="text" name="berat" id="berat" class="form-control">
                              </div>
                              <div class="form-group">
                                <label for="diskon">Diskon(%)</label>
                                <input type="text" name="diskon" id="diskon" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="satuan">Satuan(gram,pcs)</label>
                                <select name="satuan" id="satuan" class="form-control">
                                  <option value="gram">Gram</option>
                                  <option value="pcs">Pcs</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="rak">Letak rak</label>
                                <input type="text" name="rak" id="rak" class="form-control">
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
                  <div class="row">
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <img src="https://dummyimage.com/300x300/000/fff" alt="coba" class="img-responsive img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                      <form id="uploadFile" enctype="multipart/form-data">
                        <input type="file" name="upload" id="upload" class="upload" multiple>
                        <label for="upload" class="labelUpload" style="background-image: url('https://dummyimage.com/300x300/000/fff')">
                          <i class="far fa-images"></i>
                          <small class="labelFile">ini label</small>
                        </label>
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


@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://kit.fontawesome.com/b10279cbf9.js" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
    const data = null
  </script>
  <script src="{{ asset('js/managements/barang.js') }}"></script>
  <script src="{{ asset('js/managements/barangUpdate.js') }}"></script>
@endsection