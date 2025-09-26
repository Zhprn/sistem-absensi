<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bagian;
use App\Models\sop;
use Illuminate\Http\Request;

class SopController extends Controller
{
    public function index(){
        $sop = sop::with('bagian')->get();

        return view('admin.sop.sop', compact('sop'));
    }

    public function create(){
        $bagian = bagian::get();
        

        return view('admin.sop.tambah', compact('bagian'));
    }

    public function store(Request $request){

        $request->validate([
            'titleSop'  => 'required|min:3|max:30',
            'descSop'  => 'required|min:3|max:50',
            'bagianSop'  => 'required',
            'contentSop'  => 'required',
            
        ],[
            'titleSop.required'=>'Title wajib diisi',
            'descSop.required'=>'Deskripsi wajib diisi',
            'bagianSop.required'=>'Bagian wajib diisi',
            'contentSop.required'=>'Content wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'title' => $request->titleSop,
            'desc' => $request->descSop,
            'bagian_id' => $request->bagianSop,
            'content' => $request->contentSop,
        ];

        // dd($data);

        sop::create($data);

        return redirect()->route('sop.index');
    }

    public function edit($id){
        $sopContent = sop::find($id);
        $bagian = bagian::get();
        

        return view('admin.sop.edit', compact('sopContent','bagian'));
    }

    public function update(Request $request, string $id){

        $request->validate([
            'titleSop'  => 'required|min:3|max:30',
            'descSop'  => 'required|min:3|max:50',
            'bagianSop'  => 'required',
            'contentSop'  => 'required',
            
        ],[
            'titleSop.required'=>'Title wajib diisi',
            'descSop.required'=>'Deskripsi wajib diisi',
            'bagianSop.required'=>'Bagian wajib diisi',
            'contentSop.required'=>'Content wajib diisi',
            'min'=>'Input minimal memiliki 3 karakter',
            'max'=>'Input karakter terlalu panjang',
        ]);

        $data = [
            'title' => $request->titleSop,
            'desc' => $request->descSop,
            'bagian_id' => $request->bagianSop,
            'content' => $request->contentSop,
        ];

        // dd($data);

        sop::where('id', $id)->update($data);

        return redirect()->route('sop.index');
    }

    public function destroy($id){
        sop::where('id', $id)->delete();
        return redirect()->route('sop.index');
    }

    public function detailSop($id){
        
        $sop = sop::find($id);
        $sopValue = $sop->value('content');
        $sopTitle = $sop->value('title');

        return view('admin.sop.detail', compact('sop'));
        
    }

    public function viewpdfSop(string $title){
        $mpdf = new \Mpdf\Mpdf();
        // $sopContent = sop::find($id);
        $sopContent = sop::where('title', $title)->first();
        $sopValue = $sopContent->value('content');
        $sopTitle = $sopContent->value('title');
    
        
        $mpdf->WriteHTML($sopContent->content);
        $mpdf->Output('SOP-Pegawai-'. $sopContent->title .'.pdf','I');
    }


}
