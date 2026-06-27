<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControllerKeranjang
{
    public function index()
    {
        $keranjangs = Keranjang::with('barang')
            ->where('id_user', Auth::id())
            ->get();

        $total = $keranjangs->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        return view('keranjang.index', compact('keranjangs', 'total'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = Keranjang::with('barang')
            ->where('id_user', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($request->jumlah > $keranjang->barang->stok) {
            return back()->with('error', 'Jumlah beli melebihi stok barang');
        }

        $keranjang->update([
            'jumlah' => $request->jumlah,
        ]);

        return back()->with('success', 'Jumlah barang berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        $keranjang = Keranjang::where('id_user', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $keranjang->delete();

        return back()->with('success', 'Barang berhasil dihapus dari keranjang');
    }

    public function checkout(Request $request)
    {
        $keranjangs = Keranjang::with('barang')
            ->where('id_user', Auth::id())
            ->get();

        if ($keranjangs->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong');
        }

        $total = $keranjangs->sum(function ($item) {
            return $item->jumlah * $item->harga;
        });

        $request->validate([
            'bayar' => 'required|numeric|min:' . $total,
            'metode_pembayaran' => 'required|in:cash,qris,transfer,debit',
        ]);

        DB::beginTransaction();

        try {
            $penjualan = Penjualan::create([
                'kode_transaksi' => 'TRX' . date('YmdHis'),
                'id_user' => Auth::id(),
                'tanggal' => now(),
                'total' => $total,
                'bayar' => $request->bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'kembalian' => $request->bayar - $total,
                'status' => 'selesai',
            ]);

            foreach ($keranjangs as $keranjang) {
                $barang = $keranjang->barang;

                if ($keranjang->jumlah > $barang->stok) {
                    DB::rollBack();

                    return back()->with('error', 'Stok barang ' . $barang->nama_barang . ' tidak mencukupi');
                }

                $hargaModal = $barang->harga_modal ?? 0;
                $subtotal = $keranjang->jumlah * $keranjang->harga;
                $subtotalModal = $keranjang->jumlah * $hargaModal;
                $laba = $subtotal - $subtotalModal;

                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $barang->id,
                    'jumlah' => $keranjang->jumlah,
                    'harga' => $keranjang->harga,
                    'harga_modal' => $hargaModal,
                    'subtotal' => $subtotal,
                    'subtotal_modal' => $subtotalModal,
                    'laba' => $laba,
                ]);

                $barang->update([
                    'stok' => $barang->stok - $keranjang->jumlah,
                ]);

            }

            Keranjang::where('id_user', Auth::id())->delete();

            DB::commit();

            return redirect()->route('penjualan.struk', $penjualan->id)
                ->with('success', 'Checkout berhasil');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function struk(int $id)
    {
        $query = Penjualan::with(['detail.barang', 'user'])
            ->where('id', $id);

        if (Auth::user()->role == 'kasir') {
            $query->where('id_user', Auth::id());
        }

        $penjualan = $query->firstOrFail();

        return view('penjualan.struk', compact('penjualan'));
    }
}
