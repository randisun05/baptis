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
        $this->cekAuth();
        
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
        $this->cekAuth();
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
        $this->cekAuth(); 

        $request->validate([
            'title' => 'required|string|unique:events,title',
            'body' => 'required|string', 
            'date' => 'required|date',
            'place' => 'nullable|string',
            'ref_event_id' => 'nullable|exists:ref_events,id',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;

        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Event::create([
            'title' => $request->title,
            'body' => $request->body, 
            'date' => $request->date,
            'slug' => $slug,
            'place' => $request->place,
            'ref_event_id' => $request->ref_event_id,
            'status' => 'active', 
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->cekAuth();

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->cekAuth();
        $event = Event::findOrFail($id);
        $refevents = RefEvent::all();
        
        return inertia('Admin/Events/Edit', [
            'event' => $event,
            'refevents' => $refevents 
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
        $this->cekAuth();

        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|unique:events,title,' . $id,
            'body' => 'required|string',
            'date' => 'required|date',
            'place' => 'nullable|string',
            'ref_event_id' => 'nullable|exists:ref_events,id',
            'status' => 'required|in:active,closed',
        ]);

        $slug = Str::slug($request->title);
        
        if ($event->title !== $request->title) {
            $originalSlug = $slug;
            $counter = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $slug = $event->slug;
        }

        $event->update([
            'title' => $request->title,
            'body' => $request->body,
            'date' => $request->date,
            'slug' => $slug,
            'place' => $request->place,
            'ref_event_id' => $request->ref_event_id,
            'status' => $request->status,
        ]);

      return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cekAuth();
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }


    // ===============================================
    //           FUNGSI STATUS & CEK AUTH
    // ===============================================

    public function activate($id)
    {
        $this->cekAuth();
        $post = Event::findOrFail($id);
        $post->update(['status' => 'active']);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diaktifkan!');
    }

    public function close($id)
    {
        $this->cekAuth();
        $post = Event::findOrFail($id);
        $post->update(['status' => 'closed']);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditutup!');
    }


    public function cekAuth()
    {
        if(!auth()->check()) {
            auth()->logout();
            return redirect()->route('login')->with('warning', 'Anda tidak memiliki akses');
        }
    }

    // ===============================================
    //               FUNGSI REF EVENT
    // ===============================================

    public function Indexref()
    {
        $this->cekAuth();
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
            $this->cekAuth();
            $request->validate(['title' => 'required|string']);
            RefEvent::create(['title' => $request->title]);
            return redirect()->route('admin.events.Indexref')->with('success', 'Referensi Event berhasil ditambahkan!');
        }

      public function Updateref(Request $request , $id)
        {
            $this->cekAuth();
            $request->validate(['title' => 'required|string']);
            RefEvent::where('id',$id)->update(['title' => $request->title]);
            return redirect()->route('admin.events.Indexref')->with('success', 'Referensi Event berhasil diperbarui!');
        }

      public function Deleteref($id)
        {
            $this->cekAuth();
            $refevent = RefEvent::findOrFail($id);
            $refevent->delete();
            return redirect()->route('admin.events.Indexref')->with('success', 'Referensi Event berhasil dihapus!');
        }

        // ===============================================
        //               FUNGSI ENROLL DENGAN CHECK STATUS
        // ===============================================

        public function enroll($id)
        {
            $this->cekAuth();
            $event = Event::findOrFail($id);

            // Cek Status: Jika closed, tidak boleh enroll
            if ($event->status === 'closed') {
                return redirect()->route('admin.events.show', $id)
                                ->with('error', 'Event sudah ditutup dan tidak dapat menerima peserta baru.');
            }
            
            $member_enroled = DetailEvent::where('event_id', $id)->pluck('member_id')->toArray();
            $members = Member::whereNotIn('id', $member_enroled)->get();

            return inertia('Admin/Events/Enroll', [
                'members' => $members,
                'event' => $event,
            ]);
        }

        public function storeenroll(Request $request, $id)
        {
            $this->cekAuth();
            $event = Event::findOrFail($id);
            
            // Cek Status: Jika closed, tidak boleh store enroll
            if ($event->status === 'closed') {
                return redirect()->route('admin.events.show', $id)
                                ->with('error', 'Event sudah ditutup dan tidak dapat menerima peserta baru.');
            }

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

            return redirect()->route('admin.events.show', $id)->with('success', 'Peserta berhasil didaftarkan!');
        }

        // ===============================================
    //           FUNGSI UNENROLL / HAPUS PESERTA
    // ===============================================

    public function unenroll($id)
    {
        $this->cekAuth();
        $event = Event::findOrFail($id);

        // Cek Status: Jika closed, tidak boleh mengubah data
        if ($event->status === 'closed') {
            return redirect()->route('admin.events.show', $id)
                            ->with('error', 'Event sudah ditutup, tidak dapat mengubah data peserta.');
        }
        
        // LOGIKA TERBALIK DARI ENROLL:
        // Ambil ID member yang SUDAH terdaftar di event ini
        $member_enroled_ids = DetailEvent::where('event_id', $id)->pluck('member_id')->toArray();
        
        // Ambil data member berdasarkan ID tersebut
        $members = Member::whereIn('id', $member_enroled_ids)->get();

        return inertia('Admin/Events/Unenroll', [
            'members' => $members,
            'event' => $event,
        ]);
    }

    public function storeunenroll(Request $request, $id)
    {
        $this->cekAuth();
        $event = Event::findOrFail($id);
        
        if ($event->status === 'closed') {
            return redirect()->route('admin.events.show', $id)
                            ->with('error', 'Event sudah ditutup.');
        }

        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
        ]);

        // Hapus data dari DetailEvent di mana event_id sesuai DAN member_id ada dalam list yang dipilih
        DetailEvent::where('event_id', $id)
                    ->whereIn('member_id', $request->member_ids)
                    ->delete();

        return redirect()->route('admin.events.show', $id)->with('success', 'Peserta berhasil dihapus dari event!');
    }
}