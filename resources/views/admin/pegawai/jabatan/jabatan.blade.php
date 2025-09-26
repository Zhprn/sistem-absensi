@extends('layout.app')
{{-- @section('title-body', 'List Jabatan') --}}
@section('konten-title', 'Data Jabatan')

@push('style')
  
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" /> --}}

@endpush

@section('konten-header')
<div class="section-header">
  <h1>List Jabatan</h1>
</div>
@endsection
@section('konten-main')

    <div class="row">
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
                <h4>Tabel Data Jabatan</h4>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Jabatan</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                      
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($jabatan as $no=>$data)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $data->jabatan }}</td>
                        <td>{{ $data->deskripsi }}</td>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('jabatan.edit', $data->id) }}" class="btn btn-warning btn-sm me-2 mr-2 ">Edit</a>    
                            <form action="{{ route('jabatan.delete', $data->id) }}" method="post"  onsubmit="return confirm('Yakin ingin menghapus data?')">
                              @csrf
                              @method('delete')
                              <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Tambah Data Jabatan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.post') }}" method="post">
                        @csrf
                        <label for="">Nama Jabatan</label>
                        <input type="text" name="jabatan" class="form-control mb-2">
                        <label for="">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control mb-2">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary mt-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-primary">
              <div class="card-header">
                  <h4>Import/Export Data</h4>
              </div>
              <div class="card-body">
                <label for="">Import Excel</label>
                <form action="{{ route('import.jabatan') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="d-flex justify-content-between">
                  <input type="file" name="file" id="file" class="form-control mr-2">
                  <input type="submit" value="Import" class="btn btn-sm btn-primary">
                </div>
                </form>

                <div class="d-flex justify-content-between mt-4">
                  <a href="/admin/export-excel-jabatan" class="btn btn-success" target="__blank"><i class="fa fas fa-file-excel"></i> Download Excel</a>
                </div>
              </div>
          </div>
        </div>
      </div>
  

@endsection

@push('scripts')

{{-- <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script> --}}

<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

{{-- <script>

  $(document).ready( function () {
    $('#table-2').DataTable();
  } );
</script> --}}



@endpush