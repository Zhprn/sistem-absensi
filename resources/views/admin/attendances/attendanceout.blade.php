@extends('layout.app')
@section('konten-title', 'Absen Keluar')

@section('title-body', 'Attendances')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('konten-header')
<div class="section-header" >
  <h1>Absensi Keluar</h1>
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
                {{-- <label for="">Shift</label>
                        <div class="input-group mb-3">
                        <select class="form-control" name="shift" required>
                            <option selected disabled>Pilih Shift.</option>
                            @foreach ($shift as $data)
                            <option value="{{ $data->id }}">{{ $data->shift }} | {{ $data->waktu_mulai }} - {{ $data->waktu_akhir }} </option>
                            @endforeach
                                 
                        </select>
                </div> --}}
                <div  id="reader" width="600px"></div>
                <input type="hidden" name="result" id="result">
                {{-- <div>
                    <button class="btn btn-success mt-3"><i class="fa fa-reguler fa-envelope-open-text"></i>  Ajukan Izin</button>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>List Pegawai Absensi Hari Ini</h4>

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
                
                <div class="table-responsive mt-2">
                    <table class="table table-striped" id="table-1">
                      <thead>
                        <tr>
                          <th class="text-center">
                            #
                          </th>
                          <th>NIP</th>
                          <th>Nama Pegawai</th>
                          <th>Status</th>
                          <th>Waktu Masuk</th>
                          <th>Waktu Keluar</th>
                          
                        </tr>
                      </thead>
                      <tbody>
    
                        @foreach($pegawai as $no=>$dataP)
                          @if($dataP->attendances->isEmpty())
                            <tr>
                              <td class="text-center">{{ $no+1 }}</td>
                              <td>{{ $dataP->nip }}</td>
                              <td>{{ $dataP->nama_pegawai }}</td>
                              <td><div class="badge badge-danger">Tidak Hadir</div></td>
                              <td>-</td>
                              <td><div>-</div></td>
                            </tr>
                          @else
                          @foreach($dataP->attendances as $dataA)
                        <tr>
                            <td class="text-center">{{ $no+1 }}</td>
                            <td>{{ $dataP->nip }}</td>
                            <td>{{ $dataP->nama_pegawai }}</td>
    
                            <td><div class="badge {{ $dataA->status == 'present' ? 'badge-success' : 
                            ($dataA->status == 'late' ? 'badge-warning' : ($dataA->status == 'excused' ? 'badge-info' : ($dataA->status == 'sick' ? 'badge-info' : 'badge-danger'))) }}">{{ $dataA->getStatusInIndonesian()}}</div></td>
    
                            <td>{{ $dataA->waktu_masuk }}</td>
                            <td><div class="badge {{ $dataA->waktu_keluar == null ? 'badge-warning' : '' }}">{{ $dataA->waktu_keluar == null ? 'Belum Keluar' : $dataA->waktu_keluar }}</div></td>
 
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                    
            </div>
            <div class="card-footer">
                    <!-- Menampilkan link pagination -->
                    <div class="d-flex justify-content-end">
                        {{ $pegawai->links() }} <!-- Ini akan menampilkan link pagination -->
                    </div>
              </div>
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
                    'action': "{{ route('attendances.outPost') }}", // Ganti dengan rute yang sesuai
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