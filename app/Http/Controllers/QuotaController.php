<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Period;
use App\Models\Quota;
class QuotaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,admin,agency');
    }
    public function index($agent)
    {
        try {
            $data['agent'] = Agency::where('id',$agent)->first();
            $data['period'] = Period::with(['quota' => function($query) use ($agent){
                $query->where('agency_id', $agent)->with('agency');
            }])->get();
            // return $data['agent'];
            return view('master.quota',compact('data'));
        } catch (Throwable $e) {

            return $e;
        }
    }

    public function store($agent, Request $request)
    {
        // Membuat Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
        ];

        $attributes = [
            'total' => ucfirst('kuota'),
        ];

        $request->validate([
            'total' => 'required',
        ], $messages, $attributes);
        Quota::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'period_id' => $request->period,
                'agency_id' => $agent,
                'total' => $request->total,
            ]
        );

        return redirect()->back()->with('success','Berhasil Menambah Data');
    }
}
