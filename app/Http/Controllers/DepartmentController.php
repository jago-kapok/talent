<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $department = DB::table('department as d1')->select('d1.department_id', 'd1.department_code', 'd1.department_name', 'd2.department_name as department_head_name')
                        ->leftJoin('department as d2', 'd1.department_head', 'd2.department_id')->orderBy('d1.department_name')->get();
        $department_head = Department::all();

        return view('contents.department')->with('department', $department)->with('department_head', $department_head);
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

    public function show()
    {
        $department = Department::getOrganizational();

        return view('contents.organizational')->with('department', $department);
    }
}
