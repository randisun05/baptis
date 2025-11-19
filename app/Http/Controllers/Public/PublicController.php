<?php

namespace App\Http\Controllers\Public;

use Log;
use App\Models\Post;
use App\Models\Event;
use App\Models\Member;
use App\Models\Category;
use App\Models\Management;
use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\DetailEvent;
use App\Models\ReactDetail;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\DocumentDigital;
use App\Models\RegistrationGroup;
use Illuminate\Support\Facades\DB;
use App\Models\ProfileDataPosition;
use App\Models\TemplateCertificate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailForgetPassword;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
    //    $showPopup = Management::where('item', 'popup')->sum('status');
    //    $datas = Management::where('item', 'popup')->where('status','1')->get();

        return inertia('Public/Website/Index', [
        //    'showPopup' => $showPopup,
        //    'datas' => $datas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function maintenance()
    {
        return inertia('Public/Website/Maintenance/Index', [
            'title' => "Maintenance",

        ]);
    }


    public function about()
    {
       $data = Management::where('item', 'siapakita')->first();
        return inertia('Public/Website/About/About', [
            'title' => "Siapa Kita?",
           'data' => $data
        ]);
    }

    public function visiMisi()
    {
        $data = Management::where('item', 'visimisi')->first();
        return inertia('Public/Website/About/VisiMisi', [
            'title' => "Visi Misi",
            'data' => $data
        ]);
    }

    public function strukturOrganisasi()
    {
        $data = Management::where('item', 'strukturorganisasi')->get();
        return inertia('Public/Website/About/StrukturOrganisasi', [
            'title' => "Struktur Organisasi",
            'data' => $data
        ]);
    }

    public function sejarah()
    {
        $data = Management::where('item', 'sejarah')->first();
        return inertia('Public/Website/About/Sejarah', [
            'title' => "Sejarah Terbentuknya Aspro SDMA",
            'data' => $data
        ]);
    }

    public function peraturanOrganisasi()
    {
       $datas = Management::when(request()->q, function($query) {
           $query->where('body', 'like', '%' . request()->q . '%');
       })
       ->where('item', 'peraturan')
       ->where('status', '1')
       ->latest()
       ->paginate(6);

       $datas->appends(['q' => request()->q]);

        return inertia('Public/Website/About/PeraturanOrganisasi', [
            'title' => "Peraturan Organisasi",
            'datas' => $datas
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


    public function kontak()
    {
        $data = Management::where('item', 'kontak')->first();
        return inertia('Public/Website/About/Kontak-kami', [
            'title' => "Kontak Kami",
              'data' => $data
        ]);
    }



    public function faq()
    {
       $datas = Management::when(request()->q, function($query) {
           $query->where('body', 'like', '%' . request()->q . '%');
       })
       ->where('item', 'faq')
       ->latest()
       ->paginate(6);
        $datas->appends(['q' => request()->q]);
        return inertia('Public/Website/FAQ/faq', [
            'title' => "FAQ",
           'datas' => $datas
        ]);
    }

    public function forgetPassword()
    {
        return inertia('User/Auth/Forget', [

        ]);
    }

    public function emailforgetPassword(Request $request)
    {

        $request->validate([
            'nip' => 'required',
            'email' => 'required|email', // Tambahkan validasi email
        ], [
            'nip.required' => 'Nip harus diisi',
            'email.required' => 'Email terdaftar harus diisi',
            'email.email' => 'Format email tidak valid', // Pesan untuk validasi email
        ]);

        $data = Member::where('nip', $request->nip)->first();

        // Periksa apakah data ditemukan dan email sesuai dengan yang dimasukkan pengguna
        if ($data && $data->email === $request->email) {
             // Generate a UUID for the password code
             $passwordCode = \Illuminate\Support\Str::uuid()->toString();
             $data->update([
                 'code-password' => $passwordCode,
             ]);

            Mail::to($data->email)->send(new SendEmailForgetPassword($data));
            return back()->with('success', 'Email telah dikirimkan untuk reset password.');
        }

        // Jika data tidak ditemukan atau email tidak sesuai
        return redirect()->back()->with('error','Data tidak sesuai.');
    }

    public function IndexforgetPassword(Member $member, $id)
    {
        $member = $member->where('code-password', $id)->first();
        if(!$member || $member->{'code-password'} === null)
        // Jika status registrasi bukan 'confirm', arahkan pengguna kembali atau tampilkan pesan kesalahan
        return redirect()->route('user.login')->with('error', 'Link telah ditutup.');

        return inertia('User/Auth/Index', [
            'member' => $member
        ]);
    }

    public function ResetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/',
                'confirmed',
                // At least one lowercase, one uppercase, one number, and one special character
            ],
        ],[
            'password.regex' => 'Password terdiri dari kombinasi huruf kapaital, huruf kecil, angka dan karakter spesial, contoh:A5proSDM@',
            'password.required' => 'Password baru harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'oldpassword.min:8' => 'Password baru minimal 8 karakter'
        ]);

        $member = Member::Where('code-password', $id)->first();

        $member->update([
            'password' => Hash::make($request->password),
            'code-password' => null,
        ]);

        return redirect()->route('user.login')->with('success', 'Password berhasil direset.');
    }

}
