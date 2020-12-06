@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span>Daftar Pajak</span>
              <button class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#myModal">
                <svg class="c-icon">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}"></use>
                </svg>
                <span>Tambah pajak</span>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-8 col-md-6">
                  <div class="form-group">
                    <label for="search_pajak" class="sr-only">Nama Pajak</label>
                    <input type="text" name="search_pajak" id="search_pajak" placeholder="Cari Data Pajak" class="form-control">
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
                    <th>Nama Pajak</th>
                    <th style="width: 30%">Nama Barang</th>
                    <th style="width: 30%">Persentase Pajak</th>
                    <th style="width: 10%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listTaxes">
                  
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
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pajak</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formAddTax" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_pajak">Nama Pajak *</label>
                <div class="row">
                  <div class="col-6 col-md-12">
                    <input type="text" name="nama_pajak" id="nama_pajak" class="form-control">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="nama_barang">Nama Barang *</label>
                  <small><a href="{{ route('managementBarang') . "?redirect=" . route('managementPajak') }}" class="btn-link">Tambah Barang</a></small>
                </div>
                <select name="nama_barang" id="nama_barang" class="form-control" style="width: 100%">
                  
                </select>
              </div>
              <div class="form-group">
                <label for="persentase_pajak">Persentase Pajak *</label>
                <input type="text" name="persentase_pajak" id="persentase_pajak" class="form-control">
              </div>

            </div>
            <div class="col-md-4">
              <div class="row mb-2">
                <div class="col-12">
                  <ul class="pgwSlider">

                  </ul>
                </div>
              </div>
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

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    // const detailSuplierUrl = '{{ route('managementSuplier'). '/detail' }}'
  </script>
  <script src="{{ asset('js/managements/pajak/index.js') }}"></script>
@endsection