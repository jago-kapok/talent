<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $department = Department::all();

        return view('contents.department')->with('department', $department);
    }

    /*
        ==============================================================
    */

    public function store(Request $request)
    {
        $input_form = $request->all();

        $department = Department::updateOrCreate(['department_id' => $request->input('department_id')], $input_form);

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function getById($department_id)
    {
        $department = Department::find($department_id);

        return response()->json(['success' => true, 'department' => $department]);
    }

    /*
        ==============================================================
    */

    public function destroy($department_id)
    {
        Department::where('department_id', $department_id)->delete();

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */
}
