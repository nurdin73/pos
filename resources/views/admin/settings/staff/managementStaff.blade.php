@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">List Staff</span>
            <button class="btn btn-sm btn-primary" data-target="#addStaffModal" data-toggle="modal">Tambah Staff</button>
          </div>
          <div class="card-body">
            <form action="#" id="filterData">
              <div class="row">
                <div class="col-9 col-md-6">
                  <div class="form-group">
                    <label for="nama_staff" class="sr-only">Nama Staff</label>
                    <input type="text" name="nama_staff" id="nama_staff" class="form-control" placeholder="Nama staff">
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
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="text-align: center">Nama Staff</th>
                    <th style="width: 15%">No Telp</th>
                    <th style="width: 15%">Jabatan</th>
                    <th style="width: 12%; text-align:center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Nurdin</td>
                    <td>0832423412</td>
                    <td><span class="badge badge-primary">Halo</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-book"></i></button>
                        <button class="btn btn-sm btn-info"><i class="fas fa-trash"></i></button>
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
  <!-- Modal -->
  <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="addStaffForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="email_staff">Email Staff</label>
              <input type="text" name="email_staff" id="email_staff" class="form-control">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_staff">Nama Staff</label>
                  <input type="text" name="nama_staff" id="nama_staff" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="no_telp_staff">No Telp</label>
                  <input type="text" name="no_telp_staff" id="no_telp_staff" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jabatan">Jabatan Staff</label>
                  <select name="jabatan" id="jabatan" class="custom-select">
                    <option value="kasir">Kasir</option>
                    <option value="manager">Manager</option>
                    <option value="administrator">Administrator</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">Password Staff</label>
                  <input type="password" name="password" id="password" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/settings/staff.js') }}"></script>
@endsection