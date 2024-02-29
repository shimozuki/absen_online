<?php

namespace App\Http\Controllers;
use App\Models\Murid;
use App\Models\Absensi;
use App\Models\ManajemenWaktu;
use App\Models\alpha_view;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        $manajemenWaktu = new ManajemenWaktu();               
        $tanggalHariIni = $manajemenWaktu->ambilTanggal();
        $hariIni = $manajemenWaktu->ambilHari();
        $bulanHariIni = $manajemenWaktu->ambilBulan();
        $tahunHariIni = $manajemenWaktu->ambilTahun();
        $waktuDatabase = $manajemenWaktu->ambilTahunBulanTanggal();

        $totalMurid = count(Murid::all());

        $dataAbsenMasuk = Absensi::with(['murid','kelas'])->where('status', 1)->whereDate('created_at', $waktuDatabase)->get();
        $dataAbsenAlpa = alpha_view::whereDate('timetamps_column', $waktuDatabase)->get();
        $dataAbsenTerlambat = Absensi::with(['murid','kelas'])->whereIn('status', [2,3])->whereDate('created_at', $waktuDatabase)->get();

        $absenAlpa = count($dataAbsenAlpa);
        $absenMasuk = count($dataAbsenMasuk);
        $absenTerlambat = count($dataAbsenTerlambat);        
        

        return view('pages/beranda', [
            "title" => "Beranda",
            "titlepage" => "Beranda",
            "absenMasuk" => $absenMasuk,
            "absenTerlambat" => $absenTerlambat,
            "absenAlpa" => $absenAlpa,
            "muridMasuk" => $dataAbsenMasuk,
            "muridTerlambat" => $dataAbsenTerlambat,
            "muridAlpa" => $dataAbsenAlpa,
            "totalMurid" => $totalMurid,
            "hari" => $hariIni,
            "tanggal" => $tanggalHariIni,
            "bulan" => $bulanHariIni,
            "tahun" => $tahunHariIni
        ]);
    }
}
