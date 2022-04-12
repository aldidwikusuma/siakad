<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
        

        //fungsi eloquent menampilkan data menggunakan pagination
        //$mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3); // Mengambil semua isi tabel
        //$posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        //return view('mahasiswa.index', compact('mahasiswa'));
        //with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
        {
            //melakukan validasi data
            $request->validate([
            'Nim' => 'required|digits_between:8,10',
            'Nama' => 'required|string|max:25',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => ['required', 'email:dns', 'unique:mahasiswa'],
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
            ]);

            $mahasiswa = new Mahasiswa;
            $mahasiswa->Nim = $request->get('Nim');
            $mahasiswa->Nama = $request->get('Nama');
            $mahasiswa->Jurusan = $request->get('Jurusan');
            $mahasiswa->Email = $request->get('Email');
            $mahasiswa->Alamat = $request->get('Alamat');
            $mahasiswa->Tanggal = $request->get('Tanggal_Lahir');
            $mahasiswa->Kelas_id = $request->get('Kelas');
            $mahasiswa->save();

            return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Ditambahkan');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
        {
            //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
            $Mahasiswa = Mahasiswa::find($Nim);
            return view('mahasiswa.detail', compact('Mahasiswa'));
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
        {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
            $Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();;
            $Kelas = Kelas::all();
            return view('mahasiswa.edit', compact('Mahasiswa','Kelas'));
        }
    public function update(Request $request, $Nim)
        {
            //melakukan validasi data
            $request->validate([
            'Nim' => 'required|digits_between:8,12',
            'Nama' => 'required|string|max:25',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => ['required', 'email:dns'],
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
            ]);

            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
            $mahasiswa->Nim = $request->get('Nim');
            $mahasiswa->Nama = $request->get('Nama');
            $mahasiswa->Jurusan = $request->get('Jurusan');
            $mahasiswa->Email = $request->get('Email');
            $mahasiswa->Alamat = $request->get('Alamat');
            $mahasiswa->Tanggal = $request->get('Tanggal_Lahir');
            
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();
                return redirect()->route('mahasiswa.index')
                    ->with('success', 'Mahasiswa Berhasil Diupdate');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

    		// mengambil data dari table pegawai sesuai pencarian data
		$mahasiswa = DB::table('mahasiswa')
		->where('nama','like',"%".$cari."%")
		->paginate(3);

    		// mengirim data pegawai ke view index
		// return view('index',['pegawai' => $pegawai]);
        return dd($mahasiswa);

	}
}