@extends('layouts.template')

@section('css')
  <style>
    .page-link { cursor: pointer !important; }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Cabang List</span>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBranchStoreModal">Tambah Cabang</button>
          </div>
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-8 col-md-6">
                  <div class="form-group">
                    <label for="search_cabang" class="sr-only">Nama Cabang</label>
                    <input type="text" name="search_cabang" id="search_cabang" placeholder="Cari cabang" class="form-control">
                  </div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="form-group">
                    <select name="sorting" id="sorting" class="custom-select">
                      <option value="10">10</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="150">150</option>
                    </select>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <button type="reset" class="btn btn-warning btn-block btn-reset">Reset</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 20%">Nama Cabang</th>
                    <th style="width: 15%">No Telp</th>
                    <th>Alamat</th>
                    <th style="width: 10%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listCabang">
                  
                </tbody>
              </table>
              <div class="paginate d-flex justify-content-end">

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
  <div class="modal fade" id="addBranchStoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Cabang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="formAddbranchStore">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama_cabang">Nama Cabang</label>
              <input type="text" name="nama_cabang" id="nama_cabang" class="form-control">
            </div>
            <div class="form-group">
              <label for="no_telp">No Telp</label>
              <input type="text" name="no_telp" id="no_telp" class="form-control">
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="updateBranchStoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Cabang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="formUpdatebranchStore">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama_cabang_update">Nama Cabang</label>
              <input type="text" name="nama_cabang_update" id="nama_cabang_update" class="form-control">
            </div>
            <div class="form-group">
              <label for="no_telp_update">No Telp</label>
              <input type="text" name="no_telp_update" id="no_telp_update" class="form-control">
            </div>
            <div class="form-group">
              <label for="alamat_update">Alamat</label>
              <textarea name="alamat_update" id="alamat_update" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="detailBranchStoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Cabang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_cabang_detail">Nama Cabang</label>
            <input type="text" name="nama_cabang_detail" id="nama_cabang_detail" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="no_telp_detail">No Telp</label>
            <input type="text" name="no_telp_detail" id="no_telp_detail" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="alamat_detail">Alamat</label>
            <textarea name="alamat_detail" id="alamat_detail" cols="30" rows="2" class="form-control" readonly></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/jquery-mask.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const thisUrl = '{{ route('managementCabang') }}'
  </script>
  <script src="{{ asset('js/managements/cabang/index.js') }}"></script>
@endsection