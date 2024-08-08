<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Intern;
use Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user()->mahasiswa->intern->id;
        $data = Submission::whereHas('intern', function($q) use ($user){
            $q->where('id',$user);
        })
        ->with('intern')
        ->first();
        return view('mahasiswa.report',compact('data'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'path' => ucwords('File'),
        ];

        $request->validate([
            'path' => 'required',
        ], $messages, $attributes);

        // membuat file name berdasarkan nim mahasiswa dan nama
        $nim = Auth::user()->mahasiswa->uuid;
        $name = Auth::user()->mahasiswa->name;
        $report = $request->file('path');
        $fileName = $nim.'_'. str_replace(' ','_',$name) . '.' . $report->getClientOriginalExtension();

        // Cek apakah ada ID submission yang diterima dari request
        if ($request->has('id')) {
            // Cari submission yang sesuai dengan ID tersebut
            $existingSubmission = Submission::find($request->id);

            // Jika submission ditemukan, cek apakah ada file lama yang perlu dihapus
            if ($existingSubmission && $existingSubmission->path) {
                $oldFilePath = public_path('reports') . '/' . $existingSubmission->path;

                // Hapus file lama jika ada
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }

        $report->move(public_path('reports'), $fileName);
        $Submission = Submission::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'intern_id' => Auth::user()->mahasiswa->intern->id,
                'path' => $fileName,
            ]
        );
        return redirect()->back()->with('success','Berhasil Menyimpan Laporan');
    }

    // view for agency and mentor
    public function report($intern)
    {
        $magang = Intern::where('id', $intern)->first();
            if ($magang->submission) {
                // Path to the PDF file in the public folder
                $filePath = public_path('reports/'. $magang->submission->path);

                // Check if the file exists
                if (file_exists($filePath)) {
                    return response()->file($filePath);
                } else {
                    return redirect()->back()->with('error', 'File not found.');
                }
            } else {
                return redirect()->back()->with('error', 'Laporan Belum Ada');
            }
    }

}
