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
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formAddbarang">
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
            <div class="col-md-4">
              <img src="https://dummyimage.com/400x400/000/fff&text=image" alt="tes" class="img-fluid img-responsive img-thumbnail figure-img" id="preview">
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-block btn-primary btn-sm d-flex justify-content-center align-items-center" type="button">
                    <svg class="c-icon">
                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-image-plus') }}"></use>
                    </svg>
                    <span> Gambar</span>
                  </button>
                </div>
                <div class="col-6">
                  <button class="btn btn-block btn-primary btn-sm d-flex justify-content-center align-items-center" type="button">
                    <svg class="c-icon">
                      <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-video') }}"></use>
                    </svg>
                    <span> Video</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
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
                  <input type="text" name="satuan" id="satuan" class="form-control">
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
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/managements/barang.js') }}"></script>
@endsection