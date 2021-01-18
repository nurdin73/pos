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
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    Rincian Pajak
                  </div>

                  <div class="card-body">
                    <form action="#" id="rincianPajak">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="nama_pajak" class="">Nama Pajak</label>
                            <input type="text" name="nama_pajak" id="nama_pajak" class="form-control">
                            <small class="form-text text-muted">
                              misal: PPN, GST
                            </small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="persentasePajak" class="">Persentase Pajak</label>
                            <div class="input-group">
                              <input type="text" name="persentasePajak" id="persentasePajak" class="form-control" data-browse="a">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
  
                      <div class="form-group mt-4">
                        <label for="hargaBarang">Harga barang sudah termasuk pajak</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="hargaBarang" id="hargaBarang">
                          <label class="custom-control-label" for="hargaBarang">Ya</label>
                        </div>
                      </div>
  
                      <div class="form-group mt-4">
                        <label for="pajakAktif">Pajak (Aplikasi Kasir) bisa ditiadakan untuk tujuan tertentu, misalnya bungkus (tidak makan di tempat)</label>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="pajakAktif" id="pajakAktif">
                          <label class="custom-control-label" for="pajakAktif">Ya</label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    Rincian Biaya Layanan
                  </div>

                  <div class="card-body">
                    <form action="#" id="layananPajak">
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
                      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
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
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/managements/pajak/universal.js') }}"></script>
@endsection