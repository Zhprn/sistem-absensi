@extends('layout.app')
@section('konten-title', 'Data Pegawai')

@push('styles')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet"> --}}
@endpush

@section('konten-header')
<div class="section-header">
  <h1>Edit Pegawai</h1>
</div>
@endsection
@section('konten-main')

<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Data Pegawai</h4>
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
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post" id="gajiForm" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div>
                        <label for="foto">Foto</label>
                    </div>
                    @php
                        $fotoPath = public_path(getenv('CUSTOM_NAME_LOCATION').'/'.$pegawai->foto);
                    @endphp
                        @if (isset($pegawai->foto) && !empty($pegawai->foto) && file_exists($fotoPath))
                            <img src="{{ asset(getenv('CUSTOM_NAME_LOCATION').'/'.$pegawai->foto) }}" alt="" class="img-thumbnail w-25 h-25" id="previewImage">
                        @else
                            <img src="{{ asset('/assets/img/avatar/avatar-1.png') }}" alt="Default Avatar" class="img-thumbnail w-25 h-25" id="previewImage">   
                        @endif
                        
                    <input type="file" name="foto" class="form-control mb-4" id="fotoInput">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nomor Induk Pegawai</label>
                            <input type="text" name="nip" class="form-control mb-2" value="{{ $pegawai->nip }}">
                            <label for="">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control mb-2" value="{{ $pegawai->nama_pegawai }}">
                            <label for="">Alamat</label>
                            <input type="text" name="alamat" class="form-control mb-2" value="{{ $pegawai->alamat }}">
                            <label for="">Gender</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="gender">
                                    <option value="1" {{ $pegawai->gender == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki</option>
                                    <option value="2" {{ $pegawai->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                              </div>

                            <label for="">No Telepon</label>
                            <input type="text" name="telepon" class="form-control mb-2" id="telepon" value="{{ $pegawai->telepon }}">
                            
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Lahir</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="date" class="form-control" name="tgl_lahir" value="{{ $pegawai->tgl_lahir }}">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label for="">Jabatan</label>
                            <div class="input-group mb-3">
                                <select class="form-control select2" name="jabatan" required>
                                    <option selected disabled>Pilih Jabatan..</option>
                                    @foreach($jabatan as $data_jabatan)
                                        <option value="{{ $data_jabatan->id }}"  {{ $data_jabatan->id == $pegawai->jabatan_id ? 'selected' : '' }}>{{ $data_jabatan->jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="">Bagian</label>
                            <div class="input-group mb-3">
                                <select class="form-control select2" name="bagian" required>
                                    <option selected disabled>Pilih Bagian..</option>
                                    @foreach($bagian as $data_bagian)
                                        <option value="{{ $data_bagian->id }}" {{ $data_bagian->id == $pegawai->bagian_id ? 'selected' : '' }}>{{ $data_bagian->bagian }}</option>
                                    @endforeach
                                </select>
                            </div>
                                
                            <label for="">Shift</label>
                            <div class="input-group mb-3">
                            <select class="form-control select2" name="shift" required>
                                <option selected disabled>Pilih Shift..</option>
                                @foreach($shift as $data_shift)
                                    <option value="{{ $data_shift->id }}" {{ $data_shift->id == $pegawai->shift_id ? 'selected' : '' }}>{{ $data_shift->shift }}</option>
                                @endforeach
                            </select>
                            </div>
                            
                            <label for="">Gaji Pokok</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input class="form-control currency" type="text" name="gajiInput" value="{{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="d-flex justify-content-end mt-2">
                        <a href="{{ route('pegawai') }}" class="btn btn-danger mr-2">Back</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script>

$('.datepicker').datepicker({
    format: 'mm-dd-yyyy',
    startDate: '-3d' 
});  --}}
<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('previewImage');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Set src ke hasil pembacaan file
                previewImage.style.display = 'block'; // Tampilkan gambar
            }
            reader.readAsDataURL(file); // Membaca file sebagai URL data
        } else {
            previewImage.src = ''; // Reset src jika tidak ada file
            previewImage.style.display = 'none'; // Sembunyikan gambar
        }
    });

    document.getElementById("telepon").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

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
</script>

</script> 
@endpush