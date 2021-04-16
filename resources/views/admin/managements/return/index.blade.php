@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Return barang</span>
            <button class="btn btn-sm btn-primary">Tambah barang return</button>
          </div>
          <div class="card-body">
            <form action="#" id="filterData">
              <div class="row">
                <div class="col-9 col-md-6">
                  <div class="form-group">
                    <label for="search" class="sr-only">Cari staff</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari barang..">
                  </div>
                </div>
                <div class="col-3 col-md-2">
                  <div class="form-group">
                    <label for="sorting" class="sr-only">Sorting</label>
                    <select name="sorting" id="sorting" class="custom-select">
                      <option value="10">10</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="250">250</option>
                      <option value="500">500</option>
                    </select>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <label for="filter" class="sr-only">Filter</label>
                    <button type="submit" class="btn btn-primary btn-block" id="filter">Filter</button>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group">
                    <label for="reset" class="sr-only">reset</label>
                    <button type="reset" class="btn btn-warning btn-block" id="reset">reset</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th>Nama barang</th>
                    <th style="width: 10%" class="text-center">Qty</th>
                    <th style="width: 10%" class="text-center">status</th>
                    <th style="width: 10%" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="listReturnProd">
                  
                </tbody>
              </table>
              <div class="paginate"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/managements/return/index.js') }}"></script>
@endsection