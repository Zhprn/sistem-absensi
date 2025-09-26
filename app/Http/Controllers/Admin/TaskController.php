<?php

namespace App\Http\Controllers\Admin;

use App\Models\task;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use App\Models\pegawaiTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
public function index(Request $request)
{
    $bagianFilter = $request->input('bagian');
    $jabatanFilter = $request->input('jabatan');
    $search = $request->input('cari_pegawai');
    $status = $request->input('status');
    
    $bagian = bagian::get();
    $jabatan = jabatan::get();

    // 🔹 Ambil semua task + relasi bagian
    $task = task::with('bagian')->get();

    $pegawai = pegawaiTask::with('pegawai', 'task') 
        ->when($search, function ($query, $search) {
            return $query->whereHas('pegawai', function ($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            });
        })
        ->when($bagianFilter, function ($query, $bagianFilter) {
            return $query->whereHas('pegawai', function ($query) use ($bagianFilter) {
                $query->where('bagian_id', $bagianFilter);
            });
        })
        ->when($jabatanFilter, function ($query, $jabatanFilter) {
            return $query->whereHas('pegawai', function ($query) use ($jabatanFilter) {
                $query->where('jabatan_id', $jabatanFilter);
            });
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->paginate(10);

    $statusCount = pegawaiTask::count();
    $pendingCount = pegawaiTask::where('status', 'pending')->count();
    $processCount = pegawaiTask::where('status', 'process')->count();
    $doneCount = pegawaiTask::where('status', 'done')->count();

    // 🔹 Jangan lupa kirim $task ke view
    return view('admin.task.task', compact(
        'task','pegawai','bagian','jabatan',
        'statusCount','pendingCount','processCount','doneCount'
    ));
}


    public function create(Request $request){
        $bagian = bagian::get();

        $bagianData = $request->bagianInput2;
        
        $task = task::with('bagian')
        ->whereHas('bagian', function($query) use ($bagianData) {
            return $query->where('id', $bagianData);
        })->get();

        $pegawai = pegawai::with('bagian','jabatan','shift')
        ->whereHas('bagian', function($query) use ($bagianData) {
            return $query->where('id', $bagianData);
        })
        ->get();

        return view('admin.task.tambah', compact('bagian','task','pegawai'));
    }

    public function store(Request $request){

        $request->validate([
            'tugasInput'  => 'required|min:3|max:30',
            'descInput'  => 'required|min:3|max:50',
            'bagianInput'  => 'required',
            'mulaiInput'  => 'required',
            'deadlineInput'  => 'required',
            
        ],[
            'tugasInput.required'=>'Title wajib diisi',
            'descInput.required'=>'Deskripsi wajib diisi',
            'bagianInput.required'=>'Pilih Bagian Terlebih Dahulu',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'tugas' => $request->tugasInput,
            'desc' => $request->descInput,
            'bagian_id' => $request->bagianInput,
            'waktu_mulai' => $request->mulaiInput,
            'waktu_deadline' => $request->deadlineInput,
        ];

        task::create($data);

        return redirect()->route('task.create');
    }

    public function edit($id){
        $task = task::find($id);
        $bagian = bagian::get();

        return view('admin.task.edit', compact('bagian','task'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'tugasInput'  => 'required|min:3|max:30',
            'descInput'  => 'required|min:3|max:50',
            'bagianInput'  => 'required',
            'mulaiInput'  => 'required',
            'deadlineInput'  => 'required',
            
        ],[
            'tugasInput.required'=>'Title wajib diisi',
            'descInput.required'=>'Deskripsi wajib diisi',
            'bagianInput.required'=>'Pilih Bagian Terlebih Dahulu',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'tugas' => $request->tugasInput,
            'desc' => $request->descInput,
            'bagian_id' => $request->bagianInput,
            'waktu_mulai' => $request->mulaiInput,
            'waktu_deadline' => $request->deadlineInput,
        ];

        task::where('id', $id)->update($data);

        return redirect()->route('task.create');
    }

    public function destroy(string $id){
        task::where('id', $id)->delete();
        return redirect()->route('task.create');
    }

    public function detailTask($id){
        $task = task::find($id);
        return view('admin.task.detail', compact('task'));
    }

    public function storePegawai(Request $request){
        $request->validate([
            'tasks'  => 'required',
            'pegawaiInput'  => 'required',
        
        ],[
            'tasks.required'=>'Pilih Tugas Terlebih Dahulu',
            'pegawaiInput.required'=>'Pilih Pegawai Yang Ingin Di Beri Tugas',
        ]);
        
        $pegawaiIdd = $request->pegawaiInput;
        $tugas = $request->tasks;

        $pegawaiId = pegawai::with('jabatan','bagian','shift')->findMany($request->pegawaiInput);

        $checkPegawaiTask = pegawaiTask::where('pegawai_id', $pegawaiIdd)
        ->whereIn('task_id', $tugas)
        ->exists();

        if ($checkPegawaiTask) {
            return redirect()->route('task.create')->with('info', 'Ada beberapa tugas yang sudah diberikan kepada pegawai');
        }

        foreach ($pegawaiId as $pegawai) {
            $pegawai->tasks()->syncWithoutDetaching($tugas);
        }
        
        return redirect()->route('task.index');
    }

    public function statusTask($id){
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        return view('admin.task.detailStatus', compact('pegawaitask'));
    }

    public function ubahStatus(Request $request,$id){
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $pegawai_id = $pegawaitask->pegawai_id;
        $task_id = $pegawaitask->task_id;
        $status = $request->statusTask;

        $pegawai = Pegawai::find($pegawai_id);
        $pegawai->tasks()->updateExistingPivot($task_id , [
            'status' => $status,
        ]);

        return redirect()->route('task.index');
    }

    public function buktiTask($id){
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $buktiPath = public_path('bukti')."/".$pegawaitask->bukti;
    
        return view('user.task.buktiTask', compact('pegawaitask', 'buktiPath'));
    }
}
