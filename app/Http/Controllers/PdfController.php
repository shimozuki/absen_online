<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Kelas;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\IsAdmin;
use Intervention\Image\Facades\Image;

class PdfController extends Controller
{


    public function downloadKartuSatuan(Murid $murid)
    {
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();
        $kosong = [];

        $qrCode = QrCode::size(200)->generate($murid->nis);

        $qrPath = public_path('qrcodes/Kartu-Absen-' . $murid->nis . '.svg');
        file_put_contents($qrPath, $qrCode);

        return response()->download($qrPath, 'Kartu-Absen-' . $murid->nis . '.svg')->deleteFileAfterSend(true);
    }




    public function downloadKartuMassal(Murid $murid, Kelas $kelas)
    {
        // Verifikasi untuk User yang login apakah dia Admin
        $verifikasiAdmin = new IsAdmin();
        $verifikasiAdmin->isAdmin();

        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden

        $murids = Murid::where('kelas_id', $kelas->id)->get();

        if ($murids->isNotEmpty()) {
            $data = [];

            foreach ($murids as $m) {
                $qr = QrCode::size(80)->generate($m->nis);

                $data[] = [
                    'nama' => $m->nama,
                    'kelas' => $m->kelas->kelas,
                    'nis' => $m->nis,
                    'qr' => $qr
                ];
            }



            return response()->download($pngPath, 'Kartu-Absen-' . $kelas->kelas . '.png')->deleteFileAfterSend(true);
        } else {
            return redirect('/kelas/daftar')->with('fail_qr', '');
        }
    }
}
