<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'pengarang' => 'required',
            'deskripsi' => 'required',
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Buku::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi,
        ]);

        if($simpan) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function show()
    {
        return Buku::all();
    }

    public function detail($id)
    {
        if(Buku::where('id', $id)->exists()) {
            $data = Buku::where('buku.id', '=', $id)->get();

            return Response()->json($data);
        }
        else {
            return Response()->json(['pesan' => 'Tidak ditemukan']);
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'pengarang' => 'required',
            'deskripsi' => 'required',
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = Buku::where('id', $id)->update([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'deskripsi' => $request->deskripsi
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function delete($id)
    {
        $hapus = Buku::where('id', $id)->delete();

        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);            
        }
    }
}
