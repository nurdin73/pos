@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/PgwSlider/2.3.0/pgwslider.min.css" integrity="sha512-J1G8iGNI7Vk77uSN3MCVgvfTYdKVmqXhNZRI/QdC4L0S6MRImg40OsfF+N95Hix1n/Mxu7PHvdE1ULW4Hgfxyw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Data Pelanggan</span>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCustomerModal">Tambah Pelanggan</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="dataTables">
                <thead>
                  <tr>
                    <th>NIK</th>
                    <th style="width: 20%">Nama</th>
                    <th style="width: 20%">Email</th>
                    <th style="width: 7%">Point</th>
                    <th style="width: 20%">Actions</th>
                  </tr>
                </thead>
                <tbody>

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
  <div class="modal fade" id="addCustomerModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pelanggan</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form id="formAddCustomer" autocomplete="off">
          <div class="modal-body">
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" name="nik" id="nik" class="form-control">
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" id="nama" class="form-control">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" class="form-control" placeholder="Contoh: contoh@contoh.com">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="no_telp">No Telp</label>
                  <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Contoh: 088111222333">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control"></textarea>
            </div>
            <small class="text-muted">Pastikan alamat email pelanggan terisi dengan benar(email yang telah terimpan tidak dapat diubah)</small>
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


  <div class="modal fade" id="updateCustModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Pelanggan</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form id="formUpdateCustomer" autocomplete="off">
          <input type="hidden" name="id" id="id">
          <div class="modal-body">
            <div class="form-group">
              <label for="update_nik">NIK</label>
              <input type="text" name="update_nik" id="update_nik" class="form-control">
            </div>
            <div class="row">
              <div class="col-6 col-md-9">
                <div class="form-group">
                  <label for="update_nama">Nama</label>
                  <input type="text" name="update_nama" id="update_nama" class="form-control">
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="form-group">
                  <label for="update_point">Point</label>
                  <input type="number" name="update_point" id="update_point" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="update_email">Email</label>
                  <input type="text" name="update_email" id="update_email" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="update_no_telp">No Telp</label>
                  <input type="text" name="update_no_telp" id="update_no_telp" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="update_alamat">Alamat</label>
              <textarea name="update_alamat" id="update_alamat" cols="30" rows="2" class="form-control"></textarea>
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

  <div class="modal fade" id="detailCustModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Pelanggan</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="detail_nik">NIK</label>
            <input type="text" name="detail_nik" id="detail_nik" class="form-control">
          </div>
          <div class="row">
            <div class="col-6 col-md-9">
              <div class="form-group">
                <label for="detail_nama">Nama</label>
                <input type="text" name="detail_nama" id="detail_nama" class="form-control" disabled>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="form-group">
                <label for="detail_point">Point</label>
                <input type="number" name="detail_point" id="detail_point" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="detail_email">Email</label>
                <input type="text" name="detail_email" id="detail_email" class="form-control" disabled>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="detail_no_telp">No Telp</label>
                <input type="text" name="detail_no_telp" id="detail_no_telp" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="detail_alamat">Alamat</label>
            <textarea name="detail_alamat" id="detail_alamat" cols="30" rows="2" class="form-control" disabled></textarea>
          </div>
        </div>
      </div>
      <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
  </div>
@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
  </script>
  <script src="{{ asset('js/managements/customer/index.js') }}"></script>
@endsection