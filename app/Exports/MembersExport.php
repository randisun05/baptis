<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
    {
        // Ambil semua data dari model Registration
        // Anda bisa menambahkan klausa where() atau orderBy() di sini jika diperlukan
        return Member::all();
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
        ];
    }

    /**
     * Map data yang diambil dari collection ke format baris Excel
     * (Untuk menampilkan data yang lebih rapi/spesifik)
     * * @param mixed $registration
     * @return array
     */
    public function map($member): array
    {
        // Contoh pemetaan sederhana. Anda dapat menambahkan logika format di sini.
        return [
            $member->id,
            $member->name,
            $member->email,
            $member->contact,
            $member->group,
            $member->status,
          
        ];
    }
}
