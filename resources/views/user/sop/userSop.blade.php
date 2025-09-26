@extends('layout.app')
@section('konten-title', 'Data SOP')
@push('style')
    
    
@endpush

@section('konten-header')
<div class="section-header">
    <h1>SOP Pegawai</h1>
</div>
@endsection

@section('konten-main')

<div>
    <div class="card card-primary">
        <div class="card-header">
            <h4>List SOP</h4>
            
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th>Title Sop</th>
                      <th>Deskripsi</th>
                      <th>Bagian</th>
                      <th>Content</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sop as $no=>$data)
                      <tr>
                            <td class="text-center">{{ $no+1 }}</td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->desc }}</td>
                            <td>{{ $data->bagian->bagian }}</td>
                            <td><a href="{{ route('sop.pdf', $data->title) }}" class="btn btn-danger btn-sm" target="__blank"><i class="fa fas fa-file-pdf"></i> Lihat PDF</a></td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
        </div>
    </div>
</div>
    
@endsection

@push('scripts')

<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

@endpush