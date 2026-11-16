<?php

namespace App\Http\Controllers;

use App\Models\DropPoint;
use Illuminate\Http\Request;

class DropPointController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->toString();
        $dropPoints = DropPoint::query()->when($q, fn ($query) => $query->where('nama','like',"%{$q}%")->orWhere('alamat','like',"%{$q}%"))
            ->latest()->paginate(10)->withQueryString();
        return view('admin.drop-points.index', compact('dropPoints','q'));
    }
    public function create() { return view('admin.drop-points.form', ['dropPoint' => new DropPoint(), 'isEdit' => false]); }
    public function store(Request $request)
    {
        $data = $request->validate(['nama'=>['required','string','max:100'],'alamat'=>['required','string','max:500'],'jam_buka'=>['required','string','max:100']]);
        $data['status_aktif'] = $request->boolean('status_aktif', true);
        DropPoint::create($data);
        return redirect()->route('admin.drop-points.index')->with('success','Lokasi drop point berhasil ditambahkan.');
    }
    public function show(DropPoint $dropPoint) { return view('admin.drop-points.show', compact('dropPoint')); }
    public function edit(DropPoint $dropPoint) { return view('admin.drop-points.form', ['dropPoint' => $dropPoint, 'isEdit' => true]); }
    public function update(Request $request, DropPoint $dropPoint)
    {
        $data = $request->validate(['nama'=>['required','string','max:100'],'alamat'=>['required','string','max:500'],'jam_buka'=>['required','string','max:100']]);
        $data['status_aktif'] = $request->boolean('status_aktif');
        $dropPoint->update($data);
        return redirect()->route('admin.drop-points.show',$dropPoint)->with('success','Data lokasi berhasil diperbarui.');
    }
    public function destroy(DropPoint $dropPoint)
    {
        $dropPoint->delete();
        return redirect()->route('admin.drop-points.index')->with('success','Lokasi drop point berhasil dihapus.');
    }
}