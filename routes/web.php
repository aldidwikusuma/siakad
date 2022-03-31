<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/data/search', function () {
    $search = request('search');
            $mahasiswa = DB::table('mahasiswa')->where('nama', 'like', '%' . $search . '%')->paginate(5);
            return view('mahasiswa.index', compact('mahasiswa'));        
});