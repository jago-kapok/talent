<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;

    protected $table        = 'department';
    protected $primaryKey   = 'department_id';
    protected $guarded      = ['department_id'];
    public $timestamps      = false;

    public function position()
    {
        return $this->hasMany(Position::class, 'department_id', 'department_id');
    }

    public function getOrganizational() {
        $result = DB::table('position as p')->select('e.employee_id', 'd.department_id', 'd.department_name', 'd.department_head', 'd.department_color', 'p.position_desc', 'e.employee_name', 'e.employee_person_grade', 'e.employee_job_grade', 'e.employee_job_family')
            ->join('department as d', 'd.department_id', 'p.department_id')
            ->leftJoin('employee as e', 'e.position_id', 'p.position_id')
            ->where('e.deleted_at', NULL)
            ->get();

        return $result;
    }

    /* SQL Plaint Text
        SELECT e.employee_id, d.department_id, d.department_name, d.department_head, d.department_color, p.position_desc, e.employee_name, e.employee_person_grade, e.employee_job_grade, e.employee_job_family
        FROM position p JOIN department d ON p.department_id = d.department_id
        LEFT JOIN employee e ON e.position_id = p.position_id WHERE e.deleted_at IS NULL
    */
}
