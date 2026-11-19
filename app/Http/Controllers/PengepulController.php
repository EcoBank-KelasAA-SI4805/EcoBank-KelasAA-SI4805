<?php
namespace App\Http\Controllers;
use App\Models\Pengepul;
use Illuminate\Http\Request;
class PengepulController extends Controller
{
 public function index(Request $request) { $q=$request->string('q')->trim()->toString(); $pengepuls=Pengepul::when($q,fn($x)=>$x->where('nama','like',"%$q%")->orWhere('kontak','like',"%$q%"))->latest()->paginate(10)->withQueryString(); return view('admin.pengepul.index',compact('pengepuls','q')); }
 public function create() { return view('admin.pengepul.form',['pengepul'=>new Pengepul(),'isEdit'=>false]); }
 public function store(Request $request) { $data=$request->validate(['nama'=>'required|string|max:120','kontak'=>'required|string|max:50','alamat'=>'required|string|max:1000','jenis_dibeli'=>'required|string|max:1000']); Pengepul::create($data); return redirect()->route('admin.pengepul.index')->with('success','Data pengepul berhasil ditambahkan.'); }
 public function show(Pengepul $pengepul) { return view('admin.pengepul.show',compact('pengepul')); }
 public function edit(Pengepul $pengepul) { return view('admin.pengepul.form',['pengepul'=>$pengepul,'isEdit'=>true]); }
 public function update(Request $request,Pengepul $pengepul) { $data=$request->validate(['nama'=>'required|string|max:120','kontak'=>'required|string|max:50','alamat'=>'required|string|max:1000','jenis_dibeli'=>'required|string|max:1000']); $pengepul->update($data); return redirect()->route('admin.pengepul.show',$pengepul)->with('success','Data pengepul berhasil diperbarui.'); }
 public function destroy(Pengepul $pengepul) { $pengepul->delete(); return redirect()->route('admin.pengepul.index')->with('success','Data pengepul berhasil dihapus.'); }
}
