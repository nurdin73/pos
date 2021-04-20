<?php 
  $url = url()->full(); 
  $explodeUrl = explode('/', $url);
  $settings = DB::table('stores')->select("*")->first();
?>
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
    <meta name="description" content="POS">
    <meta name="author" content="Nurdin">
    <meta name="keyword" content="pos, point of sale">
    @if ((count($explodeUrl) - 3) <= 3)
      <title>{{ ucfirst(Str::slug(explode("?", end($explodeUrl))[0], " ")) ?? ucfirst(Str::slug(end($explodeUrl), " ")) }} - {{ $settings->nama_toko ?? "" }} Point Of Sales</title>
    @else
      <title>{{ ucfirst($explodeUrl[count($explodeUrl) - 2]) }} - {{ $settings->nama_toko ?? "" }} Point Of Sales</title>
    @endif
    {{-- app --}}
    <!-- Main styles for this application-->
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <link rel="preload" href="{{ asset('css/style.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/style.min.css') }}"></noscript>   --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Font --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet"> --}}
    <link rel="shortcut icon" href="{{ asset($settings->logo ?? "") }}" type="image/x-icon">
    {{-- 3rd PARTY --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" integrity="sha512-EOY99TUZ7AClCNvbnvrhtMXDuWzxUBXV7SFovruHvYf2dbvRB5ya+jgDPk5bOyTtZDbqFH3PTuTWl/D7+7MGsA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.css" integrity="sha512-0Wjihk3d5C3yp6MThcWP1WxttnKS1IWsfDf6Jd6ETz7c4QLO3SZSmqW04wDysN2Q1/QqEmJ5XFWc/p53B5ME0g==" crossorigin="anonymous" /> --}}
    {{-- Spinkit --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spinkit/2.0.1/spinkit.min.css" integrity="sha512-kRYkjiYH/VXxoiaDK2oGNMKIi8VQVfie1lkYGX3kmfzWNR2kfaF5ze0885W3/eE6lIiURBsZA91M/WNvCajHMw==" crossorigin="anonymous" /> --}}
    <link rel="stylesheet" href="{{ asset('css/spinkit.css') }}">
    {{-- toastr --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" /> --}}
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/wrapper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    @yield('css')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-5DVJWELFJ3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-5DVJWELFJ3');
    </script> --}}
  </head>
  {{-- <body class="c-app c-dark-theme"> --}}
  <body class="c-app">
    @include('components.sidebar-v2')

    <div class="c-wrapper c-fixed-components">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        @include('components.topbar')
        @include('components.breadcrumb')
      </header>
      <div class="c-body">
        @yield('content')
        @include('components.footer')
      </div>
    </div>

    <div class="loading" style="display: none">
      <div class="sk-wave">
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
      </div>
    </div>

    @yield('modal')
    <!-- Modal -->
    <div class="modal fade" id="lockAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" id="lockAccount">
            <div class="modal-body">
              <div class="form-group">
                <label for="password">Masukkan password</label>
                <input type="password" name="password" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Verifikasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- Jquery CDN --}}
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->

    {{-- 3rd PARTY --}}

    {{-- ladda --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js" integrity="sha512-fK8kfclYYyRUN1KzdZLVJrAc+LmdsZYH+0Fp3TP4MPJzcLUk3FbQpfWSbL/uxh7cmqbuogJ75pMmL62SiNwWeg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.jquery.min.js" integrity="sha512-9pDK1QtjyYU3QU0NU3+kZ6TrxsMJISp9qxRXDN3Ali+pZPJzxDJL1jc6oQuLoAtve6Pc+KUDy6QJajimBKxfYg==" crossorigin="anonymous"></script> --}}
    
    {{-- <script src="https://kit.fontawesome.com/b10279cbf9.js" crossorigin="anonymous"></script> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js" integrity="sha512-FzwLmClLNd77zi/Ke+dYlawHiPBAWhk8FzA4pwFV2a6PIR7/VHDLZ0yKm/ekC38HzTc5lo8L8NM98zWNtCDdyg==" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/laddaspin.js') }}"></script>
    {{-- Toastr --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
      $(function () {
        var dark = localStorage.getItem('theme');
        if(dark == "true") {
          console.log('masuk sini');
          $('.c-app').removeClass('c-dark-theme');
          $('.changeTheme').html(`<svg class="c-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-moon') }}"></use>
          </svg>`)
        } else {
          $('.c-app').addClass('c-dark-theme');
          $('.changeTheme').html(`<svg class="c-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-sun') }}"></use>
          </svg>`)
        }
        $('[data-toggle="tooltip"]').tooltip()
        $('.changeTheme').on('click', function(e) {
          // $(this).empty()
          e.preventDefault()
          if(dark == "true") {
            $('.c-app').addClass('c-dark-theme');
            localStorage.setItem('theme', "false");
            dark = localStorage.getItem('theme');
            $(this).html(`<svg class="c-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-sun') }}"></use>
            </svg>`)
          } else {
            $('.c-app').removeClass('c-dark-theme');
            localStorage.setItem('theme', "true")
            dark = localStorage.getItem('theme')
            // $(this).empty()
            $(this).html(`<svg class="c-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-moon') }}"></use>
            </svg>`)
          }
        })
        toastr.options = {
          "progressBar": true,
        }
      });
      $('#lockAccount').on('submit', function(e) {
        e.preventDefault()
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
    {{-- Templates --}}
    @yield('js')
  </body>
</html>