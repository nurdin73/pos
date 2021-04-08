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
    .btn-del-loyal {
      position: absolute;
      right: 5px;
      top: 5px;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="font-weight-bold text-muted">Loyality Program</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addLoyalityModal">Tambah Hadiah</button>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row" id="listLoyality">
          
        </div>
        <div class="paginate"></div>
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

  <!-- Modal -->
  <div class="modal fade" id="addLoyalityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Loyality</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="addLoyalityForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Nama Loyality *</label>
              <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="stock">Stock *</label>
                  <input type="number" name="stock" id="stock" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="point">Point *</label>
                  <input type="number" name="point" id="point" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="form-group">
                  <label for="codePoint">Kode Loyality *</label>
                  <input type="text" name="codePoint" id="codePoint" class="form-control">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="generate">&nbsp;</label>
                  <button type="button" name="generate" id="generate" class="btn btn-block btn-primary">Generate</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="category">Kategori *</label>
              <select style="width: 100%" name="category" id="category" class="custom-select">

              </select>
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label for="image">Gambar</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="image" aria-describedby="image">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="preview">Preview</label>
              <img src="{{ asset('assets/img/assets/no_img.png') }}" alt="asd" id="preview" class="img-fluid img-thumbnail">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection


@section('js')
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const URL_NO_IMAGE = '{{ asset('assets/img/assets/no_img.png') }}'
  </script>
  <script src="{{ asset('js/managements/loyality/index.js') }}"></script>
@endsection