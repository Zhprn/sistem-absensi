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
            <card class="card-header">
                <h4>Detail Tugas {{ $task->tugas }}</h4>
            </card>
            <card class="card-body">
                <div class="form-group row">
                    <label class="col-12 col-md-3 col-lg-3" for="email">Deskripsi Tugas : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $task->desc }}</strong> 
                    </div>        
                </div>
    
                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Bagian : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong class="badge badge-info">{{ $task->bagian->bagian }}</strong> 
                    </div>        
                </div>

                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tugas Untuk Periode : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong><div class="badge badge-success">{{ $task->waktu_mulai }} - {{ $task->waktu_deadline }}</div></strong> 
                    </div>        
                </div>
    
                <div class="form-group row">
                    <label class=" col-12 col-md-3 col-lg-3" for="email">Tanggal DiBuat : </label>
                    <div class="col-sm-12 col-md-4">
                        <strong>{{ $task->created_at }}</strong> 
                    </div>        
                </div>
    
                <div class=" mb-4 row">
                    <div class="container d-flex">
                        {{-- <a href="{{ route('sop.pdf', $sop) }}" class="btn btn-outline-primary me-3 mr-2" target="_blank"><i class="fa fas fa-eye"></i> Lihat SOP</a> --}}

                        <form action="{{ route('task.destroy', $task->id) }}" method="post"  onsubmit="return confirm('Yakin ingin menghapus data?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger"><i class="fa fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>

                <div class=" mb-3 row">
                    <div class="container d-flex">
                        <a href="{{ route('task.create') }}" class="btn btn-success me-3 mr-2"> Kembali</a>
                    </div>
                </div>
            </card>
        </div>
    </div>
@endsection