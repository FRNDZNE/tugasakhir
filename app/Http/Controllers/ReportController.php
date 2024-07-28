<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
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

        $report = $request->file('path');
        $fileName = rand() . '.' . $report->getClientOriginalExtension();

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

    public function delete($id)
    {

    }
}
