@extends('layout.app')
@push('styles')
 
@endpush

@section('konten-header')
    <div class="section-header">
      <h1>Detail Absensi</h1>
    </div>
@endsection

@section('konten-main')
    <div class="card">
      <div class="card-header">
        <h4>Absensi</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
              <div class="card bg-success text-white">
                <div class="card-body">
                  <h5>Jumlah Hadir</h5>
                  -
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card bg-warning text-white">
                <div class="card-body">
                  <h5>Jumlah Izin</h5>
                 -
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card bg-info text-white">
                <div class="card-body">
                  <h5>Jumlah Sakit</h5>
                  - 
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card bg-danger text-white">
                <div class="card-body">
                  <h5>Jumlah Absen</h5>
                  -
                </div>
              </div>
            </div>
      </div>
        <div >
          <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')

<script>

  document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
          // initialView: 'dayGridMonth',
          initialView: window.matchMedia("(max-width: 768px)").matches ? 'listWeek' : 'dayGridMonth',
          events: '/api/absensi',
          headerToolbar: {
              start: 'title',
              center: '',
              end: 'dayGridMonth,listWeek'
          },
          footerToolbar: {
              start: '',
              center: '',
              end: 'prev,next today'
          },
          eventDidMount: function(info, element) {
          // // Jika Anda ingin menambahkan logika tambahan saat event dimuat
          // if (info.event.extendedProps.status === 'Absen') {
              info.el.style.backgroundColor = '#f0f8ff';
              info.el.style.color = 'black';
          // }
      }
     

      });
      calendar.render();

  });

</script>

<!-- Page Specific JS File -->
{{-- <script src="{{ asset('/assets/js/page/modules-calendar.js') }}"></script> --}}
    
@endpush