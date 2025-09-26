@extends('layout.app')
@section('konten-title', 'Data Users')

@section('konten-header')
    <div class="section-header">
        <h1>Edit Akun</h1>
    </div>
@endsection

@section('konten-main')


<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Edit Akun User</h4>
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
                <form action="{{ route('manageuser.update', $pegawai->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <div class="col-sm-6">       
                                    <label for="email">Email</label>        
                                    <input type="text" name="email" class="form-control" value="{{ $pegawai->user->email }}">      
                                </div>
                                <div class="col-sm-6">       
                                    <label for="email">Tipe Role</label>        
                                    <select class="custom-select form-control" name="roleInputs" id="role">
                                        <option selected disabled>Tipe Akun</option>
                                        <option value="0" {{ $pegawai->user->type == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="1" {{ $pegawai->user->type == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="2" {{ $pegawai->user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>      
                                </div>
                            </div>

                            <label for="">Password Baru</label>
                            <input type="password" name="passNew" class="form-control mb-2" value="">

                            {{-- <label for="">Konfrimasi Password</label>
                            <input type="password" name="passCofrm" class="form-control mb-2" value=""> --}}

                            <div class="mt-4">
                                <label for="">Nama Pegawai</label>
                                <input disabled type="text" name="nama_pegawai" class="form-control mb-2" value="{{ $pegawai->nama_pegawai }}">
    
                                <label for="">NIP</label>
                                <input disabled type="text" name="nip" class="form-control mb-2" value="{{ $pegawai->nip }}">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="d-flex justify-content-end d-flex">

                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection