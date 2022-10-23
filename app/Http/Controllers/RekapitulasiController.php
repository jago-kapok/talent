<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Orangtua;
use App\Models\Petugas;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Alasan;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekapitulasiController extends Controller
{
    /*
        ******************************************
    */

    public function index()
    {
        $user_level     = Auth::user()->level;
        $user_code      = Auth::user()->code;
        $kecamatan      = $user_level == 2 ? Auth::user()->code : Auth::user()->manager;

        $ref_kecamatan  = $user_level != 3 ? Kecamatan::where('id', $kecamatan)->get() : Kecamatan::all();
        $ref_desa       = $user_level == 1 ? Desa::where('id', $user_code)->get() : Desa::all();

        return view('contents.rekapitulasi')
                    ->with('ref_kecamatan', $ref_kecamatan)
                    ->with('ref_desa', $ref_desa);
    }

    /*
        ******************************************
    */

    public function show($res_id)
    {
        $responden          = Responden::findOrFail($res_id);
        $responden_alasan   = Responden::getAlasanDetail($res_id);
        $orangtua           = Orangtua::join('ref_status_orangtua', 'ref_status_orangtua.id', 'main_orangtua.ortu_kategori')->where('res_id', $res_id)->get();
        $petugas            = Petugas::firstWhere('res_id', $res_id);

        $hasil_pendataan_id = is_null ($petugas) ? 0 : $petugas->hasil_pendataan;
        $hasil_pendataan = array(
            1 => 'Terisi Lengkap',
            2 => 'Responden Menolak',
            3 => 'Responden Tidak Ditemukan',
            4 => 'Responden Pindah'
        );

        $tanggal_lahir  = date_create($responden->res_tanggal_lahir);
        $tanggal_now    = date_create(date('Y-m-d'));
        $responden_usia = date_diff($tanggal_lahir, $tanggal_now);

        return view('contents.rekapitulasi-detail')
                    ->with('responden', $responden)
                    ->with('responden_usia', $responden_usia->format('%y'))
                    ->with('orangtua', $orangtua)
                    ->with('petugas', $petugas)
                    ->with('hasil_pendataan', Arr::get($hasil_pendataan, $hasil_pendataan_id))
                    ->with('responden_alasan', $responden_alasan);
    }

    /*
        ******************************************
    */

    public function respondenData(Request $request)
    {
        $user_level = Auth::user()->level;
        $user_code  = Auth::user()->code;
        $kecamatan  = $user_level == 2 ? Auth::user()->code : Auth::user()->manager;

        $search     = $request->query('search', array('value' => '', 'regex' => false));
        $draw       = $request->query('draw', 0);
        $start      = $request->query('start', 0);
        $length     = $request->query('length', 25);
        $order      = $request->query('order');
        $columns    = $request->query('columns');
        
        $filter     = $search['value'];
        $kecamatan  = $user_level != 3 ? $kecamatan : $columns[2]['search']['value'];
        $desa       = $user_level == 1 ? $user_code : $columns[3]['search']['value'];
        $status     = $user_level == 3 ? 2 : '';
    
        $sortColumns = array(
            0 => 'main_responden.res_id',
            1 => 'main_responden.created_at',
            2 => 'nama_kecamatan',
            3 => 'nama_desa',
            4 => 'main_responden.res_nik',
            5 => 'main_responden.res_nama_lengkap',
            6 => 'main_responden.res_tanggal_lahir',
            7 => 'status_pengisian',
        );
    
        $query = Responden::select('main_responden.*', 'ref_kecamatan.kecamatan as nama_kecamatan', 'ref_desa.desa as nama_desa',
                                DB::raw('IF
                                (
                                    EXISTS ( SELECT res_id FROM main_orangtua WHERE res_id = main_responden.res_id ) = 0,
                                    0,
                                    IF (EXISTS ( SELECT res_id FROM main_keterangan_petugas WHERE res_id = main_responden.res_id ) = 0, 0, 1)
                                )  as status_pengisian')
                            )
                            ->leftJoin('ref_kecamatan', 'ref_kecamatan.id', '=', 'main_responden.res_kecamatan_id')
                            ->leftJoin('ref_desa', 'ref_desa.id', '=', 'main_responden.res_desa_id')
                            ->where('main_responden.res_status', 'like', '%'.$status.'%')
                            ->where('main_responden.res_kecamatan_id', 'like', '%'.$kecamatan.'%')
                            ->where('main_responden.res_desa_id', 'like', '%'.$desa.'%')
                            ->where(function($sql) use ($filter)
                                {
                                    $sql->where('main_responden.res_nik', 'like', '%'.$filter.'%')->orWhere('main_responden.res_nama_lengkap', 'like', '%'.$filter.'%');
                                });
    
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
    
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );

        $query->orderBy($sortColumnName, $order[0]['dir'])
                    ->take($length)
                    ->skip($start);
    
        $responden = $query->get();
    
        foreach ($responden as $key => $value) {
            $status = $value->status_pengisian == 0 ? '<span class="badge bg-danger">Tidak Terisi Lengkap</span>' : '';

            $tanggal_lahir  = date_create($value->res_tanggal_lahir);
            $tanggal_now    = date_create(date('Y-m-d'));
            $usia           = date_diff($tanggal_lahir, $tanggal_now);
            $res_status     = $value->res_status == 1 ? '<span class="badge bg-warning">Menunggu Verifikasi</span>' : '<span class="badge bg-success">Sudah Verifikasi</span>';

            $json['data'][] = [
                $key + 1,
                date('d-m-Y H:i', strtotime($value->created_at)),
                $value->nama_kecamatan,
                $value->nama_desa,
                $value->res_nik,
                strtoupper($value->res_nama_lengkap),
                $usia->format('%y'). ' Tahun',
                $status,
                $res_status,
                '<a href="rekapitulasi-detail/'.$value->res_id.'" class="btn btn-primary btn-sm"><i class="bi-search"></i></a>&nbsp;
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(\''.$value->res_id.'\')"><i class="bi-trash"></i></button>',
            ];
        }
    
        return $json;
    }
}