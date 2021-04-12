@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-7">
            <div class="card">
              <div class="card-header">
                Filter barang
              </div>
              <div class="card-body">
                <form action="#">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Kode barang(barcode)" autofocus>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama barang">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <select name="kategori" id="kategori" class="custom-select">
                          <option selected>Pilih kategori</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <button class="btn btn-primary btn-block">Filter</button>
                    </div>
                    <div class="col-md-3">
                      <button class="btn btn-secondary btn-block">clear</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  @for ($i = 0; $i < 10; $i++)
                  <div class="col-md-4">
                    <div class="card position-relative">
                      <img src="https://picsum.photos/300/30{{ $i }}" style="height: 120px;" class="card-img-top" alt="...">
                      <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-2">
                          <a href="#" class="text-muted text-uppercase font-weight-bold">Nama barang</a>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <button type="button" class="input-group-text btn">-</button>
                            </div>
                            <input type="text" readonly value="1" class="form-control text-center" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                              <button type="button" class="input-group-text btn">+</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endfor
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <form action="#">
                  <div class="d-flex justify-content-end">
                    <a href="#">Tambah customer</a>
                  </div>
                  <input type="text" class="form-control" placeholder="cari customer">
                </form>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>Nama barang</th>
                        <th style="width: 10%">Qyt</th>
                        <th class="text-right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($i = 0; $i < 10; $i++)
                      <tr>
                        <td><a href="#">Baju kaos oblong</a></td>
                        <td>100</td>
                        <td class="text-right">Rp. 200.000 ,-</td>
                      </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
                <small class="text-muted font-weight-bold">* Klik Nama barang untuk aksi</small>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <button class="btn btn-secondary btn-block mb-2">Batalkan transaksi</button>
                <form action="#">
                  <button class="btn btn-primary btn-block btn-lg">Rp. 200.000</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 