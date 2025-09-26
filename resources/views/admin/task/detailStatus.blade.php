@extends('layout.app')
@section('konten-title', 'Data Task')

@section('konten-header')
    <div class="section-header">
        <h1>Detail Task</h1>
    </div>
@endsection

@section('konten-main')
    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Detail Tugas {{ $pegawaitask->task->tugas }}</h4>
                <div class="card-header-action">
                    <strong><div class="badge {{ $pegawaitask->status === 'pending' ? 'badge-warning' : ($pegawaitask->status === 'process' ? 'badge-info' : ($pegawaitask->status === 'done' ? 'badge-success' : ''))}}">{{ $pegawaitask->status }}</div></strong>
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
                    <label class="col-12 col-md-3 col-lg-3" for="email">Penanggung Jawab Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->pegawai->nama_pegawai }}</strong> 
                    </div>        
                </div>

                <form action="{{ route('task.statusUpdate', $pegawaitask->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                
                <input type="hidden" value="{{ $pegawaitask->task->tugas }}" name="titleTask">

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Ubah Status Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <div class="input-group">
                            <select class="form-control" name="statusTask" id="statusTask">
                                <option value="pending" {{ $pegawaitask->status === 'pending' ? 'selected' : ''}}>Pending</option>
                                <option value="process" {{ $pegawaitask->status === 'process' ? 'selected' : ''}}>Proses</option>
                                <option value="done" {{ $pegawaitask->status === 'done' ? 'selected' : ''}}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Deskripsi Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->task->desc }}</strong> 
                    </div>        
                </div>

                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Bagian : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-info">{{ $pegawaitask->pegawai->bagian->bagian }}</div></strong> 
                    </div>        
                </div>


                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Periode : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $pegawaitask->task->waktu_mulai }} - {{ $pegawaitask->task->waktu_deadline }}</div></strong> 
                    </div>        
                </div>
    
                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tanggal DiBuat : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $pegawaitask->task->created_at }}</strong> 
                    </div>        
                </div>

            
    
                <div class=" mb-4 row">
                    <div class="container d-flex">
                        {{-- <a href="{{ route('sop.pdf', $sop) }}" class="btn btn-outline-danger me-3 mr-2" target="_blank"><i class="fa fas fa-file-pdf"></i> Lihat SOP</a> --}}

                        <a href="{{ route('task.bukti', $pegawaitask->id) }}" class="btn btn-outline-primary me-3 mr-2" target="_blank" id="buktiDone"><i class="fa fas fa-eye"></i> Lihat Bukti</a>
                        
                    </div>
                    
                </div>

                <div class=" mb-3 row">
                    <div class="container d-flex">
                        
                        
                        <a href="{{ route('task.index') }}" class="btn btn-success me-3 mr-2"> Kembali</a>
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