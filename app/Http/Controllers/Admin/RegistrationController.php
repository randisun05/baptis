<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
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

    /**
     * Menyimpan data peserta baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari Vue
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:registrations,email',
            'contact' => 'required|unique:registrations,contact',
            'kelompok' => 'required|in:Katekumen,Sakramen Baptis Bayi',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'contact.unique' => 'Nomor telepon sudah terdaftar.',
            'kelompok.required' => 'Silakan pilih kelompok katekese.'
        ]);

        // 2. Mapping Data (String Vue -> Boolean DB)
        // Sesuai migration: $table->boolean('gender'); $table->boolean('group');
        $isMale = $request->gender === 'Laki-laki' ? true : false;
        $isCatechumen = $request->kelompok === 'Katekumen' ? true : false;

        // 3. Simpan ke Database
        Registration::create([
            'name' => $request->name,
            'gender' => $isMale,
            'email' => $request->email,
            'contact' => $request->contact,
            'group' => $isCatechumen, // Masuk ke kolom 'group' di DB
            'status' => 'wait',       // Default status sesuai enum migration
        ]);

        // 4. Redirect dengan pesan sukses
        return Redirect::route('admin.registration.index')->with('success', 'Data peserta berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $register = Registration::findOrFail($id);

        // Format data agar sesuai dengan v-model di Vue Edit
        $formattedData = [
            'id' => $register->id,
            'name' => $register->name,
            'email' => $register->email,
            'contact' => $register->contact,
            'gender' => $register->gender ? 'Laki-laki' : 'Perempuan',
            'kelompok' => $register->group ? 'Katekumen' : 'Sakramen Baptis Bayi',
        ];

        return inertia('Admin/Registration/Edit', [
            'register' => $formattedData,
        ]);
    }

    /**
     * Update data peserta.
     */
    public function update(Request $request, $id)
    {
        $register = Registration::findOrFail($id);

        // 1. Validasi (Unique ignore current ID)
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:registrations,email,' . $id,
            'contact' => 'required|unique:registrations,contact,' . $id,
            'kelompok' => 'required|in:Katekumen,Sakramen Baptis Bayi',
        ]);

        // 2. Mapping Data
        $isMale = $request->gender === 'Laki-laki' ? true : false;
        $isCatechumen = $request->kelompok === 'Katekumen' ? true : false;

        // 3. Update Database
        $register->update([
            'name' => $request->name,
            'gender' => $isMale,
            'email' => $request->email,
            'contact' => $request->contact,
            'group' => $isCatechumen,
        ]);

        return Redirect::route('admin.registration.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    /**
     * Hapus data peserta.
     */
    public function destroy($id)
    {
        $register = Registration::findOrFail($id);
        $register->delete();

        return Redirect::route('admin.registration.index')->with('success', 'Data peserta berhasil dihapus.');
    }

    /**
     * Menyetujui Pendaftaran (Approve)
     * Mengubah status menjadi 'accept'
     */
    public function approve($id)
    {
        $register = Registration::findOrFail($id);
        
        $register->update([
            'status' => 'accept'
        ]);

        // Opsional: Kirim Email Notifikasi di sini (Anda bisa uncomment jika mailer sudah siap)
        // Mail::to($register->email)->send(new SendEmailApprove($register));

        return Redirect::back()->with('success', 'Pendaftaran peserta telah disetujui.');
    }

    /**
     * Menolak Pendaftaran (Reject)
     * Mengubah status menjadi 'reject'
     */
    public function reject($id)
    {
        $register = Registration::findOrFail($id);
        
        $register->update([
            'status' => 'reject'
        ]);

        // Opsional: Kirim Email Notifikasi Reject
        // Mail::to($register->email)->send(new SendEmailReject($register));

        return Redirect::back()->with('success', 'Pendaftaran peserta ditolak.');
    }
}