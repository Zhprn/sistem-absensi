<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Pegawai;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function absenmasuk()
    {
        $today = Carbon::today()->toDateString();
        $userId = Auth::id();

        $pegawai = Pegawai::with('attendances')->where('user_id', $userId)->first();
        $absen_hari_ini = $pegawai?->attendances()->whereDate('date', $today)->first();

        return view('user.absensi.absensimasuk', [
            'statusAbsenMasuk' => $absen_hari_ini->status ?? null,
            'jamAbsenMasuk'    => $absen_hari_ini?->waktu_masuk,
            'jamAbsenKeluar'   => $absen_hari_ini?->waktu_keluar,
        ]);
    }

    public function absenkeluar()
    {
        $today = Carbon::today()->toDateString();
        $userId = Auth::id();

        $pegawai = Pegawai::with('attendances')->where('user_id', $userId)->first();
        $absen_hari_ini = $pegawai?->attendances()->whereDate('date', $today)->first();

        return view('user.absensi.absensikeluar', [
            'statusAbsenMasuk' => $absen_hari_ini->status ?? null,
            'jamAbsenMasuk'    => $absen_hari_ini?->waktu_masuk,
            'jamAbsenKeluar'   => $absen_hari_ini?->waktu_keluar,
        ]);
    }

    public function absenmasukStore(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta'); // jam real time
        $formattedDate = $now->toDateString();
        $formattedTime = $now->format('H:i:s');

        $pegawai = Pegawai::where('nip', $request->qr_code)->first();

        if (!$pegawai || $pegawai->user_id !== Auth::id()) {
            return redirect()->route('absen.masuk')->with('gagal', 'QR Code Tidak Sesuai!');
        }

        $sudah_absen = Attendance::where('pegawai_id', $pegawai->id)
            ->whereDate('date', $formattedDate)
            ->first();

        if ($sudah_absen) {
            return redirect()->route('absen.masuk')->with('gagal', 'Pegawai sudah absen hari ini!');
        }

        // cek shift
        $shift = Shift::find($pegawai->shift_id);
        $mulai = Carbon::parse($shift->waktu_mulai);
        $akhir = Carbon::parse($shift->waktu_akhir);
        $batas_telat = $mulai->copy()->addMinutes(15);

        if ($now->between($mulai, $batas_telat)) {
            $status = 'present';
        } elseif ($now->between($batas_telat, $akhir)) {
            $status = 'late';
        } else {
            return redirect()->route('absen.masuk')->with('gagal', 'Diluar Jadwal Shift');
        }

        Attendance::create([
            'pegawai_id'  => $pegawai->id,
            'date'        => $formattedDate,
            'waktu_masuk' => $formattedTime,
            'status'      => $status,
            'note'        => $request->note,
        ]);

        return redirect()->route('absen.masuk')->with('success', 'Pegawai Berhasil Absensi!');
    }

    public function absenkeluarStore(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta'); // jam real time
        $formattedDate = $now->toDateString();
        $formattedTime = $now->format('H:i:s');

        $pegawai = Pegawai::where('nip', $request->qr_code)->first();

        if (!$pegawai || $pegawai->user_id !== Auth::id()) {
            return redirect()->route('absen.keluar')->with('gagal', 'QR Code Tidak Sesuai!');
        }

        $absen = Attendance::where('pegawai_id', $pegawai->id)
            ->whereDate('date', $formattedDate)
            ->first();

        if (!$absen) {
            return redirect()->route('absen.keluar')->with('gagal', 'Pegawai Belum Absen Hari Ini');
        }

        if ($absen->waktu_keluar) {
            return redirect()->route('absen.keluar')->with('gagal', 'Pegawai Sudah Absen Keluar');
        }

        $absen->update([
            'waktu_keluar' => $formattedTime,
        ]);

        return redirect()->route('absen.keluar')->with('success', 'Pegawai Berhasil Absen Keluar!');
    }
}
