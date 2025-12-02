<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ManagementController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login: nama, email, dan role.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Mengirim data pengguna yang relevan ke Inertia
        return inertia('Admin/Management/Index', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            // Data 'success' atau 'error' akan ditangkap oleh Inertia jika dikirim melalui session flash
        ]);
    }

    
    /**
     * Memperbarui password pengguna (hanya password baru dan konfirmasi).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            // Memastikan password baru diisi, berupa string, minimal 8 karakter, dan terkonfirmasi (cocok dengan 'password_confirmation')
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
        ]);

        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login

        // 2. Update Password
        User::where('id', $userId)->update([
            'password' => Hash::make($request->password), // Hash password baru sebelum disimpan
        ]);

        // 3. Redirect ke halaman sebelumnya dengan pesan flash.
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}