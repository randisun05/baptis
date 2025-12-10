<?php

namespace App\Http\Controllers\User;

use App\Models\Member;
use App\Models\DataBaptis;
use App\Models\DataMenikah;
use App\Models\DataRiwayat;

// Import semua model relasi yang diperlukan untuk Eager Loading
use App\Models\DataKeluarga;
use Illuminate\Http\Request;
use App\Models\DataKatekumen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Registration; // Diperlukan untuk data tambahan/jabatan

class DataProfileController extends Controller
{
    /**
     * Menampilkan halaman detail profil pengguna yang sudah terautentikasi HANYA JIKA statusnya 'confirmed'.
     * Data dimuat dengan Eager Loading untuk semua relasi.
     *
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
  public function showProfileOnly()
    {
        // 1. Ambil data user dari guard 'member'
        $loggedInUser = auth()->guard('member')->user();

        if (!$loggedInUser) {
            return redirect('/login')->with('error', 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        // 2. Ambil objek Member LENGKAP dengan Eager Loading SEMUA relasi
        $memberData = Member::where('number', $loggedInUser->number)
                           ->with([
                               'dataKatekumen',
                               'dataRiwayat',
                               'dataMenikah',
                               'dataBaptis',
                               'dataKeluarga',
                           ])
                           ->firstOrFail();

        // 3. Mengambil data registrasi (untuk detail tambahan seperti jabatan/role)
        $registrationData = Registration::where('email', $loggedInUser->email)->first();
        // 4. Kirim data yang dibutuhkan ke frontend
        return inertia('User/DataProfile/Index', [ 
            'registrationData' => $registrationData, // Data Registrasi
            'user'             => $memberData,       // Data Member LENGKAP dengan semua relasi
            'errors'           => session('errors') ? session('errors')->getBag('default')->toArray() : [], // Kirimkan errors (jika ada)
        ]);
    }

    /**
     * Memperbarui password pengguna yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id (ID User)
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        // Pastikan pengguna yang login adalah pemilik ID ini
        $loggedInUser = auth()->guard('member')->user();
        if (!$loggedInUser || $loggedInUser->id != $id) {
            return response()->json(['message' => 'Unauthorized or invalid user ID.'], 403);
        }

        // 1. Validasi Input Password
        // 'nullable' berarti jika kosong, tidak ada validasi lain yang dijalankan.
        // 'required_with:password_confirmation' memastikan jika salah satu diisi, yang lain juga harus diisi.
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi Password tidak cocok.',
        ]);

        // 2. Cek apakah password baru diisi
        if (!empty($request->password)) {
            // Dapatkan model User berdasarkan ID (ID dari guard 'member' biasanya dari tabel 'members')
            // Di sini kita berasumsi model Member adalah model yang digunakan untuk autentikasi.
            $member = Member::findOrFail($id);
            
            // 3. Update password
            $member->update([
                'password' => Hash::make($request->password),
            ]);

            // 4. Redirect atau kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Password berhasil diperbarui.');

        } else {
            // Jika password kosong, kembali tanpa update, mungkin dengan pesan peringatan
            return redirect()->back()->with('warning', 'Tidak ada perubahan password yang dilakukan.');
        }
    }
}