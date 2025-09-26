@extends('layout.app')
@section('konten-title', 'Barcode')

@section('title-body', 'Attendances')

@push('styles')

@endpush

@section('konten-header')
<div class="section-header" >
  <h1>QR Code</h1>
</div>
@endsection

@section('konten-main')


        <div class="card">
            <div class="card-header">
                <h4>List QR Code</h4>
                <div class="card-header-action">
                    <form action="{{ route('barcode.index') }}" method="get">
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
                <div class="container">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-success" href="{{ route('barcode.downloadAll') }}"><i class="fa fas fa-download"></i> Download Semua</a>
                </div>
                <div class="row mt-4">
                        @foreach ($pegawai as $data)
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="text-dark">{{ $data->nama_pegawai }}</h4>
                                    <div class="card-header-action">
                                        <a class="btn btn-success" href="{{ route('barcode.download', ['pegawai_id' => $data->id]) }}"><i class="fas fa-download"></i></a>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <div class="visible-print ">
                                        {!! QrCode::size(150)->generate($data->nip); !!}
                                    </div>
                                    <p class="mt-2">NIP :{{ $data->nip }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                    <div class="d-flex justify-content-end">
                    {{ $pegawai->links() }}
                    </div>
                </div>
            </div>
            
        </div>

@endsection