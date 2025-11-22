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

// Import semua model relasi yang diperlukan untuk Eager Loading
use App\Models\DataBaptis;
use App\Models\DataKatekumen;
use App\Models\DataKeluarga;
use App\Models\DataMenikah;
use App\Models\DataRiwayat;


class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user dari guard
        $loggedInUser = auth()->guard('member')->user();

        // 2. Ambil objek Member LENGKAP dengan Eager Loading SEMUA relasi
        $memberData = Member::where('number', $loggedInUser->number)
                           ->with([
                               'dataKatekumen',
                               'dataRiwayat',
                               'dataMenikah',
                               'dataBaptis',
                               // Relasi 'dataKeluarga' harus diambil
                               'dataKeluarga',
                           ])
                           ->firstOrFail();

        // 3. Mengambil data registrasi (untuk detail tambahan seperti jabatan)
        $registrationData = Registration::where('email', $loggedInUser->email)->first();

        // 4. Mengambil event yang diikuti user
        $events = DetailEvent::with('event')
                           ->where('member_id', $loggedInUser->id)
                           ->latest()
                           ->get();

        // 5. Kirim data yang dibutuhkan ke frontend
        return inertia('User/Dashboard/Index', [
            'registrationData' => $registrationData, // Kirim data registrasi (data)
            'events'           => $events,
            'user'             => $memberData // Kirim data Member lengkap dengan relasi
        ]);
    }

    // Fungsi untuk tombol "Data Sudah Benar" (Tidak ada perubahan)
    public function verifyData()
    {
        $user = auth()->guard('member')->user();

        $verify = Member::where('email', $user->email)->firstOrFail();
        
        $verify->update([
            'status' => 'confirmed'
        ]);

        return redirect()->back()->with('success', 'Data berhasil diverifikasi. Selamat datang di Dashboard Kegiatan.');
    }
}