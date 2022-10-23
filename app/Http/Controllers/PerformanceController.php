<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Performance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $employee = Employee::all();
        $performance = DB::table('performance_result')
                        ->join('employee', 'employee.employee_id', 'performance_result.employee_id')
                        ->leftJoin('position', 'position.position_id', 'employee.position_id')
                        ->get();

        return view('contents.performance')
                    ->with('employee', $employee)
                    ->with('performance', $performance);
    }
}
