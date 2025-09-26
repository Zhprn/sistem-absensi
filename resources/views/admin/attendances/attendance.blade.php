@extends('layout.app')
@section('konten-title', 'Absensi Masuk')

@section('title-body', 'Attendances')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('konten-header')
<div class="section-header" >
  <h1>Absensi Masuk</h1>
</div>
@endsection

@section('konten-main')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Scan Barcode</h4>
            </div>
            <div class="card-body">
                
                <div id="reader" width="600px"></div>
                <input type="hidden" name="result" id="result">
                
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Pegawai Tidak Hadir/Izin</h4>
                <div class="card-header-action"><a href="{{ route('listAttendances') }}" class="btn btn-success"><i class="fa far fa-clipboard"></i> List Absensi Hari Ini</a></div>
            </div>
            <div class="card-body">
                @if (session('gagal'))
                <div class="alert alert-danger">
                    <h5>{{ session('gagal') }}</h4>
                </div>
                @elseif (session('success'))
                <div class="alert alert-success">
                    <h5>{{ session('success') }}</h4>
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('attendances.inPost') }}" method="post">
                    @csrf
                    <label for="">Pegawai</label>
                        <div class="input-group mb-3">
                        <select class="form-control select2" name="pegawai" required>
                            <option selected disabled>Pilih Pegawai.</option>
                            @foreach ($pegawai as $data)
                            <option value="{{ $data->id }}">{{ $data->nama_pegawai }}</option>
                            @endforeach
                                 
                        </select>
                        
                    </div>

                    <label for="">Status</label>
                        <div class="input-group mb-3">
                        <select class="form-control" name="status" required>
                            <option selected disabled>Pilih Status..</option>
                      
                            {{-- <option value="present">Hadir</option>
                            <option value="late">Telat</option> --}}
                            <option value="excused">Izin</option>
                            <option value="sick">Sakit</option>
                            <option value="absent">Absen</option>
                              
                        </select>
                    </div>

                    <label for="">Note <i class="text-danger"> *</i></label>
                    <input type="text" class="form-control" name="note">
                    
                    
                    <div class="d-flex justify-content-end">

                        <button class="btn btn-success mt-3"><i class="fa fa-reguler fa-envelope-open-text"></i>  Ajukan Izin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')

{{-- HTML5 QRCODE --}}
<script src="{{ asset('assets/js/html5-qrcode.js') }}" type="text/javascript"></script>
<script>
 // $('#result').val('test');
        function onScanSuccess(decodedText, decodedResult) {
            // Set hasil pemindaian ke input tersembunyi
            $('#result').val(decodedText);
            // Hentikan pemindaian setelah berhasil
            html5QrcodeScanner.clear().then(_ => {
                // Lakukan logika yang diperlukan, misalnya mengarahkan ke rute
                let form = $('<form>', {
                    'action': "{{ route('attendances.inPost') }}", // Ganti dengan rute yang sesuai
                    'method': 'POST'
                });

                // Tambahkan CSRF token
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': $('meta[name="csrf-token"]').attr('content')
                }));

                // Tambahkan data QR Code
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'qr_code',
                    'value': decodedText
                }));

                // Tambahkan form ke body dan submit
                $(document.body).append(form);
                form.submit();
            }).catch(error => {
                alert('something wrong');
            });
        }
        function onScanFailure(error) {
            // Handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: { width: 250, height: 250 }, disableFlip: true },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush