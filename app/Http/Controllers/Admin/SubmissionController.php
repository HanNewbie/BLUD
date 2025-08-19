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

    public function edit($id)
    {
        $submission = Submission::findOrFail($id);
        $contents = Content::all();
        return view('admin.event.submission', compact('submission', 'contents'));
    }

    public function update(Request $request, $id)
    {
        try {
            $submission = Submission::findOrFail($id);

            $data = $request->validate([
                'namePIC'    => 'required|string|max:100',
                'no_hp'      => 'required|string|max:12',
                'address'    => 'required|string|max:255',
                'vendor'     => 'required|string|max:100',
                'location'   => 'required|exists:content,name',
                'start_date' => 'required|date',
                'end_date'   => 'required|date',
                'name_event' => 'required|string|max:255',
                'file'       => 'nullable|file|mimes:pdf|max:5048',
                'ktp'        => 'nullable|file|mimes:pdf|max:5048',
                'appl_letter'=> 'nullable|file|mimes:pdf|max:5048',
                'actv_letter'=> 'nullable|file|mimes:pdf|max:5048',
            ]);

            $content = Content::where('name', $data['location'])->firstOrFail();

            // update status tidak diubah, tetap sesuai yg ada
            $data['notes'] = $request->input('notes', $submission->notes);

            // update file jika ada upload baru
            if ($request->hasFile('file')) {
                if ($submission->file && \Storage::disk('public')->exists($submission->file)) {
                    \Storage::disk('public')->delete($submission->file);
                }
                $filePath = $request->file('file')->store('assets/rundowns', 'public');
                $data['file'] = $filePath;
            }

            if ($request->hasFile('ktp')) {
                if ($submission->ktp && \Storage::disk('public')->exists($submission->ktp)) {
                    \Storage::disk('public')->delete($submission->ktp);
                }
                $ktpPath = $request->file('ktp')->store('assets/ktp', 'public');
                $data['ktp'] = $ktpPath;
            }

            if ($request->hasFile('appl_letter')) {
                if ($submission->appl_letter && \Storage::disk('public')->exists($submission->appl_letter)) {
                    \Storage::disk('public')->delete($submission->appl_letter);
                }
                $applLetterPath = $request->file('appl_letter')->store('assets/appl_letters', 'public');
                $data['appl_letter'] = $applLetterPath;
            }

            if ($request->hasFile('actv_letter')) {
                if ($submission->actv_letter && \Storage::disk('public')->exists($submission->actv_letter)) {
                    \Storage::disk('public')->delete($submission->actv_letter);
                }
                $actvLetterPath = $request->file('actv_letter')->store('assets/actv_letters', 'public');
                $data['actv_letter'] = $actvLetterPath;
            }

            $submission->update($data);

            return redirect()->route('event.index')->with('success', 'Pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengajuan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $submission = Submission::findOrFail($id);

            $files = ['file', 'ktp', 'appl_letter', 'actv_letter'];
            foreach ($files as $fileField) {
                if ($submission->$fileField && \Storage::disk('public')->exists($submission->$fileField)) {
                    \Storage::disk('public')->delete($submission->$fileField);
                }
            }

            $submission->delete();

            return redirect()->route('user.history')
                ->with('success', 'Pengajuan beserta semua file berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengajuan: ' . $e->getMessage());
        }
    }

}
