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
                    <form action="{{ route('usertask.index') }}" method="GET">
                        <input type="hidden"  value="">
                        <button type="submit" class="nav-link {{ request('status') == '' ? 'active' : '' }}">All <span class="badge {{ request('status') == '' ? 'badge-white' : 'badge-primary' }}">{{ $allCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('usertask.index') }}" method="GET">
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">Pending <span class="badge {{ request('status') == 'pending' ? 'badge-white' : 'badge-primary' }}">{{ $pendingCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('usertask.index') }}" method="GET">
                        <input type="hidden" name="status" value="process">
                        <button type="submit" class="nav-link {{ request('status') == 'process' ? 'active' : '' }}">Proses <span class="badge {{ request('status') == 'process' ? 'badge-white' : 'badge-primary' }}">{{ $prosesCount }}</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="{{ route('usertask.index') }}" method="GET">
                        <input type="hidden" name="status" value="done">
                        <button type="submit" class="nav-link {{ request('status') == 'done' ? 'active' : '' }}">Done <span class="badge {{ request('status') == 'done' ? 'badge-white' : 'badge-primary' }}">{{ $doneCount }}</span></button>
                    </form>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </div>

    <div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>List Tugas</h4>
                
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Tugas</th>
                                    <th>Bagian</th>
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
                                {{-- @foreach ($pegawai as $data)  --}}
                                    @foreach ($pegawai as $taskData)   
                                        <tr>
                                            <td class="text-center">{{ ++$no }}</td>
                                            <td>{{ $taskData->task->tugas }}</td>
                                            <td>{{ $taskData->pegawai->bagian->bagian }}</td>
                                            <td><div class="badge {{ $taskData->status === 'done' ? 'badge-success' : 'badge-warning' }}">{{ $taskData->status === 'pending' ? 'Pending' : ($taskData->status === 'process' ? 'Proses' : ($taskData->status === 'done' ? 'Selesai' : $taskData->status))}}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->task->waktu_mulai }}</div></td>
                                            <td><div class="badge badge-info">{{ $taskData->task->waktu_deadline }}</div></td>
                                            <td><a href="{{  route('usertask.detail', $taskData->id)  }}" class="btn btn-sm btn-primary">Detail</a></td>
                                        </tr>                                  
                                    @endforeach                  
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    {{-- {{ $pegawai->links() }} --}}
                </div>

            </div>
        </div>
    </div>
    
@endsection