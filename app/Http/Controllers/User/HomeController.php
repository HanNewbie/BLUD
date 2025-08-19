<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use App\Models\News;
use App\Models\Event;
use App\Models\ContentFeature;
use App\Models\Submission;
use Carbon\Carbon; 


class HomeController extends Controller
{
    public function index()
    {
        $news = News::all();
        $contents = Content::all();
        return view('welcome', compact('contents','news'));
    }

    public function event()
    {
        $contents = Content::all();
        return view('user.event', compact('contents'));
    }

    public function booking($slug)
    {
        // Ambil lokasi berdasarkan slug
        $content = Content::where('slug', $slug)->first();

        if (!$content) {
            abort(404, 'Lokasi tidak ditemukan.');
        }

        // Ambil semua event untuk lokasi tersebut
        $events = Event::select('name_event', 'start_date', 'end_date', 'location')
            ->where('location', $content->name)
            ->get()
            ->map(function ($item) {
                $item->type = 'event';
                return $item;
            });

        // Ambil submission yang disetujui dan lokasi cocok
        $submissions = Submission::select('name_event', 'start_date', 'end_date', 'location')
            ->where('status', 'approved')
            ->where('location', $content->name)
            ->get()
            ->map(function ($item) {
                $item->type = 'submission';
                return $item;
            });

        // Gabungkan dan urutkan berdasarkan tanggal mulai
        $combined = $events->concat($submissions)->sortBy('start_date');

        // Group berdasarkan bulan
        $grouped = $combined->groupBy(function ($item) {
            return Carbon::parse($item->start_date)->translatedFormat('F');
        });

        return view('user.booking', [
            'events' => $grouped,
            'slug' => $slug,
        ]);
    }

    public function bookingDetail($slug, $bulan)
    {
        $monthNumber = \Carbon\Carbon::parse("1 $bulan")->month;

        $content = Content::where('slug', $slug)->firstOrFail();

        $events = Event::with('content')
            ->where('location', $content->name)
            ->whereMonth('start_date', $monthNumber)
            ->orderBy('start_date')
            ->get();

        $submissions = Submission::where('status', 'approved')
            ->where('location', $content->name)
            ->whereMonth('start_date', $monthNumber)
            ->orderBy('start_date')
            ->get();

        $merged = collect($events)->merge($submissions)->sortBy('start_date')->values();

        return view('user.booking_detail', [
            'events' => $merged,
            'slug' => $slug,
            'bulan' => $bulan,
        ]);
    }

    public function content(){

        $contents = Content::all();
        return view('user.wisata', compact('contents'));
    }

    public function contentDetail($slug){

        $contents = Content::where('slug', $slug)->firstOrFail();
        return view('user.wisata_detail', compact('contents','slug'));
    }

    public function history(){

        $submissions = Submission::where('user_id', auth()->id())->orderBy('apply_date', 'desc')->orderBy('id', 'desc')->get();
        return view('user.history', compact('submissions'));
    }

    public function profile(){
        $user = Auth::user();

        return view('user.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
        ]);

        // Update data
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function facility($location)
    {
        // Cari lokasi berdasarkan nama
        $content = Content::where('location', $location)->firstOrFail();

        // Ambil fasilitas berdasarkan ID content
        $facilities = ContentFeature::where('location', $content->id)->get();
        // dd($facilities);
        return view('user.facility', compact('facilities', 'location','content'));
    }

    public function createSubmission()
    {
        $contents = Content::all();
        return view('user.form', compact('contents'));
    }
    
    public function storeSubmission(Request $request)
    {
        try {
         $data = $request->validate([
        'namePIC'=>'required|string|max:100',
        'no_hp'=>'required|string|max:12',
        'address'=>'required|string|max:255',
        'vendor' => 'required|string|max:100',
        'location'  => 'required|exists:content,name',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'name_event' => 'required|string|max:255',
        'file' => 'file|mimes:pdf|max:5048',
        'ktp' => 'required|file|mimes:pdf|max:5048',
        'appl_letter' => 'file|mimes:pdf|max:5048',
        'actv_letter' => 'file|mimes:pdf|max:5048',
        ]);

        $data['user_id'] = auth()->id();
        $content = Content::where('name', $data['location'])->firstOrFail();

        $data['status'] = 'pending';
        $data['apply_date'] = Carbon::now()->format('Y-m-d H:i');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('assets/rundowns', 'public');
            $data['file'] = $filePath;
        }
        if ($request->hasFile('ktp')) {
            $ktpFile = $request->file('ktp');
            $ktpPath = $ktpFile->store('assets/ktp', 'public');
            $data['ktp'] = $ktpPath;
        }
        if ($request->hasFile('appl_letter')) {
            $applLetterFile = $request->file('appl_letter');
            $applLetterPath = $applLetterFile->store('assets/appl_letters', 'public');
            $data['appl_letter'] = $applLetterPath;
        }
        if ($request->hasFile('actv_letter')) {
            $actvLetterFile = $request->file('actv_letter');
            $actvLetterPath = $actvLetterFile->store('assets/actv_letters', 'public');
            $data['actv_letter'] = $actvLetterPath;
        }

        $data['notes'] = $request->input('notes', null);

        Submission::create($data);

        return redirect()->route('user.history')->with('success', 'Pengajuan berhasil harap tunggu informasi lebih lanjut.');
        } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat mengubah konten: ' . $e->getMessage());
        }
    }
}
