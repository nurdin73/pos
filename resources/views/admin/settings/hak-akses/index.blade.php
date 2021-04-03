@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            Hak akses
          </div>
          <div class="card-body">
            <form action="#" id="filterData">
              <div class="row">
                <div class="col-9 col-md-6">
                  <div class="form-group">
                    <label for="search" class="sr-only">Nama Jabatan</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Nama jabatan">
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
                    <th class="text-center">Jabatan</th>
                    <th style="width: 15%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="listRoleAccess">
                  
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
  <div class="modal fade" id="checkAksesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">change akses menu user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-borderless table-striped">
              <thead>
                <tr>
                  <th>Menu</th>
                  <th style="width: 20%" class="text-center">Is Granted</th>
                </tr>
              </thead>
              <tbody id="listMenu">
                
              </tbody>
            </table>
            <div class="paginateMenu"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/settings/roleAccess.js') }}"></script>
@endsection