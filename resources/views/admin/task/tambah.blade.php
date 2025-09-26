@extends('layout.app')
@section('konten-title','Data Tugas')

@section('konten-header')
    <div class="section-header">
        <h1>Tambah Tugas</h1>
    </div>
@endsection

@section('konten-main')
<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Form Tambah Tugas</h4>
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
                @if(session('info'))
                    <div class="alert alert-warning">
                        {{ session('info') }}
                    </div>
                @endif
                <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="tugasInput">Nama Tugas</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" name="tugasInput" class="form-control"> 
                                </div>        
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Keterangan Tugas</label>
                                <div class="col-sm-12 col-md-6">
                                    <input type="text" name="descInput" class="form-control"> 
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="bagianInput">Bagian :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="bagianInput">
                                        <option selected disabled>Pilih Bagian..</option>
                                        @foreach($bagian as $data_bagian)
                                            <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>        
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="descInput">Waktu Mulai/Deadline</label>
                                <div class="col-sm-12 col-md-3 mb-4 mb-md-0"> 
                                    <input type="text" name="mulaiInput" class="form-control datetimepicker"> 
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <input type="text" name="deadlineInput" class="form-control datetimepicker"> 
                                </div>          
                            </div>

                            {{-- 
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="sopInput">SOP Tugas :</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control select2" name="sopInput">
                                        <option selected disabled>Pilih SOP..</option>
                                        @foreach($sop as $data_sop)
                                            <option value="{{ $data_sop->id }}">{{ $data_sop->title }}</option>
                                        @endforeach
                                    </select>
                                </div>        
                            </div>
                            --}}

                            <div class="d-flex justify-content-end ">
                                <button class="btn btn-primary">Submit</button>
                            </div>        

                        </div>
                    </div>
                </form>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Table Tugas</h4>
                    <div class="card-header-action"></div>
                </div>
                <div class="card-body ">
                    <form action="#" method="get">
                        <div class="form-group row d-flex justify-content-end">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select class="form-control" name="bagianInput2">
                                        <option selected disabled>Pilih Bagian..</option>
                                        @foreach($bagian as $data_bagian)
                                            <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-sm btn-info form-control" name="btnfilter"><i class="fa fas fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('task.pegawai') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="table-responsive mt-2">
                            <table class="table table-striped">
                                <tr>
                                    <th>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Nama Tugas</th>
                                    <th>Keterangan</th>
                                    {{-- <th>SOP</th> --}}
                                    <th>Bagian</th>
                                    <th>Waktu Mulai</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($task as $data)  
                                    <tr>
                                        <td class="p-0 text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $data->id }}" value="{{ $data->id }}" name="tasks[]">
                                                <label for="checkbox-{{ $data->id }}" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ $data->tugas }}</td>
                                        <td>{{ $data->desc }}</td>
                                        {{-- <td><div class="badge badge-danger">{{ $data->sop->title }}</div></td> --}}
                                        <td><div class="badge badge-info">{{ $data->bagian->bagian }}</div></td>
                                        <td>{{ $data->waktu_mulai }}</td>
                                        <td>{{ $data->waktu_deadline }}</td>
                                        <td class="d-flex align-items-center">
                                            <a href="{{ route('task.edit', $data->id) }}" class="btn btn-warning btn-sm mr-2 ">Edit</a>
                                            <a href="{{ route('task.detail', $data->id) }}" class="btn btn-primary btn-sm mr-2 ">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="form-group row mt-2">
                            <div class="col-sm-12">
                                <label for="pegawaiInput" class="form-label text-dark">Pilih Pegawai : </label>
                                <div class="input-group">
                                    <select class="form-control select2" name="pegawaiInput[]" multiple="multiple" tabindex="-1" aria-hidden="true">
                                        @foreach($pegawai as $data_pegawai)
                                            <option value="{{ $data_pegawai->id }}">{{ $data_pegawai->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end ">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
 <script src="{{ asset('/assets/js/page/components-table.js') }}"></script>
@endpush
