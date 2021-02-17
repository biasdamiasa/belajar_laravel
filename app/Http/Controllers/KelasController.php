<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'nama_kelas' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Kelas::create([
            'nama_kelas' => $request->nama_kelas
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
        return Kelas::all();
    }
}
