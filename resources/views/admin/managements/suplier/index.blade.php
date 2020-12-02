@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Suplier List</span>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSuplier">Tambah Suplier</button>
          </div>
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-8 col-md-6">
                  <div class="form-group">
                    <label for="search_nama_suplier" class="sr-only">Nama Suplier</label>
                    <input type="text" name="search_nama_suplier" id="search_nama_suplier" placeholder="Cari Nama Suplier" class="form-control">
                  </div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="form-group">
                    <select name="sorting" id="sorting" class="custom-select">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
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
              <table class="table table-borderless table-stripped table-hover">
                <thead>
                  <tr>
                    <th>Suplier</th>
                    <th style="width: 15%">Email</th>
                    <th style="width: 50%">Alamat</th>
                    <th style="width: 10%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listSupliers">
                  
                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end align-items-end">
                <ul class="pagination">
                  
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('modal')
  <!-- Modal -->
  <div class="modal fade" id="addSuplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Suplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formAddSuplier" autocomplete="off">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama_suplier">Nama Suplier *</label>
              <input type="text" name="nama_suplier" id="nama_suplier" class="form-control">
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="email_suplier">Email <sub class="text-muted">Optional</sub> </label>
                  <input type="email" name="email_suplier" id="email_suplier" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="no_telp">No Telp *</label>
                  <input type="text" name="no_telp" id="no_telp" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat *</label>
              <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="updateSuplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Suplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formUpdateSuplier" autocomplete="off">
          <input type="hidden" name="id_sup" id="idSuplier">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama_suplier_update">Nama Suplier *</label>
              <input type="text" name="nama_suplier_update" id="nama_suplier_update" class="form-control">
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="email_suplier_update">Email <sub class="text-muted">Optional</sub> </label>
                  <input type="email" name="email_suplier_update" id="email_suplier_update" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="no_telp_update">No Telp *</label>
                  <input type="text" name="no_telp_update" id="no_telp_update" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="alamat_update">Alamat *</label>
              <textarea name="alamat_update" id="alamat_update" cols="30" rows="3" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const detailSuplierUrl = '{{ route('managementSuplier'). '/detail' }}'
  </script>
  <script src="{{ asset('js/managements/suplier/index.js') }}"></script>
@endsection