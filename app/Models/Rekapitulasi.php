<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rekapitulasi extends Model
{
    use HasFactory;

    public function getTotalSurvey($_where)
    {
        $result = DB::table('view_status_pengisian')->select(DB::raw('
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas > 1, 1, 0)), 0) AS terisi_lengkap,
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas <= 1, 1, 0)), 0) AS tidak_terisi_lengkap'))
                            ->rightJoin('ref_desa', 'ref_desa.id', 'view_status_pengisian.res_desa_id')
                            ->where($_where)
                            ->get();
        
        return $result;
    }

    public function getChartKecamatan()
    {
        $result = DB::table('view_status_pengisian')->select(DB::raw('
                                kecamatan as category,
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas > 1, 1, 0)), 0) AS terisi_lengkap,
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas <= 1, 1, 0)), 0) AS tidak_terisi_lengkap'))
                            ->rightJoin('ref_kecamatan', 'ref_kecamatan.id', 'view_status_pengisian.res_kecamatan_id')
                            ->groupBy('ref_kecamatan.id')
                            ->orderBy('kecamatan')
                            ->get();

        return $result;
    }

    public function getChartDesa($_where)
    {
        $result = DB::table('view_status_pengisian')->select(DB::raw('
                                desa as category,
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas > 1, 1, 0)), 0) AS terisi_lengkap,
                                IFNULL(SUM(IF( exist_orangtua + exist_petugas <= 1, 1, 0)), 0) AS tidak_terisi_lengkap'))
                            ->rightJoin('ref_desa', 'ref_desa.id', 'view_status_pengisian.res_desa_id')
                            ->where($_where)
                            ->groupBy('ref_desa.id')
                            ->orderBy('desa')
                            ->get();

        return $result;
    }

    public function getTotalByAlasan($_where)
    {
        $result = DB::table('ref_alasan')->select(DB::raw('deskripsi, COUNT(ref_alasan_id) as total'))
                            ->leftJoin('main_responden_alasan', 'ref_alasan.id', '=', 'main_responden_alasan.ref_alasan_id')
                            ->join('main_responden', 'main_responden_alasan.res_id', '=', 'main_responden.res_id')
                            ->where($_where)
                            ->groupBy('deskripsi')
                            ->orderByDesc('total')
                            ->get();

        return $result;
    }
}
