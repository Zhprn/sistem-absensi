<?php

namespace App\Http\Controllers\Users;

use App\Models\sop;
use App\Models\pegawai;
use App\Models\pegawaiTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
public function index()
{
    $userId = Auth::id();

    $status = '';
    $pending = 'pending';
    $proses = 'process';
    $done = 'done';

    $pegawai = Pegawai::with('bagian')->where('user_id', $userId)->first();
    $bagianId = $pegawai && $pegawai->bagian ? $pegawai->bagian->id : null;
    $sop = $bagianId ? Sop::where('bagian_id', $bagianId)->count() : 0;

    $task = PegawaiTask::with('pegawai', 'task')
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->where('status', '!=', 'done')
        ->whereHas('pegawai', function ($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })
        ->get();

    $allCount = PegawaiTask::with('pegawai', 'task')
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->whereHas('pegawai', function ($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })
        ->count();

    $pendingCount = PegawaiTask::with('pegawai', 'task')
        ->when($pending, function ($query, $pending) {
            return $query->where('status', $pending);
        })
        ->whereHas('pegawai', function ($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })
        ->count();

    $prosesCount = PegawaiTask::with('pegawai', 'task')
        ->when($proses, function ($query, $proses) {
            return $query->where('status', $proses);
        })
        ->whereHas('pegawai', function ($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })
        ->count();

    $totalProses = $pendingCount + $prosesCount;

    $doneCount = PegawaiTask::with('pegawai', 'task')
        ->when($done, function ($query, $done) {
            return $query->where('status', $done);
        })
        ->whereHas('pegawai', function ($query) use ($userId) {
            $query->where('pegawai.user_id', $userId);
        })
        ->count();

    return view('user.home', compact(
        'allCount',
        'totalProses',
        'doneCount',
        'sop',
        'task',
        'pegawai'
    ));
}


    public function downloadQr(Request $request){
        $userId = Auth::user()->id;
        $pegawai_id = pegawai::with('bagian')->where('user_id', $userId)->first();     
        $qrCode = QrCode::format('png')->size(500)->margin(2)->generate($pegawai_id->nip);
        $filename = 'qrcode_'. $pegawai_id->nip . '_' . $pegawai_id->nama_pegawai . '.png';   
     
         // Mengembalikan response dengan file QR Code
         return Response::make($qrCode, 200, [
             'Content-Type' => 'image/png',
             'Content-Disposition' => 'attachment; filename="' . $filename . '"'
         ]);
     }
}
