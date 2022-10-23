<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Competency extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'competency_result';
    protected $primaryKey   = 'competency_result_id';
    protected $guarded      = ['competency_result_id'];

    public function getCompetencyByPosition($position_id)
    {
        $result = DB::table('competency_role')->join('competency', 'competency.competency_id', 'competency_role.competency_id')
                    ->where('position_id', $position_id)->get();

        return $result;
    }

    public function getResult($_pmin, $_pmax, $_cmin, $_cmax)
    {
        $result = DB::table('view_competency_result')
                ->select('employee.employee_name', 'position.position_desc', 'view_performance_result.performance_total',
                    DB::raw('ROUND(view_competency_result.competency_percent, 0) as competency_total'))
                ->join('view_performance_result', 'view_performance_result.employee_id', 'view_competency_result.employee_id')
                ->join('employee', 'employee.employee_id', '=', 'view_competency_result.employee_id')
                ->leftJoin('position', 'position.position_id', '=', 'employee.position_id')
                ->whereBetween('performance_total', [$_pmin, $_pmax])
                ->whereBetween('competency_percent', [$_cmin, $_cmax])
                ->get();

        return $result;
    }
}
