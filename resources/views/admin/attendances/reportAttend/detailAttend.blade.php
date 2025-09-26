@extends('layout.app')
@section('konten-title', 'Data Absensi')

@section('konten-header')
    <div class="section-header">
        <h1>Detail Absensi</h1>
    </div>
@endsection

@section('konten-main')
    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Detail Absensi</h4>
                <div class="card-header-action">
                    {{-- <strong><div class="badge {{ $pegawaitask->status === 'pending' ? 'badge-warning' : ($pegawaitask->status === 'process' ? 'badge-info' : ($pegawaitask->status === 'done' ? 'badge-success' : ''))}}">{{ $pegawaitask->status }}</div></strong> --}}
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Nama Pegawai : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->pegawai->nama_pegawai }}</strong> 
                    </div>        
                </div>

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Shift : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->pegawai->shift->shift }}</strong> 
                    </div>        
                </div>

                <form action="{{ route('listAttendances.update', $pegawaitask->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                
                {{-- <input type="hidden" value="{{ $pegawaitask->task->tugas }}" name="titleTask"> --}}

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Status Absen : </label>
                    <div class="col-sm-12 col-md-4">
                        <div class="input-group">
                            <select class="form-control" name="statusTask" id="statusTask">
                                <option value="present" {{ $pegawaitask->status === 'present' ? 'selected' : ''}}>Hadir</option>
                                <option value="late" {{ $pegawaitask->status === 'late' ? 'selected' : ''}}>Terlambat</option>
                                <option value="excused" {{ $pegawaitask->status === 'excused' ? 'selected' : ''}}>Izin</option>
                                <option value="sick" {{ $pegawaitask->status === 'sick' ? 'selected' : ''}}>Sakit</option>
                                <option value="absent" {{ $pegawaitask->status === 'absent' ? 'selected' : ''}}>Absen</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tanggal Absen : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $pegawaitask->date }}</div></strong> 
                    </div>        
                </div>


                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Waktu Masuk : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $pegawaitask->waktu_masuk ?? '-' }}</div></strong> 
                    </div>        
                </div>


                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Waktu Keluar : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $pegawaitask->waktu_keluar ?? '-' }}</div></strong> 
                    </div>        
                </div>
    
                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Note<i class="text-danger">*</i> : </label>
                    <div class="col-sm-12 col-md-4">
                        <textarea name="noteInput" id="noteInput" cols="50" rows="30" class="form-control">{{ $pegawaitask->note }}</textarea> 
                    </div>        
                </div>

                <div class=" mb-3 row">
                    <div class="container d-flex">
                        
                        
                        <a href="{{ route('listAttendances') }}" class="btn btn-success me-3 mr-2"> Kembali</a>
                        <button class="btn btn-primary">Submit</button>
                        
                        
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    
@endpush