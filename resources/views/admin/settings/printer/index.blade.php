@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Setting Printer</span>
            <button type="button" class="btn btn-sm btn-success">Test Connection</button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <form action="#">
                  <div class="form-group">
                    <label for="os">Sistem Operasi</label>
                    <select name="os" id="os" class="custom-select">
                      <option value="windows">Windows</option>
                      <option value="linux">Linux</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="printer_name">Nama Printer</label>
                    <input type="text" name="printer_name" id="printer_name" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 