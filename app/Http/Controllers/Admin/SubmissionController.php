<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Content;
use Carbon\Carbon; 

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::query();

        $query->where('status', 'pending');

        if ($request->filled('search')) {
            $query->where('vendor', 'like', '%' . $request->search . '%');
        }
        $submissions = $query->orderBy('id', 'desc')->get();
        return view('admin.submission.index', compact('submissions'));
    }

    public function approved(Request $request)
    {
        $query = Submission::query()->where('status', 'approved');

        if ($request->filled('search')) {
            $query->where('vendor', 'like', '%' . $request->search . '%');
        }

        $submissions = $query->orderBy('id', 'desc')->get();

        return view('admin.submission.approved', compact('submissions'));
    }

    public function rejected(Request $request)
    {
        $query = Submission::query()->where('status', 'rejected');

        if ($request->filled('search')) {
            $query->where('vendor', 'like', '%' . $request->search . '%');
        }

        $submissions = $query->orderBy('id', 'desc')->get();

        return view('admin.submission.rejected', compact('submissions'));
    }

    public function approve($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->update(['status' => 'approved']);
        $submission->save();

        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission = Submission::findOrFail($id);
        $submission->status = 'rejected';
        $submission->notes = $request->notes; 
        $submission->save();

        return back()->with('success', 'Pengajuan ditolak.');
    }


}
