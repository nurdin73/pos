<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.2.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Point of sale by nurdin rittercoding">
    <meta name="author" content="nurdin">
    <meta name="keyword" content="pos,point of sales, kasir">
    <title>Error 403</title>
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
  </head>
  <body class="c-app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">403</h1>
            <h4 class="pt-3">{{ $exception->getMessage() == "locked" ? "Terkunci!" : "Unauthorized!" }}</h4>
            <p class="text-muted">{{ $exception->getMessage() == "locked" ? "Akun ini terkunci. silahkan masukan password untuk membukanya" : "Anda tidak dapat mengakses halaman ini " }}</p>
            @if ($exception->getMessage() == "locked")
              <form action="#" id="authLocked">
                <div class="input-prepend input-group">
                  <input class="form-control" id="prependedInput" size="16" type="password" name="password" placeholder="masukkan password"><span class="input-group-append">
                  <button class="btn btn-info" type="submit">Authentikasi</button></span>
                </div>
              </form>
            @else
              <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Kembali</a>
            @endif
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
      $('#authLocked').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: "put",
          url: '{{ url('api/v1/settings/update/locked') }}',
          data: $(this).serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization' : "Bearer " + sessionStorage.getItem('token')
          },
          success: function (response) {
            toastr.success(response.message, 'Success')
            setTimeout(() => {
              window.location.reload()
            }, 1500);
          },
          error:function(err) {
            toastr.error(err.responseJSON.message, 'Error')
          }
        });
      })
    </script>
  </body>
</html>