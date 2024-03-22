<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Tahun;
use App\Models\IsAdmin;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MuridsImport;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_input()
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $kelas = Kelas::orderBy('kelas')->get();
        $tahun = Tahun::orderBy('tahun')->get();
        return view('pages/murid/input', [
            "title" => "Input Murid",
            "titlepage" => "Input Murid",
            "kelas" => $kelas,
            "tahun" => $tahun
        ]);
    }

    public function index_daftar()
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $murid = Murid::with(['kelas', 'tahun'])->get();
        return view('pages/murid/daftar', [
            "title" => "Daftar Murid",
            "titlepage" => "Daftar Murid",
            "murid" => $murid
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $kelas_id = Kelas::where('kelas', $request->kelas)->first()->id;
        $tahun_id = Tahun::where('tahun', $request->tahun)->first()->id;

        $validasi = $request->validate([
            'nis' => 'required|integer|unique:murids',
            'nama' => 'required|min:3|max:255',
            'kelas' => 'required'
        ]);

        $validasi['kelas_id'] = $kelas_id;
        $validasi['tahun_id'] = $tahun_id;

        Murid::create($validasi);

        return redirect('/input-murid')->with('success', '');
    }

    /**
     * Display the specified resource.
     */
    public function show(Murid $murid)
    {
    }

    public function show_detail(Murid $murid)
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $kelas = Kelas::get('kelas');
        $tahun = Tahun::get('tahun');
        return view('pages/murid/detail', [
            "title" => "Detail Murid",
            "titlepage" => "Detail Murid",
            "kelas" => $kelas,
            "murid" => $murid,
            "tahun" => $tahun,
            "absensi" => Absensi::latest()->where('murid_id', $murid->id)->limit(30)->get(),
            "qr" => QrCode::size(200)->generate($murid->nis)

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Murid $murid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Murid $murid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $getId = $request->murid;

        // Hapus data Murid sesuai dengan id-nya
        $validasi = $request->validate([
            'captcha' => 'required|captcha'
        ]);

        if ($validasi) {
            Murid::where('id', $getId)->delete();
            return redirect('/daftar-murid')->with('deleted', 'Data Murid berhasil di hapus!.');
        }

        return redirect('/detail-murid/' . $getId)->with('fail', '');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls|max:2048', // Validate file type and size
        ]);

        print($request->file('excelFile'));

        $file = $request->file('excelFile');

        try {
            Excel::import(new MuridsImport, $file);

            return redirect()->route('murids.index')->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data. ' . $e->getMessage());
        }
    }
}
