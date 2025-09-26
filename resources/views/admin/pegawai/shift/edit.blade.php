@extends('layout.app')
@section('konten-title', 'Data Shift')

@push('styles')

@endpush

@section('konten-header')
<div class="section-header">
  <h1>Edit Shift</h1>
</div>
@endsection
@section('konten-main')


<div class="row justify-content-center mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Form Data shift</h4>
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
                <form action="{{ route('shift.update', $shift->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama shift</label>
                            <input type="text" name="shift" class="form-control mb-2" value="{{ $shift->shift }}">
                            <label for="">Waktu Mulai</label>
                            <input type="text" name="waktu_mulai" class="form-control timepicker mb-2" value="{{ $shift->waktu_mulai }}">
                            <label for="">Waktu Akhir</label>
                            <input type="text" name="waktu_akhir" class="form-control timepicker mb-2" value="{{ $shift->waktu_akhir }}">
                            
                        </div>
                    </div>
                    
                    
                    <div class="d-flex justify-content-end mt-2">
                        <a href="{{ route('shift') }}" class="btn btn-danger mr-2">Back</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script src="{{ asset('/assets/js/page/components-table.js') }}"></script>

</script> 
@endpush