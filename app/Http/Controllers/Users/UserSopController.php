<?php

namespace App\Http\Controllers\Users;

use App\Models\sop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pegawai;
use Illuminate\Support\Facades\Auth;

class UserSopController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $pegawai = pegawai::with('bagian')->where('user_id', $userId)->first();
        $sop = sop::where('bagian_id', $pegawai->bagian->id)->get();

        return view('user.sop.userSop', compact('sop'));
    }
}
