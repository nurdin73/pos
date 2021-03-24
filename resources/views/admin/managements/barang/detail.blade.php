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
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#kodeBarang" role="tab" aria-controls="kode_barang">Kode barang</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="suplier">Suplier</label>
                        <select id="suplier" style="width: 100%" class="custom-select" disabled></select>
                      </div>
                      <div class="form-group">
                        <label for="cabang">Cabang</label>
                        <select id="cabang" style="width: 100%" class="custom-select" disabled></select>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly>
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
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="berat">Berat</label>
                            <input type="text" name="berat" id="berat" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="diskon">Diskon(%)</label>
                            <input type="text" name="diskon" id="diskon" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="form-group">
                              <label for="point">Point</label>
                              <input type="number" name="point" id="point" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" readonly></textarea>
                      </div>
                      <div class="alert alert-info" id="infoEceran">
                        
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
                <div class="tab-pane" id="kodeBarang" role="tabpanel">
                  <div class="d-flex justify-content-center flex-column align-items-center mb-2">
                    <div id="listKodeBarang" style="width: 100%">
                      <table class="table table-striped table-borderless">
                        <thead>
                          <tr>
                            <th>Kode barang</th>
                          </tr>
                        </thead>
                        <tbody id="listCodeProduct">
                          
                        </tbody>
                      </table>
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
  <script src="{{ asset('js/select2.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
    const data = null
  </script>
  <script src="{{ asset('js/managements/barang/detailBarang.js') }}"></script>
@endsection