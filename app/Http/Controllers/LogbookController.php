<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\LogbookImage;
use App\Models\Intern;
use Auth;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LogbookController extends Controller
{
    public function index()
    {
        $user = Auth::user()->mahasiswa->intern->id;
        $data = Logbook::where('intern_id', $user)->get();
        return view('mahasiswa.logbook',compact('data'));
    }

    public function store(Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'date' => ucwords('tanggal'),
            'title' => ucwords('kegiatan'),
        ];

        $request->validate([
            'date' => 'required',
            'title' => 'required',
        ], $messages, $attributes);

        $intern = Auth::user()->mahasiswa->intern;

        // Mengambil Tanggal Periode Pelaksanaan Magang Mahasiswa
        $datePicker = Intern::where('id', $intern->id)
        ->with('period')
        ->first();

        $dateStart = $datePicker->period->start;
        $dateEnd = $datePicker->period->end;

        if ($request->date < $dateStart || $request->date > $dateEnd) {
            # code...
            // return $datePicker;
            return redirect()->back()->with('error', 'Melewati Tanggal Periode Magang');
        }else {
            // Setelah Di Cek berdasarkan batas tanggal magang. Cek Validasi Absen
            $cekAbsen = $intern->attendance->where('date', $request->date)->first();
            if ($cekAbsen) {
                // Cek Apakah Absen Sudah Di Validasi Oleh Mitra Magang Atau Mentor
                if ($cekAbsen->isvalid) {
                    // Cek Apakah Mahasiswa Hadir Pada Hari Yang dibuat
                    if (!$cekAbsen->status == 'h') {
                        return redirect()->back()->with('error', 'Anda Tidak Masuk Pada Tanggal Ini !');
                    }else {
                        try {
                            //code...
                            $logbook = Logbook::updateOrCreate(
                                [
                                    'id' => $request->id,
                                ],
                                [
                                    'intern_id' => $intern->id,
                                    'date' => $request->date,
                                    'title' =>  $request->title,
                                    'desc' => $request->desc,
                                ]
                            );

                            if ($logbook->wasRecentlyCreated) {
                                return redirect()->back()->with('success', 'Berhasil Menambah Data');
                            } else {
                                return redirect()->back()->with('success', 'Berhasil Mengubah Data');
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                            return redirect()->back()->with('error', $th->getMessage());
                        }
                    }
                }else {
                    return redirect()->back()->with('error', 'Absensi Anda Belum Di Verifikasi Oleh Mentor / Mitra Magang');
                }
            } else {
                return redirect()->back()->with('error', 'Anda Belum Melakukan Absensi');
            }
        }
    }

    public function delete($logbook)
    {
        $log = Logbook::where('id',$logbook)->first();
        if ($log->image->isEmpty()) {
            # code...
            $log->forceDelete();
        }else{
            $images = LogbookImage::where('logbook_id', $log->id)->get();
            foreach ($images as $image) {
                if (file_exists($image->path)) {
                    unlink($image->path);
                }
            }
            $log->forceDelete();
        }
        return redirect()->back()->with('success','Berhasil Menghapus Data');

    }

    public function index_image($logbook)
    {
        $log = Logbook::where('id',$logbook)->first();
        $gambar = LogbookImage::where('logbook_id', $logbook)->get();
        return view('mahasiswa.logbookimage',compact('gambar','log'));
    }

    public function store_image($logbook, Request $request)
    {
        $log = Logbook::where('id', $logbook)->first();
        // Path untuk lokasi gambar
        $path = 'logbook/'. md5(date('dmyhis')) . '.jpg';
        // proses upload gambar
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($request->file('gambar'));
        $encoded = $image->toJpeg(50)->save($path);

        // simpan file path gambar berdasarkan logbook
        LogbookImage::create([
            'logbook_id' => $log->id,
            'path' => $path,
        ]);
        return redirect()->back()->with('success','Berhasil Menambah Gambar');
    }

    public function update_image($logbook, Request $request)
    {
        $logImg = LogbookImage::where('id', $request->id)->first();
        if ($request->file('gambar')) {
            # code...
            if (file_exists($logImg->path)) {
                # code...
                unlink($logImg->path);
            }

            $path = 'logbook/'. md5(date('dmyhis')) . '.jpg';
            // proses upload gambar
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->file('gambar'));
            $encoded = $image->toJpeg(50)->save($path);

            $logImg->path = $path;
            $logImg->save();
        }

        return redirect()->back()->with('success','Berhasil Mengubah Gambar');
    }

    public function delete_image($logbook, $image)
    {
        $gambar = LogbookImage::where('id', $image)->where('logbook_id', $logbook)->first();
        if (file_exists($gambar->path)) {
            # code...
            unlink($gambar->path);
        }
        $gambar->forceDelete();
        return redirect()->back()->with('success','Berhasil Menghapus Gambar');

    }

    // POV Mentor dan Agency
    public function index_mahasiswa($intern)
    {
        $user = Intern::where('id', $intern)->first();
        $data = Logbook::where('intern_id',$intern)->get();
        return view('mahasiswa.logbook',compact('data','user'));
    }

    public function index_image_mahasiswa($intern, $logbook)
    {
        $user = Intern::where('id', $intern)->first();
        $log = Logbook::where('id',$logbook)->first();
        $gambar = LogbookImage::where('logbook_id', $logbook)->get();
        return view('agency.mentor.galleries',compact('gambar','log','user'));
    }
}
