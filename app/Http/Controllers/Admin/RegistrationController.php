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

    /**
     * Menyimpan data peserta baru.
     */
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

            // DataRiwayat (Disederhanakan: religion wajib, sisanya nullable)
            $rules['religion'] = 'required|string|max:50';

            // Semua field Riwayat dijadikan nullable karena tidak ada historyType yang mengaturnya
            $rules['location'] = 'nullable|string|max:255';
            $rules['dateStart'] = 'nullable|date';
            $rules['schedule'] = 'nullable|date|max:255';
            $rules['dateEnd'] = 'nullable|date';
            $rules['participateBefore'] = 'nullable|string|max:255';
            $rules['nameGuru'] = 'nullable|string|max:255';
            $rules['nameGereja'] = 'nullable|string|max:255';
            $rules['addressGereja'] = 'nullable|string';
            $rules['namePriest'] = 'nullable|string|max:255';
            $rules['dateBaptis'] = 'nullable|date';
            $rules['numberBaptis'] = 'nullable|string|max:50';

            // DataMenikah
            $rules['statusMarried'] = 'required|string|max:50';

            // Validasi detail pernikahan kondisional
            if ($request->statusMarried && $request->statusMarried !== 'Belum Menikah') {
                $rules['namePasangan'] = 'nullable|string|max:255';
                $rules['religionPasangan'] = 'nullable|string|max:50';

                // Hanya wajibkan input dasar jika statusMarried bukan 'Belum Menikah' atau 'Pernah Menikah'
                if ($request->statusMarried !== 'Pernah Menikah') {
                    if ($request->statusMarried === 'Menikah Katolik') {
                        $rules['placeMarried1'] = 'required|string|max:255';
                    } elseif ($request->statusMarried === 'Menikah Kristen') {
                         $rules['placeMarried2'] = 'required|string|max:255';
                    } elseif ($request->statusMarried === 'Menikah Sipil') {
                         $rules['cityMarried3'] = 'required|string|max:255';
                         $rules['dateMarried3'] = 'required|date';
                         $rules['numberMarried3'] = 'required|string|max:50';
                    } elseif ($request->statusMarried === 'Menikah Lain') {
                         $rules['placeMarried4'] = 'required|string|max:255';
                    }
                }
            }
            if ($request->statusMarried === 'Pernah Menikah') {
                $rules['nameMantan'] = 'required|string|max:255';
                $rules['statusMantan'] = 'required|in:Cerai,Meninggal';
                $rules['yearMantan'] = 'required|string|max:4';
            }


        } elseif ($request->kelompok === 'Sakramen Baptis Bayi') {
            // DataBaptis
            $rules['nameWali'] = 'required|string|max:255';
            $rules['namePastoor'] = 'required|string|max:255';
            $rules['status'] = 'required|string|max:50'; // Status DataBaptis (Bapak Baptis/Ibu Baptis)
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'contact.unique' => 'Nomor telepon sudah terdaftar.',
            'kelompok.required' => 'Silakan pilih kelompok katekese.',
            'family_members.required' => 'Data anggota keluarga wajib diisi.',
            'nameWali.required' => 'Nama Wali/Orang Tua wajib diisi untuk Sakramen Baptis Bayi.',
            // Hapus pesan error historyType
            'religionPasangan.required_if' => 'Agama Pasangan wajib diisi.',
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

                // 5b. Data Riwayat (Sederhana tanpa historyType)
                DataRiwayat::create([
                    'number' => $request->number,
                    'religion' => $request->religion,
                    // Semua field diambil langsung dari request, akan null jika tidak dikirim
                    'location' => $request->location ?? null,
                    'schedule' => $request->schedule ?? null,
                    'dateStart' => $request->dateStart ?? null,
                    'dateEnd' => $request->dateEnd ?? null,
                    'participateBefore' => $request->participateBefore ?? null,
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

                    // Detail Katolik
                    'placeMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->placeMarried1 : null,
                    'cityMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->cityMarried1 : null,
                    'dateMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->dateMarried1 : null,
                    'namePeneguh1' => $request->statusMarried === 'Menikah Katolik' ? $request->namePeneguh1 : null,
                    'numberMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->numberMarried1 : null,

                    // Detail Kristen
                    'placeMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->placeMarried2 : null,
                    'cityMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->cityMarried2 : null,
                    'dateMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->dateMarried2 : null,
                    'namePeneguh2' => $request->statusMarried === 'Menikah Kristen' ? $request->namePeneguh2 : null,
                    'numberMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->numberMarried2 : null,

                    // Detail Sipil
                    'cityMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->cityMarried3 : null,
                    'dateMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->dateMarried3 : null,
                    'numberMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->numberMarried3 : null,

                    // Detail Lain (Hanya mencantumkan yang tidak Sipil/Katolik/Kristen)
                    'placeMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->placeMarried4 : null,
                    'cityMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->cityMarried4 : null,
                    'dateMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->dateMarried4 : null,
                    'namePeneguh4' => $request->statusMarried === 'Menikah Lain' ? $request->namePeneguh4 : null,
                    'numberMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->numberMarried4 : null,

                    // Detail Pernah Menikah
                    'nameMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->nameMantan : null,
                    'cityMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->cityMantan : null,
                    'statusMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->statusMantan : null,
                    'yearMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->yearMantan : null,
                ]);

            } elseif ($request->kelompok === 'Sakramen Baptis Bayi') {
                // 5a. Data Baptis Bayi
                DataBaptis::create([
                    'number' => $request->number,
                    'nameWali' => $request->nameWali,
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

            // Mengirim email dengan password yang baru dibuat
            Mail::to($request->email)->send(new \App\Mail\SendEmailRegistration($registration, $password));

            // // 7. Respon ke Vue/Inertia
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

            // DataRiwayat (Disederhanakan: religion wajib, sisanya nullable)
            $rules['religion'] = 'required|string|max:50';

            // Semua field Riwayat dijadikan nullable
            $rules['location'] = 'nullable|string|max:255';
            $rules['dateStart'] = 'nullable|date';
            $rules['schedule'] = 'nullable|string|max:255';
            $rules['dateEnd'] = 'nullable|date';
            $rules['participateBefore'] = 'nullable|string|max:255';
            $rules['nameGuru'] = 'nullable|string|max:255';
            $rules['nameGereja'] = 'nullable|string|max:255';
            $rules['addressGereja'] = 'nullable|string';
            $rules['namePriest'] = 'nullable|string|max:255';
            $rules['dateBaptis'] = 'nullable|date';
            $rules['numberBaptis'] = 'nullable|string|max:50';

            // DataMenikah
            $rules['statusMarried'] = 'required|string|max:50';

            // Validasi detail pernikahan kondisional
            if ($request->statusMarried && $request->statusMarried !== 'Belum Menikah') {
                
                // *** PERBAIKAN VALIDASI PASANGAN UNTUK 'PERNAH MENIKAH' ***
                if ($request->statusMarried === 'Pernah Menikah') {
                    // Untuk status 'Pernah Menikah', Pasangan diizinkan null/kosong
                    $rules['namePasangan'] = 'nullable|string|max:255';
                    $rules['religionPasangan'] = 'nullable|string|max:50';
                } else {
                    // Untuk status pernikahan aktif lainnya
                    $rules['namePasangan'] = 'required|string|max:255'; 
                    $rules['religionPasangan'] = 'nullable|string|max:50'; // Default nullable
                    
                    if ($request->statusMarried === 'Menikah Kristen') {
                        $rules['religionPasangan'] = 'required_if:namePasangan,!=,null|string|max:50';
                    } elseif ($request->statusMarried === 'Menikah Lain') {
                         $rules['religionPasangan'] = 'required|string|max:50';
                    }
                }
                
                // Validasi Detail Khusus Pernikahan Aktif
                if ($request->statusMarried !== 'Pernah Menikah') {
                    if ($request->statusMarried === 'Menikah Katolik') {
                        $rules['placeMarried1'] = 'required|string|max:255';
                    } elseif ($request->statusMarried === 'Menikah Kristen') {
                         $rules['placeMarried2'] = 'required|string|max:255';
                    } elseif ($request->statusMarried === 'Menikah Sipil') {
                         $rules['cityMarried3'] = 'required|string|max:255';
                         $rules['dateMarried3'] = 'required|date';
                         $rules['numberMarried3'] = 'required|string|max:50';
                    } elseif ($request->statusMarried === 'Menikah Lain') {
                         $rules['placeMarried4'] = 'required|string|max:255';
                    }
                }
            }
             if ($request->statusMarried === 'Pernah Menikah') {
                $rules['nameMantan'] = 'required|string|max:255';
                $rules['statusMantan'] = 'required|in:Cerai,Meninggal';
                $rules['yearMantan'] = 'required|string|max:4';
            }


        } else {
            // DataBaptis
            $rules['nameWali'] = 'required|string|max:255';
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

                // 5b. Data Riwayat (Sederhana tanpa historyType)
                // Semua field diambil langsung dari request, akan null jika tidak dikirim
                $riwayatData = [
                    'religion' => $request->religion,
                    'location' => $request->location ?? null,
                    'schedule' => $request->schedule ?? null,
                    'dateStart' => $request->dateStart ?? null,
                    'dateEnd' => $request->dateEnd ?? null,
                    'participateBefore' => $request->participateBefore ?? null,
                    'nameGuru' => $request->nameGuru ?? null,
                    'nameGereja' => $request->nameGereja ?? null,
                    'addressGereja' => $request->addressGereja ?? null,
                    'namePriest' => $request->namePriest ?? null,
                    'dateBaptis' => $request->dateBaptis ?? null,
                    'numberBaptis' => $request->numberBaptis ?? null,
                ];

                DataRiwayat::updateOrCreate(['number' => $oldNumber], $riwayatData);

                // 5c. Data Menikah
                $menikahData = [
                    'statusMarried' => $request->statusMarried,
                    'namePasangan' => $request->namePasangan ?? null,
                    'religionPasangan' => $request->religionPasangan ?? null,

                    // Detail Katolik (Clear if not Catholic)
                    'placeMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->placeMarried1 : null,
                    'cityMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->cityMarried1 : null,
                    'dateMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->dateMarried1 : null,
                    'namePeneguh1' => $request->statusMarried === 'Menikah Katolik' ? $request->namePeneguh1 : null,
                    'numberMarried1' => $request->statusMarried === 'Menikah Katolik' ? $request->numberMarried1 : null,

                    // Detail Kristen (Clear if not Kristen)
                    'placeMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->placeMarried2 : null,
                    'cityMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->cityMarried2 : null,
                    'dateMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->dateMarried2 : null,
                    'namePeneguh2' => $request->statusMarried === 'Menikah Kristen' ? $request->namePeneguh2 : null,
                    'numberMarried2' => $request->statusMarried === 'Menikah Kristen' ? $request->numberMarried2 : null,

                    // Detail Sipil (Clear if not Sipil)
                    'cityMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->cityMarried3 : null,
                    'dateMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->dateMarried3 : null,
                    'numberMarried3' => $request->statusMarried === 'Menikah Sipil' ? $request->numberMarried3 : null,

                    // Detail Lain (Clear if not Lain)
                    'placeMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->placeMarried4 : null,
                    'cityMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->cityMarried4 : null,
                    'dateMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->dateMarried4 : null,
                    'namePeneguh4' => $request->statusMarried === 'Menikah Lain' ? $request->namePeneguh4 : null,
                    'numberMarried4' => $request->statusMarried === 'Menikah Lain' ? $request->numberMarried4 : null,

                    // Detail Pernah Menikah (Clear if not Pernah Menikah)
                    'nameMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->nameMantan : null,
                    // *** KOREKSI DI BAWAH INI: Pastikan menggunakan 'Pernah Menikah' ***
                    'cityMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->cityMantan : null, 
                    'statusMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->statusMantan : null,
                    'yearMantan' => $request->statusMarried === 'Pernah Menikah' ? $request->yearMantan : null,
                ];

                DataMenikah::updateOrCreate(['number' => $oldNumber], $menikahData);

            } else {
                // 5a. Data Baptis Bayi
                DataBaptis::updateOrCreate(['number' => $oldNumber], [
                    'nameWali' => $request->nameWali,
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
