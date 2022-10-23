<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $employee = Employee::all();
        $position = Position::all();

        return view('contents.employee')
                ->with('employee', $employee)
                ->with('position', $position);
    }

    /*
        ==============================================================
    */

    public function store(Request $request)
    {
        $input_form = $request->all();

        $employee = Employee::updateOrCreate(['employee_id' => $request->input('employee_id')], $input_form);

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function destroy($employee_id)
    {
        Employee::where('employee_id', $employee_id)->delete();

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function getById($employee_id)
    {
        $employee = Employee::find($employee_id)->first();

        return response()->json(['success' => true, 'employee' => $employee]);
    }
}
