<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\sop;
use App\Models\task;
use App\Models\pegawai;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){

        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');

        // Memanggil Data Untuk Card Stastistic
        $pegawaiData = pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->get();
        //Pegawai Paginate
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->latest()->paginate(5);

        $attendances = attendance::where('date', date('Y-m-d'))->get();
        $sop = sop::get();
        $task = task::paginate(5);

        // Dashboard card
        $pegawaiCount = $pegawaiData->count();
        $absenToday = $attendances->where('status' , 'present')->count();
        
        $lateCount = $attendances->where('status' , 'late')->count();
        $presentLateCount = $absenToday + $lateCount; 
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($absenToday + $lateCount + $excusedCount + $sickCount);
        
        $sopCount = $sop->count();
        $taskCount = $task->count();


        return view('admin.welcome', compact('pegawaiCount','presentLateCount','taskCount','sopCount','pegawai','task','excusedCount','sickCount','absentCount'));
    }
}
