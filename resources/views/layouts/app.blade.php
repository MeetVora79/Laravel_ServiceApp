<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-social/bootstrap-social.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css')}}">
  @stack('styles')
</head>

<body>
  <div id="app">
    @yield('content')

  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('backend/assets/js/custom.js')}}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  @if (session('success'))
  <script>
    swal("{{ session('success') }}");
  </script>
  @endif

  @if (session('error'))
  <script>
    swal("{{ session('error') }}");
  </script>
  @endif

  @if (session('info'))
  <script>
   swal("Information", "{{ session('info') }}", "info");
  </script>
  @endif
  
  @stack('scripts')
</body>

</html>