<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Performance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'performance_result';
    protected $primaryKey   = 'performance_id';
    protected $guarded      = ['performance_id'];

    public function getLastPerformance($employee_id, $year)
    {
        $result = DB::table('performance_result')->select(DB::raw('ROUND(AVG( performance_result )) AS performance_total'))
                        ->where('employee_id', $employee_id)
                        ->whereRaw('performance_year BETWEEN ? AND ?', [$year - 3, $year])
                        ->first();

        return $result;
    }
}
