<?php

namespace App\Http\Controllers;

use App\Models\Competency;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

        // getResult(PMin, PMax, CMin, CMax)

        $dead_wood                  = Competency::getResult(0, 85, 0, 75);
        $adequate_performer         = Competency::getResult(86, 100, 0, 75);
        $reliable_performer         = Competency::getResult(101, 150, 0, 75);
        $under_performer            = Competency::getResult(0, 85, 76, 85);
        $expected_performer         = Competency::getResult(86, 100, 76, 85);
        $key_contributor            = Competency::getResult(101, 150, 76, 85);
        $possible_potential_star    = Competency::getResult(0, 85, 86, 100);
        $possible_future_star       = Competency::getResult(86, 100, 86, 100);
        $star                       = Competency::getResult(101, 150, 86, 100);

        return view('home')
                ->with('password_match', $password_match)
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
