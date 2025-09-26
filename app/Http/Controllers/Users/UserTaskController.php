<?php

namespace App\Http\Controllers\Users;

use App\Models\task;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pegawaiTask;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index(Request $request){
        $userId = Auth::user()->id;

        $status = $request->input('status');

        $pending = 'pending';
        $proses = 'process';
        $done = 'done';


        $pegawai = pegawaiTask::with('pegawai', 'task')
        ->when($status, function($query, $status) {
            // Filter status
            return $query->where('status', $status);
        })
        ->whereHas('pegawai', function($query) use ($userId) {
            // Filter user_id
            $query->where('pegawai.user_id', $userId);
        })
        ->get();
            

        $allCount = pegawaiTask::with('pegawai', 'task')
        ->when($status, function($query, $status) {
            // Filter berdasarkan status jika ada
            return $query->where('status', $status);
        })
        ->whereHas('pegawai', function($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })->count();

        $pendingCount = pegawaiTask::with('pegawai', 'task')
        ->when($pending, function ($query, $pending) { 
            return $query->where('status', $pending); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();

        $prosesCount = pegawaiTask::with('pegawai', 'task')
        ->when($proses, function ($query, $proses) { 
            return $query->where('status', $proses); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();


        $doneCount = pegawaiTask::with('pegawai', 'task')
        ->when($done, function ($query, $done) { 
            return $query->where('status', $done); 
        })
        ->when($userId, function($query, $userId) {
            return $query->whereHas('pegawai', function ($query) use ($userId) {
                $query->where('pegawai.user_id', $userId);
            });
        })
        ->count();

       
        
    
        return view('user.task.task', compact('pegawai','allCount','pendingCount','prosesCount','doneCount'));
    }

    public function detailTask($id){
        $userId = Auth::user()->id;
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        // $sop = $pegawaitask->task->sop->title;
        
        
        
        return view('user.task.detailTask', compact('pegawaitask'));
        
    }

    public function statusTask(Request $request, string $id){
        // dd($request->all());

        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $pegawai_id = $pegawaitask->pegawai_id;  // Mendapatkan pegawai_id
        $task_id = $pegawaitask->task_id;        // Mendapatkan task_id

        // dd($pegawai_id,$task_id);
        $request->validate([
            'statusTask'  => 'required',
            'buktiFile' => 'file|mimes:jpg,jpeg,png,pdf|max:5048',
            
        ],[
            'statusTask.required'=>'Pilih Status',
            'max'=>'File Maksimal 5 MB',
        ]);

        $title = str_replace(' ', '', $request->titleTask);
        $status = $request->statusTask;

        if($status === 'done'){
            $request->validate([
                'buktiFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5048',
                
            ],[
                'buktiFile.required'=>'Upload File Bukti Terlebih Dahulu',
                'max'=>'File Maksimal 5 MB',
            ]);
        }

        
        // File
        if ($request->hasFile('buktiFile')) {

            if (isset($pegawaitask->bukti) && file_exists(public_path('bukti')."/".$pegawaitask->bukti)) {
                unlink(public_path('bukti')."/".$pegawaitask->bukti);
            }

            $file = $request->file('buktiFile');
            $fileNameOrigin = $file->getClientOriginalName();
            $cleaned_name = str_replace(' ', '_', $fileNameOrigin);
            $file_name = time()."_". "$title" ."_".$cleaned_name;
            $destination_path = public_path('bukti');
            $file->move($destination_path, $file_name);
    
        }

        // dd($request->file('buktiFile'));

        
        // $data = [
        //     'status' => $status,
        //     'bukti' => isset($file_name)?$file_name:$pegawaitask->bukti,
        // ];

        
        // pegawaiTask::where('id', $id)->update($data);

        $pegawai = Pegawai::find($pegawai_id);
        $pegawai->tasks()->updateExistingPivot($task_id , [
            'status' => $status,
            'bukti' => isset($file_name) ? $file_name : $pegawai->tasks()->find($task_id )->pivot->bukti
        ]);


        return redirect()->route('usertask.index');
    }

    public function buktiTask($id){
        // $userId = Auth::user()->id;
        $pegawaitask = pegawaiTask::with('pegawai','task')->find($id);
        $buktiPath = public_path('bukti')."/".$pegawaitask->bukti;
    
        // dd($buktiPath);

        return view('user.task.buktiTask', compact('pegawaitask', 'buktiPath'));
    }
}
