<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailAbsenController extends Controller
{
    public function __invoke()
    {
        return view('user.absensi.detailabsenpegawai');
    }

    public function getAbsensi()
    {
        $events = [];
        $userId = Auth::user()->id;

        $absensi = pegawai::with('attendances')->where('user_id', $userId)->first();

        if ($absensi) {
            foreach ($absensi->attendances as $dataA) {
                // hanya buat event kalau ada waktu_masuk
                if ($dataA->waktu_masuk) {
                    $startDateTime = $dataA->date . ' ' . $dataA->waktu_masuk;
                    $endDateTime   = $dataA->waktu_keluar
                        ? $dataA->date . ' ' . $dataA->waktu_keluar
                        : null;

                    $events[] = [
                        'title' => $dataA->status,
                        'start' => $startDateTime,
                        'end'   => $endDateTime,
                    ];
                }
            }
        }

        return response()->json($events);
    }
}
