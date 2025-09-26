@extends('layout.app')
@section('konten-title', 'Data Bagian')

@push('styles')

@endpush

@section('konten-header')
<div class="section-header">
  <h1>Edit Bagian</h1>
</div>
@endsection
@section('konten-main')


<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Data Bagian</h4>
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
                <form action="{{ route('bagian.update', $bagian->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama bagian</label>
                            <input type="text" name="bagian" class="form-control mb-2" value="{{ $bagian->bagian }}">
                            <label for="">Deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control mb-2" value="{{ $bagian->deskripsi }}">
                            
                        </div>
                    </div>
                    
                    
                    <div class="d-flex justify-content-end mt-2">
                        <a href="{{ route('bagian') }}" class="btn btn-danger mr-2">Back</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')


</script> 
@endpush