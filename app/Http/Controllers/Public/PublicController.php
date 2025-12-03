<?php

namespace App\Http\Controllers\Public;

use App\Models\Member; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendEmailForgetPassword; 
use App\Models\Post;
use App\Models\Event;

class PublicController extends Controller
{

    public function index()
    {

        $posts = Post::where('status', 'active')
            ->latest()
            ->limit(3)
            ->get();

        $events = Event::latest()
            ->limit(3)
            ->get();

        return inertia('Public/Website/Index', [
            'title' => "Beranda",
            'posts' => $posts,
            'events' => $events,
        ]);
    }

    
public function beritaView(Post $post)
    {

         // Get the related category of the post
         $user = auth()->guard('member')->user();
        $member = $post->member;

        return inertia('Public/Website/Posts/Show', [
            'title' => $post->title,
            'post' => $post,
            'member' => $member
        ]);
    }



    /**
     * Menampilkan halaman "Lupa Password" (Forget.vue).
     * Route name: forget.password
     *
     * @return \Inertia\Response
     */
    public function forgetPassword()
    {
        return inertia('Public/Registration/Forget');
    }

    /**
     * Memproses permintaan reset password (mengirim email).
     * Route name: forget.password.email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function emailforgetPassword(Request $request)
    {
        // 1. Validasi Input (Menggunakan 'exists' untuk validasi di sisi server)
        $request->validate([
            'email' => 'required|email|exists:members,email',
        ], [
            'email.required' => 'Alamat email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            // Pesan ini akan muncul di bawah input email jika gagal
            'email.exists' => 'Alamat email tidak terdaftar.', 
        ]);
        
        // Catatan: Jika validasi 'exists' gagal, Inertia akan otomatis mengirim error 'email.exists'
        // ke `form.errors.email` di Vue. 

        // 2. Cari Anggota
        $member = Member::where('email', $request->email)->first();

        // 3. (Opsional) Cek Keberadaan Anggota secara eksplisit 
        // Walaupun 'exists' sudah menangani, ini adalah fallback jika Anda menghilangkan 'exists'
        if (!$member) {
             // Jika email tidak ditemukan, kirim pesan error ke session
             // Pesan ini akan ditangkap oleh $page.props.session?.error
             return redirect()->back()->with('error', 'Alamat email tidak terdaftar.');
        }

        // 4. Generate Code dan Update
        try {
            $passwordCode = Str::uuid()->toString(); 

            $member->update([
                'code-password' => $passwordCode,
            ]);

            // 5. Kirim Email
            Mail::to($member->email)->send(new SendEmailForgetPassword($member));

            return redirect()->back()->with('success', 'Tautan reset password telah dikirim ke email Anda. Silakan cek kotak masuk/spam Anda.');

        } catch (\Exception $e) {
            \Log::error('Email reset password failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }
    }



    public function IndexforgetPassword(Member $member, $id)
    {
        $member = Member::where('code-password', $id)->first();

        if (!$member || empty($member->{'code-password'})) {
             // Redirect ke halaman login jika tautan tidak valid atau kedaluwarsa
             return redirect()->route('user.login')->with('error', 'Tautan reset password tidak valid atau sudah kedaluwarsa.');
        }

        // Tampilkan Reset.vue
        return inertia('Public/Registration/Reset', [
             'member' => [
                 'email' => $member->email,
                 'code_password' => $member->{'code-password'}, // Kirim kode sebagai ID untuk proses reset POST
             ]
        ]);
    }

    /**
     * Memproses pengiriman password baru.
     * Route name: user.reset.post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id (code-password)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ResetPassword(Request $request, $id)
    {
        // 1. Validasi Input Password
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'confirmed',
            ],
        ],[
            'password.required' => 'Password baru harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'password.min' => 'Password baru minimal 8 karakter'
        ]);

        // 2. Cari Anggota berdasarkan code-password
        $member = Member::where('code-password', $id)->first();

        if (!$member || empty($member->{'code-password'})) {
            return redirect()->route('user.login')->with('error', 'Akses tidak sah atau tautan sudah digunakan.');
        }

        // 3. Update Password dan hapus code-password
        $member->update([
            'password' => Hash::make($request->password),
            'code-password' => null, // Hapus kode setelah berhasil direset
        ]);

        return redirect()->route('user.login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}