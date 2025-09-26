<!DOCTYPE html>
<html lang="en">
<head>
  
  @include('layout/_partials/head')
  
  <script>
    /*to prevent Firefox FOUC, this must be here*/
    let FF_FOUC_FIX;
  </script>
</head>

<body>
 
  <div id="app">
    <div class="main-wrapper">

      @guest
          @yield('auth')
      @endguest
      
      @auth
          
     
      {{-- Top Bar --}}
      
      @include('layout/_partials/topbar')
      
      {{-- End of Top Bar --}}
      


      {{-- Side bar --}}

      @include('layout/_partials/sidebar')

      {{-- End of Side Bar --}}



      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          {{-- <div class="section-header">
            <h1>@yield('title-body')</h1>
          </div> --}}
          @yield('konten-header')

          <div class="section-body">
            
            @yield('konten-main')
            
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          {{-- Copyright &copy; 2024 <div class="bullet"></div>Web By Agung Dwi Pratama & Stisla Template Design By <a href="https://nauv.al/">Muhamad Nauval Azhar</a> --}}
        </div>
        <div class="footer-right">
          
        </div>
      </footer>

      @endauth
    </div>
  </div>

  <!-- General JS Scripts -->
  
 {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
  <script src="{{ asset('/library/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('/library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
  

  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->


  @stack('scripts')
</body>
</html>
