<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        $password_match = Auth::user()->level == 1 && (Hash::check('admin123', Auth::user()->password)) ? 1 : 0;

        $employee                   = Employee::all();
        $employee_position          = DB::table('employee')->select('position.position_desc', DB::raw('COUNT(position.position_desc) as position_total'))
                                        ->join('position', 'position.position_id', 'employee.position_id')->groupBy('employee.position_id')->get();

        // getResult(PMin, PMax, CMin, CMax)

        $dead_wood                  = Competency::getResult(0, 95, 0, 99);
        $adequate_performer         = Competency::getResult(96, 100, 0, 99);
        $reliable_performer         = Competency::getResult(100.1, 200, 0, 99);
        $under_performer            = Competency::getResult(0, 95, 100, 100);
        $expected_performer         = Competency::getResult(96, 100, 100, 100);
        $key_contributor            = Competency::getResult(100.1, 200, 100, 100);
        $possible_potential_star    = Competency::getResult(0, 95, 100.1, 200);
        $possible_future_star       = Competency::getResult(96, 100, 100.1, 200);
        $star                       = Competency::getResult(100.1, 200, 100.1, 200);

        // dd($employee_position);

        return view('home')
                ->with('password_match', $password_match)
                ->with('employee', $employee)
                ->with('employee_position', $employee_position)
                ->with('dead_wood', $dead_wood)
                ->with('adequate_performer', $adequate_performer)
                ->with('reliable_performer', $reliable_performer)
                ->with('under_performer', $under_performer)
                ->with('expected_performer', $expected_performer)
                ->with('key_contributor', $key_contributor)
                ->with('possible_potential_star', $possible_potential_star)
                ->with('possible_future_star', $possible_future_star)
                ->with('star', $star);
    }
}
