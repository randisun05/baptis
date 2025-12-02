<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Models\Member;
use App\Models\DataBaptis;
use App\Models\DataMenikah;
use App\Models\DataRiwayat;
use App\Models\DataKeluarga;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\DataKatekumen;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\DB;
use App\Exports\RegistrationsExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class RegistrationController extends Controller
{
    /**
     * Menampilkan daftar peserta.
     */
    public function index()
    {
        // Mengambil data dengan pencarian nama/email dan pagination
        $registers = Registration::query()
            ->when(request()->q, function($query) {
                $query->where('name', 'like', '%'. request()->q . '%')
                      ->orWhere('email', 'like', '%'. request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Memformat data agar mudah dibaca di Vue (Convert Boolean ke String Label)
        $registers->getCollection()->transform(function ($reg) {
            return [
                'id' => $reg->id,
                'number' => $reg->number,
                'name' => $reg->name,
                'email' => $reg->email,
                'contact' => $reg->contact,
                // Ubah boolean DB ke string untuk tampilan tabel
                'gender' => $reg->gender ? 'Laki-laki' : 'Perempuan',
                'kelompok' => $reg->group ? 'Katekumen' : 'Sakramen Baptis Bayi',
                'status' => $reg->status,
                'created_at' => $reg->created_at
            ];
        });

        return inertia('Admin/Registration/Index', [
            'registers' => $registers,
        ]);
    }

    /**
     * Menampilkan form tambah peserta.
     */
    public function create()
    {
        return inertia('Admin/Registration/Create');
    }


    public function store(Request $request)
    {

        // 1. Validasi Input Dasar
        $rules = [
            'number' => 'required|string|unique:registrations',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:registrations,email|unique:members,email',
            'contact' => 'required|unique:registrations,contact',
            'kelompok' => 'required|in:Katekumen,Sakramen Baptis Bayi',
            // Tambahkan validasi untuk anggota keluarga wajib diisi
            'family_members' => 'required|array|min:1',
            'family_members.*.name' => 'required|string|max:255',
            'family_members.*.religion' => 'required|string|max:50',
            'family_members.*.relation' => 'required|string|max:50',
            'family_members.*.address' => 'required|string',
            'family_members.*.contact' => 'required|string|max:255',

        ];

        // 1b. Validasi Kondisional berdasarkan Kelompok
        if ($request->kelompok === 'Katekumen') {
            // DataKatekumen
             $rules['address'] = 'required|string';
             $rules['education'] = 'required|string|max:100';
             $rules['namePenjamin'] = 'required|string|max:255';

            // DataRiwayat
             $rules['religion'] = 'required|string|max:50';
             $rules['location'] = 'required|string|max:255';
            // $rules['schedule'] = 'nullable|string|max:255';
             $rules['dateStart'] = 'required|date';
            // $rules['dateEnd'] = 'nullable|date';
            // $rules['participateBefore'] = 'boolean';
            // $rules['nameGuru'] = 'nullable|string|max:255';
            // $rules['nameGereja'] = 'nullable|string|max:255';
            // $rules['addressGereja'] = 'nullable|string';
            // $rules['namePriest'] = 'nullable|string|max:255';
            // $rules['dateBaptis'] = 'nullable|date';
            // $rules['numberBaptis'] = 'nullable|string|max:50';

            // DataMenikah
             $rules['statusMarried'] = 'required|string|max:50';

            // Aturan kompleks lainnya (misalnya, jika statusMarried = Menikah Katolik, maka namePasangan wajib)
            if ($request->statusMarried && $request->statusMarried !== 'Belum Menikah') {
                 $rules['namePasangan'] = 'required|string|max:255';
                 $rules['religionPasangan'] = 'required|string|max:50';
                // ... dan validasi lainnya sesuai kompleksitas form Menikah
            }

        } elseif ($request->kelompok === 'Sakramen Baptis Bayi') {
            // DataBaptis
            // 'name' pada model Registration adalah Nama Bayi.
            $rules['nameWali'] = 'required|string|max:255'; // **TAMBAHAN UNTUK nameWali**
            $rules['namePastoor'] = 'required|string|max:255';
            $rules['status'] = 'required|string|max:50'; // Status DataBaptis
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'contact.unique' => 'Nomor telepon sudah terdaftar.',
            'kelompok.required' => 'Silakan pilih kelompok katekese.',
            'family_members.required' => 'Data anggota keluarga wajib diisi.',
             'nameWali.required' => 'Nama Wali/Orang Tua wajib diisi untuk Sakramen Baptis Bayi.', // **Pesan nameWali**
            // ... Tambahkan pesan error kondisional lainnya
        ];

        $request->validate($rules, $messages);

        // 2. Mapping Data Dasar
        $isMale = $request->gender === 'Laki-laki';
        $isCatechumen = $request->kelompok === 'Katekumen';
        $password = self::generateSecurePassword(8);
        $passwordHashed = Hash::make($password);

        // Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // 3. Simpan ke Model Registration (Detail Pendaftaran)
            $registration = Registration::create([
                'number' => $request->number,
                'name' => $request->name,
                'gender' => $isMale,
                'email' => $request->email,
                'contact' => $request->contact,
                'group' => $isCatechumen,
                'status' => 'wait',
            ]);

            // 4. Simpan ke Model Member (Akun untuk Login)
            Member::create([
                'number' => $request->number,
                'name' => $request->name,
                'password' => $passwordHashed,
                'email' => $request->email,
                'contact' => $request->contact,
                'group' => $isCatechumen,
                'status' => 'confirm',
            ]);

            // 5. Simpan Data Kondisional
            if ($request->kelompok === 'Katekumen') {
                // 5a. Data Katekumen
                DataKatekumen::create([
                    'number' => $request->number,
                    'address' => $request->address,
                    'education' => $request->education,
                    'namePenjamin' => $request->namePenjamin,
                ]);

                // 5b. Data Riwayat (LENGKAP)
                DataRiwayat::create([
                    'number' => $request->number,
                    'religion' => $request->religion,
                    'location' => $request->location,
                    'schedule' => $request->schedule ?? null,
                    'dateStart' => $request->dateStart,
                    'dateEnd' => $request->dateEnd ?? null,
                    'participateBefore' => $request->participateBefore ?? false,
                    'nameGuru' => $request->nameGuru ?? null,
                    'nameGereja' => $request->nameGereja ?? null,
                    'addressGereja' => $request->addressGereja ?? null,
                    'namePriest' => $request->namePriest ?? null,
                    'dateBaptis' => $request->dateBaptis ?? null,
                    'numberBaptis' => $request->numberBaptis ?? null,
                ]);

                // 5c. Data Menikah (LENGKAP)
                DataMenikah::create([
                    'number' => $request->number,
                    'statusMarried' => $request->statusMarried,
                    'namePasangan' => $request->namePasangan ?? null,
                    'religionPasangan' => $request->religionPasangan ?? null,
                    'placeMarried1' => $request->placeMarried1 ?? null,
                    'cityMarried1' => $request->cityMarried1 ?? null,
                    'dateMarried1' => $request->dateMarried1 ?? null,
                    'namePeneguh1' => $request->namePeneguh1 ?? null,
                    'numberMarried1' => $request->numberMarried1 ?? null,
                    'placeMarried2' => $request->placeMarried2 ?? null,
                    'cityMarried2' => $request->cityMarried2 ?? null,
                    'dateMarried2' => $request->dateMarried2 ?? null,
                    'namePeneguh2' => $request->namePeneguh2 ?? null,
                    'numberMarried2' => $request->numberMarried2 ?? null,
                    'cityMarried3' => $request->cityMarried3 ?? null,
                    'dateMarried3' => $request->dateMarried3 ?? null,
                    'numberMarried3' => $request->numberMarried3 ?? null,
                    'religionMarried' => $request->religionMarried ?? null,
                    'placeMarried4' => $request->placeMarried4 ?? null,
                    'cityMarried4' => $request->cityMarried4 ?? null,
                    'namePeneguh4' => $request->namePeneguh4 ?? null,
                    'dateMarried4' => $request->dateMarried4 ?? null,
                    'numberMarried4' => $request->numberMarried4 ?? null,
                    'nameMantan' => $request->nameMantan ?? null,
                    'cityMantan' => $request->cityMantan ?? null,
                    'statusMantan' => $request->statusMantan ?? null,
                    'yearMantan' => $request->yearMantan ?? null,
                ]);

            } elseif ($request->kelompok === 'Sakramen Baptis Bayi') {
                // 5a. Data Baptis Bayi
                DataBaptis::create([
                    'number' => $request->number,
                    'nameWali' => $request->nameWali, // **DIGANTI: Menggunakan nameWali**
                    'status' => $request->status, // Status di Model DataBaptis
                    'namePastoor' => $request->namePastoor,
                ]);
            }

            // 6. Simpan Data Keluarga (Berulang untuk kedua kelompok)
            foreach ($request->family_members as $memberData) {
                DataKeluarga::create([
                    'number' => $request->number,
                    'name' => $memberData['name'],
                    'religion' => $memberData['religion'],
                    'relation' => $memberData['relation'],
                    'address' => $memberData['address'],
                    'contact' => $memberData['contact'],
                ]);
            }

            DB::commit(); // Commit (Simpan Permanen)

            Mail::to($request->email)->send(new \App\Mail\SendEmailRegistration($registration, $password));

            // 7. Respon ke Vue/Inertia
            return Redirect::route('admin.registration.index')->with('success', 'Pendaftaran baru berhasil diproses dan disimpan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback (Batalkan semua operasi DB jika ada error)

            \Log::error("Registration failed: " . $e->getMessage());

            // Berikan feedback error kepada pengguna
            return redirect()->back()->with('error', 'Gagal memproses pendaftaran karena masalah sistem. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        // 1. Ambil data Registrasi utama
        $registration = Registration::findOrFail($id);
        $number = $registration->number; // Gunakan 'number' sebagai kunci relasi

        // 2. Tentukan kelompok dan ambil data terkait
        $isCatechumen = $registration->group;
        $data = [
            'registration' => $registration,
            'family_members' => DataKeluarga::where('number', $number)->get(),
        ];

        if ($isCatechumen) {
            $data['data_katekumen'] = DataKatekumen::where('number', $number)->first();
            $data['data_riwayat'] = DataRiwayat::where('number', $number)->first();
            $data['data_menikah'] = DataMenikah::where('number', $number)->first();
            $data['data_baptis'] = null; // Pastikan data yang tidak relevan null
        } else {
            $data['data_baptis'] = DataBaptis::where('number', $number)->first();
            $data['data_katekumen'] = null;
            $data['data_riwayat'] = null;
            $data['data_menikah'] = null;
        }

        // 3. Kirim semua data yang telah di-load ke view Edit.vue
        return inertia('Admin/Registration/Edit', [
            'registration' => $data
        ]);
    }
    /**
     * Memperbarui (Update) data registrasi yang ada di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID dari Registrasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Temukan data registrasi yang akan diubah
        $registration = Registration::findOrFail($id);

        $oldNumber = $registration->number;
        $isCatechumen = $registration->group; // Kelompok tidak bisa diubah

        // 1. Validasi Input Dasar
        $rules = [
            // number tidak divalidasi unique karena tidak berubah
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            // Pastikan email dan contact unique, kecuali untuk record yang sedang di-edit
            'email' => 'required|email|unique:registrations,email,' . $id . '|unique:members,email,' . $oldNumber . ',number', // Gunakan 'number' sebagai unique key di tabel Member
            'contact' => 'required|string|max:255|unique:registrations,contact,' . $id,
            'kelompok' => 'required|in:Katekumen,Sakramen Baptis Bayi',
             // Validasi Data Keluarga (Array)
            'family_members' => 'required|array|min:1',
            'family_members.*.name' => 'required|string|max:255',
            'family_members.*.religion' => 'required|string|max:50',
            'family_members.*.relation' => 'required|string|max:50',
            'family_members.*.address' => 'required|string',
            'family_members.*.contact' => 'required|string|max:255',
        ];

        // 1b. Validasi Kondisional (Menggunakan aturan yang sama dengan store)
        if ($isCatechumen) {
            // DataKatekumen
             $rules['address'] = 'required|string';
             $rules['education'] = 'required|string|max:100';
             $rules['namePenjamin'] = 'required|string|max:255';

            // DataRiwayat
             $rules['religion'] = 'required|string|max:50';
            // // ... (tambahkan validasi DataRiwayat dan DataMenikah lainnya)
        } else {
            // DataBaptis
            $rules['nameWali'] = 'required|string|max:255'; // **TAMBAHAN UNTUK nameWali**
            $rules['namePastoor'] = 'required|string|max:255';
            $rules['status'] = 'required|string|max:50';
        }

        $request->validate($rules);

        // 2. Mapping Data Dasar
        $newIsMale = $request->gender === 'Laki-laki';

        // Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // 3. Update Model Registration
            $registration->update([
                'name' => $request->name,
                'gender' => $newIsMale,
                'email' => $request->email,
                'contact' => $request->contact,
                // 'group' tidak diupdate karena disabled di form
            ]);

            // 4. Update Model Member (Akun untuk Login)
            Member::where('number', $oldNumber)->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                // Password tidak diubah, kecuali ada field khusus
            ]);

            // 5. Update Data Kondisional (UPDATE atau INSERT jika tidak ada - tapi diasumsikan data terkait sudah ada dari awal)
            if ($isCatechumen) {
                // 5a. Data Katekumen
                DataKatekumen::updateOrCreate(['number' => $oldNumber], [
                    'address' => $request->address,
                    'education' => $request->education,
                    'namePenjamin' => $request->namePenjamin,
                ]);

                // 5b. Data Riwayat
                DataRiwayat::updateOrCreate(['number' => $oldNumber], [
                    'religion' => $request->religion,
                    'location' => $request->location,
                    'schedule' => $request->schedule,
                    'dateStart' => $request->dateStart,
                    'dateEnd' => $request->dateEnd,
                    'participateBefore' => $request->participateBefore,
                    'nameGuru' => $request->nameGuru,
                    'nameGereja' => $request->nameGereja,
                    'addressGereja' => $request->addressGereja,
                    'namePriest' => $request->namePriest,
                    'dateBaptis' => $request->dateBaptis,
                    'numberBaptis' => $request->numberBaptis,
                ]);

                // 5c. Data Menikah
                DataMenikah::updateOrCreate(['number' => $oldNumber], [
                    'statusMarried' => $request->statusMarried,
                    'namePasangan' => $request->namePasangan,
                    'religionPasangan' => $request->religionPasangan,
                    // ... (lanjutkan update semua field DataMenikah)
                    'placeMarried1' => $request->placeMarried1,
                    'cityMarried1' => $request->cityMarried1,
                    'dateMarried1' => $request->dateMarried1,
                    'namePeneguh1' => $request->namePeneguh1,
                    'numberMarried1' => $request->numberMarried1,
                    'placeMarried2' => $request->placeMarried2,
                    'cityMarried2' => $request->cityMarried2,
                    'dateMarried2' => $request->dateMarried2,
                    'namePeneguh2' => $request->namePeneguh2,
                    'numberMarried2' => $request->numberMarried2,
                    'cityMarried3' => $request->cityMarried3,
                    'dateMarried3' => $request->dateMarried3,
                    'numberMarried3' => $request->numberMarried3,
                    'religionMarried' => $request->religionMarried,
                    'placeMarried4' => $request->placeMarried4,
                    'cityMarried4' => $request->cityMarried4,
                    'namePeneguh4' => $request->namePeneguh4,
                    'dateMarried4' => $request->dateMarried4,
                    'numberMarried4' => $request->numberMarried4,
                    'nameMantan' => $request->nameMantan,
                    'cityMantan' => $request->cityMantan,
                    'statusMantan' => $request->statusMantan,
                    'yearMantan' => $request->yearMantan,
                ]);

            } else {
                // 5a. Data Baptis Bayi
                DataBaptis::updateOrCreate(['number' => $oldNumber], [
                    'nameWali' => $request->nameWali, // **DIGANTI: Menggunakan nameWali**
                    'status' => $request->status,
                    'namePastoor' => $request->namePastoor,
                ]);
            }

            // 6. Update Data Keluarga (Hapus yang lama, simpan yang baru/diperbarui)
            // Hapus semua anggota keluarga yang terkait dengan registrasi ini
            DataKeluarga::where('number', $oldNumber)->delete();

            // Simpan semua anggota keluarga yang baru dari request
            foreach ($request->family_members as $memberData) {
                // Karena kita menghapus semua lalu membuat baru, kita hanya perlu create
                DataKeluarga::create([
                    'number' => $oldNumber,
                    'name' => $memberData['name'],
                    'religion' => $memberData['religion'],
                    'relation' => $memberData['relation'],
                    'address' => $memberData['address'],
                    'contact' => $memberData['contact'],
                ]);
            }

            DB::commit(); // Commit (Simpan Permanen)

            // 7. Respon ke Vue/Inertia
            return Redirect::route('admin.registration.index')->with('success', 'Data registrasi peserta berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback (Batalkan semua operasi DB jika ada error)

            \Log::error("Registration update failed: " . $e->getMessage());

            // Berikan feedback error kepada pengguna
            return redirect()->back()->with('error', 'Gagal memperbarui pendaftaran karena masalah sistem. Silakan coba lagi.')->withInput();
        }
    }
    /**
     * Hapus data peserta.
     */
    // Pastikan Anda telah mengimpor Model yang diperlukan di bagian atas file:
// use App\Models\Registration;
// use App\Models\Member;
// use Illuminate\Support\Facades\Redirect;

public function destroy($id)
{
    // 1. Cari data Registration berdasarkan ID
    $register = Registration::findOrFail($id);

    // Simpan email sebelum data dihapus
    $email = $register->email;

    // 2. Hapus data Member terkait
    // Cari member yang memiliki email yang sama dengan registrasi yang akan dihapus
    $member = Member::where('email', $email)->first();

    if ($member) {
        $member->delete();
    }

    // 3. Hapus data Registration
    $register->delete();

    // 4. Redirect dengan pesan sukses
    return Redirect::route('admin.registration.index')->with('success', 'Data peserta dan akun member terkait berhasil dihapus.');
}


public function sendEmail()
{
    $registration = Registration::first();
    $password = 'password'; // Ganti dengan logika pengambilan password yang sesuai


    Mail::to($registration->email)->send(new \App\Mail\SendEmailRegistration($registration, $password));

    return Redirect::back()->with('success', 'Email registrasi berhasil dikirim ulang.');
}

    public static function generateSecurePassword(int $length = 8): string
    {
        // Kumpulan karakter yang aman dan tidak ambigu.
        // Dihindari: 0, 1, I, L, O, i, l, o.
        $characters = '23456789'
                    . 'ABCDEFGHJKMNPQRSTUVWXYZ'
                    . 'abcdefghkmnpqrstuvwxyz'
                    . '@#$%&'; // Tambahkan simbol untuk keamanan tambahan

        $password = '';
        $max = strlen($characters) - 1;

        // Loop untuk memilih karakter acak dari set yang ditentukan
        for ($i = 0; $i < $length; $i++) {
            // Menggunakan random_int untuk menghasilkan angka acak yang aman secara kriptografi
            $password .= $characters[random_int(0, $max)];
        }

        // Tidak ada pemeriksaan kompleksitas atau pengacakan ulang (sesuai permintaan "simpel")
        return $password;
    }

    public function export()
    {
       // Nama file yang akan diunduh
        $fileName = 'data_pendaftaran_' . now()->format('Ymd_His') . '.xlsx';

        // Panggil facade Excel untuk mendownload.
        // Parameter 1: Instance dari Export Class
        // Parameter 2: Nama file
        // Parameter 3 (opsional): Jenis File (Excel::XLSX adalah default)
        return Excel::download(new RegistrationsExport, $fileName);
    }
}