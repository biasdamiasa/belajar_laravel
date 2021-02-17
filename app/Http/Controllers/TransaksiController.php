<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Buku;
use App\Pinjam;
use App\Kembali;
use App\DetailPinjam;

use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function tambahPinjam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Pinjam::create([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        if($simpan) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function tambahDetail($id, Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id_buku' => 'required',
            'jumlah' => 'required'
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = DetailPinjam::create([
            'id_peminjaman_buku' => $id,
            'id_buku' => $request->id_buku,
            'jumlah' => $request->jumlah
        ]);

        if($simpan) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

    public function tambahKembali(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_peminjaman_buku' => 'required'
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $cek = Kembali::where('id_peminjaman_buku', $request->id_peminjaman_buku);
        if($cek->count() == 0) {
            $data = Pinjam::where('id', $request->id_peminjaman_buku)->first();
            $tanggal_sekarang = Carbon::now()->format('Y-m-d');
            $tanggal_kembali = new Carbon($data->tanggal_kembali);
            
            $dendaperhari = 1500;

            if(strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)) {
                $jumlahhari = $tanggal_kembali->diff($tanggal_sekarang)->days;
                $denda = $jumlahhari*$dendaperhari;
            }
            else {
                $denda = 0;
            }

            $simpan = Kembali::create([
                'id_peminjaman_buku' => $request->id_peminjaman_buku,
                'tanggal_kembali' => $tanggal_sekarang,
                'denda' => $denda
            ]);

            if($simpan) {
                $respon['status'] = 1;
                $respon['pesan'] = 'Pengembalian buku berhasil';
            } 
            else {
                $respon['status'] = 0;
                $respon['pesan'] = 'Pengembalian buku gagal';
            }
        } 
        else {
            $respon['status'] = 0;
            $respon['pesan'] = 'Buku sudah kembali';            
        }
        return Response()->json($respon);
    }
}
