<?php

namespace App\Http\Controllers\Admin;

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


        return inertia('Admin/Dashboard/Index', [

        ]);
    }
}
