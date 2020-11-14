@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Edit Barang</span>
            <a href="{{ route('managementBarang') }}" class="btn btn-primary btn-sm">
              <svg class="c-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
              </svg>
              Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 