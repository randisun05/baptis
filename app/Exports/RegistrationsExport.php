<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua data dari model Registration
        // Anda bisa menambahkan klausa where() atau orderBy() di sini jika diperlukan
        return Registration::all();
    }

    /**
     * Tentukan baris heading (judul kolom) untuk Excel
     * * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Peserta',
            'Email',
            'No. Telepon',
            'Group (1: Katekumen, 0: Baptis Bayi)',
            'Status',
            'Tanggal Registrasi',
        ];
    }

    /**
     * Map data yang diambil dari collection ke format baris Excel
     * (Untuk menampilkan data yang lebih rapi/spesifik)
     * * @param mixed $registration
     * @return array
     */
    public function map($registration): array
    {
        // Contoh pemetaan sederhana. Anda dapat menambahkan logika format di sini.
        return [
            $registration->id,
            $registration->name,
            $registration->email,
            $registration->contact,
            $registration->group,
            $registration->status,
            $registration->created_at->format('Y-m-d H:i:s'), // Format tanggal
        ];
    }
}