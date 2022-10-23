<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Competency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetencyController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $employee = Employee::all();
        $competency = DB::table('view_competency_history')
                        ->join('employee', 'employee.employee_id', 'view_competency_history.employee_id')
                        ->leftJoin('position', 'position.position_id', 'employee.position_id')
                        ->get();

        return view('contents.competency')
                    ->with('employee', $employee)
                    ->with('competency', $competency);
    }
    
    /*
        ==============================================================
    */

    public function getHistory($employee_id)
    {
        $competency = Competency::where('employee_id', $employee_id)->where('competency_status', 1)->get();

        $message = sizeof($competency) == 0 ? 'Belum ada penilaian' : '';

        return response()->json(['result' => $competency, 'message' => $message]);
    }
}
