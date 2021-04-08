@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Setting Printer</span>
            <button class="btn btn-sm btn-success" id="testConnection">Test Connection</button>
          </div>
          <div class="card-body">
            <form action="#" id="settingPrinter">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="os">Sistem Operasi</label>
                    <select name="os" id="os" class="custom-select">
                      <option value="windows">Windows</option>
                      <option value="linux">Linux</option>
                      <option value="mac">Mac</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="koneksi">Koneksi</label>
                    <select name="koneksi" id="koneksi" class="custom-select">
                      <option value="usb">USB</option>
                      <option value="ethernet">Ehternet</option>
                      <option value="bluetooth">Bluetooth(belum dicoba)</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name_printer">Nama/lokasi Printer</label>
                    <input type="text" name="name_printer" id="name_printer" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
              </div>
            </form>
            <div class="dropdown-divider"></div>
            <p class="text-muted font-weight-bold">* Penting</p>
            <ul>
              <li><strong>Sistem Operasi</strong> pilih sesuai sistem operasi yang digunakan oleh komputer</li>
              <li><strong>Koneksi</strong> jika memilih sistem operasi <strong>Windows /  Mac</strong> maka pastikan printer thermal sudah di sharing terlebih dahulu. lalu copy nama sharing printernya dan masukkan nama printer di kolom yang sudah disediakan</li>
              <li><strong>Nama / lokasi printer</strong> jika memilih sistem operasi linux dan memilih koneksi via USB. masukkan lokasi usb seperti <strong>dev/usb/lp1</strong>. namun jika memilih enthernet. silahkan masukkan IP server printer yang telah disharing</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
    <script>
      const BASE_URL_API = '{{ url('api/v1') }}'
    </script>
    <script src="{{ asset('js/settings/printer.js') }}"></script>
@endsection