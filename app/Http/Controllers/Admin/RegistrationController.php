<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\instansi;
use Illuminate\Support\Str;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\SendEmailReject;
use GuzzleHttp\Handler\Proxy;
use App\Mail\SendEmailAprrove;
use App\Mail\SendEmailConfirm;
use App\Models\ProfileDataMain;
use Illuminate\Validation\Rule;
use App\Exports\RegistrationPaid;
use App\Models\RegistrationGroup;
use Illuminate\Support\Facades\DB;
use App\Exports\RegistrationExport;
use App\Imports\RegistrationImport;
use App\Mail\SendEmailRegistration;
use App\Models\ProfileDataPosition;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Colors\Rgb\Channels\Red;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registers = Registration::when(request()->q, function($registers) {
            $registers = $registers->where('name', 'like', '%'. request()->q . '%');
        }) ->orderBy('created_at', 'asc')->paginate(10);
        //render with inertia
        return inertia('Admin/Registration/Index', [
            'registers' => $registers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return inertia('Admin/Registration/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

  // Validate request including file validation
      $validatedData = $request->validate([
         'nik' => 'required|string|unique:registrations,nik',
        'name' => 'required|string',
        'email' => 'required|email|unique:registrations,email',
        'contact' => 'required|string|unique:registrations,contact',
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status' => 'nullable|string',
        'info' => 'nullable|string',
        'emailstatus' => 'nullable|string',
        'by' => 'nullable|string',

    ],
    [

    ]);

     // Store the file using Laravel's file storage system
     $document = $request->file('document');
     $document = $document->storePublicly('/document');

    if ($document) {
         $registration = Registration::create(array_merge($validatedData, [ 'status' => '1',
         'document' => $document
         ]));
     } else { // Create registration
        $registration = Registration::create(array_merge($validatedData, ['document' => '']));
    }

     //redirect
     return redirect()->route('admin.registration.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user()->name;

        $register = Registration::findOrFail($id);

        // Lanjutkan ke halaman jika telah melalui verifikasi
        return inertia('Admin/Registration/Show', [
            'register' => $register,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $register = Registration::findOrFail($id);
        //render with inertia
       return inertia('Admin/Registration/Edit', [
        'register' => $register,
        ]);
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
        // Validate request including file validation
       $validatedData = $request->validate([
        'nik' => 'required|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'contact' => 'required|string',
        'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status' => 'nullable|string',
        'info' => 'nullable|string',
        'emailstatus' => 'nullable|string',
        'by' => 'nullable|string',
    ], [
        'nik.required' => 'NIK harus diisi.',
    ]);
            // Store the file using Laravel's file storage system
            $document = $request->file('document');

            if ($document) {
                // Jika keduanya diisi, update semua
                $document = $document->storePublicly('/document');
                Registration::where('id',$id)->update(array_merge($validatedData, [
                    'document' => $document,
                    'status' => "updated"
                ]));
            }

            // Buat registration
            Registration::where('id',$id)->update(array_merge($validatedData, [
            ]));

       //redirect
       return redirect()->route('admin.registration.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get
        $register = Registration::findOrFail($id);

        //delete
        $register->delete();

        //redirect
        return redirect()->route('admin.registration.index');
    }

    public function paid($id)
    {
        //get
        Registration::where('id', $id)->update([
            'status' => "paid"
        ]);

        //redirect
        return redirect()->route('admin.registration.index');
    }

    public function hadlecode()
    {


    }

    public function approve($id, Request $request)
    {
        $register = Registration::findOrFail($id);

         $password = Hash::make($register->nik);

         $code = Str::random(10);


        Member::create([
            'nip'            => $register->nip,
            'name'           => $register->name,
            'email'          => $register->email,
            'nomember'         => $code,
            'password'       => $password,
        ]);

        $today = Carbon::now()->format('Y-m-d H:i:s');
          //create data profile


        $email = Member::where('nik',$register->nik)->first();

        //email
        Mail::to($register['email'])->send(new SendEmailAprrove($email));

        Registration::where('id', $id)->update([
            'status'        => "approved",
        ]);

        Registration::where('id', $id)->increment('emailstatus');

        //redirect
        return redirect()->route('admin.registration.index');
    }



    public function reject($id)
    {

        $register = Registration::findOrFail($id);

        Mail::to($register['email'])->send(new SendEmailReject($register));

        Registration::where('id', $id)->update([
            'status' => "rejected",
        ]);
        Registration::where('id', $id)->increment('emailstatus');

        //redirect
        return redirect()->route('admin.registration.index');
    }

    public function sendEmail($id)
    {
        $register = Registration::findOrFail($id);

        Mail::to($register['email'])->send(new SendEmailRegistration($register));

        Registration::where('id', $id)->increment('emailstatus');
        //redirect
        return redirect()->route('admin.registration.index');
    }

    public function confirm($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $register = Registration::findOrFail($id);

        Mail::to($request['email'])->send(new SendEmailConfirm($register));

        Registration::where('id', $id)->update([
            'status' => "confirm",
            'info' => $request->info,
            // 'emailstatus'      => 1,
        ]);
        Registration::where('id', $id)->increment('emailstatus');

        //redirect
        return redirect()->route('admin.registration.index');
    }


}
