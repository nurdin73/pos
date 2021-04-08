@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
@endsection

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
                    <label for="search" class="sr-only">Cari staff</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari staff..">
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
                    <th style="width: 15%">Email</th>
                    <th style="width: 15%">No Telp</th>
                    <th style="width: 15%">Jabatan</th>
                    <th style="width: 12%; text-align:center">Aksi</th>
                  </tr>
                </thead>
                <tbody id="listStaffs">
                  
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

@section('modal')
  <!-- Modal -->
  <div class="modal fade" id="addStaffModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="addStaffForm" autocomplete="off">
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
            <div class="form-group">
              <label for="jabatan">Jabatan Staff</label>
              <select name="jabatan" id="jabatan" class="custom-select"  style="width: 100%">
                
              </select>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control"></textarea>
            </div>
            <div class="alert alert-info">
              <h5 class="alert-heading">Perhatian!</h5>
              <p>Untuk staff baru. login menggunakan password : "<strong>password</strong>". tolong update pada saat pertama kali login</p>
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

  <!-- Modal -->
  <div class="modal fade" id="updateStaff" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="updateStaffForm" autocomplete="off">
          <input type="hidden" name="idStaff" id="idStaff">
          <div class="modal-body">
            <div class="form-group">
              <label for="update_email_staff">Email Staff</label>
              <input type="text" name="update_email_staff" id="update_email_staff" class="form-control">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="update_nama_staff">Nama Staff</label>
                  <input type="text" name="update_nama_staff" id="update_nama_staff" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="update_no_telp_staff">No Telp</label>
                  <input type="text" name="update_no_telp_staff" id="update_no_telp_staff" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="update_jabatan">Jabatan Staff</label>
              <select name="update_jabatan" id="update_jabatan" class="custom-select"  style="width: 100%">
                
              </select>
            </div>
            <div class="form-group">
              <label for="update_alamat">Alamat</label>
              <textarea name="update_alamat" id="update_alamat" cols="30" rows="2" class="form-control"></textarea>
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
  <script src="{{ asset('js/jquery-mask.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script src="{{ asset('js/select2.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/settings/staff.js') }}"></script>
@endsection