@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span>Data Pajak</span>
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
              <div class="row justify-content-end">
                <div class="col-md-2">
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
              <table class="table table-striped table-hover table-condensed" id="dataTables">
                <thead>
                  <tr>
                    <th style="width: 15%">Nama Pajak</th>
                    <th>Nama Barang</th>
                    <th style="width: 15%">Persentase</th>
                    <th align="center" style="width: 20%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listTaxes">
                  
                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-between align-items-center">
                <span class="text-muted">Menampilan <span id="fromData"></span> sampai <span id="toData"></span> dari <span id="totalData"></span> data</span>
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
      <form id="formAddbarang" enctype="multipart/form-data" autocomplete="off">
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
                  <small><a href="{{ route('managementSuplier') . "?redirect=" . route('managementBarang') }}" class="btn-link">Tambah Suplier</a></small>
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
