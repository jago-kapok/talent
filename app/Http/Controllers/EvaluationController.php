<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Competency;
use App\Models\Performance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /*
        ==============================================================
    */

    public function index()
    {
        $employee = Employee::all();
        $evaluation = DB::table('view_competency_result')
                    ->select('view_competency_result.employee_id', 'employee.employee_name', 'position.position_desc', 'view_performance_result.performance_total', 'view_competency_result.competency_percent as competency_total')
                    ->join('view_performance_result', 'view_performance_result.employee_id', 'view_competency_result.employee_id')
                    ->join('employee', 'employee.employee_id', '=', 'view_competency_result.employee_id')
                    ->leftJoin('position', 'position.position_id', '=', 'employee.position_id')
                    ->get();

        return view('contents.evaluation')
                    ->with('evaluation', $evaluation)
                    ->with('employee', $employee);
    }

    public function create($employee_id)
    {
        $employee   = Employee::findOrFail($employee_id);
        $competency = Competency::getCompetencyByPosition($employee->position_id);

        return view('contents.create.evaluation')
                    ->with('employee', $employee)
                    ->with('competency', $competency);
    }

    /*
        ==============================================================
    */

    public function store(Request $request)
    {
        $employee_id    = $request->input('employee_id');
        $input_form     = $request->input('competency_id');

        Competency::where('employee_id', $employee_id)->where('competency_status', 2)->update(['competency_status' => 0]);
        Competency::where('employee_id', $employee_id)->where('competency_status', 1)->update(['competency_status' => 2]);

        $competency = Competency::create(
            [
                'competency_date'   => date('Y-m-d'),
                'employee_id'       => $employee_id,
                'competency_status' => 1,
                'created_by'        => Auth::user()->id
            ]
        );

        $competency_result = [];
        foreach($input_form as $key => $value) {
            array_push($competency_result,
            [
                'competency_result_id'  => $competency->competency_result_id,
                'competency_id'         => $value,
                'competency_result'     => $request->input('competency_result.'.$key),
            ]);
        };
        
        DB::table('competency_detail')->insert($competency_result);

        Performance::updateOrCreate(
            [
                'employee_id'           => $employee_id,
                'performance_year'      => $request->input('performance_year') 
            ], [
                'performance_result'    => $request->input('performance_result'),
                'created_by'            => Auth::user()->id
            ]
        );

        return response()->json(['success' => true]);
    }

    /*
        ==============================================================
    */

    public function destroy($employee_id)
    {
        Competency::where('employee_id', $employee_id)->where('competency_status', 1)->delete();
        Performance::where('employee_id', $employee_id)->where('performance_year', date('Y'))->delete();

        return response()->json(['success' => true]);
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

    /*
        ==============================================================
    */

    public function getData(Request $request)
    {
        $search     = $request->query('search', array('value' => '', 'regex' => false));
        $draw       = $request->query('draw', 0);
        $start      = $request->query('start', 0);
        $length     = $request->query('length', 25);
        $order      = $request->query('order');
        $columns    = $request->query('columns');
        
        $filter     = $search['value'];
    
        $sortColumns = array(
            0 => 'view_competency_result.employee_id',
            1 => 'employee.employee_name',
            2 => 'position.position_desc',
            3 => 'view_performance_result.performance_total',
            4 => 'competency_total'
        );
    
        $query = DB::table('view_competency_result')
                    ->select('view_competency_result.employee_id', 'employee.employee_name', 'position.position_desc', 'view_performance_result.performance_total', 'view_competency_result.competency_percent as competency_total')
                    ->join('view_performance_result', 'view_performance_result.employee_id', 'view_competency_result.employee_id')
                    ->join('employee', 'employee.employee_id', '=', 'view_competency_result.employee_id')
                    ->leftJoin('position', 'position.position_id', '=', 'employee.position_id')
                    ->where(function($sql) use ($filter)
                        {
                            $sql->where('employee.employee_name', 'like', '%'.$filter.'%')
                                ->orWhere('position.position_desc', 'like', '%'.$filter.'%');
                        });
    
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
    
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );

        $query->orderBy($sortColumnName, $order[0]['dir'])
                    ->take($length)
                    ->skip($start);
    
        $evaluation = $query->get();
    
        foreach ($evaluation as $key => $value) {

            if ((int) $value->performance_total <= 85) {
                if ((int) $value->competency_total <= 75) {
                    $talent = '<span class="badge bg-danger">Dead Wood</span>';
                } else if ((int) $value->competency_total > 75 && (int) $value->competency_total <= 85) {
                    $talent = '<span class="badge bg-success">Under Performer</span>';
                } else {
                    $talent = '<span class="badge bg-success">Possible Potential Star</span>';
                }
            } else if ((int) $value->performance_total > 85 && (int) $value->performance_total <= 100) {
                if ((int) $value->competency_total <= 75) {
                    $talent = '<span class="badge bg-info">Adequate Performer</span>';
                } else if ((int) $value->competency_total > 75 && (int) $value->competency_total <= 85) {
                    $talent = '<span class="badge bg-primary">Expected Performer</span>';
                } else {
                    $talent = '<span class="badge bg-secondary">Possible Future Star</span>';
                }
            } else {
                if ((int) $value->competency_total <= 75) {
                    $talent = '<span class="badge bg-info">Reliable Performer</span>';
                } else if ((int) $value->competency_total > 75 && (int) $value->competency_total <= 85) {
                    $talent = '<span class="badge bg-secondary">Key Contributor</span>';
                } else {
                    $talent = '<span class="badge bg-warning">Star</span>';
                }
            }

            $json['data'][] = [
                $key + 1,
                strtoupper($value->employee_name),
                strtoupper($value->position_desc),
                $value->performance_total,
                round($value->competency_total, 0).'%',
                $talent,
                '<a href="#" class="btn btn-primary btn-sm"><i class="bi-search"></i></a>&nbsp;
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(\''.$value->employee_id.'\')">
                <i class="bi-trash"></i></button>',
            ];
        }
    
        return $json;
    }
}
