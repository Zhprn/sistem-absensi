@extends('layout.app')

@push('style')
  

@endpush

@section('konten-header')
<div class="section-header">
    <h1>Rekap Data dan Import/Export</h1>
</div>

@endsection

@section('konten-main')

    <div class="container">
        <h2 class="section-title">Absensi</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-day"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">
                            <div>
                                Absensi Hari Ini
                            </div>
                            <div class="card-cta">
                                <a href="{{ route('listAttendances') }}"><h6>Lihat Data <i class="fas fa-chevron-right mb-2"></i></h6></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-week"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">
                            <div>
                                Absensi Mingguan
                            </div>
                            <div class="card-cta">
                                <a href="{{ route('detailAttendances') }}"><h6>Lihat Data <i class="fas fa-chevron-right mb-2"></i></h6></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-statistic-1">
                    <div class="card-icon shadow-primary bg-success"><i class="fa fas fa-calendar-alt"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Absensi</h4></div>
                        <div class="card-body">
                            <div>
                                Absensi Bulanan
                            </div>
                            <div class="card-cta">
                                <a href="{{ route('detailAttendancesMonth') }}"><h6>Lihat Data <i class="fas fa-chevron-right mb-2"></i></h6></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="section-title">Pegawai</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-statistic-1"> 
                    <div class="card-icon shadow-primary bg-info"><i class="fa fas fa-user"></i></div>
                    <div class="card-warp">
                        <div class="card-header"><h4>Rekap Data Pegawai</h4></div>
                        <div class="card-body">
                            <div>
                                PDF Pegawai
                            </div>
                            <div class="card-cta">
                                <a href="{{ route('export-pegawai') }}" target="__blank"><h6>Lihat PDF <i class="fas fa-chevron-right mb-2"></i></h6></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
@endsection

@push('script')

@endpush