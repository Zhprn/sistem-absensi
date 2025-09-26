<?php

namespace App\Services;

use illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\pegawai;
use App\Models\attendance;

class AbsenGenerate {
    public function __invoke()
    {
        $today = Carbon::today();
        $tglFormat = Carbon::parse($today)->format('Y-m-d');

        $pegawaiData = Pegawai::whereDoesntHave('attendances', function($query) use ($tglFormat) {
            $query->whereDate('date', $tglFormat);
        })->with(['jabatan', 'bagian', 'shift'])->pluck('id');
        

        foreach ($pegawaiData as $pegawai_id) {
            Attendance::create([
                'pegawai_id' => $pegawai_id,
                'date' => $tglFormat,
                'status' => 'absent',
            ]);
        }
    }
}