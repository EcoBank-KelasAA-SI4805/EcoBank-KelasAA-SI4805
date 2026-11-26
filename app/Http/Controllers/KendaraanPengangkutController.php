<?php
namespace App\Http\Controllers;
use App\Models\KendaraanPengangkut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class KendaraanPengangkutController extends Controller
{
 public function index(Request $request) { $q=$request->string('q')->trim()->toString(); $kendaraans=KendaraanPengangkut::when($q,fn($x)=>$x->where('nama','like',"%$q%")->orWhere('nomor_polisi','like',"%$q%"))->latest()->paginate(10)->withQueryString(); return view('admin.kendaraan.index',compact('kendaraans','q')); }
 public function create() { return view('admin.kendaraan.form',['kendaraan'=>new KendaraanPengangkut(),'isEdit'=>false]); }
 public function store(Request $request) { $data=$request->validate(['nama'=>'required|string|max:120','nomor_polisi'=>'required|string|max:20|unique:kendaraan_pengangkut,nomor_polisi','jenis'=>'required|string|max:80','status'=>['required',Rule::in(['tersedia','servis'])]]); KendaraanPengangkut::create($data); return redirect()->route('admin.kendaraan.index')->with('success','Kendaraan berhasil ditambahkan.'); }
 public function show(KendaraanPengangkut $kendaraan) { return view('admin.kendaraan.show',compact('kendaraan')); }
 public function edit(KendaraanPengangkut $kendaraan) { return view('admin.kendaraan.form',['kendaraan'=>$kendaraan,'isEdit'=>true]); }
 public function update(Request $request,KendaraanPengangkut $kendaraan) { $data=$request->validate(['nama'=>'required|string|max:120','nomor_polisi'=>['required','string','max:20',Rule::unique('kendaraan_pengangkut','nomor_polisi')->ignore($kendaraan->id)],'jenis'=>'required|string|max:80','status'=>['required',Rule::in(['tersedia','servis'])]]); $kendaraan->update($data); return redirect()->route('admin.kendaraan.show',$kendaraan)->with('success','Data kendaraan berhasil diperbarui.'); }
 public function destroy(KendaraanPengangkut $kendaraan) { $kendaraan->delete(); return redirect()->route('admin.kendaraan.index')->with('success','Kendaraan berhasil dihapus.'); }
}
