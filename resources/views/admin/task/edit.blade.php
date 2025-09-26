@extends('layout.app')
@section('konten-title', 'Data Tugas')

@push('style')
    
@endpush

@section('konten-header')
    <div class="section-header">
        <h1>Edit Tugas</h1>
    </div>
@endsection

@section('konten-main')
    

<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Form Edit Tugas</h4>
            </div>
            <div class="card-body text-start">
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <form action="{{ route('task.update', $task->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="tugasInput">Nama Tugas</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" name="tugasInput" class="form-control" value="{{ $task->tugas }}"> 
                                </div>        
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Keterangan Tugas</label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" name="descInput" class="form-control"  value="{{ $task->desc }}"> 
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="bagianInput">Bagian :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="bagianInput">
                                        <option selected disabled>Pilih Bagian..</option>
                                        @foreach($bagian as $data_bagian)
                                            <option value="{{ $data_bagian->id }}" {{ $data_bagian->id == $task->bagian_id ? 'selected' : '' }}>{{ $data_bagian->bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Waktu Mulai/Deadline</label>
                                <div class="col-sm-12 col-md-3 mb-4 mb-md-0"> 
                                    <input type="text" name="mulaiInput" class="form-control datetimepicker" value="{{ $task->waktu_mulai }}"> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" name="deadlineInput" class="form-control datetimepicker" value="{{ $task->waktu_deadline }}"> 
                                </div>          
                            </div>

                            {{-- <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="sopInput">SOP Tugas :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="sopInput">
                                        <option selected disabled>Pilih SOP..</option>
                                        @foreach($sop as $data_sop)
                                            <option value="{{ $data_sop->id }}"  value="{{ $data_sop->id }}" {{ $data_sop->id == $task->sop_id ? 'selected' : '' }}>{{ $data_sop->title }}</option>
                                        @endforeach
                                    </select>
                                </div>        
                            </div> --}}

                                <div class="d-flex justify-content-end ">
                                   <button class="btn btn-primary">Submit</button>
                                </div>        

                            </div>
                        </div>
                    </div>                  
                    
                </form>
            </div>

           
        </div>
</div>



@endsection

@push('scripts')


 {{-- <script src="{{ asset('/assets/js/page/components-table.js') }}"></script> --}}
    
    
@endpush