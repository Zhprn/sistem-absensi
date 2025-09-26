  <meta charset="UTF-8">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Aplikasi Pegawai &mdash; @yield('konten-title')</title>

  <!-- General CSS Files -->

  <link rel="stylesheet" href="{{ asset('/library/bootstrap/dist/css/bootstrap.min.css') }}">
 {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
  
  {{-- <link rel="stylesheet" href="{{ asset('/library/font-awesome/css/font-awesome.min.css') }}"> --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/skins/reverse.css') }}">

  {{-- select 2 --}}
  <link rel="stylesheet" href="{{ asset('/library/select2/dist/css/select2.min.css') }}">

  {{-- time picker --}}
  <link rel="stylesheet" href="{{ asset('/library/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">

  <!-- include summernote css/js -->
  <link rel="stylesheet" href="{{ asset('/library/summernote/dist/summernote-bs4.css') }}">

  {{-- Data Table --}}
  <link rel="stylesheet" href="{{ asset('/library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

  {{-- Jqeury --}}
  <script src="{{ asset('/library/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('/library/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('/library/bootstrap/dist/js/bootstrap.min.js') }}"></script>

  {{-- Select 2 --}}
  <script src="{{ asset('/library/select2/dist/js/select2.full.min.js') }}"></script>

  {{-- time picker --}}
  <script src="{{ asset('/library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('/library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
 

  <!-- include summernote css/js -->
  <script src="{{ asset('/library/summernote/dist/summernote-bs4.js') }}"></script>

  {{-- Cleave --}}
  <script src="{{ asset('/library/cleave.js/dist/cleave.min.js') }}"></script>
  <script src="{{ asset('/library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
  
  {{-- Full Calendar --}}
  {{-- <link rel="stylesheet" href="{{ asset('/library/fullcalendar/dist/fullcalendar.min.css') }}">
  <script src="{{ asset('/library/fullcalendar/dist/fullcalendar.min.js') }}"></script> --}}
  {{-- <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

  {{-- Data Table --}}
  <script src="{{ asset('/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('/library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src=" {{ asset('/library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

  @stack('styles')