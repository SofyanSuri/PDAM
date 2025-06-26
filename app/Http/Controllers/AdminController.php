<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AdminController extends Controller
{
    public function dashboard()
    {
        $db = Firebase::firestore()->database();
        $documents = $db->collection('pengaduans')->documents();

        $baru = 0;
        $proses = 0;
        $selesai = 0;
        $pengaduan = [];

        foreach ($documents as $doc) {
            if (!$doc->exists()) continue;

            $data = $doc->data();
            $data['id'] = $doc->id();
            $pengaduan[] = $data;

            switch ($data['status'] ?? 'baru') {
                case 'proses':
                    $proses++;
                    break;
                case 'selesai':
                    $selesai++;
                    break;
                default:
                    $baru++;
            }
        }

        return view('admin.dashboard', [
            'baru' => $baru,
            'proses' => $proses,
            'selesai' => $selesai,
            'labels' => ['Baru', 'Proses', 'Selesai'],
            'data' => [$baru, $proses, $selesai],
            'pengaduan' => $pengaduan, // ← penting untuk tabel
        ]);
    }

    public function dataFirebase()
    {
        $db = Firebase::firestore()->database();
        $pengaduans = $db->collection('pengaduans')->documents();

        return view('admin.pengaduan_firebase', compact('pengaduans'));
    }


}