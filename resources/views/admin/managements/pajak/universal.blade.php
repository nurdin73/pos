@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <span class="lead">Pajak</span>
          </div>
          <div class="card-body">
            <form action="#" id="pajak">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      Rincian Pajak
                    </div>

                    <div class="card-body">
                      <div class="form-group">
                        <label for="nama_pajak" class="">Nama Pajak</label>
                        <input type="text" name="nama_pajak" id="nama_pajak" class="form-control">
                        <small class="form-text text-muted">
                          misal: PPN, GST
                        </small>
                      </div>

                      <div class="form-group mt-4">
                        <label for="persentase_pajak" class="">Persentase Pajak</label>
                        <div class="input-group">
                          <input type="text" name="persentase_pajak" id="persentase_pajak" class="form-control" data-browse="a">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </div>

                      <div class="form-group mt-4">
                        <label for="harga_barang">Harga barang sudah termasuk pajak</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="harga_barang" id="harga_barang">
                          <label class="custom-control-label" for="harga_barang">Ya</label>
                        </div>
                      </div>

                      <div class="form-group mt-4">
                        <label for="biaya_pengiriman">Biaya pengiriman dikenakan pajak</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="biaya_pengiriman" id="biaya_pengiriman">
                          <label class="custom-control-label" for="biaya_pengiriman">Ya</label>
                        </div>
                      </div>

                      <div class="form-group mt-4">
                        <label for="pajak_ditiadakan">Pajak (Aplikasi Kasir) bisa ditiadakan untuk tujuan tertentu, misalnya bungkus (tidak makan di tempat)</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="pajak_ditiadakan" id="pajak_ditiadakan">
                          <label class="custom-control-label" for="pajak_ditiadakan">Ya</label>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      Rincian Biaya Layanan
                    </div>

                    <div class="card-body">
                      <div class="form-group">
                        <label for="biaya_layanan" class="">Biaya Layanan</label>
                        <div class="input-group">
                          <input type="text" name="biaya_layanan" id="biaya_layanan" class="form-control" data-browse="a">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                        <small class="form-text text-muted">
                          Diimplementasikan untuk POS di restoran, cafe, dll.
                        </small>
                      </div>

                      <div class="form-group mt-4">
                        <label for="biaya_ditiadakan">Biaya layanan (Aplikasi Kasir) bisa ditiadakan untuk tujuan tertentu, misalnya bungkus (tidak makan di tempat)</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="biaya_ditiadakan" id="biaya_ditiadakan">
                          <label class="custom-control-label" for="biaya_ditiadakan">Ya</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  
@endsection