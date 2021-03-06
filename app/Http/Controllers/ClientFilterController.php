<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Divisi;

class ClientFilterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:client');
    }

    // TIKET SEARCH 
    public function judul_tiket(Request $request)
    {
        $search = $request->search;
        $user_id = Auth::guard('client')->user()->id;

        $tikets = DB::table('tikets')
            ->join('divisis', 'tikets.divisi_id', '=', 'divisis.id')
            ->where('judul', 'like', "%" . $search . "%")
            ->select(
                'divisis.divisi',
                'tikets.judul',
                'tikets.status',
                'tikets.updated_at',
                'tikets.id',
                'tikets.created_at',
                'tikets.balasan_terbaru'
            )
            ->where('tikets.client_id', '=', $user_id)
            ->paginate(8);

        $tikets->appends(array('search' => $request->search));

        $divisis = Divisi::all();
        return view('client.tiket')
            ->with('divisis', $divisis)
            ->with('tikets', $tikets);
    }

    public function divisi_tiket($divisi)
    {
        $user_id = Auth::guard('client')->user()->id;

        $tikets = DB::table('tikets')
            ->join('divisis', 'tikets.divisi_id', '=', 'divisis.id')
            ->where('divisi', 'like', "%" . $divisi . "%")
            ->select(
                'divisis.divisi',
                'tikets.judul',
                'tikets.status',
                'tikets.updated_at',
                'tikets.id',
                'tikets.created_at',
                'tikets.balasan_terbaru'
            )
            ->where('tikets.client_id', '=', $user_id)
            ->paginate(8);

        $divisis = Divisi::all();
        return view('client.tiket')
            ->with('divisis', $divisis)
            ->with('tikets', $tikets);
    }

    public function status_tiket($status)
    {
        $user_id = Auth::guard('client')->user()->id;

        $tikets = DB::table('tikets')
            ->join('divisis', 'tikets.divisi_id', '=', 'divisis.id')
            ->where('status', 'like', "%" . $status . "%")
            ->select(
                'divisis.divisi',
                'tikets.judul',
                'tikets.status',
                'tikets.updated_at',
                'tikets.id',
                'tikets.created_at',
                'tikets.balasan_terbaru',
            )
            ->where('tikets.client_id', '=', $user_id)
            ->paginate(8);

        $divisis = Divisi::all();
        return view('client.tiket')
            ->with('divisis', $divisis)
            ->with('tikets', $tikets);
    }

    public function update_tiket(Request $request)
    {
        $user_id = Auth::guard('client')->user()->id;
        $dari =  date($request->input('dari'));
        $sampai =  date($request->input('sampai'));

        $tikets = DB::table('tikets')
            ->join('divisis', 'tikets.divisi_id', '=', 'divisis.id')
            ->whereBetween('tikets.balasan_terbaru', [$dari, $sampai])
            ->select(
                'divisis.divisi',
                'tikets.judul',
                'tikets.status',
                'tikets.id',
                'tikets.balasan_terbaru',
                'tikets.created_at',
            )
            ->where('tikets.client_id', '=', $user_id)
            ->paginate(8);

        $tikets->appends(array('dari' => date($request->input('dari')), 'sampai' => date($request->input('sampai'))));

        $divisis = Divisi::all();
        return view('client.tiket')
            ->with('divisis', $divisis)
            ->with('tikets', $tikets);
    }
}
