<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/data/search', function () {
    $search = request('search');
            $mahasiswa = Mahasiswa::with('kelas')->get();
            $paginate = Mahasiswa::where('nama', 'like', '%' . $search . '%')->orderBy('Nim', 'asc')->paginate(3);
            return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);        
});