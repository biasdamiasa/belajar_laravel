<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::group(['middleware' => ['api.superadmin']], function() {
        //KELAS
        Route::post('/kelas', 'KelasController@store');
        
        //SISWA
        Route::post('/siswa', 'SiswaController@store');
        Route::put('/siswa/{id}', 'SiswaController@update');
        Route::delete('/siswa/{id}', 'SiswaController@delete');
    });
    
    Route::group(['middleware' => ['api.admin']], function() {
        //KELAS
        Route::get('/kelas', 'KelasController@show');

        //SISWA
        Route::get('/siswa', 'SiswaController@show');
        Route::get('/siswa/{id}', 'SiswaController@detail');
        
        //BUKU
        Route::post('/buku', 'BukuController@store');
        Route::put('/buku/{id}', 'BukuController@update');
        Route::delete('/buku/{id}', 'BukuController@delete');
        
        //TRANSAKSI
        Route::post('/transaksi/pinjam', 'TransaksiController@tambahPinjam');
        Route::post('/transaksi/tambahdetail/{id}', 'TransaksiController@tambahDetail');
        Route::post('/transaksi/kembali', 'TransaksiController@tambahKembali');
    });
    
    Route::get('/buku', 'BukuController@show');
    Route::get('/buku/{id}', 'BukuController@detail');    
    
});



