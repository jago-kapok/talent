<?php

namespace App\Http\Controllers;

use App\Models\CompetencyItem;
use Illuminate\Http\Request;

class CompetencyItemController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $competency = CompetencyItem::all();

        return view('contents.competency-item')->with('competency', $competency);
    }

    /*
        ==============================================================
    */

    public function store(Request $request)
    {
        $input_form = $request->all();

        $competency = CompetencyItem::updateOrCreate(['competency_id' => $request->input('competency_id')], $input_form);

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function destroy($competency_id)
    {
        CompetencyItem::where('competency_id', $competency_id)->delete();

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function getById($competency_id)
    {
        $competency = CompetencyItem::find($competency_id);

        return response()->json(['success' => true, 'competency' => $competency]);
    }
}
