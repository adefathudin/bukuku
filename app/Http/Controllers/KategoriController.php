<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends BaseController
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('index', ['template' => 'kategori.index', 'kategori' => $kategori]);
    }

    public function save(Request $request)
    {
        $kategori = Kategori::updateOrCreate(
            ['id' => $request->input('id')],
            ['nama_kategori' => $request->input('nama_kategori'), 'tipe' => $request->input('tipe')]
        );

        return response()->json(['message' => 'Kategori saved successfully', 'data' => $kategori]);
    }

    public function list(Request $request)
    {
        $kategori = Kategori::query();

        if ($request->has('search')) {
            $kategori->where('nama', 'like', '%' . $request->search . '%');
        }

        $pemasukan = (clone $kategori)->where('tipe', 1)->get();
        $pengeluaran = (clone $kategori)->where('tipe', 2)->get();

        return response()->json([
            'data' => $kategori->get(),
            'total' => $kategori->count(),
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return response()->json(['message' => 'Kategori deleted successfully']);
    }
}
