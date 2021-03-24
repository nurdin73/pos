@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Detail Suplier</span>
            <a href="{{ route('managementSuplier') }}" class="btn btn-sm btn-primary">Kembali</a>
          </div>
          <div class="card-body">
            <div class="row justify-content-between">
              <div class="col-6">
                <div class="d-flex justify-content-start flex-column align-items-start mb-2">
                  <span class="text-primary font-weight-bold">Nama Suplier</span>
                  <span class="text-muted" id="nameSuplier">CV. Jawa Kali</span>
                </div>
                <div class="d-flex justify-content-start flex-column align-items-start mb-2">
                  <span class="text-primary font-weight-bold">Alamat</span>
                  <span class="text-muted" id="addressSuplier">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa, ipsum.</span>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex justify-content-end flex-column align-items-end mb-2">
                  <span class="text-primary font-weight-bold">Email</span>
                  <span class="text-muted" id="emailSuplier">email@email.com</span>
                </div>
                <div class="d-flex justify-content-end flex-column align-items-end mb-2">
                  <span class="text-primary font-weight-bold">No Telp</span>
                  <span class="text-muted" id="noTelpSuplier">0000-0000-0000</span>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="text-center lead">Daftar Barang</div>
            <div class="dropdown-divider"></div>
            <div class="table-responsive">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Barang</th>
                    <th>Terjual</th>
                  </tr>
                </thead>
                <tbody id="listProducts">
                  
                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end">
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

@section('js')
  <script src="{{ asset('js/jquery-mask.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const id = '{{ $id }}'
  </script>
  <script src="{{ asset('js/managements/suplier/detail.js') }}"></script>
@endsection