<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Penghasilan;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Alasan;
use App\Models\Responden;

use App\Http\Requests\RespondenPostRequest as PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RespondenController extends Controller
{
    /*
        ******************************************
    */

    public function index()
    {
        $ref_agama          = Agama::all();
        $ref_pendidikan     = Pendidikan::all();
        $ref_pekerjaan      = Pekerjaan::all();
        $ref_penghasilan    = Penghasilan::all();
        $ref_kecamatan      = Kecamatan::all();
        $ref_desa           = Desa::all();
        $ref_alasan         = Alasan::all();

        return view('contents.create.responden')
                ->with('responden_alasan', [])
                ->with('ref_agama', $ref_agama)
                ->with('ref_pendidikan', $ref_pendidikan)
                ->with('ref_pekerjaan', $ref_pekerjaan)
                ->with('ref_penghasilan', $ref_penghasilan)
                ->with('ref_kecamatan', $ref_kecamatan)
                ->with('ref_desa', $ref_desa)
                ->with('ref_alasan', $ref_alasan);
    }

    /*
        ******************************************
    */

    public function store(PostRequest $request)
    {
        $input = $request->all();

        $responden = Responden::updateOrCreate(['res_id' => $request->res_id], $input);

        $success    = true;
        $message    = 'Data berhasil disimpan !';
        $main_id    = $request->res_id == '' ? $responden->res_id : $request->res_id;

        $responden_alasan = [];
        foreach($request->res_alasan_id as $value) {
            array_push($responden_alasan, ['res_id' => $main_id, 'ref_alasan_id' => $value]);
        };

        DB::table('main_responden_alasan')->where('res_id', $main_id)->delete();
        DB::table('main_responden_alasan')->insert($responden_alasan);

        return response()->json(['success' => $success, 'message' => $message, 'main_id' => $main_id]);
    }

    /*
        ******************************************
    */

    public function edit(Request $request, $res_id)
    {
        $responden          = Responden::findOrFail($res_id);
        $responden_alasan   = Responden::getAlasanDetail($res_id);

        $collection = collect($responden_alasan);
        $responden_alasan = $collection->pluck('ref_alasan_id')->toArray();

        $ref_agama          = Agama::all();
        $ref_pendidikan     = Pendidikan::all();
        $ref_pekerjaan      = Pekerjaan::all();
        $ref_penghasilan    = Penghasilan::all();
        $ref_kecamatan      = Kecamatan::all();
        $ref_desa           = Desa::all();
        $ref_alasan         = Alasan::all();

        return view('contents.update.responden')
                ->with('responden', $responden)
                ->with('responden_alasan', $responden_alasan)
                ->with('ref_agama', $ref_agama)
                ->with('ref_pendidikan', $ref_pendidikan)
                ->with('ref_pekerjaan', $ref_pekerjaan)
                ->with('ref_penghasilan', $ref_penghasilan)
                ->with('ref_kecamatan', $ref_kecamatan)
                ->with('ref_desa', $ref_desa)
                ->with('ref_alasan', $ref_alasan);
    }

    /*
        ******************************************
    */

    public function verify($res_id)
    {
        Responden::where('res_id', $res_id)->update(['res_status' => 2]);

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function destroy($res_id)
    {
        Responden::find($res_id)->delete();

        return response()->json(['success' => true]);
    }
}
