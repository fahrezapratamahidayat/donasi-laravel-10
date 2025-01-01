<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class AdminDonasiController extends Controller
{
    public function index()
    {
        $donasi = Donasi::with(['user'])
            ->latest()
            ->paginate(10);

        return view('admin.donasi.index', compact('donasi'));
    }

    public function verify($id)
    {
        $donasi = Donasi::findOrFail($id);

        $donasi->update([
            'is_verified' => true,
            'status' => 'active'
        ]);

        return redirect()
            ->route('admin.donasi.show', $id)
            ->with('success', 'Campaign berhasil diverifikasi');
    }

    public function show($id)
    {
        $donasi = Donasi::with(['donasiDetail.user', 'user'])
            ->findOrFail($id);

        return view('admin.donasi.show', compact('donasi'));
    }
}
