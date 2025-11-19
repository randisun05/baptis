<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Member;
use App\Models\Certificate;
use App\Models\DetailEvent;
use Illuminate\Http\Request;
use App\Models\TemplateCertificate;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventParticipantsExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::
             when(request()->q, function($query) {
                 $query->where('title', 'like', '%' . request()->q . '%');
             })
             ->latest()
             ->paginate(10);

        $events->appends(['q' => request()->q]);

        return inertia('Admin/Events/Index', [
            'events' => $events,
         ]);

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return inertia('Admin/Events/Create', [

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
    $request->validate([
        'title' => 'required|string',
        'date' => 'required',
    ]);

    $slug = strtolower(str_replace(' ', '-', $request->title));

        Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'slug' => $slug,
        ]);

     //redirect
     return redirect()->route('admin.events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        $details = DetailEvent::where('event_id', $id)
        ->with('member', 'event')
        ->when(request()->q, function($query) {
            $query->whereHas('member', function($subQuery) {
            $subQuery->where('name', 'like', '%' . request()->q . '%');
            });
        })
        ->latest()
        ->paginate(10);

        $details->appends(['q' => request()->q]);

        return inertia('Admin/Events/Show', [
            'event' => $event,
            'details' => $details
        ]);
        //redirect
        return redirect()->route('admin.events.index');
    }

    public function absenAll($id)
    {
        $details = DetailEvent::where('event_id', $id)->get();

        foreach ($details as $detail) {
            $detail->update([
                'status' => 'hadir',
            ]);
        }

        return redirect()->route('admin.events.show', $id)->with('success', 'Data has been saved');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $event = Event::findOrFail($id);
        return inertia('Admin/Events/Edit', [
            'event' => $event,
        ]);

        //redirect
        return redirect()->route('admin.events.index');
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
      $request->validate([
        'title' => 'required|string',
        'date' => 'required',

    ]);

    $slug = strtolower(str_replace(' ', '-', $request->title));

        Event::where('id',$id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'slug' => $slug,
        ]);


     //redirect
     return redirect()->route('admin.events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        //redirect
        return redirect()->route('admin.events.index');
    }


    public function absen($id)
    {

        $status = Event::where('id', $id)->value('absen');

        if ($status == 'N') {
            Event::where('id',$id)->update([
                'absen' => "Y",
            ]);
        } else {
            Event::where('id',$id)->update([
                'absen' => "N",
            ]);
        }

     //redirect
     return redirect()->route('admin.events.index');
    }


}
