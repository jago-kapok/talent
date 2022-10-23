<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Requests\UserPostRequest as PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct() {}

    /*
        ******************************************
    */

    public function index()
    {
        $user = User::all();
        
        return view('contents.users')
                    ->with('user', $user);
    }

    /*
        ******************************************
    */

    public function create()
    {
        $user_level     = Auth::user()->level;
        $user_code      = Auth::user()->code;
        $kecamatan      = $user_level == 2 ? Auth::user()->code : Auth::user()->manager;
        
        $ref_kecamatan  = $user_level != 3 ? Kecamatan::where('id', $kecamatan)->get() : Kecamatan::all();
        $ref_desa       = $user_level == 1 ? Desa::where('id', $user_code)->get() : Desa::all();

        return view('contents.create.users')
                    ->with('ref_kecamatan', $ref_kecamatan)
                    ->with('ref_desa', $ref_desa);
    }

    /*
        ******************************************
    */

    public function store(PostRequest $request)
    {
        $user_level = $request->input('level');
        $kecamatan  = $request->input('kecamatan_id');
        $desa       = $request->input('desa_id');

        if ($user_level == 1)
        {
            $code       = $desa;
            $manager    = $kecamatan;
        }
        else if ($user_level == 2)
        {
            $code       = $kecamatan;
            $manager    = '22';
        }
        else
        {
            $code       = '22';
            $manager    = '';
        }

        $request->merge([
            'code'      => $code,
            'manager'   => $manager,
            'password'  => Hash::make($request->input('password'))
        ]);

        $input = $request->all();

        $pengguna = User::create($input);

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function deactivate($user_id)
    {
        User::find($user_id)->delete();

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function activate($user_id)
    {
        User::withTrashed()->find($user_id)->restore();

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function resetPassword($user_id)
    {
        $password = Hash::make('admin123');
        User::where('id', $user_id)->update(['password' => $password]);

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'password'                 => 'required|confirmed|min:8',
                'password_confirmation'    => 'required',
            ], [
                'password.required'                 => 'Password harus diisi !',
                'password.min'                      => 'Password minimal harus 8 karakter',
                'password_confirmation.required'    => 'Konfirmasi kata sandi tidak cocok',
            ]
        )->validate();

        $password = Hash::make($request->input('password'));
        User::where('id', Auth::user()->id)->update(['password' => $password]);

        return response()->json(['success' => true]);
    }

    /*
        ******************************************
    */

    public function userData(Request $request)
    {
        $user_level = Auth::user()->level;
        $user_code  = Auth::user()->code;
        $kecamatan  = $user_level == 2 ? Auth::user()->code : '';

        $search     = $request->query('search', array('value' => '', 'regex' => false));
        $draw       = $request->query('draw', 0);
        $start      = $request->query('start', 0);
        $length     = $request->query('length', 25);
        $order      = $request->query('order');
        $columns    = $request->query('columns');
        
        $filter     = $search['value'];
        $kecamatan  = $user_level != 3 ? $kecamatan : $columns[2]['search']['value'];
        $desa       = $columns[3]['search']['value'];
        $status     = $user_level == 3 ? '' : '';
    
        $sortColumns = array(
            0 => 'view_users.user_id',
            1 => 'view_users.user_fullname',
            2 => 'view_users.user_name',
            3 => 'view_users.nama_kecamatan',
            4 => 'view_users.nama_desa',
            5 => 'view_users.user_level',
        );
    
        $query = DB::table('view_users')->select('view_users.*')
                            ->where('view_users.user_access', 'like', '%'.$status.'%')
                            ->where('view_users.kecamatan_id', 'like', '%'.$kecamatan.'%')
                            ->where('view_users.desa_id', 'like', '%'.$desa.'%')
                            ->where(function($sql) use ($filter)
                                {
                                    $sql->where('view_users.user_fullname', 'like', '%'.$filter.'%')->orWhere('view_users.user_name', 'like', '%'.$filter.'%');
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
    
        $responden = $query->get();
    
        foreach ($responden as $key => $value) {
            $user_level     = $value->user_level == 3 ? '<span class="badge bg-success">Kabupaten</span>' : ($value->user_level == 2 ? '<span class="badge bg-info">Kecamatan</span>' : '<span class="badge bg-secondary">Desa</span>');
            $user_access    = $value->user_access == 1 ? ' <span class="badge bg-primary">Verifikator</span>' : '';
            
            if ($value->deleted_at != "") {
                $user_status        = ' <span class="badge bg-danger">Non-Aktif</span>';
                $user_status_btn    = '<button type="button" class="btn btn-warning btn-sm" onclick="activateUser(\''.$value->user_id.'\')" title="Activate User"><i class="bi-unlock"></i></button>';
            } else {
                $user_status        = '';
                $user_status_btn    = '<button type="button" class="btn btn-danger btn-sm" onclick="deactivateUser(\''.$value->user_id.'\')" title="Deactivate User"><i class="bi-lock"></i></button>';
            }

            $json['data'][] = [
                $key + 1,
                $value->user_fullname,
                $value->user_name,
                $value->nama_kecamatan,
                $value->nama_desa,
                $user_level . $user_access . $user_status,
                '<button class="btn btn-info btn-sm" onclick="resetPassword(\''.$value->user_id.'\')" title="Reset Password"><i class="bi-arrow-repeat"></i></button>&nbsp;
                '.$user_status_btn,
            ];
        }
    
        return $json;
    }
}
