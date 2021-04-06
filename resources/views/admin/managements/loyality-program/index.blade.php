@extends('layouts.template')

@section('css')
  <style>
    .thumbnail-point {
      height: 130px;
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
    }
    .captions {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
    }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="font-weight-bold text-muted">Loyality Program</h3>
          <button class="btn btn-sm btn-primary">Tambah Hadiah</button>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
          <div class="col-md-3">
            <div class="card thumbnail-point position-relative" style="overflow: hidden; background-image: url('{{ asset('assets/img/assets/no_img.png') }}')">
              <div class="bg-dark p-2 captions d-flex justify-content-between align-items-center">
                <a href="#" class="text-white card-link font-weight-bold stretched-link" data-toggle="modal" data-target="#descriptionVoucher">Title</a>
                <small>200 Point</small>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card thumbnail-point position-relative" style="overflow: hidden; background-image: url('https://dummyimage.com/600x400/000/fff')">
              <div class="bg-dark p-2 captions d-flex justify-content-between align-items-center">
                <a href="#" class="text-white card-link font-weight-bold stretched-link" data-toggle="modal" data-target="#descriptionVoucher">Title</a>
                <small>200 Point</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('modal')
  <!-- Modal -->
  <div class="modal fade" id="descriptionVoucher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection