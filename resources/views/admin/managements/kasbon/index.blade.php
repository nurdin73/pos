@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap4-select2-theme@1.0.3/src/css/bootstrap4-select2-theme.css">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-6 col-lg-6">
            <div class="card overflow-hidden">
              <div class="card-body p-0 d-flex align-items-center">
                <div class="bg-primary p-4 mfe-3">
                  <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-clipboard') }}"></use>
                  </svg>
                </div>
                <div>
                  <div class="text-value text-primary" id="totalKasbon">Rp. 1000 ,-</div>
                  <div class="text-muted text-uppercase font-weight-bold small">Total Kasbon</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-6">
            <div class="card overflow-hidden">
              <div class="card-body p-0 d-flex align-items-center">
                <div class="bg-primary p-4 mfe-3">
                  <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-swap-horizontal') }}"></use>
                  </svg>
                </div>
                <div>
                  <div class="text-value text-primary" id="totalTransaksi">1</div>
                  <div class="text-muted text-uppercase font-weight-bold small">Total transaksi</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Data Kasbon</span>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahKasbon">Tambah Kasbon</button>
          </div>
          <div class="card-body">
            <form id="filterData">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="nama" id="nama" placeholder="Cari Nama (optional)" class="form-control">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="text" name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh Tempo (optional)" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <button class="btn btn-primary btn-block">Cari</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama Pelanggan</th>
                    <th>Jumlah</th>
                    <th>Tanggal Tempo</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="listData">

                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end">
                <ul class="pagination">
                  {{-- <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li> --}}
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
  <div class="modal fade" id="tambahKasbon" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Kasbon</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form id="formAddKasbon" autocomplete="off">
          <input type="hidden" name="id_kategori" id="id_kategori">
          <div class="modal-body">
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <small><a href="{{ route('managementPelanggan') . "?redirect=" . route('managementKasbon') }}" class="btn-link">Tambah Pelanggan</a></small>
              </div>
              <select name="nama_pelanggan" id="nama_pelanggan" class="form-control"></select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jumlah">Jumlah Kasbon</label>
                  <input type="text" name="jumlah" id="jumlah" placeholder="Rp. " class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jatuh_tempo">Jatuh Tempo</label>
                  <input type="text" name="jatuh_tempo" id="jatuh_tempo" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
  </script>
  <script src="{{ asset('js/managements/kasbon/index.js') }}"></script>
@endsection