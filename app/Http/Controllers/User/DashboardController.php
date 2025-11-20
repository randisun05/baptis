<?php

namespace App\Http\Controllers\User;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Post;
use App\Models\Event;
use App\Models\Member;
use App\Models\Merchan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\ProfileDataMain;
use App\Models\ProfileDataPosition;
use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use App\Models\Registration;
use Barryvdh\Snappy\Facades\SnappyImage;

class DashboardController extends Controller
{
   public function index()
    {
        if (!auth()->guard('member')->check()) {
            return redirect()->route('login');
        }

        $user = auth()->guard('member')->user();

        // Mengambil data registrasi
        // Asumsi: Kolom penghubung adalah 'member_id' atau 'member_nip' sesuai database Anda
        $data = Registration::where('email', $user->email)->first();

        // Mengambil event yang diikuti user
        // with('event') digunakan untuk mengambil detail nama kegiatan & tanggal dari tabel events
        $events = DetailEvent::with('event')
                    ->where('member_id', $user->id)
                    ->latest()
                    ->get();

        return inertia('User/Dashboard/Index', [
            'data'   => $data,
            'events' => $events,
            'user'   => $user // Kirim data user untuk header
        ]);
    }

    // Fungsi untuk tombol "Data Sudah Benar"
    public function verifyData()
    {
        $user = auth()->guard('member')->user();
        $verify = Member::where('email', $user->email)->firstOrFail();

        // Ubah status dari 'confirm' menjadi 'verified' (atau status aktif lainnya)
        $verify->update([
            'status' => 'confirmed'
        ]);

        return redirect()->back()->with('success', 'Data berhasil diverifikasi. Selamat datang di Dashboard Kegiatan.');
    }

}
