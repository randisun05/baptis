<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member; // Import model Member untuk statistik
use App\Models\Post;
use App\Models\Event;
use App\Models\Merchan;
use App\Models\PublicPost;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProfileDataPosition;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // 1. Hitung Statistik Dasar
        $total = Member::count();
        
        // Asumsi: 'group' adalah boolean di Model Member (true=Katekumen, false=Baptis Bayi)
        $katekumen = Member::where('group', true)->count();
        $baptis_bayi = Member::where('group', false)->count();
        $verified = Member::where('status', 'confirmed')->count();
        
        
        // Order by created_at desc (terbaru)
        $recent_members = Member::orderBy('created_at', 'desc')->get();

        // 3. Gabungkan data statistik ke dalam array 'stats'
        $stats = [
            'total_participants' => $total,
            'katekumen_count' => $katekumen,
            'baptis_bayi_count' => $baptis_bayi,
            'verified_count' => $verified,
            'recent_members' => $recent_members,
        ];

        return inertia('Admin/Dashboard/Index', [
            'stats' => $stats, // Kirim data statistik ke Vue
        ]);
    }
}