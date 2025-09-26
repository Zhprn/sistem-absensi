@extends('layout.app')

@section('konten-title','Gaji Pegawai')
    
@section('konten-header')
    <div class="section-header">
        <h1>Tambah Gaji</h1>
    </div>
@endsection

@section('konten-main')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Infromasi Pegawai</h4>
                </div>
                <div class="card-body">
                    @if (session('gagal'))
                        <div class="alert alert-danger">
                            {{ session('gagal') }}
                        </div>
                    @endif

                    <form action="#" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-4">
                                <div class="col-sm-4">       
                                    <label for="pegawai">Bulan</label>        
                                    <select class="custom-select form-control" name="bulanInput" id="bulan">
                                        @foreach($months as $month)
                                            <option value="{{ $month['value'] }}" @if($month['is_current']) selected @endif>{{ $month['label'] }}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="col-sm-4">       
                                    <label for="pegawai">Bagian</label>        
                                    <select class="custom-select form-control" name="bagianInput" id="bagian">
                                        <option value="" disabled>Pilih Bagian</option>
                                        @foreach ($bagian as $data)
                                            <option value="{{ $data->id }}">{{ $data->bagian }}</option>
                                        @endforeach
                                    </select>      
                                </div>
                                <div class="col-sm-4">       
                                    <label for="pegawai">Jabatan</label>        
                                    <select class="custom-select form-control" name="jabatanInput" id="jabatan">
                                        <option value="" disabled>Pilih Jabatan</option>
                                        @foreach ($jabatan as $data)
                                            <option value="{{ $data->id }}">{{ $data->jabatan }}</option>
                                        @endforeach
                                    </select>      
                                </div>
                            </div>
                            <div class="justify-content-end d-flex">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <form action="{{ route('gaji.store') }}" method="post" enctype="multipart/form-data" id="gajiForm">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Gaji Pegawai Bulan : </h4>
                </div>
                <div class="card-body">
                    
                        @csrf
                        <input type="hidden" name="bulanValue" id="" value="{{ $bulan }}" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">       
                                        <label for="pegawai">Nama Pegawai</label>        
                                        <select class="custom-select form-control" name="namaInput" id="nama">
                                            <option value="" disabled selected>Pilih Pegawai</option>
                                            @foreach($pegawai as $pegawai)
                                                <option value="{{ $pegawai->id }}" >{{ $pegawai->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                    </div>  
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">       
                                    <div class="form-group">
                                        <label for="gajiPokokInput">Gaji Pokok</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="gajiPokokInput" id="gajiPokokInput" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">       
                                    <div class="form-group">
                                        <label for="pphInput">PPH <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="pphInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Tunjangan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="kehadiranInput">Kehadiran <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="kehadiranInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="makanInput">Makan <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="makanInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="transportInput">Transportasi <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="transportInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="lemburInput">Lembur <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="lemburInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="tunlainInput">Tunjangan Lainnya <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="tunlainInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Potongan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="asuransiInput">Asuransi <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="asuransiInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="bpjsInput">BPJS (kttk&kes) <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="bpjsInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="absenInput">Absen <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="absenInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">       
                                    <div class="form-group">
                                        <label for="potlainInput">Potongan Lainnya <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp
                                                </div>
                                            </div>
                                            <input class="form-control currency" type="text" name="potlainInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Aksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mt-2">
                            {{-- <a href="{{ route('gaji.index') }}" class="btn btn-danger mr-2">Back</a> --}}
                            <button class="btn btn-primary">Submit</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
@endsection

@push('scripts')


  {{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Pilih semua elemen dengan class 'currency'
        document.querySelectorAll(".currency").forEach(function (input) {
            new Cleave(input, {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
                delimiter: ".",
                numeralDecimalMark: ",",
                numeralDecimalScale: 0,
            });
        });
    });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Pilih semua elemen dengan class 'currency'
        document.querySelectorAll(".currency").forEach(function (input) {
            new Cleave(input, {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
                delimiter: ".",
                numeralDecimalMark: ",",
                numeralDecimalScale: 0,
            });
        });

        // Saat form disubmit, ubah nilai ke integer sebelum dikirim ke server
        document.getElementById("gajiForm").addEventListener("submit", function () {
            document.querySelectorAll(".currency").forEach(function (input) {
                input.value = input.value.replace(/\./g, ""); // Hapus semua titik (pemisah ribuan)
            });
        });

    });

        document.addEventListener("DOMContentLoaded", function () {
            // Format Cleave.js untuk input gaji
            var cleaveC = new Cleave("#gajiPokokInput", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
                delimiter: ".",
                numeralDecimalMark: ",",
                numeralDecimalScale: 0,

            });

            // Saat form disubmit, ubah nilai ke integer sebelum dikirim ke server
            document.getElementById("gajiForm").addEventListener("submit", function () {
                var gajiPokokInput = document.getElementById("gajiPokokInput");
                gajiPokokInput.value = gajiPokokInput.value.replace(/\./g, ""); // Hapus semua titik (pemisah ribuan)
            });
        
            // Event saat pegawai dipilih
            document.getElementById("nama").addEventListener("change", function () {
                var pegawaiId = this.value;
                if (pegawaiId) {
                    fetch(`/admin/gaji/${pegawaiId}/gaji-pokok`)
                        .then(response => response.json())
                        .then(data => {
                            // Set nilai gaji pokok dengan Cleave.js
                            cleaveC.setRawValue(data.gaji_pokok);
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
        </script>
  
@endpush