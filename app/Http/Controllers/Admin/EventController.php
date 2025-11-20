<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Member;
use App\Models\RefEvent;
use App\Models\Certificate;
use App\Models\DetailEvent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TemplateCertificate;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventParticipantsExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $refevents = RefEvent::all();
        return inertia('Admin/Events/Create', [
            'refevents' => $refevents
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
        'place' => 'nullable|string',
        'ref_event_id' => 'nullable|exists:ref_events,id',
    ]);

    $slug = strtolower(str_replace(' ', '-', $request->title));

        Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'slug' => $slug,
            'place' => $request->place,
            'desc' => $request->desc,
            'ref_event_id' => $request->ref_event_id,

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
        'place' => 'nullable|string',
        'ref_event_id' => 'nullable|exists:ref_events,id',

    ]);

    $slug = strtolower(str_replace(' ', '-', $request->title));

        Event::where('id',$id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'slug' => $slug,
            'place' => $request->place,
            'desc' => $request->desc,
            'ref_event_id' => $request->ref_event_id,
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

    public function Indexref()
    {
        $refevents = RefEvent::
             when(request()->q, function($query) {
                 $query->where('title', 'like', '%' . request()->q . '%');
             })
             ->latest()
             ->paginate(10);

        $refevents->appends(['q' => request()->q]);

        return inertia('Admin/Events/Ref', [
            'refevents' => $refevents,
         ]);
    }

     public function Storeref(Request $request)
        {

            // Validate request including file validation
        $request->validate([
            'title' => 'required|string',
        ]);
            RefEvent::create([
                'title' => $request->title,
            ]);
            //redirect
            return redirect()->route('admin.events.Indexref');
        }

     public function Updateref(Request $request , $id)
        {
            // Validate request including file validation
        $request->validate([
            'title' => 'required|string',
        ]);
            RefEvent::where('id',$id)->update([
                'title' => $request->title,
            ]);
            //redirect
            return redirect()->route('admin.events.Indexref');
        }

     public function Deleteref($id)
        {
            $refevent = RefEvent::findOrFail($id);
            $refevent->delete();
            //redirect
            return redirect()->route('admin.events.Indexref');
        }

         public function enroll($id)
        {
          $member_enroled = DetailEvent::where('event_id', $id)->pluck('member_id')->toArray();
          $members = Member::whereNotIn('id', $member_enroled)->get();

          $event = Event::findOrFail($id);
          return inertia('Admin/Events/Enroll', [
            'members' => $members,
            'event' => $event,
          ]);
        }

        public function storeenroll(Request $request, $id)
        {
          $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
          ]);

          foreach ($request->member_ids as $member_id) {
            DetailEvent::create([
              'event_id' => $id,
              'member_id' => $member_id,
            ]);
          }

          return redirect()->route('admin.events.show', $id);
        }





}
