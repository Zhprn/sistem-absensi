<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pegawai;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use ZipArchive;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('cari_pegawai');
        // $pegawai = pegawai::paginate(4);

        $pegawai = pegawai::when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")->orWhere('nip','like',"%{$search}%");
        })->paginate(4);

        // dd($nip);

        $qr_code = [];
        // foreach($nipArray as $nip){
        //    $qr_code[] =  QrCode::size(200)->generate($nip);
        // }

        return view('admin.barcode.barcode', compact('qr_code','pegawai'));
    }

    public function downloadQr(Request $request){

       $pegawai_id = pegawai::find($request->pegawai_id);      
       $qrCode = QrCode::format('png')->size(500)->margin(2)->generate($pegawai_id->nip);
       $filename = 'qrcode_'. $pegawai_id->nip . '_' . $pegawai_id->nama_pegawai . '.png';   
    

        // Mengembalikan response dengan file QR Code
        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    public function downloadAll()
    {
        // Mengambil data pegawai dengan nip sebagai value dan nama_pegawai sebagai key
        $pegawai = pegawai::select('nip', 'nama_pegawai')->get();
        
        // Buat nama file ZIP
        $zipFileName = 'qrCode_pegawai.zip';
        $zip = new ZipArchive();

        // Buat file ZIP
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($pegawai as $employee) {
                // Buat QR Code untuk setiap pegawai
                $qrCode = QrCode::format('png')->size(500)->margin(2)->generate($employee->nip);
                // Nama file untuk QR Code
                $fileName = 'qrcode_' . $employee->nip . '_' . $employee->nama_pegawai . '.png';
                // Tambahkan QR Code ke file ZIP
                $zip->addFromString($fileName, $qrCode);
            }
            $zip->close();
        }

        // Kembalikan file ZIP sebagai respons
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }
}
