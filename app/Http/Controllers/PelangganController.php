<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $db = Firebase::firestore()->database();
        $documents = $db->collection('pengaduans')->where('user_id', '=', Auth::id())->documents();

        $pengaduanSaya = [];

        foreach ($documents as $doc) {
            if ($doc->exists()) {
                $data = $doc->data();
                $data['id'] = $doc->id();
                $data['created_at'] = \Carbon\Carbon::parse($data['created_at']);
                $pengaduanSaya[] = (object) $data;
            }
        }

        return view('pelanggan.dashboard', compact('pengaduanSaya'));
    }

}
