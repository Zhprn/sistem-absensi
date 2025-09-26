<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BagianExport;
use App\Exports\JabatanExport;
use App\Exports\PegawaiExport;
use App\Exports\ShiftExport;
use Carbon\Carbon;
use App\Models\User;
use App\Models\shift;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BagianImport;
use App\Imports\JabatanImport;
use App\Imports\PegawaiImport;
use App\Imports\ShiftImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;


class PegawaiController extends Controller
{

    //INDEX

    public function PegawaiIndex(){

        $max_data = 5;

        $pegawai = Pegawai::with(['jabatan','bagian','shift'])->get();
    //    dd($pegawai);

        return view('admin.pegawai.pegawai', compact('pegawai'));
    }

    public function PegawaitampilTambah(){
        $jabatan = Jabatan::all();
        $bagian = Bagian::all();
        $shift = Shift::all();

        return view('admin.pegawai.tambah', compact('jabatan','bagian','shift'));
    }

    public function JabatanIndex(){

        $max_data = 5;

        $jabatan = Jabatan::get();
       

        return view('admin.pegawai.jabatan.jabatan', compact('jabatan'));
    }

    public function BagianIndex(){

        $max_data = 5;

        $bagian = Bagian::get();
       

        return view('admin.pegawai.bagian.bagian', compact('bagian'));
    }

    public function ShiftIndex(){

        $max_data = 5;

        $shift = Shift::get();
       

        return view('admin.pegawai.shift.shift', compact('shift'));
    }

    // INSERT DATA

    public function PegawaiStore(Request $request){

        $request->validate([
            'nip'  => 'required|min:3|max:50',
            'nama_pegawai' => 'required|min:3|max:50',
            'foto' => 'image|mimes:jpg,jpeg,png',
            'jabatan' => 'required',
            'bagian' => 'required',
            'shift' => 'required',
            'gender' => 'required'
            
        ],[
            'nip.required'=>'NIP Wajib Diisi',
            'nama_pegawai.required'=>'Nama Pegawai Wajib Diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        // Tanggal Lahir
        $inputTgl = $request->input('tgl_lahir');
        // $tglFormat = Carbon::createFromFormat('m/d/Y', $inputTgl)->format('Y-m-d');
        $tglFormat =  Carbon::parse($request->tgl_lahir)->format('Y-m-d');

        // Image
        if ($request->hasFile('foto')){
            $image = $request->file('foto');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_NAME_LOCATION'));
            $image->move($destination_path, $image_name);
        }


        $data = [
            'nip' => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'tgl_lahir' => $tglFormat,
            'jabatan_id' => $request->jabatan,
            'bagian_id' => $request->bagian,
            'shift_id' => $request->shift,
            'foto' => isset($image_name)?$image_name:null,
            'telepon' => $request->telepon,
            'gaji_pokok' => $request->gajiInput
            // 'foto' => $request->foto,
        ];

        // dd($data);

        $pegawaiCreate = pegawai::create($data);

        // Membuat user email dan password
        $pegawaiId = $pegawaiCreate->id;
        $email = strtolower(str_replace(' ', '', $request->nama_pegawai)) . '@email.com';

        $user = User::create([
            'name' => $request->nama_pegawai,
            'email' => $email,
            'password' => bcrypt('password'),
            'type' => '0',
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        $pegawaiCreate->user_id = $user->id;
        $pegawaiCreate->save();

        return redirect()->route('pegawai');
    }

    public function JabatanStore(Request $request)
    {
        $request->validate([
            'jabatan'  => 'required|min:3|max:50',
            'deskripsi' => 'required|min:3|max:50',
        ],[
            'jabatan.required'=>'Jabatan wajib diisi',
            'deskripsi.required'=>'Deskripsi wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $data = [
            'jabatan' => $request->input('jabatan'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Jabatan::create($data);

        return redirect()->route('jabatan');
    }

    public function BagianStore(Request $request)
    {
        $request->validate([
            'bagian'  => 'required|min:3|max:50',
            'deskripsi' => 'required|min:3|max:50',
        ],[
            'bagian.required'=>'Task wajib diisi',
            'deskripsi.required'=>'Task wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $data = [
            'bagian' => $request->input('bagian'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Bagian::create($data);

        return redirect()->route('bagian');
    }

    public function ShiftStore(Request $request)
    {
        $request->validate([
            'shift'  => 'required|min:3|max:50',
            
        ],[
            'shift.required'=>'Task wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $carbonWaktuMulai = Carbon::parse($request->waktu_mulai)->format('H:i:s');
        $carbonWaktuAkhir = Carbon::parse($request->waktu_akhir)->format('H:i:s');

        $data = [
            'shift' => $request->shift,
            'waktu_mulai' => $carbonWaktuMulai,
            'waktu_akhir' => $carbonWaktuAkhir,
        ];

        // dd($data);
        shift::create($data);

        return redirect()->route('shift');
    }

    // EDIT DATA

    public function PegawaiEdit($id) {
        $pegawai = Pegawai::find($id);

        $jabatan = Jabatan::all();
        $bagian = Bagian::all();
        $shift = Shift::all();

        return view('admin.pegawai.edit', compact('pegawai','jabatan','bagian','shift'));
    }

    public function PegawaiUpdate(Request $request, string $id){
        $pegawai = Pegawai::find($id);

        $request->validate([
            'nip'  => 'required|min:3|max:50',
            'nama_pegawai' => 'required|min:3|max:50',
            'foto' => 'image|mimes:jpg,jpeg,png',
            
        ],[
            'nip.required'=>'NIP Wajib Diisi',
            'nama_pegawai.required'=>'Nama Pegawai Wajib Diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $inputTgl = $request->input('tgl_lahir');
        $tglFormat =  Carbon::parse($request->tgl_lahir)->format('Y-m-d');

        // Image
        if ($request->hasFile('foto')){

            if (isset($pegawai->foto) && file_exists(public_path(getenv('CUSTOM_NAME_LOCATION'))."/".$pegawai->foto)) {
                unlink(public_path(getenv('CUSTOM_NAME_LOCATION'))."/".$pegawai->foto);
            }

            $image = $request->file('foto');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_NAME_LOCATION'));
            $image->move($destination_path, $image_name);
        }

        $data = [
            'nip' => $request->input('nip'),
            'nama_pegawai' => $request->input('nama_pegawai'),
            'alamat' => $request->input('alamat'),
            'gender' => $request->input('gender'),
            'tgl_lahir' => $tglFormat,
            'jabatan_id' => $request->input('jabatan'),
            'bagian_id' => $request->input('bagian'),
            'shift_id' => $request->input('shift'),
            'foto' => isset($image_name)?$image_name:$pegawai->foto,
            'telepon' => $request->telepon,
            'gaji_pokok' => $request->gajiInput
        ];

       // dd($data);

        pegawai::where('id', $id)->update($data);
        return redirect()->route('pegawai');
    }

    public function JabatanEdit($id) {
        $jabatan = Jabatan::find($id);
       
        return view('admin.pegawai.jabatan.edit', compact('jabatan'));
    }

    public function JabatanUpdate(Request $request, string $id){
        $jabatan = Jabatan::find($id);
        $request->validate([
            'jabatan'  => 'required|min:3|max:50',
            'deskripsi' => 'required|min:3|max:50',
        ],[
            'jabatan.required'=>'Jabatan wajib diisi',
            'deskripsi.required'=>'Deskripsi wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $data = [
            'jabatan' => $request->input('jabatan'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Jabatan::where('id', $id)->update($data);
       
        return redirect()->route('jabatan');
    }

    public function BagianEdit($id) {
        $bagian = Bagian::find($id);
       
        return view('admin.pegawai.bagian.edit', compact('bagian'));
    }

    public function BagianUpdate(Request $request, string $id){
        $bagian = Bagian::find($id);
        $request->validate([
            'bagian'  => 'required|min:3|max:50',
            'deskripsi' => 'required|min:3|max:50',
        ],[
            'bagian.required'=>'Task wajib diisi',
            'deskripsi.required'=>'Task wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $data = [
            'bagian' => $request->input('bagian'),
            'deskripsi' => $request->input('deskripsi'),
        ];

       // dd($data);

        Bagian::where('id', $id)->update($data);
       
        return redirect()->route('bagian');
    }

    public function ShiftEdit($id) {
        $shift = Shift::find($id);
       
        return view('admin.pegawai.shift.edit', compact('shift'));
    }

    public function ShiftUpdate(Request $request, string $id)
    {
        $shift = Shift::find($id);
        $request->validate([
            'shift'  => 'required|min:3|max:50',
            
        ],[
            'shift.required'=>'Task wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 50 karakter',
        ]);

        $carbonWaktuMulai = Carbon::parse($request->waktu_mulai)->format('H:i:s');
        $carbonWaktuAkhir = Carbon::parse($request->waktu_akhir)->format('H:i:s');

        $data = [
            'shift' => $request->shift,
            'waktu_mulai' => $carbonWaktuMulai,
            'waktu_akhir' => $carbonWaktuAkhir,
        ];

        // dd($data);
        shift::where('id', $id)->update($data);

        return redirect()->route('shift');
    }

    //DELETE DATA

    public function PegawaiDelete (Request $request, string $id){
        $pegawai = Pegawai::find($id);
        // pegawai::where('id', $id)->delete();

        if ($pegawai) {
            // Hapus user yang terkait     
            if ($pegawai->user_id) {    
                User::where('id', $pegawai->user_id)->delete();
                
                $fotoPath = public_path(getenv('CUSTOM_NAME_LOCATION') . '/' . $pegawai->foto);
                // Periksa apakah file ada sebelum menghapus
                if (File::exists($fotoPath)) {
                    File::delete($fotoPath);
                }
            }        
            // Hapus pegawai 
            $pegawai->delete();  
        } else { 

        }

        return redirect()->route('pegawai');
    }

    public function JabatanDelete (Request $request, string $id){
        $jabatan = Jabatan::find($id);
        Jabatan::where('id', $id)->delete();
        return redirect()->route('jabatan');
    }

    public function BagianDelete (Request $request, string $id){
        $bagian = Bagian::find($id);
        Bagian::where('id', $id)->delete();
        return redirect()->route('bagian');
    }

    public function ShiftDelete (Request $request, string $id){
        $shift = Shift::find($id);
        Shift::where('id', $id)->delete();
        return redirect()->route('shift');
    }

    public function viewpdfPegawai(){
        $mpdf = new \Mpdf\Mpdf();
        $pegawai = Pegawai::with(['jabatan','bagian','shift'])->orderBy('nip', 'asc')->get();
        $mpdf->WriteHTML(view("admin.import-export.export-pegawai", compact('pegawai')));
        $mpdf->Output('pdf-pegawai','I');
    }

    public function excelBagian() 
    {
        // return Excel::download(new BagianExport, 'bagian-'.Carbon::now()->timestamp.'.xlsx');
        return (new BagianExport)->download('bagian-'.Carbon::now()->timestamp.'.xlsx');

    }

    public function excelJabatan() 
    {
        // return Excel::download(new BagianExport, 'bagian-'.Carbon::now()->timestamp.'.xlsx');
        return (new JabatanExport)->download('jabatan-'.Carbon::now()->timestamp.'.xlsx');

    }

    public function excelShift() 
    {
        // return Excel::download(new BagianExport, 'bagian-'.Carbon::now()->timestamp.'.xlsx');
        return (new ShiftExport)->download('shift-'.Carbon::now()->timestamp.'.xlsx');

    }

    public function excelPegawai() 
    {
        // return Excel::download(new BagianExport, 'bagian-'.Carbon::now()->timestamp.'.xlsx');
        return (new PegawaiExport)->download('pegawai-'.Carbon::now()->timestamp.'.xlsx');

    }

    public function excelBagianImport(Request $request) 
    {
        // dd($request->file('file'));
        if ($request->hasFile('file')) {
            Excel::import(new BagianImport, $request->file('file'));
        } else {
            return back()->withErrors('No file uploaded');
        }
        
        
        return redirect()->route('bagian');

    }

    public function excelJabatanImport(Request $request) 
    {
        // dd($request->file('file'));
        if ($request->hasFile('file')) {
            Excel::import(new JabatanImport, $request->file('file'));
        } else {
            return back()->withErrors('No file uploaded');
        }
        
        
        return redirect()->route('jabatan');

    }

    public function excelShiftImport(Request $request) 
    {
        // dd($request->file('file'));
        if ($request->hasFile('file')) {
            Excel::import(new ShiftImport, $request->file('file'));
        } else {
            return back()->withErrors('No file uploaded');
        }
        
        
        return redirect()->route('shift');

    }

    public function excelPegawaiImport(Request $request) 
    {
        // dd($request->file('file'));
        if ($request->hasFile('file')) {
            Excel::import(new PegawaiImport, $request->file('file'));
        } else {
            return back()->withErrors('No file uploaded');
        }
        
        
        return redirect()->route('pegawai');

    }
}
