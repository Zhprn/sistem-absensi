@extends('layout.app')
@section('konten-title', 'Data Absensi')

@push('style')
  
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@endpush

@section('konten-header')
<div class="section-header" >
  <h1>List Presensi Masuk</h1>
</div>
@endsection

@section('konten-main')
    <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Absensi Hari Ini</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-3">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <h5>Hadir : {{ $presentLateCount }}</h5>
                      Terlambat : {{ $lateCount }}
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-3">
                  <div class="card bg-info text-white">
                    <div class="card-body">
                      <h5>Izin : {{ $excusedCount }}</h5>
                      Izin/Cuti
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-3">
                  <div class="card bg-secondary text-white">
                    <div class="card-body">
                      <h5>Sakit : {{ $sickCount }}</h5>
                      .
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-3">
                  <div class="card bg-danger text-white">
                    <div class="card-body">
                      <h5>Absen : {{ $absentCount }}</h5>
                      Tidak/Belum Hadir
                    </div>
                  </div>
                </div>
              </div>
              
              <form action="#" method="get">
              <div class="row align-items-center justify-content-between">
                <div class="col-md-2 text-end">
                    <h6 class="mb-2">Jumlah Pegawai: {{ $pegawaiCount }}</h6>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <input  type="date" name="dateInput" id="dateInput" class="form-control">
                    <div class="input-group-append">
                      <button class="btn btn-primary">
                          <i class="fa fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>    
              </form>

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
                      <th>Shift</th>
                      <th>Status</th>
                      <th>Waktu Masuk</th>
                      <th>Waktu Keluar</th>
                      <th>Aksi</th>
                      
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($pegawai as $no=>$dataP)
                      @if($dataP->attendances->isEmpty())
                        <tr>
                          <td class="text-center">{{ $no+1 }}</td>
                          <td>{{ $dataP->nip }}</td>
                          <td>{{ $dataP->nama_pegawai }}</td>
                          <td>{{ $dataP->jabatan->jabatan }}</td>
                          <td>{{ $dataP->bagian->bagian }}</td>
                          <td>{{ $dataP->shift->shift }}</td>
                          <td><div class="badge badge-danger">Belum Hadir</div></td>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                      @else
                      @foreach($dataP->attendances as $dataA)
                    <tr>
                        <td class="text-center">{{ $no+1 }}</td>
                        <td>{{ $dataP->nip }}</td>
                        <td>{{ $dataP->nama_pegawai }}</td>
                        <td>{{ $dataP->jabatan->jabatan }}</td>
                        <td>{{ $dataP->bagian->bagian }}</td>
                        <td>{{ $dataP->shift->shift }}</td>

                        <td><div class="badge {{ $dataA->status == 'present' ? 'badge-success' : 
                        ($dataA->status == 'late' ? 'badge-warning' : ($dataA->status == 'excused' ? 'badge-info' : ($dataA->status == 'sick' ? 'badge-info' : 'badge-danger'))) }}">{{ $dataA->getStatusInIndonesian()}}</div></td>

                        <td>{{ $dataA->waktu_masuk }}</td>
                        <td><div class="badge {{ $dataA->waktu_keluar == null ? 'badge-danger' : '' }}">{{ $dataA->waktu_keluar == null ? 'Belum Keluar' : $dataA->waktu_keluar }}</div></td>
                        {{-- {{ $dataA->waktu_keluar == null ? '-' : $dataA->waktu_keluar }} --}}
                        <td class="d-flex align-items-center" style="width: 50px;">
                            <a href="{{ route('listAttendances.date', $dataA->id) }}" class="btn btn-primary btn-sm me-2 mr-2 ">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
                <!-- Menampilkan link pagination -->
                <div class="d-flex justify-content-end mt-2">
                  {{ $pegawai->links() }} <!-- Ini akan menampilkan link pagination -->
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

@endpush


                  