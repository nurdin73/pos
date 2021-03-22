@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-body">
            <span class="lead">Toko</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <form action="#" class="position-relative" enctype="multipart/form-data">
                  <img src="https://demo.getstisla.com/assets/img/avatar/avatar-1.png" alt="avatar" class="img-fluid img-thumbnail" id="prevLogo">
                  <input type="file" name="logo" id="logo">
                  <label for="logo" class="logo">Ganti logo</label>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <form id="updateStoreDetail" autocomplete="off">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="jenis_usaha">Jenis Usaha</label>
                        <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="nama_toko">Nama Usaha</label>
                        <input type="text" name="nama_toko" id="nama_toko" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" name="npwp" id="npwp" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="owner">Owner</label>
                        <input type="text" name="owner" id="owner" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="no_telp">No. Telp</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script src="{{ asset('js/jquery-mask.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const BASE_URL = '{{ url('/') }}'
  </script>
  <script src="{{ asset('js/settings/toko.js') }}"></script>
@endsection