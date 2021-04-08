@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}"/>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            Backup databases
          </div>
          <div class="card-body">
            <form action="#" id="exportDB">
              <div class="form-group">
                <label for="namefile">Nama backup</label>
                <input type="text" name="namefile" id="namefile" class="form-control" placeholder="Ex. backup-jumat">
              </div>
              <div class="form-group">
                <button class="btn btn-sm btn-primary">Backup Databases</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            List export databases
          </div>
          <div class="card-body">
            <form action="#" id="filteringData">
              <div class="row">
                <div class="col-6 col-md-3">
                  <div class="form-group">
                    <label for="search_pengexport" class="sr-only">Pengexport</label>
                    <input type="text" name="search_pengexport" id="search_pengexport" placeholder="Cari Pengexport(optional)" class="form-control">
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="form-group">
                    <label for="search_waktu_export" class="sr-only">Cari waktu</label>
                    <input type="text" name="search_waktu_export" id="search_waktu_export" placeholder="Cari waktu(optional)" class="form-control">
                  </div>
                </div>
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
            <table class="table table-striped table-borderless">
              <thead>
                <tr>
                  <th>Pengexport</th>
                  <th>Nama file export</th>
                  <th>Waktu export</th>
                  <th style="width: 5%">actions</th>
                </tr>
              </thead>
              <tbody id="listExported">
                
              </tbody>
            </table>
            <div id="pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  {{-- <script src="https://kit.fontawesome.com/b10279cbf9.js" crossorigin="anonymous"></script> --}}
  <script>
    const urlExport = '{{ route('exportDatabases') }}' 
    const urlListExport = '{{ route('getListDatabaseExport') }}'
    const baseUrl = '{{ url('') }}'
  </script>
  <script src="{{ asset('js/daterangepicker.js') }}"></script>
  <script src="{{ asset('js/settings/database.js') }}"></script>
@endsection