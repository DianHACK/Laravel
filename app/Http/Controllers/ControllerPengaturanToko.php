<?php

namespace App\Http\Controllers;

use App\Models\PengaturanToko;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerPengaturanToko
{
    public function index()
    {
        $pengaturan = PengaturanToko::firstOrCreate(
            ['id' => 1],
            [
                'nama_toko' => 'Sistem Swalayan',
                'alamat' => 'Alamat toko belum diatur',
                'no_hp' => '-',
                'email' => '-',
                'bank' => 'BRI',
                'no_rekening' => '1234567890',
                'atas_nama' => 'Sistem Swalayan',
            ]
        );

        return view('pengaturan-toko.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanToko::firstOrCreate(['id' => 1]);

        $request->validate([
            'nama_toko' => 'required|min:3',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'bank' => 'nullable|string|max:100',
            'no_rekening' => 'nullable|string|max:100',
            'atas_nama' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'bank' => $request->bank,
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama,
        ];

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }

            $data['logo'] = $request->file('logo')->store('pengaturan-toko', 'public');
        }

        if ($request->hasFile('qris')) {
            if ($pengaturan->qris && Storage::disk('public')->exists($pengaturan->qris)) {
                Storage::disk('public')->delete($pengaturan->qris);
            }

            $data['qris'] = $request->file('qris')->store('pengaturan-toko', 'public');
        }

        $pengaturan->update($data);

        LogAktivitas::catat(
            'Update Pengaturan Toko',
            'Pengaturan Toko',
            'Mengubah data pengaturan toko'
        );
        return redirect()->route('pengaturan-toko.index')
            ->with('success', 'Pengaturan toko berhasil diperbarui');
    }
}
