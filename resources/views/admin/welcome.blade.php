@extends('layout.app')

@section('konten-title', 'Dashboard')
    

@section('konten-header')
    <div class="section-header">
      <h1>Dashboard Admin</h1>
    </div>
@endsection

@section('konten-main')

    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Pegawai</h4>
            </div>
            <div class="card-body">
              {{ $pegawaiCount }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fa fas fa-tasks"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Tugas</h4>
            </div>
            <div class="card-body">
              {{ $taskCount }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-circle"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pegawai Hadir</h4>
            </div>
            <div class="card-body">
              {{ $presentLateCount }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Absensi Hari Ini</h4>
            <div class="card-header-action">
                <a href="{{ route('listAttendances') }}" class="btn btn-primary">Lihat Lebih Lanjut <i class="fas fa fa-chevron-right"></i></a>
            </div>
          </div>
          <div class="card-body">
            <div class="statistic-details mb-sm-4">
              <div class="statistic-details-item">
                <div class="detail-value">{{ $presentLateCount }}</div>
                <div class="detail-name">Pegawai Hadir</div>
              </div>
              <div class="statistic-details-item">
                <div class="detail-value">{{ $sickCount }}</div>
                <div class="detail-name">Pegawai Sakit</div>
              </div>
              <div class="statistic-details-item">
                <div class="detail-value">{{ $excusedCount }}</div>
                <div class="detail-name">Pegawai Izin</div>
              </div>
              <div class="statistic-details-item">
                <div class="detail-value">{{ $absentCount }}</div>
                <div class="detail-name">Pegawai Absen</div>
              </div>
            </div>
            <div class="table-responsive mt-2">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>Nama Pegawai</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach($pegawai as $no=>$dataP)
                    @if($dataP->attendances->isEmpty())
                      <tr>
                        <td>{{ $dataP->nama_pegawai }}</td>
                        <td>{{ $dataP->shift->shift }}</td>
                        <td><div class="badge badge-danger">Belum Hadir</div></td>
                        <td>-</td>
                        <td>-</td>
                      </tr>
                    @else
                    @foreach($dataP->attendances as $dataA)
                  <tr>
                      <td>{{ $dataP->nama_pegawai }}</td>
                      <td>{{ $dataP->shift->shift }}</td>

                      <td><div class="badge {{ $dataA->status == 'present' ? 'badge-success' : 
                      ($dataA->status == 'late' ? 'badge-warning' : ($dataA->status == 'excused' ? 'badge-info' : ($dataA->status == 'sick' ? 'badge-info' : 'badge-danger'))) }}">{{ $dataA->getStatusInIndonesian()}}</div></td>

                      <td>{{ $dataA->waktu_masuk == null ? '-' : $dataA->waktu_masuk }}</td>
                      <td><div class="badge {{ $dataA->waktu_keluar == null ? 'badge-danger' : '' }}">{{ $dataA->waktu_keluar == null ? 'Belum Keluar' : $dataA->waktu_keluar }}</div></td>
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

      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Tugas On Progress</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border">
              @foreach ($task as $data)   
                <li class="media">
                  <div class="media-body">
                    <div class="float-right text-primary">{{ $data->bagian->bagian}}</div>
                    <div class="media-title">{{ $data->tugas }}</div>
                    <span class="text-small text-muted">{{ $data->desc }}</span>
                  </div>
                </li>
              @endforeach
            </ul>
            <div class="text-center pt-1 pb-1">
              <a href="{{ route('task.index') }}" class="btn btn-primary btn-lg btn-round">
                View All
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection