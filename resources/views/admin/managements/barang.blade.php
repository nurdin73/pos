@extends('layouts.template')
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
            <div class="table-responsive">
              <table class="table table-striped table-hover table-condensed">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Gambar Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th align="center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="width: 5%">1.</td>
                    <td style="width: 15%">
                      <img src="https://dummyimage.com/100x100/000/fff&text=Image" alt="image" class="img-fluid img-responsive" width="50" height="50">
                    </td>
                    <td style="width: 40%">Jelly kukus</td>
                    <td style="width: 5%">20</td>
                    <td>Rp. 1.000.00 ,-</td>
                    <td align="center">
                      <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                        <button class="btn btn-primary" type="button">Edit</button>
                        <button class="btn btn-primary" type="button">Detail</button>
                        <button class="btn btn-primary" type="button">Hapus</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('modal')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control">
              </div>
              <div class="form-group">
                <label for="type_barang">Type Barang</label>
                <select name="type_barang" id="type_barang" class="form-control">
                  <option value="baru">Baru</option>
                  <option value="bekas">Bekas</option>
                </select>
              </div>
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="stok">Stok Barang</label>
                    <input type="text" name="stok" id="stok" class="form-control">
                  </div>
                </div>
                <div class="col-8">
                  <div class="form-group">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="kategori">Kategori Barang</label>
                  <small class="btn-link" style="cursor: pointer; font-weight: bold;">Tambah kategori</small>
                </div>
                <select name="kategori" id="kategori" class="form-control">
                  <option value="baru">Baru</option>
                  <option value="bekas">Bekas</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <img src="https://dummyimage.com/400x400/000/fff&text=image" alt="tes" class="img-fluid img-responsive img-thumbnail figure-img" id="preview">
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-block btn-primary btn-sm d-flex justify-content-center align-items-center">
                    <svg class="c-icon">
                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-image-plus') }}"></use>
                    </svg>
                    <span> Gambar</span>
                  </button>
                </div>
                <div class="col-6">
                  <button class="btn btn-block btn-primary btn-sm d-flex justify-content-center align-items-center">
                    <svg class="c-icon">
                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-video') }}"></use>
                    </svg>
                    <span> Video</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <small class="btn-link" style="cursor: pointer; font-weight: bold;">Tampilkan lainnya</small>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content-->
  </div>
  <!-- /.modal-dialog-->
</div>
@endsection