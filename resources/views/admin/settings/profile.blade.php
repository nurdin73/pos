@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                      <span class="text-primary font-weight-bold text-uppercase">Nama</span>
                      <span class="text-muted" id="nameUser"></span>
                      <span class="text-primary font-weight-bold text-uppercase">Email</span>
                      <span class="text-muted" id="emailUser"></span>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                      <span class="text-primary font-weight-bold text-uppercase">Role</span>
                      <span class="badge badge-info" id="roleUser"></span>
                      <span class="text-primary font-weight-bold text-uppercase">Alamat</span>
                      <span class="text-muted" id="addressUser"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <span>Ganti profile</span>
              </div>
              <div class="card-body">
                <form id="updateProfile" enctype="multipart/form-data">
                  <input type="hidden" name="id_user" id="id_user">
                  <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">nama</label>
                    <div class="col-sm-10">
                      <input type="text" name="nama" class="form-control" id="nama">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="email" class="form-control" id="email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                      <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <span class="lead">Ganti password</span>
              </div>
              <div class="card-body">
                <form id="changePass">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="password_lama">Password Lama</label>
                        <input type="password" name="password_lama" id="password_lama" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
  </script>
  <script src="{{ asset('js/settings/profile.js') }}"></script>
@endsection