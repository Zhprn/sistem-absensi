@extends('layout.app')
@section('konten-title', 'Data Absensi')

@push('style')
  
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

  

@endpush

@section('konten-header')
<div class="section-header" >
  <h1>Rekap Data Absensi</h1>
</div>
@endsection

@section('konten-main')
    <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Absensi Minggu Ini</h4>
              <div class="card-header-action">
                <div>
                  <form action="{{ route('export-absensi-minggu') }}" method="get" target="_blank">
                    <input type="hidden" name="start_date" value="{{ $weekInputPdf }}">
                    <button class="btn btn-outline-info"><i class="fa fas fa-print"></i> Cetak Laporan</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form action="#" method="get">
              <H5>Filter : </H5>
              <div class="form-group row">
                <div class="col-sm-4">
                    <label for="nip" class="col-form-label">Minggu Ke :</label>
                    <select class="custom-select form-control" name="weekInputs" id="week">
                          <option selected disabled>Pilih Minggu</option>
                          @foreach($weeks as $week)
                                <option value="{{ $week['value'] }}">{{ $week['label'] }}</option>
                          @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="jabatan" class="col-form-label">Jabatan</label>
                    <div class="input-group mb-3">
                      <select class="custom-select form-control" name="jabatan">
                          <option selected disabled>Jabatan</option>
                          @foreach($jabatan as $data_jabatan)
                            <option value="{{ $data_jabatan->id }}">{{ $data_jabatan->jabatan }}</option>
                          @endforeach
                      </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="bagian" class="col-form-label">Bagian</label>
                    <select class="custom-select form-control" name="bagian">
                      <option selected disabled>Bagian</option>
                        @foreach($bagian as $data_bagian)
                          <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                        @endforeach
                  </select>
                </div>
                </div>

                <div class="row">                  
                    <div class="col-md-4 ">                     
                        <div class="input-group">
                          <input type="text" name="cari_pegawai" placeholder="Cari Pegawai.." class="form-control">
                          <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fa fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                  </div>
                </form>
                
                <div class="d-flex justify-content-end">
                  Minggu Ke : {{ $weekInputStatus }}
                </div>

                <div class="table-responsive mt-2">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                       
                        <th class="text-center">
                          #
                        </th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th>Bagian</th>
                        @foreach($data as $no=>$dataP)
                        <th>{{ $dataP }}</th>
                        @endforeach
  
                        @foreach (['H', 'T', 'I', 'S', 'A'] as $_st)
                          <th scope="col">
                            {{ $_st }}
                          </th>
                        @endforeach
                        
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $no=>$dataP)
                          {{-- @foreach($dataP->attendances as $dataA) --}}
                          <tr>
                            <td class="text-center">{{ $no+1 }}</td>
                            <td>{{ $dataP->nip }}</td>
                            <td>{{ $dataP->nama_pegawai }}</td>
                            <td>{{ $dataP->jabatan->jabatan }}</td>
                            <td>{{ $dataP->bagian->bagian }}</td>
                              @php
                                $presentCount = 0;
                                $lateCount = 0;
                                $excusedCount = 0;
                                $sickCount = 0;
                                $absentCount = 0;
                              @endphp
                              @foreach($data as $date)
                               
                                @php
                                // Mencari sttus absensi untuk tanggal tertentu
                                // $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                                // Mengubah format tanggal untuk perbandingan
                                  $currentDate = \Carbon\Carbon::createFromFormat('d/m', $date)->format('Y-m-d');
                                  $dayOfWeek = \Carbon\Carbon::createFromFormat('Y-m-d', $currentDate)->dayOfWeek; // 0 = Minggu, 6 = Sabtu
                                 
                                @endphp
                              <td>  
                                @if ($dayOfWeek == 0 || $dayOfWeek == 6)
                                    <!-- Jika hari Minggu (0) atau Sabtu (6), tampilkan output khusus -->
                                    -
                                @else
                                    
                                    @php
                                        $attendance = $dataP->attendances->firstWhere('formatted_date', $date);
                                    @endphp
                                    @if ($attendance)
                                      @switch($attendance->status)
                                        @case('present')
                                            <div class="badge badge-success">H</div>
                                              @php
                                                $presentCount++;
                                              @endphp
                                            @break
                                        @case('late')
                                            <div class="badge badge-warning">T</div>
                                              @php
                                                $lateCount++;
                                              @endphp
                                            @break
                                        @case('excused')
                                            <div class="badge badge-info">I</div>
                                              @php
                                                $excusedCount++;
                                              @endphp
                                            @break
                                        @case('sick')
                                            <div class="badge badge-info">S</div>
                                              @php
                                                $sickCount++;
                                              @endphp
                                            @break
                                        @case('absent')
                                            <div class="badge badge-danger">A</div>
                                              @php
                                                $absentCount++;
                                              @endphp
                                            @break
                                        @default
                                            <div class="badge badge-secondary">N/A</div>
                                    @endswitch
                                    @else
                                      <div class="badge badge-danger">-</div>
                                        @php
                                            $absentCount++;
                                        @endphp
                                    @endif
                                @endif
                                
                              </td>
                              @endforeach
  
                              @foreach ([$presentCount,$lateCount,$excusedCount,$sickCount,$absentCount] as $statusCount)
                                <td style=" text-align: center;">
                                  {{ $statusCount }}
                                </td>
                              @endforeach
                          </tr>
                          {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                  </table>
                </div>
                  <!-- Menampilkan link pagination -->
                  <div class="d-flex justify-content-end mt-2">
                    <!-- Ini akan menampilkan link pagination -->
                    {{ $pegawai->links() }}
                  </div>
                  </div>
                  <div class="card-footer">
                      <form action="{{ route('absen.test') }}" method="get"  onsubmit="return confirm('Anda Yakin Ingin Update Data? Ini Akan Mengubah Status Menjadi Absent Untuk Pegawai Yang Tidak Ada Data Absensi')">
                        @csrf
                        <button class="btn btn-sm btn-primary">Update Data</button>
                      </form>
                  </div>
                </div>
            </div>
              
          </div>
        </div>
      </div>
                
@endsection

@push('scripts')

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>




{{-- <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script> --}}

{{-- <script>

  $(document).ready( function () {
    $('#table-1').DataTable();
  } );
</script> --}}

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#weekPicker').datepicker({
          format: 'mm-dd-yyyy',
          weekStart: 1, // Mulai minggu dari hari Senin
          beforeShowDay: function(date) {
              var day = date.getDay();
              return [(day !== 0)]; // Nonaktifkan hari Minggu
          },
          autoclose: true
      }).on('changeDate', function(e) {
          var startDate = new Date(e.date);
          var endDate = new Date(startDate);
          endDate.setDate(startDate.getDate() + (6 - startDate.getDay())); // Menentukan akhir minggu
          $('#weekPicker').val(startDate.toLocaleDateString() + ' - ' + endDate.toLocaleDateString());
      });
  });
</script> --}}

@endpush


                  