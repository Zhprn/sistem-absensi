@extends('layout.app')
{{-- @section('title-body', 'List bagian') --}}
@section('konten-title', 'Data Bagian')

@push('style')
  
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" /> --}}

@endpush

@section('konten-header')
<div class="section-header">
  <h1>List Bagian</h1>
</div>
@endsection
@section('konten-main')

    <div class="row">
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
                <h4>Tabel Data bagian</h4>
          </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th>Bagian</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($bagian as $no=>$data)
                    <tr>
                        <td class="text-center">{{ $no+1 }}</td>
                        <td>{{ $data->bagian }}</td>
                        <td>{{ $data->deskripsi }}</td>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('bagian.edit', $data->id) }}" class="btn btn-warning btn-sm me-2 mr-2 ">Edit</a>    
                            <form action="{{ route('bagian.delete', $data->id) }}" method="post"  onsubmit="return confirm('Yakin ingin menghapus data?')">
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
                    <h4>Tambah Data Bagian</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bagian.post') }}" method="post">
                        @csrf
                        
                        <label for="">Nama bagian</label>
                        <input type="text" name="bagian" class="form-control mb-2">
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
                <form action="{{ route('import.bagian') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="d-flex justify-content-between">
                  <input type="file" name="file" id="file" class="form-control mr-2">
                  <input type="submit" value="Import" class="btn btn-sm btn-primary">
                </div>
                </form>

                <div class="d-flex justify-content-between mt-4">
                  <a href="/admin/export-excel-bagian" class="btn btn-success" target="__blank"><i class="fa fas fa-file-excel"></i> Download Excel</a>
                  <a href="/admin/export-excel-bagian" class="btn btn-danger"><i class="fa fas fa-file-pdf"></i> Download pdf</a>
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