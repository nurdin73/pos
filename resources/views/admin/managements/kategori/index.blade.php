@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Data Kategori</span>
            <button class="btn btn-sm btn-primary" data-target="#addCategoryModal" data-toggle="modal">Tambah kategori</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover table-bordered" id="dataTables">
                <thead>
                  <tr>
                    <th style="width: 90%">Nama kategori</th>
                    <th>Aksi</th>
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
<div class="modal fade" id="addCategoryModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah kategori</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formAddKategori" autocomplete="off">
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control">
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

<div class="modal fade" id="updateCategoryModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update kategori</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formUpdateCategory" autocomplete="off">
        <input type="hidden" name="id_kategori" id="id_kategori">
        <div class="modal-body">
          <div class="form-group">
            <label for="update_name">Nama Kategori</label>
            <input type="text" name="update_name" id="update_name" class="form-control">
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
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/jquery-datatables.js') }}"></script>
  <script src="{{ asset('js/datatable-bs4.js') }}"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
  </script>
  <script src="{{ asset('js/managements/kategori/index.js') }}"></script>
@endsection