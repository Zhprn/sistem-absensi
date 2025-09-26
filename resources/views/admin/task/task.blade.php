@extends('layout.app')
@section('konten-title', 'Data Tugas')

@section('konten-header')
<div class="section-header">
    <h1>List Tugas</h1>
</div>
@endsection

@section('konten-main')

    <div class="row">
        <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <form action="{{ route('task.index') }}" method="GET">
                        {{-- @csrf --}}
                        <input type="hidden"  value="">
                        <button type="submit" class="nav-link {{ request('status') == '' ? 'active' : '' }}">All <span class="badge {{ request('status') == '' ? 'badge-white' : 'badge-primary' }}">{{ $statusCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('task.index') }}" method="GET">
                        {{-- @csrf --}}
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">Pending <span class="badge {{ request('status') == 'pending' ? 'badge-white' : 'badge-primary' }}">{{ $pendingCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('task.index') }}" method="GET">
                        {{-- @csrf --}}
                        <input type="hidden" name="status" value="process">
                        <button type="submit" class="nav-link {{ request('status') == 'process' ? 'active' : '' }}">Proses <span class="badge {{ request('status') == 'process' ? 'badge-white' : 'badge-primary' }}">{{ $processCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('task.index') }}" method="GET">
                        {{-- @csrf --}}
                        <input type="hidden" name="status" value="done">
                        <button type="submit" class="nav-link {{ request('status') == 'done' ? 'active' : '' }}">Done <span class="badge {{ request('status') == 'done' ? 'badge-white' : 'badge-primary' }}">{{ $doneCount }}</span></button>
                    </form>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </div>

    <div class=" mt-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Tugas</h4>
                <div class="card-header-action">
                    <a href="{{ route('task.create') }}" class="btn btn-success mr-2"><i class="fa fas fa-plus"></i> Tambah Data</a>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <form action="#" method="get">
                        <H5>Filter : </H5>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="role" class="col-form-label">Cari Pegawai : </label>
                                    <input type="text" class="form-control" name="cari_pegawai">
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


                <div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Bagian</th>
                                    <th>Nama Tugas</th>
                                    <th>Status</th>
                                    <th>Waktu Mulai Tugas</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($pegawai as $data) 
                                <tr>
                                    <td class="text-center">{{ ++$no }}</td>
                                    <td>{{ $data->pegawai->nip }}</td> 
                                    <td>{{ $data->pegawai->nama_pegawai }}</td> 
                                    <td>{{ $data->pegawai->bagian->bagian }}</td> 
                                    <td>{{ $data->task->tugas }}</td> 
                                    <td>
                                        <div class="badge 
                                            {{ $data->status === 'done' ? 'badge-success' : 
                                            ($data->status === 'process' ? 'badge-warning' : 'badge-warning') }}">
                                            {{ 
                                                $data->status === 'done' ? 'Selesai' : 
                                                ($data->status === 'process' ? 'Proses' : 
                                                ($data->status === 'pending' ? 'Pending' : $data->status)) 
                                            }}
                                        </div>
                                    </td>
                                    <td><div class="badge badge-info">{{ $data->task->waktu_mulai }}</div></td>
                                    <td><div class="badge badge-info">{{ $data->task->waktu_deadline }}</div></td>                           
                                    <td><a href="{{ route('task.status', $data->id) }}" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>                                  
                            @endforeach
                            
                                {{-- @foreach ($pegawai as $data) 
                                    @foreach ($data->tasks as $taskData)   
                                        <tr>
                                            <td class="text-center">{{ ++$no }}</td>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nama_pegawai }}</td>
                                            <td>{{ $data->bagian->bagian }}</td>
                                            <td>{{ $taskData->tugas }}</td>
                                            <td><div class="badge {{ $taskData->pivot->status === 'done' ? 'badge-success' : 'badge-warning' }}">{{ $taskData->pivot->status === 'pending' ? 'Pending' : ($taskData->pivot->status === 'process' ? 'Proses' : ($taskData->pivot->status === 'done' ? 'Selesai' : $taskData->pivot->status))}}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_mulai }}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->waktu_deadline }}</div></td>
                                            <td><a href="" class="btn btn-sm btn-primary">Detail</a></td>
                                        </tr>                                  
                                    @endforeach                  
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    {{ $pegawai->links() }}
                </div>

            </div>
        </div>
    </div>
    
@endsection

@push('scripts')

<!-- Page Specific JS File -->
<script src="{{ asset('/assets/js/page/features-posts.js') }}"></script>

{{-- <script>
    $(document).ready(function() {
        $('.nav-link').on('click', function(e) {
            e.preventDefault();
            var status = $(this).data('status');
            $.ajax({
                url: '{{ route("task.index") }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle error response
                    console.error(xhr);
                }
            });
        });
    });
</script> --}}

    
@endpush