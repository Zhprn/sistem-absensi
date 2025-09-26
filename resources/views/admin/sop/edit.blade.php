@extends('layout.app')
@section('konten-title', 'Data SOP')

@section('konten-header')
    <div class="section-header">
        <h1>Edit SOP Pegawai</h1>
    </div>
@endsection

@section('konten-main')
    <div>
        <div class="card card-primary">
            <div class="card-header"><h4>SOP Form</h4></div>
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
                <div class="container">
                    <form action="{{ route('sop.update', $sopContent->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="email">Title SOP</label>
                            <div class="col-sm-12 col-md-4">
                                <input type="text" name="titleSop" class="form-control" value="{{ $sopContent->title }}"> 
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="email">Deskripsi SOP</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="descSop" class="form-control" value="{{ $sopContent->desc }}"> 
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="bagianSop">Untuk Bagian :</label>
                            <div class="col-sm-12 col-md-4">
                                {{-- <input type="text" name="bagianSop" class="form-control">  --}}
                                <select class="form-control select2" name="bagianSop" required>
                                    <option selected disabled>Pilih Bagian..</option>
                                    @foreach($bagian as $data_bagian)
                                        <option value="{{ $data_bagian->id }}" {{ $data_bagian->id == $sopContent->bagian_id ? 'selected' : '' }}>{{ $data_bagian->bagian }}</option>
                                    @endforeach
                                </select>
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="contentSop">Content SOP</label>
                            <div class="col-sm-12 col-md-7">
                                {{-- <textarea name="contentSop" id="summernote" cols="65" rows="10"></textarea>  --}}
                                <textarea name="contentSop" class="summernote">{{ old('contentSop', $sopContent->content) }}</textarea>
                            </div>        
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="button"></label>
                            <div class="col-sm-12 col-md-7">
                               <button class="btn btn-primary">Submit</button>
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection