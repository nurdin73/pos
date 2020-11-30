@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap4-select2-theme@1.0.3/src/css/bootstrap4-select2-theme.css">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Detail Barang <span id="kode-barang" class="badge badge-info"></span></span>
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
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly>
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
                            <input type="text" name="stok" id="stok" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="harga_dasar">Harga dasar</label>
                            <input type="text" name="harga_dasar" id="harga_dasar" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="harga_jual">Harga jual</label>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="kategori">Kategori Barang</label>
                        <select name="kategori" id="kategori" style="width: 100%" class="form-control"> 
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="berat">Berat</label>
                            <input type="text" name="berat" id="berat" class="form-control" readonly>
                          </div>
                          <div class="form-group">
                            <label for="diskon">Diskon(%)</label>
                            <input type="text" name="diskon" id="diskon" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="satuan">Satuan(gram,pcs)</label>
                            <select name="satuan" id="satuan" class="form-control" readonly>
                              <option value="gram">Gram</option>
                              <option value="pcs">Pcs</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="rak">Letak rak</label>
                            <input type="text" name="rak" id="rak" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" readonly></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                  <div class="row" id="fieldImage">
                    
                  </div>
                </div>
                <div class="tab-pane" id="type_harga" role="tabpanel">
                  <div class="d-flex justify-content-center flex-column align-items-center mb-2">
                    <div id="listTypeHarga" style="width: 100%">
                      
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
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
    const data = null
  </script>
  <script src="{{ asset('js/managements/barang/detailBarang.js') }}"></script>
@endsection