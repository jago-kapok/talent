<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $department     = Department::all();
        $position       = Position::all();

        return view('contents.position')->with('position', $position)->with('department', $department);
    }

    /*
        ==============================================================
    */

    public function store(Request $request)
    {
        $input_form = $request->all();

        $position = Position::updateOrCreate(['position_id' => $request->input('position_id')], $input_form);

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function getById($position_id)
    {
        $position = Position::find($position_id);

        return response()->json(['success' => true, 'position' => $position]);
    }

    /*
        ==============================================================
    */

    public function destroy($position_id)
    {
        Position::where('position_id', $position_id)->delete();

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function detail($position_id)
    {
        $position   = Position::where('position_id', $position_id)->first();
        $competency = DB::table('competency')->get();
        $roles      = DB::table('competency_role')->where('position_id', $position_id)->get();

        $competency_roles = [];
        foreach ($roles as $value) {
            array_push($competency_roles, $value->competency_id);
        }

        // dd($competency_roles);

        return view('contents.create.position-detail')
                ->with('position', $position)
                ->with('competency', $competency)
                ->with('competency_roles', $competency_roles);
    }

    /*
        ==============================================================
    */

    public function storeDetail(Request $request)
    {
        $position_id   = $request->input('position_id');
        $input_form    = $request->input('competency_id');
        
        $position_detail = [];
        $position_score = [];
        foreach($input_form as $key => $value) {
            array_push($position_detail,
            [
                'position_id'       => $position_id,
                'competency_id'     => $value,
            ]);

            array_push($position_score, $request->input('competency_score.'.$key));
        };
        
        DB::table('position')->where('position_id', $position_id)->update(['position_score' => array_sum($position_score)]);
        DB::table('competency_role')->where('position_id', $position_id)->delete();
        DB::table('competency_role')->insert($position_detail);

        return response()->json(['success' => true, 'total_score' => array_sum($position_score)]);
    }
}
