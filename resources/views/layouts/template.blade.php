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
    <title>POS</title>
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">

    {{-- 3rd PARTY --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" integrity="sha512-EOY99TUZ7AClCNvbnvrhtMXDuWzxUBXV7SFovruHvYf2dbvRB5ya+jgDPk5bOyTtZDbqFH3PTuTWl/D7+7MGsA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.css" integrity="sha512-0Wjihk3d5C3yp6MThcWP1WxttnKS1IWsfDf6Jd6ETz7c4QLO3SZSmqW04wDysN2Q1/QqEmJ5XFWc/p53B5ME0g==" crossorigin="anonymous" />
  </head>
  <body class="c-app">
    
    @include('components.sidebar')

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

    @yield('modal')
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->

    {{-- 3rd PARTY --}}

    {{-- ladda --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js" integrity="sha512-fK8kfclYYyRUN1KzdZLVJrAc+LmdsZYH+0Fp3TP4MPJzcLUk3FbQpfWSbL/uxh7cmqbuogJ75pMmL62SiNwWeg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.jquery.min.js" integrity="sha512-9pDK1QtjyYU3QU0NU3+kZ6TrxsMJISp9qxRXDN3Ali+pZPJzxDJL1jc6oQuLoAtve6Pc+KUDy6QJajimBKxfYg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js" integrity="sha512-FzwLmClLNd77zi/Ke+dYlawHiPBAWhk8FzA4pwFV2a6PIR7/VHDLZ0yKm/ekC38HzTc5lo8L8NM98zWNtCDdyg==" crossorigin="anonymous"></script>
  </body>
</html>