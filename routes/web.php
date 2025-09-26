<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAkses;
use App\Http\Controllers\Admin\SopController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttendancesController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Users\AbsenController;
use App\Http\Controllers\Users\DetailAbsenController;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\Users\UserSopController;
use App\Http\Controllers\Users\UserTaskController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect('login');
// });

Route::get('/test', function () {
    return view('layout.app');
})->middleware(UserAkses::class);

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.post');
});  

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('sop/pdf/{title}', [SopController::class, 'viewPdfSop'])->name('sop.pdf');

Route::middleware('auth','admin:user')->group(function () {

Route::get('/home', [HomeController::class, 'index'])->name('home.pegawai');
    Route::get('/', function () {
        // return route('home.pegawai');
        return redirect()->route('home.pegawai');
    });

Route::get('/user-qrcode', [HomeController::class ,'downloadQr'])->name('user.qrcode');
Route::get('/absenmasuk', [AbsenController::class, 'absenmasuk'])->name('absen.masuk');
Route::post('/absenmasuk', [AbsenController::class, 'absenmasukStore'])->name('absen.masukStore');

Route::get('/absenkeluar', [AbsenController::class, 'absenkeluar'])->name('absen.keluar');
Route::post('/absenkeluar', [AbsenController::class, 'absenkeluarStore'])->name('absen.keluarStore');

// Route::get('/absenpegawai', DetailAbsenController::class)->name('absen.detail');
Route::get('/absenpegawai', DetailAbsenController::class)->name('absen.detail');
Route::get('/api/absensi', [DetailAbsenController::class, 'getAbsensi']);

Route::resource('usersop', UserSopController::class);
// Route::get('sop/pdf/{title}', [SopController::class, 'viewPdfSop'])->name('sop.pdf');

Route::resource('usertask', UserTaskController::class);
Route::get('/usertask/detail/{id}', [UserTaskController::class, 'detailTask'])->name('usertask.detail');
Route::put('/usertask/detail/{id}', [UserTaskController::class, 'statusTask'])->name('usertask.update');
Route::get('/usertask/detail/bukti/{id}', [UserTaskController::class, 'buktiTask'])->name('usertask.bukti');

});

Route::middleware('auth','admin:admin,manager')->group(function () {
    
    
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');  
    Route::controller(PegawaiController::class)->group(function () {

        // PEGAWAI ROUTE
        Route::get('/admin/pegawai','PegawaiIndex')->name('pegawai');
        Route::get('/admin/pegawai/tambah','PegawaitampilTambah')->name('pegawai.tambah');
        Route::post('/admin/pegawai/tambah','PegawaiStore')->name('pegawai.post');
        Route::get('/admin/pegawai/edit/{id}', 'PegawaiEdit')->name('pegawai.edit');
        Route::put('/admin/pegawai/edit/{id}', 'PegawaiUpdate')->name('pegawai.update');
        Route::delete('/admin/pegawai/{id}','PegawaiDelete')->name('pegawai.delete');

        Route::get('/export-pegawai/view/pdf','viewpdfPegawai')->name('export-pegawai');
        Route::get('/admin/export-excel-pegawai','excelPegawai')->name('excel.pegawai');
        Route::post('/admin/import-excel-pegawai','excelPegawaiImport')->name('import.pegawai');

        // JABATAN ROUTE
        Route::get('/admin/jabatan','JabatanIndex')->name('jabatan');
        Route::post('/admin/jabatan','JabatanStore')->name('jabatan.post');
        Route::delete('/admin/jabatan/{id}','JabatanDelete')->name('jabatan.delete');
        Route::get('/admin/jabatan/edit/{id}','JabatanEdit')->name('jabatan.edit');
        Route::put('/admin/jabatan/edit/{id}','JabatanUpdate')->name('jabatan.update');
        Route::get('/admin/export-excel-jabatan','excelJabatan')->name('excel.jabatan');
        Route::post('/admin/import-excel-jabatan','excelJabatanImport')->name('import.jabatan');

        // BAGIAN ROUTE
        Route::get('/admin/bagian','BagianIndex')->name('bagian');
        Route::post('/admin/bagian','BagianStore')->name('bagian.post');
        Route::delete('/admin/bagian/{id}','BagianDelete')->name('bagian.delete');
        Route::get('/admin/bagian/edit/{id}','BagianEdit')->name('bagian.edit');
        Route::put('/admin/bagian/edit/{id}','BagianUpdate')->name('bagian.update');
        Route::get('/admin/export-excel-bagian','excelBagian')->name('excel.bagian');
        Route::post('/admin/import-excel-bagian','excelBagianImport')->name('import.bagian');

        // SHIFT ROUTE
        Route::get('/admin/shift','ShiftIndex')->name('shift');
        Route::post('/admin/shift','ShiftStore')->name('shift.post');
        Route::delete('/admin/shift/{id}','ShiftDelete')->name('shift.delete');
        Route::get('/admin/shift/edit/{id}','ShiftEdit')->name('shift.edit');
        Route::put('/admin/shift/edit/{id}','ShiftUpdate')->name('shift.update');
        Route::get('/admin/export-excel-shift','excelShift')->name('excel.shift');
        Route::post('/admin/import-excel-shift','excelShiftImport')->name('import.shift');

    });

    Route::controller(AttendancesController::class)->group(function () {

        Route::get('/admin/attendances','AttendanceIn')->name('attendances.in');
        Route::post('/admin/attendances','AttendanceInStore')->name('attendances.inPost');
        Route::get('/admin/attendances/out','AttendanceOut')->name('attendances.out');
        Route::post('/admin/attendances/out','AttendanceOutStore')->name('attendances.outPost');

        Route::get('/admin/attendances/list','AttendanceInList')->name('listAttendances');
        Route::get('/admin/attendances/{id}/date','DetailAttendancesitem')->name('listAttendances.date');
        Route::put('/admin/attendances/{id}/date/update','StatusAttendanceUpdate')->name('listAttendances.update');
        
        Route::get('/admin/attendances/detail/week','AttendancesDetailWeek')->name('detailAttendances');
        Route::get('/admin/attendances/detail/month','AttendancesDetailMonth')->name('detailAttendancesMonth');

        Route::get('/export-absensi-minggu/view/pdf','viewpdfAbsenWeek')->name('export-absensi-minggu');
        Route::get('/export-absensi-bulan/view/pdf','viewpdfAbsenMonth')->name('export-absensi-bulan');

        Route::get('/admin/attendances/detail/week/submit','StatusAbsen')->name('absen.test');

    });


    Route::get('/admin/rekapdata', function () {
        return view('admin.rekapData');
    })->name('rekapdata');

    Route::resource('/admin/manageuser', UserController::class);
    Route::resource('/admin/sop', SopController::class);
    Route::get('/admin/sop/detail/{id}', [SopController::class, 'detailSop'])->name('sop.detail');
    

    Route::resource('/admin/task', TaskController::class);
    Route::post('/admin/task/create', [TaskController::class, 'storePegawai'])->name('task.pegawai');
    Route::get('/admin/task/create/detail/{id}', [TaskController::class, 'detailTask'])->name('task.detail');

    Route::get('/admin/task/statusDetail/{id}', [TaskController::class, 'statusTask'])->name('task.status');
    Route::put('/admin/task/statusDetail/{id}', [TaskController::class, 'ubahStatus'])->name('task.statusUpdate');
    Route::get('/admin/task/statusDetail/bukti/{id}', [TaskController::class, 'buktiTask'])->name('task.bukti');
    
    Route::resource('/admin/gaji', GajiController::class);
    Route::get('/admin/gaji/{id}/gaji-pokok', [GajiController::class, 'getGajiPokok'])->name('gaji.api');
    // Route::post('/admin/gaji/tambah', [GajiController::class, 'getGajiPokok'])->name('gaji.test');
    Route::get('/slip-gaji/{id}', [GajiController::class, 'viewpdfGaji'])->name('slip.gaji');


    Route::resource('/admin/barcode', BarcodeController::class);
    Route::get('/download-qrcode', [BarcodeController::class ,'downloadQr'])->name('barcode.download');
    Route::get('/downloadAll-qrcode', [BarcodeController::class ,'downloadAll'])->name('barcode.downloadAll');


});



