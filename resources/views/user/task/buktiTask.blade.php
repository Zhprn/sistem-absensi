@extends('layout.app')

@section('konten-header')
<div class="section-header">
    <h1>Bukti Tugas</h1>
  </div>
@endsection

@section('konten-main')
<div class="container">
    <h3>File yang diupload:</h3>

    @if (isset($pegawaitask->bukti) && file_exists($buktiPath))
        @php
            // Mendapatkan ekstensi file
            $fileExtension = pathinfo($pegawaitask->bukti, PATHINFO_EXTENSION);
        @endphp

        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif','JPG', 'JPEG', 'PNG', 'GIF']))
            <!-- Menampilkan gambar -->
            <img src="{{ asset('bukti/' . $pegawaitask->bukti) }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
        @elseif ($fileExtension === 'pdf')
            <!-- Menampilkan PDF -->
            <iframe src="{{ asset('bukti/' . $pegawaitask->bukti) }}" width="100%" height="500px"></iframe>
        @else
            <!-- Menampilkan link untuk file lainnya -->
            <p>File yang diupload: <a href="{{ asset('bukti/' . $pegawaitask->bukti) }}" target="_blank">{{ $pegawaitask->bukti }}</a></p>
        @endif
    @else
        <p>File tidak ditemukan.</p>
    @endif
</div>


@endsection