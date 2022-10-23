<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Responden extends Model
{
    use CreatedUpdatedBy, HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey())
            {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    protected $table = 'main_responden';

    protected $primaryKey = 'res_id';

    protected $keyType = 'string';

    protected $guarded = ['res_id', 'res_status', 'created_by', 'updated_by'];

    protected $attributes = ['res_status' => 1];

    public $incrementing = false;

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'res_agama_id', 'id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'res_pendidikan_id', 'id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'res_pekerjaan_id', 'id');
    }

    public function penghasilan()
    {
        return $this->belongsTo(Penghasilan::class, 'res_penghasilan_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'res_kecamatan_id', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'res_desa_id', 'id');
    }

    public function getAlasanDetail($res_id)
    {
        $result = DB::table('main_responden_alasan')->join('ref_alasan', 'ref_alasan.id', 'main_responden_alasan.ref_alasan_id')->where('res_id', $res_id)->get();

        return $result;
    }
}
