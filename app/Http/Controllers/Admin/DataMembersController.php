<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\instansi;
use Illuminate\Http\Request;
use App\Exports\MemberExport;
use App\Exports\MembersExport;
use App\Models\ProfileDataMain;
use Illuminate\Support\Facades\DB;
use App\Models\ProfileDataPosition;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Pastikan semua Model terkait diimpor untuk Eager Loading
use App\Models\DataBaptis;
use App\Models\DataKatekumen;
use App\Models\DataKeluarga;
use App\Models\DataMenikah;
use App\Models\DataRiwayat;


class DataMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // Mengambil data dengan pencarian nama/email dan pagination
       $datas = Member::query()
            ->when(request()->q, function($query) {
                $query->where('name', 'like', '%'. request()->q . '%')
                      ->orWhere('email', 'like', '%'. request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            $datas->appends(['q' => request()->q]);
        
            return inertia('Admin/Members/Index', [
                'datas' => $datas,
             ]);
        

    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        // 1. Ambil data Member berdasarkan ID
        $data = Member::findOrFail($id); 
        // Menggunakan Lazy Eager Loading (load()) pada data yang sudah diambil
        // Relasi didefinisikan menggunakan kunci 'number' di Member Model.
        $data->load([
            'dataKatekumen', // Data Katekumen (alamat, pendidikan, penjamin)
            'dataRiwayat',   // Data Riwayat Agama/Kegiatan
            'dataMenikah',   // Data Pernikahan
            'dataBaptis',    // Data Baptis Bayi
            'dataKeluarga',  // Data Keluarga (list array)
        ]);
        return inertia('Admin/Members/Show', [
           'data' => $data
        ]);


    }

      public function export()
    {
       // Nama file yang akan diunduh
        $fileName = 'data_peserta_' . now()->format('Ymd_His') . '.xlsx';

        // Panggil facade Excel untuk mendownload.
        // Parameter 1: Instance dari Export Class
        // Parameter 2: Nama file
        // Parameter 3 (opsional): Jenis File (Excel::XLSX adalah default)
        return Excel::download(new MembersExport, $fileName);
    }

 
}