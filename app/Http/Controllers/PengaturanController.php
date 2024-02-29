<?php

namespace App\Http\Controllers;
use App\Models\IsAdmin;
use App\Models\Pengaturan;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        // Verifikasi untuk User yang login apakah dia Admin
            $verifikasiAdmin = new IsAdmin();
            $verifikasiAdmin->isAdmin(); 
        // Jika status=1, maka akan lanjut kode di bawah
        // Jika status != 1, maka akan 403 Forbidden
        
        $data = Pengaturan::get()->first() ?? "0";

        return view('/pages/pengaturan', [
            "title" => "Pengaturan",
            "titlepage" => "Pengaturan",
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        $validasi = $request->validate([
            'nama_sekolah' => 'required',
            'jam_masuk' => 'required',
            'logo' => 'required'
        ]);

        Pengaturan::create($validasi);

        return redirect('/pengaturan')->with('success');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
