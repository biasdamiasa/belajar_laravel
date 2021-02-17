<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kembali extends Model
{
    protected $table = 'pengembalian_buku';
    public $timestamps = false;

    protected $fillable = ['id_peminjaman_buku', 'tanggal_kembali', 'denda'];
}
