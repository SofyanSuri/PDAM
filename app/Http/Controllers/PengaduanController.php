<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Contract\Firestore;


class PengaduanController extends Controller
{
    // Menyimpan pengaduan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $db = Firebase::firestore()->database();

        $db->collection('pengaduans')->add([
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'status' => 'baru',
            'created_at' => now()->toDateTimeString()
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }

    // Menampilkan semua pengaduan dari Firebase
    public function index()
    {
        $db = Firebase::firestore()->database();
        $documents = $db->collection('pengaduans')->documents();

        $pengaduan = [];

        foreach ($documents as $doc) {
            if ($doc->exists()) {
                $data = $doc->data();
                $data['id'] = $doc->id();
                $pengaduan[] = $data;
            }
        }

        return view('pengaduan.index', compact('pengaduan'));
    }

    // Update status pengaduan (admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:baru,proses,selesai',
        ]);

        try {
            $db = app(Firestore::class)->database();
            $document = $db->collection('pengaduans')->document($id);
            $snapshot = $document->snapshot();

            if (!$snapshot->exists()) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $document->update([
                ['path' => 'status', 'value' => $request->status]
            ]);

            return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
