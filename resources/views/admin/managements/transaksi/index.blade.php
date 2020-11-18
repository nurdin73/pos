@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="border bg-white p-3" style="height: 170px">
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="tanggal">Tanggal</label>
                <div class="col-md-9">
                  <input class="form-control" id="tanggal" type="text" name="tanggal">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="kasir">Kasir</label>
                <div class="col-md-9">
                  <input class="form-control" id="kasir" type="text" name="kasir">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="customer">Customer</label>
                <div class="col-md-9">
                  <select name="customer" id="customer" class="form-control">
                    <option value="umum">Umum</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="border bg-white p-3" style="height: 170px">
              <form action="#">
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="barcode">Kode</label>
                  <div class="col-md-9">
                    <input class="form-control" id="barcode" type="text" name="barcode">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="qyt">Qyt</label>
                  <div class="col-md-9">
                    <input class="form-control" id="qyt" type="text" name="qyt">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="qyt"></label>
                  <div class="col-md-9">
                    <button class="btn btn-primary btn-sm" type="submit">Tambah</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body d-flex justify-content-center align-items-end flex-column" style="height: 170px">
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <span class="text-muted">Invoice <span class="font-weight-bold">POS2011180001</span></span>
                  <span class="font-weight-bold" style="font-size: 30px">RP. 100.000 ,-</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th>Kode Barang</th>
                    <th>Nama barang</th>
                    <th>Harga</th>
                    <th style="width:5%">Qyt</th>
                    <th>Diskon</th>
                    <th>Total</th>
                    <th style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>POS00000001</td>
                    <td>Celana luar dalam</td>
                    <td>Rp. 1.000.000 ,-</td>
                    <td>1</td>
                    <td>Rp. 1.000 ,-</td>
                    <td>Rp. 999.999 ,-</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-danger">Hapus</button>
                        <button class="btn btn-sm btn-info">Edit</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="card" style="height: 180px">
              <div class="card-body">
                <div class="form-group">
                  <input type="text" name="sub_total" id="sub_total" placeholder="Sub total" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="diskon" id="diskon" placeholder="Diskon" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="grand_total" id="grand_total" placeholder="grand total" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <input type="text" name="cash" id="cash" placeholder="Cash" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="change" id="change" placeholder="Kembalian" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" placeholder="Keterangan"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <button class="btn btn-block btn-danger">Cancel</button>
            <button class="btn btn-block btn-success btn-lg">Prosess</button>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 