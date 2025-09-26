@extends('layout.app')
@section('konten-title', 'Data Users')

@section('konten-header')
    <div class="section-header">
        <h1>Manage Akun</h1>
    </div>
@endsection

@section('konten-main')

    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Manage Akun Pegawai</h4>
                <div class="card-header-action">
                    <form action="#" method="get">
                        <div class="input-group" >
                            <input name="cari_pegawai" type="text" placeholder="Cari Pegawai" class="form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-primary">
                                    <i class="fa fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <form action="#" method="get">
                        <H5>Filter : </H5>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="role" class="col-form-label">Role Akun </label>
                                    <select class="custom-select form-control" name="roleInputs" id="role">
                                        <option selected disabled>Tipe Akun</option>
                                        @foreach($uniqueTypes as $data)
                                                <option value="{{ $data }}">{{ $data }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="jabatan" class="col-form-label">Jabatan</label>
                                    <div class="input-group mb-3">
                                    <select class="custom-select form-control" name="jabatan">
                                        <option selected disabled>Jabatan</option>
                                        @foreach($jabatan as $data_jabatan)
                                            <option value="{{ $data_jabatan->id }}">{{ $data_jabatan->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="bagian" class="col-form-label">Bagian</label>
                                    <select class="custom-select form-control" name="bagian">
                                    <option selected disabled>Bagian</option>
                                        @foreach($bagian as $data_bagian)
                                        <option value="{{ $data_bagian->id }}">{{ $data_bagian->bagian }}</option>
                                        @endforeach
                                </select>
                                </div>

                                <div class="col-sm-2" >
                                    <label for="btnfilter" class="col-form-label">&nbsp;</label>
                                    <button class="btn btn-info form-control" name="btnfilter"><i class="fa fas fa-filter"></i> Filter</button>
                                </div>
                                {{-- style="margin-top: 40px;" --}}
                            </div>
                    </form>
                </div>

                <div class="row">
                    <div class="btn-group col-sm-4" role="group" aria-label="Basic example">
                        <a href="{{ route('manageuser.create') }}" class="btn btn-success mr-2"><i class="fa fas fa-plus"></i> Tambah Data</a>
                        <button type="button" class="btn btn-outline-info"><i class="fa fas fa-print"></i> Download Report</button>
                    </div>
                </div>

                <div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>jabatan</th>
                                    <th>Bagian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUser as $no=>$data)                   
                                <tr>
                                    <td class="text-center">{{ $no+1 }}</td>
                                    <td>{{ $data->user->email }}</td>
                                    <td>{{ $data->user->type }}</td>
                                    <td>{{ $data->nip }}</td>
                                    <td>{{ $data->nama_pegawai }}</td>
                                    <td>{{ $data->jabatan->jabatan }}</td>
                                    <td>{{ $data->bagian->bagian }}</td>
                                    <td>
                                        <a href="{{ route('manageuser.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    </td>
                                </tr>                                  
                                @endforeach      
                            </tbody>
                        </table>
                    </div>
                </div>
    
                <div class="d-flex justify-content-end mt-2">
                    {{ $dataUser->links() }}
                </div>
                
                <h6 class="mt-4">User Yang Tidak Terhubung Ke Pegawai : </h6>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($usersWithoutPegawai as $no=>$user)
                                        <tr>
                                            <td class="text-center">{{ $no+1 }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->type }}</td>
                                            <td>
                                                <form action="{{ route('manageuser.destroy', $user->id) }}" method="post"  onsubmit="return confirm('Yakin ingin menghapus data?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                                  </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tr>                                      
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        {{ $usersWithoutPegawai->links() }}
                    </div>

            </div>
        </div>
    </div>
    
@endsection