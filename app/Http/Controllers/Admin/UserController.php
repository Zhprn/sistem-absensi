<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){

        $search = $request->input('cari_pegawai');
        $jabatanFilter = $request->input('jabatan');
        $bagianFilter = $request->input('bagian');
        $roleFilter = $request->input('roleInputs');
        

        $dataUser = pegawai::with(['user','jabatan','bagian'])
        ->when($search, function($query, $search){
            return $query->where('nama_pegawai','like',"%{$search}%")
            ->orWhere('nip','like',"%{$search}%");
        })->when($jabatanFilter, function($query, $jabatanFilter){
            return $query->where('jabatan_id', $jabatanFilter);
        })->when($bagianFilter, function($query, $bagianFilter){
            return $query->where('bagian_id', $bagianFilter);
        })->when($roleFilter, function($query, $roleFilter) {
            return $query->whereHas('user', function($query) use ($roleFilter) {
                switch($roleFilter){
                    case 'user':
                        $dataRole = '0';
                        break;
                    
                    case 'manager':
                        $dataRole = '1';
                        break;
        
                    case 'admin':
                        $dataRole = '2';
                        break;
        
                    default:
                        $dataRole = collect(); // Mengembalikan koleksi kosong
                        break;
                }
                $query->where('type', $dataRole);
            });
        })->paginate(5);
        
        // $uniqueTypes = pegawai::with('user')->get()->pluck('user.type')->unique();
        $uniqueTypes = pegawai::with('user')
            ->select('users.type')
            ->join('users', 'pegawai.user_id', '=', 'users.id')
            ->distinct()
            ->groupBy('users.type')
            ->paginate(10);

        $jabatan = jabatan::get();
        $bagian = bagian::get();


        $usersWithoutPegawai = User::leftJoin('pegawai', 'users.id', '=', 'pegawai.user_id')
        ->whereNull('pegawai.user_id')
        ->select('users.*')
        ->paginate(10);

        // dd($usersWithoutPegawai);

        
        return view('admin.manageAuth.user', compact('dataUser','jabatan','bagian','uniqueTypes','usersWithoutPegawai'));
    }

    public function create(){

        return view('admin.manageAuth.tambah');
    }

    public function store(Request $request){
        $pegawai = Pegawai::with('user')->get();
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,',
            'passNew' => 'nullable|min:8',
            
        ],[
            'email.required'=>'Email Wajib Diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input maximal memiliki 25 karakter',
        ]);

        
        $data = [
            'name' => $request->input('nama_pegawai'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('passNew')),
            'type' => $request->input('roleInputs'),
            'remember_token' => Str::random(10),
        ];

        User::create($data);
        return redirect()->route('manageuser.index');
    }

    public function edit($id){

        $pegawai = Pegawai::with('user')->find($id);

        return view('admin.manageAuth.edit', compact('pegawai'));
    }

    public function update(Request $request, string $id){

        $pegawai = Pegawai::with('user')->find($id);

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,' . $pegawai->user->id,
            'passNew' => 'nullable|min:3',
            
        ],[
            'email.required'=>'Email Wajib Diisi',
            'max'=>'Input maximal memiliki 25 karakter',
        ]);

        $tipeRole = $request->input('roleInputs');
        

        // Update email dan tipe role pengguna
        $pegawai->user->email = $validatedData['email'];
        $pegawai->user->type = $tipeRole;

        // Jika password diisi, hash dan simpan
        if ($request->filled('passNew')) {
            $pegawai->user->password = Hash::make($validatedData['passNew']);
        }

        $pegawai->user->save();

        return redirect()->route('manageuser.index');
    }

    public function destroy(Request $request, string $id){
        $user = User::find($id);
        User::where('id', $id)->delete();
        return redirect()->route('manageuser.index');
    }

    
}
