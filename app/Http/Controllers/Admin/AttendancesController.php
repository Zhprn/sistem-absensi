<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\shift;
use App\Models\pegawai;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\bagian;
use App\Models\jabatan;

class AttendancesController extends Controller
{
    //ABSENSI MASUK
    public function AttendanceIn() {

        $pegawai = Pegawai::all();
        $shift = Shift::all();

        
        return view('admin.attendances.attendance' , compact('pegawai','shift'));
    }

    public function validasi(Request $request){

        // dd($request->all());
        $qr = $request->qr_code;
        $data = '6474765401146968'; 
        
        if($qr == $data){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Melakukan Absensi'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Gagal Melakukan Absensi'
            ]);
        }
    }

    public function AttendanceInList(Request $request) {

        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');
        $dateInput = Carbon::parse($request->input('dateInput'))->format('Y-m-d');

        //Mengambil data pegawai dan attendaces
        $attendances = Attendance::where('date', date('Y-m-d'))->get();
        //Pegawai Paginate
        $pegawai = Pegawai::with(['attendances' => function($query) use ($dateInput){
            $query->whereDate('date', $dateInput);
        },'jabatan','bagian','shift'])->paginate(10);

        //Count Pegawai
        $pegawaiData = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->get();


        //Menghitung jumlah keterangan absen
        $pegawaiCount = $pegawaiData->count();
        $presentCount = $attendances->where('status' , 'present')->count();
        $lateCount = $attendances->where('status' , 'late')->count();
        $presentLateCount = $presentCount + $lateCount; 
        $excusedCount = $attendances->where('status' , 'excused')->count();
        $sickCount = $attendances->where('status' , 'sick')->count();
        $absentCount = $pegawaiCount - ($presentCount + $lateCount + $excusedCount + $sickCount);

        

       
        return view('admin.attendances.reportAttend.listattend', compact('pegawai','pegawaiCount','presentCount','presentLateCount','excusedCount','sickCount','lateCount','absentCount'));
    }

    public function DetailAttendancesitem($id){
        
        $today = Carbon::today();
        $date =  Carbon::parse($today)->format('Y-m-d');

        $pegawaitask = attendance::with('pegawai')->find($id);

        

        // dd($pegawaitask);
        return view('admin.attendances.reportAttend.detailAttend', compact('pegawaitask'));
    }

    public function StatusAttendanceUpdate(Request $request,$id){
        $request->validate([
            'statusTask'  => 'required',
            
        ],[
            'statusTask.required'=>'Pilih Status',
            
        ]);

        $data = [
            'status' => $request->statusTask,
            'note' => $request->noteInput ?? null,
        ];

        attendance::where('id', $id)->update($data);

        return redirect()->route('listAttendances');
    }

    public function AttendancesDetailWeek(Request $request) {

        // Mendapatkan tanggal awal dan akhir minggu ini
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $thisWeekLabel = $startOfWeek->format('W, o'); // Label untuk minggu ini
        $thisWeekValue = $startOfWeek->format('Y-m-d'); // Nilai untuk minggu ini


        $search = $request->input('cari_pegawai');
        $weekInput = $request->input('weekInputs');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');
        
        $weekInputStatus = Carbon::parse($weekInput)->format('W, o');
        $weekInputPdf = Carbon::parse($weekInput)->format('Y-m-d');
        $weekInputS = Carbon::parse($weekInput)->startOfWeek()->format('Y-m-d');
        $weekInputE = Carbon::parse($weekInput)->endOfWeek()->format('Y-m-d');

        $weeks = [];
        while ($startOfLastYear->lte($startOfWeek)) {
            $weeks[] = [
                'label' => $startOfLastYear->format('W, o'),
                'value' => $startOfLastYear->format('Y-m-d'),
                'has_events' => false, // Default tidak ada event
                'is_current' => $startOfLastYear->format('W, o') === $thisWeekLabel
            ];
            $startOfLastYear->addWeek();
        }
        
        // Jika ada minggu yang dipilih, hitung tanggal akhir minggu
        $data = [];
        $endOfWeekss = null;

        for ($i = 0; $i < 7; $i++) {
            $data[] = $startOfWeek->copy()->addDays($i)->format('d/m');
        }

        if ($request->has('weekInputs')) {
            $selectedWeekStart = Carbon::parse($weekInput); 

            $data = [];
            for ($i = 0; $i < 7; $i++) {
                $data[] = $selectedWeekStart->copy()->addDays($i)->format('d/m');
            }
        }
        // $endOfWeekss = $selectedWeekStart->endOfWeek(Carbon::MONDAY)->format('Y-m-d'); // Hitung akhir minggu

        // dd($endOfWeekss);

        // minggu ini
        // $data = [];
        // for ($i = 0; $i < 7; $i++) {
        //     $data[] = $startOfWeek->copy()->addDays($i)->format('d/m');
        // }


        //Query Database
        $pegawai = Pegawai::with(['attendances' => function($query) use ($weekInputS,$weekInputE){
            $query->whereBetween('date', [$weekInputS,$weekInputE]);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); 
        })->paginate(10);

    

        $jabatan = jabatan::all();
        $bagian = bagian::all();

        // Mengonversi status absensi ke format d/m
        foreach ($pegawai as $dataP) {
            foreach ($dataP->attendances as $attendance) {
                $attendance->formatted_date = Carbon::parse($attendance->date)->format('d/m');
            }

        }

       
        return view('admin.attendances.reportAttend.detailAttendWeek', compact('data','pegawai','jabatan','bagian','weeks','weekInputStatus','weekInput','weekInputPdf'));
    }


    Public function AttendancesDetailMonth(Request $request) {

        $search = $request->input('cari_pegawai');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');
        $monthInput = $request->input('monthInputs');
        // Mendapatkan tanggal awal dan akhir Bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $thisMonthLabel = $startOfMonth->format('F, Y'); // Label untuk minggu ini
        $thisMonthValue = $startOfMonth->format('Y-m-01'); // Nilai untuk minggu ini

        $monthInputStatus = Carbon::parse($monthInput)->format('F, Y');
        $monthInputPdf = Carbon::parse($monthInput)->format('Y-m-d');
        $monthInputS = Carbon::parse($monthInput)->startOfmonth()->format('Y-m-d');
        $monthInputE = Carbon::parse($monthInput)->endOfmonth()->format('Y-m-d');

        // data untuk memilih bulan di Select
        $months = [];
        while ($startOfLastYear->lte($startOfMonth)) {
            $months[] = [
                'label' => $startOfLastYear->format('F, Y'),
                'value' => $startOfLastYear->format('Y-m-01'),
                'has_events' => false, // Default tidak ada event
                'is_current' => $startOfLastYear->format('F, Y') === $thisMonthLabel
            ];
            $startOfLastYear->addMonth();
        }
        

        // Bulan ini
        $endOfMonthss = null;
        $daysInMonth = $startOfMonth->daysInMonth;
        $dataMonth = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            // $dataMonth[] = $startOfMonth->copy()->addDays($i)->format('d/m');
            $date = $startOfMonth->copy()->day($i); // Mengatur tanggal ke hari ke-i
            $dataMonth[] = $date->format('d/m');
        }

        if ($request->has('monthInputs')) {
            $selectedMonthStart = Carbon::parse($monthInput);
            $endOfMonthss = range(1, $selectedMonthStart->daysInMonth); // Hitung akhir bulan
            $daysInMonth = $selectedMonthStart->daysInMonth;

            $dataMonth = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                // $dataMonth[] = $selectedMonthStart->copy()->addDays($i)->format('d/m');
                $date = $selectedMonthStart->copy()->day($i); // Mengatur tanggal ke hari ke-i
                $dataMonth[] = $date->format('d/m'); 
            }   
        }



        //Query Database
        $pegawai = Pegawai::with(['attendances' => function($query) use ($monthInputS,$endOfMonth){
            $query->whereBetween('date', [$monthInputS,$endOfMonth]);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); 
        })->paginate(10);

        $jabatan = jabatan::all();
        $bagian = bagian::all();

        // Mengonversi status absensi ke format d/m
        foreach ($pegawai as $dataP) {
            foreach ($dataP->attendances as $attendance) {
                $attendance->formatted_date = Carbon::parse($attendance->date)->format('d/m');
            }

        }

       
        return view('admin.attendances.reportAttend.detailAttendMonth', compact('dataMonth','pegawai','jabatan','bagian','months','monthInputPdf','monthInputStatus'));
    }

    public function AttendanceInStore(Request $request) {
        $currentDateTime = Carbon::now();
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');

        $qr = $request->qr_code;
        

        // Ambil pegawai
        $pegawaiInput = Pegawai::find($request->pegawai);
        $pegawai = Pegawai::where('nip', $qr)->first();


        // Cek apakah pegawai sudah absen pada hari ini
        $absen_hari_ini = Attendance::where('pegawai_id', $pegawai->id ?? $pegawaiInput->id)
            ->whereDate('date', $currentDateTime->toDateString())
            ->first();

        if ($absen_hari_ini) {
            return redirect()->route('attendances.in')->with('gagal','Pegawai sudah absen hari ini!');
        }

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id ?? $pegawaiInput->id)->value('shift_id');
        $shift = Shift::where('id', $pegawaiShift)->first();
        

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);

        //Menambahkan waktu lebih untuk waktu mulai absen
        $menitTelat = 15; //menit
        $waktumulaiTelat =  $waktumulaiCarbon->addMinutes($menitTelat)->toTimeString();

        if ($request->filled('status')) {
            $statusHadir = $request->status;
        }elseif($waktumulaiTelat <= $formattedTime && $formattedDate <= $waktuakhirCarbon){
            $statusHadir = 'late';
        }else if($waktumulaiTelat >= $formattedTime && $formattedDate <= $waktuakhirCarbon) {
            $statusHadir = 'present';
        }else{
            return redirect()->route('attendances.in')->with('gagal','Diluar Jadwal Shift Pegawai');
        }

        
        $data = [
            
            'pegawai_id' => $pegawai->id ?? $pegawaiInput->id,
            'date' => $formattedDate,
            'waktu_masuk' => $formattedTime,
            'status' => $statusHadir,
            'note' => $request->note ?? null,
            'attachment' => null
        ];

        

        attendance::create($data);
        return redirect()->route('attendances.in')->with('success','Pegawai Berhasil Absensi!');
        
    }

    // ABSENSI KELUAR
    public function AttendanceOut(Request $request) {

        $search = $request->input('cari_pegawai');
        $today = Carbon::today();
        $tglFormat =  Carbon::parse($today)->format('Y-m-d');

        //Mengambil data pegawai dan attendaces
        $attendances = Attendance::where('date', date('Y-m-d'))->get();
        $pegawai = Pegawai::with(['attendances' => function($query) use ($tglFormat){
            $query->whereDate('date', $tglFormat);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->paginate(5);

        
        
        return view('admin.attendances.attendanceout' , compact('pegawai'));
    }

    public function AttendanceOutStore(Request $request) {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $formattedDate = $currentDateTime->format('Y-m-d');
        $formattedTime = $currentDateTime->format('H:i:s');

        $qr = $request->qr_code;

        // Ambil pegawai
        $pegawaiInput = Pegawai::find($request->pegawai);
        $pegawai = Pegawai::where('nip', $qr)->first();


        // Cek apakah pegawai sudah absen pada hari ini
        $absen_hari_ini = Attendance::where('pegawai_id', $pegawai->id ?? $pegawaiInput->id)
            ->whereDate('date', $currentDateTime->toDateString())
            ->first();

        

        if ($absen_hari_ini == null) {
            return redirect()->route('attendances.out')->with('gagal','Pegawai Belum Absen Hari Ini');
        }else if ($absen_hari_ini->waktu_keluar){
            return redirect()->route('attendances.out')->with('gagal','Pegawai Sudah Absen Keluar');
        }

        

        //Mengambil data pegawai dan shift
        $pegawaiShift = Pegawai::where('id', $pegawai->id ?? $pegawaiInput->id)->value('shift_id');
        $shift = Shift::where('id', $pegawaiShift)->first();
        

        //Parsin waktu menggunakan carbon
        $waktumulaiCarbon = Carbon::parse($shift->waktu_mulai);
        $waktuakhirCarbon = Carbon::parse($shift->waktu_akhir);


        $data = [
            'waktu_keluar' => $formattedTime,
            
        ];

        // dd($pegawai->id);

        attendance::where('pegawai_id', $pegawai->id)->update($data);
        return redirect()->route('attendances.out')->with('success','Absensi Keluar Berhasil');
        
    }

    public function StatusAbsen(Request $request){

        $today = Carbon::today();
        $tglFormat = Carbon::parse($today)->format('Y-m-d');
        $tglFirstWeek = Carbon::parse($today)->startOfWeek()->format('Y-m-d');

        // Membuat daftar semua tanggal dalam rentang satu minggu
        $allDates = collect();
        $startDate = Carbon::parse($tglFirstWeek);
        $endDate = Carbon::parse($tglFormat)->subDay(); //Satu hari sebelum

        while ($startDate->lte($endDate)) {
            if (!in_array($startDate->dayOfWeek, [0, 6])) { // 0 = Minggu, 6 = Sabtu
                $allDates->push($startDate->toDateString());
            }
            $startDate->addDay();
        }

        // $pegawaiId = [4,7];
        $pegawaiId = pegawai::pluck('id');
        
        $pegawaiAbsen = Pegawai::with(['attendances' => function($query) use ($tglFirstWeek,$tglFormat){
            $query->whereBetween('date', [$tglFirstWeek,$tglFormat]);
        },'jabatan','bagian','shift'])->when($pegawaiId, function($query, $pegawaiId){
            return $query->whereIn('id',$pegawaiId);
        })->get()
        ->map(function ($pegawai) use ($allDates) {
            // Membuat daftar kehadiran berdasarkan tanggal
            $attendanceByDate = $pegawai->attendances->keyBy('date');
    
            // Menyusun ulang data untuk memasukkan tanggal yang tidak ada dengan status "absen"
            $pegawai->attendances = $allDates->map(function ($date) use ($attendanceByDate) {
                return $attendanceByDate->get($date, (object)[
                    'date' => $date,
                    'status' => 'absent' // Status absen jika tidak ada di database
                ]);
            });
    
            return $pegawai;
        });

        

        foreach ($pegawaiId as $dataId) {
            foreach ($allDates as $date) {
                $existingAttendance = Attendance::where('pegawai_id', $dataId)
                    ->whereDate('date', $date)
                    ->exists();
            
                if (!$existingAttendance) {
                    Attendance::create([
                        'pegawai_id' => $dataId,
                        'date' => $date,
                        'status' => 'absent',
                    ]);
                }
            }
        }
        

        // dd($date);

        // foreach ($pegawaiData as $pegawai_id) {
        //     Attendance::create([
        //         'pegawai_id' => $pegawai_id,
        //         'date' => $tglFormat,
        //         'status' => 'absent',
        //     ]);
        // }

        

        return redirect()->route('detailAttendances');
        
    }

    public function viewpdfAbsenWeek(Request $request){
        $mpdf = new \Mpdf\Mpdf();

        // Mendapatkan tanggal awal dan akhir minggu ini
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $thisWeekLabel = $startOfWeek->format('W, Y'); // Label untuk minggu ini
        $thisWeekValue = $startOfWeek->format('Y-m-d'); // Nilai untuk minggu ini

        $search = $request->input('cari_pegawai');
        $weekInput = $request->input('start_date');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');

        $weekInputStatus = Carbon::parse($weekInput)->format('W, Y');
        $weekInputS = Carbon::parse($weekInput)->startOfWeek()->format('Y-m-d');
        $weekInputE = Carbon::parse($weekInput)->endOfWeek()->format('Y-m-d');
     

        $weeks = [];
        while ($startOfLastYear->lte($startOfWeek)) {
            $weeks[] = [
                'label' => $startOfLastYear->format('W, Y'),
                'value' => $startOfLastYear->format('Y-m-d'),
                'has_events' => false, // Default tidak ada event
                'is_current' => $startOfLastYear->format('W, Y') === $thisWeekLabel
            ];
            $startOfLastYear->addWeek();
        }
        
        // Jika ada minggu yang dipilih, hitung tanggal akhir minggu
        $data = [];
        $endOfWeekss = null;
        if ($request->has('start_date')) {
            $selectedWeekStart = Carbon::parse($weekInput)->startOfWeek();

            $data = [];
            for ($i = 0; $i < 7; $i++) {
                $data[] = $selectedWeekStart->copy()->addDays($i)->format('d/m');
            }
        }

        //Query Database
        $pegawai = Pegawai::with(['attendances' => function($query) use ($weekInputS,$weekInputE){
            $query->whereBetween('date', [$weekInputS,$weekInputE]);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); 
        })->paginate(10);


        // Mengonversi status absensi ke format d/m
        foreach ($pegawai as $dataP) {
            foreach ($dataP->attendances as $attendance) {
                $attendance->formatted_date = Carbon::parse($attendance->date)->format('d/m');
            }

        }


        $mpdf->WriteHTML(view("admin.import-export.export-absensi-minggu", compact('data','pegawai','weeks','weekInput','weekInputStatus')));
        $mpdf->Output('Absensi-Pegawai-Minggu-'. $weekInputStatus .'.pdf','I');
        // $mpdf->Output('pdf-absen-minggu','D');
    }

    Public function viewpdfAbsenMonth(Request $request) {

        $mpdf = new \Mpdf\Mpdf();

        $search = $request->input('cari_pegawai');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');
        $monthInput = $request->input('start_date');
        // Mendapatkan tanggal awal dan akhir Bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $thisMonthLabel = $startOfMonth->format('F, Y'); // Label untuk minggu ini
        $thisMonthValue = $startOfMonth->format('Y-m-01'); // Nilai untuk minggu ini

        $monthInputStatus = Carbon::parse($monthInput)->format('F, Y');
        $monthInputS = Carbon::parse($monthInput)->startOfmonth()->format('Y-m-d');
        $monthInputE = Carbon::parse($monthInput)->endOfmonth()->format('Y-m-d');


        $months = [];
        while ($startOfLastYear->lte($startOfMonth)) {
            $months[] = [
                'label' => $startOfLastYear->format('F, Y'),
                'value' => $startOfLastYear->format('Y-m-01'),
                'has_events' => false, // Default tidak ada event
                'is_current' => $startOfLastYear->format('F, Y') === $thisMonthLabel
            ];
            $startOfLastYear->addMonth();
        }
        

        // Bulan ini
        $endOfMonthss = null;
        $daysInMonth = $startOfMonth->daysInMonth;
        $dataMonth = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $startOfMonth->copy()->day($i); // Mengatur tanggal ke hari ke-i
            $dataMonth[] = $date->format('d/m');
        }

        if ($request->has('start_date')) {
            $selectedMonthStart = Carbon::parse($monthInput);
            $endOfMonthss = range(1, $selectedMonthStart->daysInMonth); // Hitung akhir minggu
            $daysInMonth = $selectedMonthStart->daysInMonth;

            $dataMonth = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = $selectedMonthStart->copy()->day($i); // Mengatur tanggal ke hari ke-i
                $dataMonth[] = $date->format('d/m'); 
            }   
        }



        //Query Database
        $pegawai = Pegawai::with(['attendances' => function($query) use ($monthInputS,$monthInputE){
            $query->whereBetween('date', [$monthInputS,$monthInputE]);
        },'jabatan','bagian','shift'])->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query) use ($jabatanFilter) {
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query) use ($bagianFilter) {
            return $query->where('bagian_id', $bagianFilter); 
        })->paginate(10);


        // Mengonversi status absensi ke format d/m
        foreach ($pegawai as $dataP) {
            foreach ($dataP->attendances as $attendance) {
                $attendance->formatted_date = Carbon::parse($attendance->date)->format('d/m');
            }

        }

       
        $mpdf->WriteHTML(view("admin.import-export.export-absensi-bulan", compact('dataMonth','pegawai','months','monthInput','monthInputStatus')));
        
        $mpdf->Output('Absensi-Pegawai-Bulan-'. $monthInputStatus .'.pdf','I');
    }
}
